<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\Traveller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Validate the student number for the given request.
     */
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'login' => 'required|regex:/^[rub]\d{7}$/i',
        ], [
            'login.required' => 'Het studentnummer is verplicht.',
            'login.regex' => 'Het studentnummer moet beginnen met r, u of b en gevolgd worden door 7 cijfers.',
        ]);
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        try {
            // Find the user by their student number/login from users table
            $user = User::where('login', $request->login)->first();

            \Log::info('Looking for user with login: ' . $request->login);

            if (!$user) {
                \Log::info('No user found with login: ' . $request->login);
                return back()->withErrors([
                    'login' => ['We kunnen geen gebruiker vinden met dit studentnummer.'],
                ]);
            }

            \Log::info('Found user: ' . $user->id);

            // Find the traveller record for this user to get their email
            $traveller = Traveller::where('user_id', $user->id)->first();
            $email = null;

            if ($traveller && !empty($traveller->email)) {
                $email = $traveller->email;
                \Log::info('Using email from traveller record: ' . $email);
            } else {
                \Log::info('No traveller email found for user: ' . $user->id);
                return back()->withErrors([
                    'login' => ['We kunnen geen e-mailadres vinden dat gekoppeld is aan dit studentnummer.'],
                ]);
            }

            // Generate a new password
            $newPassword = Str::random(10);

            // Update the user's password
            $user->password = Hash::make($newPassword);
            $user->save();

            // Create masked email for display
            $maskedEmail = $this->maskEmail($email);

            // Send an email with the new password
            \Log::info("Password reset for user {$user->login}: New password is {$newPassword}");
            Mail::to($email)->send(new PasswordResetMail($user, $newPassword));

            // Redirect to login with success message
            return redirect()->route('login')
                ->with('status', "We hebben een nieuw wachtwoord verstuurd naar {$maskedEmail}. Controleer uw e-mail.");

        } catch (\Exception $e) {
            \Log::error('Exception in password reset: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return back()->withErrors([
                'login' => ['Er is een fout opgetreden bij het herstellen van uw wachtwoord. Probeer het later opnieuw.'],
            ]);
        }
    }

    /**
     * Mask an email address for privacy in messages.
     * 
     * @param string $email The email to mask
     * @return string The masked email
     */
    private function maskEmail($email)
    {
        if (empty($email)) {
            return '[onbekend e-mailadres]';
        }

        $emailParts = explode('@', $email);
        if (count($emailParts) !== 2) {
            return '[ongeldig e-mailadres]';
        }

        $name = $emailParts[0];
        $domain = $emailParts[1];

        // Show first 2 characters and last character of the name part
        $nameLength = strlen($name);
        if ($nameLength <= 3) {
            $maskedName = $name[0] . str_repeat('*', $nameLength - 1);
        } else {
            $maskedName = $name[0] . $name[1] . str_repeat('*', $nameLength - 3) . $name[$nameLength - 1];
        }

        return $maskedName . '@' . $domain;
    }
}

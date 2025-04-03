<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Validate the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'studentnumber' => 'required|regex:/^[rub]\d{7}$/i',
        ], [
            'studentnumber.required' => 'Het studentnummer is verplicht.',
            'studentnumber.regex' => 'Studentnummer moet beginnen met r, u of b en gevolgd worden door 7 cijfers.',
        ]);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $studentNumber = $request->studentnumber;

        // Get the student number from the request
        $user = DB::table('users')->where('login', $studentNumber)->first();

        if (!$user) {
            return back()->withErrors([
                'studentnumber' => __('We kunnen geen gebruiker vinden met dit studentnummer.')
            ]);
        }

        // Directly use the broker's sendResetLink method with the correct field
        $status = Password::broker()->sendResetLink(
            ['login' => $studentNumber],  // Use login field instead of email
            function ($user, $token) {
                $user->sendPasswordResetNotification($token);
            }
        );

        // Return the appropriate response
        return $status == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $status)
            : $this->sendResetLinkFailedResponse($request, $status);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        // Custom Dutch message for clarity
        $message = 'We hebben een e-mail verstuurd met instructies om je wachtwoord te herstellen.';

        // Redirect to login page with success message
        return redirect()->route('login')->with('status', $message);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Major;
use App\Models\Cities;
use App\Models\Trip;
use App\Models\User;
use App\Models\Traveller;
use App\Services\FormValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Mail\RegistrationConfirmationMail;
use Illuminate\Support\Facades\Mail;

class GuestRegistrationController extends Controller
{
    const SESSION_KEY = 'guest_registration';

    /**
     * The form validation service
     *
     * @var FormValidationService
     */
    protected $formValidator;

    public function __construct(FormValidationService $formValidator)
    {
        $this->middleware('auth');
        $this->middleware('user-access:guest');
        $this->formValidator = $formValidator;
    }

    //function to fetch majors based on selected education
    // This function is called via AJAX when the user selects an education
    public function getMajorsByEducation($educationId)
    {
        $majors = Major::where('education_id', $educationId)->get();
        return response()->json($majors);
    }

    // Show Basic Info Form
    public function showBasicInfoForm(Request $request)
    {
        $registration = $request->session()->get(self::SESSION_KEY, [
            'step' => 1,
            'trip' => '',
            'student_number' => '',
            'education' => '',
            'major' => '',
        ]);

        $trips = Trip::all(); // Fetch all trips from the database
        $educations = Education::all(); // Fetch all educations from the database

        // Fetch majors based on the selected education instead of all of them, this is so that when redirecting back to the basicinfo page, you can see the majors instantly in the dropdown
        $majors = [];
        if (!empty($registration['education'])) {
            $majors = Major::where('education_id', $registration['education'])->get();
        }

        return view('guest.registration.basic-info', [
            'registration' => (object) $registration,
            'trips' => $trips,
            'educations' => $educations,
            'majors' => $majors
        ]);
    }

    // Submit Basic Info Form
    public function submitBasicInfo(Request $request)
    {
        // Use the validation service to validate the form
        $validation = $this->formValidator->validate(request: $request, formType: 'basicInfo');

        if (!$validation['success']) {
            return back()
                ->withErrors($validation['validator'])
                ->withInput();
        }

        // Get current session data and update it with validated data
        $registration = $request->session()->get(self::SESSION_KEY, []);
        $registration = array_merge($registration, $validation['validated'], ['step' => 2]);

        // Save updated data back to session
        $request->session()->put(self::SESSION_KEY, $registration);

        return redirect()->route('guest.registration.personal-info');
    }

    // Show Personal Info Form
    public function showPersonalInfoForm(Request $request)
    {
        $registration = $request->session()->get(self::SESSION_KEY, ['step' => 1]);

        if ($registration['step'] < 2) {
            return redirect()->route('guest.registration.basic-info');
        }

        $cities = Cities::all();

        return view('guest.registration.personal-info', ['registration' => (object) $registration, 'cities' => $cities]);
    }

    // Submit Personal Info Form
    public function submitPersonalInfo(Request $request)
    {
        // Use the validation service to validate the form
        $validation = $this->formValidator->validate(request: $request, formType: 'personalInfo');

        if (!$validation['success']) {
            return back()
                ->withErrors($validation['validator'])
                ->withInput();
        }

        // Get current session data and update it with validated data
        $registration = $request->session()->get(self::SESSION_KEY, []);
        $registration = array_merge($registration, $validation['validated'], ['step' => 3]);

        // Save updated data back to session
        $request->session()->put(self::SESSION_KEY, $registration);

        return redirect()->route('guest.registration.contact-info');
    }

    // Show Contact Info Form
    public function showContactInfoForm(Request $request)
    {
        $registration = $request->session()->get(self::SESSION_KEY, ['step' => 1]);

        if ($registration['step'] < 3) {
            return redirect()->route('guest.registration.personal-info');
        }

        return view('guest.registration.contact-info', ['registration' => (object) $registration]);
    }

    // Submit Contact Info Form
    public function submitContactInfo(Request $request)
    {
        // Use the validation service to validate the form
        $validation = $this->formValidator->validate(request: $request, formType: 'contactInfo');

        if (!$validation['success']) {
            return back()
                ->withErrors($validation['validator'])
                ->withInput();
        }

        // Get current session data and update it with validated data
        $registration = $request->session()->get(self::SESSION_KEY, []);
        $registration = array_merge($registration, $validation['validated'], ['step' => 4]);

        // Save updated data back to session
        $request->session()->put(self::SESSION_KEY, $registration);

        // Redirect to the confirmation page
        return redirect()->route('guest.registration.confirmation');
    }

    // Show Confirmation Page
    public function showConfirmationPage(Request $request)
    {
        $registration = $request->session()->get(self::SESSION_KEY, ['step' => 1]);

        if ($registration['step'] < 4) {
            return redirect()->route('guest.registration.contact-info')
                ->with('error', 'U moet eerst alle voorgaande stappen voltooien.');
        }

        return view('guest.registration.confirmation', ['registration' => (object) $registration]);
    }

    // Final submit to create account
    public function submitConfirmation(Request $request)
    {
        $validated = $request->validate([
            'terms_accepted' => 'required|accepted',
        ], [
            'terms_accepted.required' => 'U moet de algemene voorwaarden accepteren.',
            'terms_accepted.accepted' => 'U moet de algemene voorwaarden accepteren.',
        ]);

        // Get the complete registration data
        $registration = $request->session()->get(self::SESSION_KEY, []);

        try {
            // Check if user already exists by student number (login) instead of email
            $existingUser = User::where('login', $registration['student_number'])->first();

            if ($existingUser) {
                \Log::info("User with login {$registration['student_number']} already exists. Skipping user creation.");

                // Check if the user already has a traveller record
                $existingTraveller = Traveller::where('user_id', $existingUser->id)->first();

                if ($existingTraveller) {
                    \Log::info("Traveller record for {$registration['student_number']} already exists. Registration complete.");

                    // Clear the registration data from session
                    $request->session()->forget(self::SESSION_KEY);

                    // Redirect with a different message for existing users
                    return redirect()->route('login')
                        ->with('success', 'U bent reeds geregistreerd. U kunt nu inloggen met uw studentnummer en wachtwoord.');
                }

                // User exists but traveller record doesn't, use existing user
                $user = $existingUser;
            } else {
                // Generate a secure random password
                $password = Str::random(10);

                // Create user with the fields that exist in the users table
                $userData = [
                    'login' => $registration['student_number'],
                    'password' => Hash::make($password),
                    'role' => 'traveller',
                ];

                // Reset AUTO_INCREMENT value for users table to avoid id gaps
                DB::statement("ALTER TABLE users AUTO_INCREMENT = 1");
                // Create the user record
                $user = User::create($userData);
                \Log::info("Created new user with login: {$registration['student_number']}");

                // We'll need to send the password email after traveller creation
                $shouldSendEmail = true;
            }

            // Get the major ID based on name and education
            $major = Major::where('name', $registration['major'])
                ->where('education_id', $registration['education'])
                ->first();
            $majorId = $major ? $major->id : 1; // Default to 1 if not found
            // Create the traveller record matching the database schema
            $travellerData = [
                'user_id' => $user->id,
                'trip_id' => Trip::where('name', $registration['trip'])->value('id'), // set trip_id based on trip name
                'zip_id' => 3000, // Default value
                'major_id' => $majorId,
                'first_name' => $registration['first_name'],
                'last_name' => $registration['last_name'],
                'email' => $registration['email'],
                'country' => $registration['country'],
                'address' => $registration['address'],
                'gender' => $registration['gender'],
                'phone' => $registration['phone'],
                'emergency_phone_1' => $registration['emergency_contact'],
                'emergency_phone_2' => $registration['optional_emergency_contact'] ?? '',
                'nationality' => $registration['nationality'] ?? 'Belg',
                'birthdate' => $registration['date_of_birth'],
                'birthplace' => $registration['place_of_birth'],
                'iban' => 'BE00000000000000', // Default placeholder
                'bic' => 'GEBABEBB', // Default placeholder
                'medical_issue' => $registration['medical_info'] === 'yes' ? 1 : 0,
                'medical_info' => $registration['medical_info'] === 'yes' ? $registration['medical_details'] : '',
                'created_at' => now(),
                'updated_at' => now(),
                 // from basic-info form
            ];

            //this is for when u delete a user in the database, the id will be reset to 1
            // Reset AUTO_INCREMENT value for users table to avoid id gaps
            DB::statement("ALTER TABLE travellers AUTO_INCREMENT = 1");
            // Use direct DB insertion to avoid model validation issues
            DB::table('travellers')->insert($travellerData);
            \Log::info("Created traveller record for: {$registration['first_name']} {$registration['last_name']}");

            // Send the confirmation email with login credentials if this is a new user
            if (isset($shouldSendEmail)) {
                Mail::to($registration['email'])->send(new RegistrationConfirmationMail(
                    (object) array_merge($registration, ['password' => $password])
                ));
                \Log::info("Sent registration confirmation email to: {$registration['email']}");
            }

            // Clear the registration data from session
            $request->session()->forget(self::SESSION_KEY);

            // Log out the current user first
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login page with success message and pre-filled data
            return redirect()->route('login')
                ->with('registration_complete', true)
                ->with('login', $registration['student_number'])
                ->with('success', 'Uw registratie is succesvol verwerkt! Een e-mail met uw inloggegevens is verzonden naar ' . $registration['email'] . '. Controleer uw inbox om uw account te activeren.');

        } 
        catch (\Exception $e) {
            // Log the error and show a generic message
            \Log::error("Registration error: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());

            return redirect()->route('login')
                ->with('error', 'Er is een fout opgetreden bij uw registratie. Neem contact op met de beheerder.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Major;
use App\Models\Trip;
use App\Models\User;
use App\Models\Traveller;
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

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user-access:guest');
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

        return view('guest.registration.basic-info', ['registration' => (object) $registration, 'trips' => $trips, 'educations' => $educations, 'majors' => $majors]);
    }

    // Submit Basic Info Form
    public function submitBasicInfo(Request $request)
    {
        // Create a validator with specific error messages for each field
        $validator = validator($request->all(), [
            'trip' => 'required|string|max:255',
            'student_number' => [
                'required',
                'string',
                'max:255',
                'regex:/^[rub]\d{7}$/i'
            ],
            'education' => 'required|string|max:255',
            'major' => 'required|string|max:255',
        ], [
            'trip.required' => 'Selecteer een reis.',
            'student_number.required' => 'Studentnummer is verplicht.',
            'student_number.regex' => 'Studentnummer moet beginnen met r, u of b en gevolgd worden door 7 cijfers.',
            'education.required' => 'Selecteer een opleiding.',
            'major.required' => 'Selecteer een afstudeerrichting.',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the validated data
        $validated = $validator->validated();

        // Get current session data and update it
        $registration = $request->session()->get(self::SESSION_KEY, []);
        $registration = array_merge($registration, $validated, ['step' => 2]);

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

        return view('guest.registration.personal-info', ['registration' => (object) $registration]);
    }

    // Submit Personal Info Form
    public function submitPersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Man,Vrouw,Anders',
            'nationality' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'place_of_birth' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',

        ], [
            'first_name.required' => 'Voornaam is verplicht.',
            'last_name.required' => 'Achternaam is verplicht.',
            'gender.required' => 'Selecteer een geslacht.',
            'gender.in' => 'Selecteer een geldig geslacht.',
            'nationality.required' => 'Nationaliteit is verplicht.',
            'date_of_birth.required' => 'Geboortedatum is verplicht.',
            'date_of_birth.before' => 'Geboortedatum moet in het verleden zijn.',
            'place_of_birth.required' => 'Geboorteplaats is verplicht.',
            'address.required' => 'Adres is verplicht.',
            'city.required' => 'Stad is verplicht.',
            'country.required' => 'Land is verplicht.',

        ]);

        // Get current session data and update it
        $registration = $request->session()->get(self::SESSION_KEY, []);
        $registration = array_merge($registration, $validated, ['step' => 3]);

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
        $validated = $request->validate([
            'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'secondary_email' => 'nullable|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'phone' => 'required|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'emergency_contact' => 'required|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'optional_emergency_contact' => 'nullable|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'medical_info' => 'required|in:yes,no',
            'medical_details' => 'required_if:medical_info,yes|nullable|string',
        ], [
            'email.required' => 'E-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.regex' => 'Het e-mailadres moet een geldig formaat hebben.',
            'secondary_email.email' => 'Voer een geldig tweede e-mailadres in.',
            'secondary_email.regex' => 'Het tweede e-mailadres moet een geldig formaat hebben.',
            'phone.required' => 'Telefoonnummer is verplicht.',
            'phone.regex' => 'Het telefoonnummer moet een geldig formaat hebben (bijv. +32412345678).',
            'emergency_contact.required' => 'Noodnummer 1 is verplicht.',
            'emergency_contact.regex' => 'Het noodnummer moet een geldig formaat hebben (bijv. +32412345678).',
            'optional_emergency_contact.regex' => 'Het optionele noodnummer moet een geldig formaat hebben (bijv. +32412345678).',
            'medical_info.required' => 'Geef aan of er medische informatie is.',
            'medical_details.required_if' => 'Vul de medische details in als u "Ja" selecteert.',
        ]);

        // Get current session data
        $registration = $request->session()->get(self::SESSION_KEY, []);

        // Merge the validated data from the current form
        $registration = array_merge($registration, $validated, ['step' => 4]);

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

        // Check if user already exists
        $existingUser = User::where('email', $registration['email'])->first();

        if (!$existingUser) {
            try {
                // Generate a secure random password
                $password = Str::random(10);

                // Create user with the fields that exist in the users table
                $userData = [
                    'login' => $registration['student_number'],
                    'password' => Hash::make($password),
                    'role' => 'traveller',
                ];

                $user = User::create($userData);

                // Get the major ID based on name and education
                $major = Major::where('name', $registration['major'])
                    ->where('education_id', $registration['education'])
                    ->first();
                $majorId = $major ? $major->id : 1; // Default to 1 if not found

                // Create the traveller record matching the database schema
                $travellerData = [
                    'user_id' => $user->id,
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
                ];

                // Use direct DB insertion to avoid model validation issues
                DB::table('travellers')->insert($travellerData);

                // Send the confirmation email with login credentials
                Mail::to($registration['email'])->send(new RegistrationConfirmationMail(
                    (object) array_merge($registration, ['password' => $password])
                ));
            } catch (\Exception $e) {
                // Log the error and show a generic message
                \Log::error("Registration error: " . $e->getMessage());
                return redirect()->route('login')
                    ->with('error', 'Er is een fout opgetreden bij uw registratie. Neem contact op met de beheerder.');
            }
        }

        // Clear the registration data from session
        $request->session()->forget(self::SESSION_KEY);

        // Log out the current user first
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to register page with success message and pre-filled data
        return redirect()->route('login')
            ->with('registration_complete', true)
            ->with('login', $registration['student_number'])
            ->with('success', 'Uw registratie is succesvol verwerkt! Een e-mail met uw inloggegevens is verzonden naar ' . $registration['email'] . '. Controleer uw inbox om uw account te activeren.');
    }
}

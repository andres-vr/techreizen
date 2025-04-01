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

class GuestRegistrationController extends Controller
{
    const SESSION_KEY = 'guest_registration';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user-access:guest');
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

        $majors = Major::all(); // Fetch all majors from the database

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
            'gender' => 'required|string|in:male,female,other',
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
            'phone' => 'required|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'emergency_contact' => 'required|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'optional_emergency_contact' => 'nullable|string|max:15|regex:/^\+?[0-9]{7,15}$/',
            'medical_info' => 'required|in:yes,no',
            'medical_details' => 'required_if:medical_info,yes|nullable|string',
        ], [
            'email.required' => 'E-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.regex' => 'Het e-mailadres moet een geldig formaat hebben.',
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

        // Check if the user already exists
        if (User::where('login', $registration['email'])->exists()) {
            return back()->withErrors(['email' => 'Een gebruiker met dit e-mailadres bestaat al.'])->withInput();
        }

        // Create a new user with the role 'traveller' using all collected data
        User::create([
            'login' => $registration['email'], // Ensure the login field is provided
            'role' => 'traveller',
            'password' => bcrypt('default_password'), // Vervang met het ingevoerde wachtwoord
            'phone' => $registration['phone'],
            'emergency_contact' => $registration['emergency_contact'],
            'optional_emergency_contact' => $registration['optional_emergency_contact'] ?? null,
            'medical_info' => $registration['medical_info'],
            'medical_details' => $registration['medical_info'] === 'yes' ? $registration['medical_details'] : null,
            'first_name' => $registration['first_name'],
            'last_name' => $registration['last_name'],
            'gender' => $registration['gender'],
            'nationality' => $registration['nationality'] ?? null,
            'date_of_birth' => $registration['date_of_birth'],
            'place_of_birth' => $registration['place_of_birth'],
            'address' => $registration['address'],
            'city' => $registration['city'],
            'country' => $registration['country'],
            'trip' => $registration['trip'],
            'student_number' => $registration['student_number'],
            'education' => $registration['education'],
            'major' => $registration['major'],
        ]);

        return redirect()->route('home')->with('success', 'Registratie voltooid en gebruiker aangemaakt.');
    }

}

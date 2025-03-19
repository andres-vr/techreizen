<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Traveller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GuestRegistrationController extends Controller
{
    const SESSION_KEY = 'guest_registration';
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user-access:guest');
    }
    // TODO: Show Basic Info Form
    public function showBasicInfoForm(Request $request){}
    
    // Submit Basic Info Form
    public function submitBasicInfo(Request $request)
    {
        $validated = $request->validate([
            'trip' => 'required|string|max:255',
            'student_number' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'major' => 'required|string|max:255',
        ]);

        // Get current session data and update it
        $registration = $request->session()->get(self::SESSION_KEY, []);
        $registration = array_merge($registration, $validated, ['step' => 2]); // IMPORTANT: save current steps so we can the progress in a partial view
        
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

        return view('guest.registration.personal-info', ['registration' => (object)$registration]);
    }

    // TODO Submit Personal Info Form
    public function submitPersonalInfo(Request $request){}

}

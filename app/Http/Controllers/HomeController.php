<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // Import DB facade

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $page = DB::table('pages')->where('name', 'home')->first();
        $content = $page ? $page->content : '';
        return view('home', ['page' => $page, 'content' => $content]);
    }

    public function travellerHome(): View
    {
        $page = DB::table('pages')->where('name', 'home')->first();
        $content = $page ? $page->content : '';
        return view('home', ['page' => $page, 'content' => $content]);
    }

    public function guideHome(): View
    {
        $page = DB::table('pages')->where('name', 'home')->first();
        $content = $page ? $page->content : '';
        return view('home', ['page' => $page, 'content' => $content]);
    }

    public function adminHome(): View
    {
        $page = DB::table('pages')->where('name', 'home')->first();
        $content = $page ? $page->content : '';
        return view('home', ['page' => $page, 'content' => $content]);
    }

    public function disclaimerPage(): View
    {
        //guest.disclaimer is the file found in the views folder
        return view('guest.disclaimer');
    }

    public function acceptDisclaimer(Request $request)
    {
        return redirect()->route('guest.registration.basic-info');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use DB;
use function Laravel\Prompts\alert;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $hotels = DB::table('hotels')->get();

        return view('components.layout.hotelListView', [
            'selectedCountries' => [],
            'hotels' => $hotels,
        ]);
    }

    public function filter(Request $request)
    {
        $tripId = $request->input('trips', []);
        $countriesJson = DB::table('trips')->where('id', $tripId)->pluck('countries')->first();
        $countries = json_decode($countriesJson, true);

        // Make sure countries is always an array (even if it's empty)
        if (!is_array($countries)) {
            $countries = $countries ? [$countries] : [];
        }

        $hotels = DB::table('hotels')
            ->when(!empty($countries), fn($query) => $query->whereIn('country', $countries))
            ->get();

        return view('components.layout.hotelListView', [
            'selectedTrip' => $tripId,
            'hotels' => $hotels,
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'addHotelName' => 'required|string',
            'addTypeHotel' => 'required|string',
            'addStreetHotel' => 'required|string',
            'addPostcodeHotel' => 'required|numeric',
            'addCityHotel' => 'required|string',
            'addCountryHotel' => 'required|string',
            'addLinkSiteHotel' => 'required|url',
            'addPhoneNumber' => 'required|string',
            'pdf1_path' => 'required|string',
            'pdf2_path' => 'required|string',
        ]);

        DB::table('hotels')->insert([
            'name' => $validated['addHotelName'],
            'type' => $validated['addTypeHotel'],
            'street' => $validated['addStreetHotel'],
            'zip_code' => $validated['addPostcodeHotel'],
            'city' => $validated['addCityHotel'],
            'country' => $validated['addCountryHotel'],
            'link' => $validated['addLinkSiteHotel'],
            'phone' => $validated['addPhoneNumber'],
            'image1' => $validated['pdf1_path'],
            'image2' => $validated['pdf2_path'],
        ]);
        return redirect()->route('hotels.show')->with('success', 'Hotel succesvol toegevoegd!');
    }
    public function update(Request $request)
    {
        $hotel = Hotel::where('name', $request->input('addHotelName'))->first();

        $hotel->type = $request->input('addTypeHotel');
        $hotel->street = $request->input('addStreetHotel');
        $hotel->zip_code = $request->input('addPostcodeHotel');
        $hotel->city = $request->input('addCityHotel');
        $hotel->country = $request->input('country');
        $hotel->link = $request->input('addLinkSiteHotel');
        $hotel->phone = $request->input('addPhoneNumber');
        $hotel->image1 = $request->input('pdf1_path');
        $hotel->image2 = $request->input('pdf2_path0');
        $hotel->trip_id = $request->input('trip');

        $hotel->save();

        return redirect()->route('hotels.show')->with('success', 'Hotel bijgewerkt!');
    }

    public function showInfo($id)
    {
        $hotels = DB::table('hotels')->get();

        return view('components.layout.hotelListView', [
            'selectedCountries' => [],
            'hotels' => $hotels,
            'x.layout.hotelInfo' => 'content.hotelinfo',
        ]);
    }

    public function deleteHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        $hotels = DB::table('hotels')->get();

        return view('components.layout.hotelListView', [
            'selectedCountries' => [],
            'hotels' => $hotels,
        ]);
    }

    public function deletepopup($id)
    {
        return view('content.deleteHotelPopup', ['id' => $id]);
    }

}

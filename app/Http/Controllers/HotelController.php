<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use DB;
use function Laravel\Prompts\alert;

class HotelController extends Controller
{
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
        return redirect()->route('home')->with('success', 'Hotel succesvol toegevoegd!');
    }
    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $hotel->type = $request->input('addTypeHotel');
        $hotel->street = $request->input('addStreetHotel');
        $hotel->zip_code = $request->input('addPostcodeHotel');
        $hotel->city = $request->input('addCityHotel');
        $hotel->country = $request->input('addCountryHotel');
        $hotel->link = $request->input('addLinkSiteHotel');
        $hotel->phone = $request->input('addPhoneNumber');
        $hotel->image1 = $request->input('pdf1_path');
        $hotel->image2 = $request->input('pdf2_path');

        $hotel->save();

        return redirect()->route('home')->with('success', 'Hotel bijgewerkt!');
    }

    public function deleteHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return view('content.hotelListView');
    }

    public function deletepopup($id)
    {
        return view('content.deleteHotelPopup', ['id' => $id]);
    }

}

<x-layout.hotelListView>
    <x-layout.home>
    <form method="GET" action="{{ route('hotels.filter') }}">
        @csrf
        <div>
            <p>Selecteer een Trip:</p>
            @php
                $selectedCountries = $selectedCountries ?? [];
                $countries = DB::table('hotels')->select('country')->distinct()->get();
            @endphp
            <p>Filter op Trip:</p>

            <select id="country-select" name="countries[]" multiple>
                <option value="" disabled>--- Selecteer een Trip ---</option>
                @foreach($countries as $country)
                    <option value="{{ $country->country }}"
                        @if(in_array($country->country, $selectedCountries)) selected @endif>
                        {{ $country->country }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Toon hotels</button>
        </div>  
    </form>
        <div>
            <!-- Hotel info -->
            <div class="p-4">
                <div style="text-align: right;">
                    <button style="background-color: blue; color:white;">Add Hotel</button>
                </div>
                <table
                    style="border: 3px black solid; margin: 0 auto; margin-top: 10px; width: 100%; background-color:azure;">
                    <tr>
                        <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Info
                        </th>
                        <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Hotel
                        </th>
                        <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Address
                        </th>
                        <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Zipcode
                        </th>
                        <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Edit
                        </th>
                        <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Delete
                        </th>

                    </tr>
                    @foreach ($hotels as $hotel)
                        <tr>
                            <!-- Info button -->
                            <td style="padding: 10px; border: 2px black solid; text-align: center;">
                                <a href="{{ route('hotels.showinfo', $hotel->id) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded text-white">
                                    ℹ️
                                </a>
                            </td>
                            <!-- name of hotel -->
                            <td style="padding: 10px; border: 2px black solid;">
                                <h3 class="font-bold text-lg mb-1 truncate">{{ $hotel->name }}</h3>
                            </td>
                            <!-- hotel address -->
                            <td style="padding: 10px; border: 2px black solid; font-size: 1.2em;">
                                <p class="text-gray-600 text-sm">{{ $hotel->street }}</p>
                            </td>
                            <!-- zipcode -->
                            <td style="padding: 10px; border: 2px black solid; font-size: 1.2em;">
                                <p class="text-gray-600 text-sm">{{ $hotel->zip_code }} {{ $hotel->city }}</p>
                            </td>
                            <td style="padding: 10px; border: 2px black solid; text-align: center;">
                                <button style="width: 100px; background-color: blue; color: white;">Edit</button>
                            </td>
                            <td style="padding: 10px; border: 2px black solid; text-align: center;">
                                <form method="POST" action="{{ route('hotels.deletepopup', $hotel->id) }}">
                                    @csrf
                                    <button type="submit" style="width: 100px; background-color: red;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
</x-layout.home>
</x-layout.hotelListView>

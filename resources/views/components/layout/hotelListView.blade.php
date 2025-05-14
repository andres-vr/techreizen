<!DOCTYPE html>
<html>

<head>
    <title>{{ $title ?? 'Hotel Info' }}</title>

</head>

<body>
    <x-layout.home>
    <form method="GET" action="{{ route('hotels.filter') }}">
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
                    <button style="background-color: blue; color:white;" class="show-create-hotel">Add Hotel</button>
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
                            <button type="button"
                                class="show-hotel-info"
                                data-id="{{ $hotel->id }}"
                                data-name="{{ $hotel->name }}"
                                data-street="{{ $hotel->street }}"
                                data-zip="{{ $hotel->zip_code }}"
                                data-city="{{ $hotel->city }}"
                                data-country="{{ $hotel->country }}"
                                data-phone="{{ $hotel->phone }}"
                                data-link="{{ $hotel->link }}"
                                data-image1="{{ url('view-image/1/' . substr($hotel->image1, 33)) }}"
                                data-image2="{{ url('view-image/1/' . substr($hotel->image2, 33)) }}">
                                ℹ️
                            </button>
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
                                <button style="width: 100px; background-color: blue; color: white;" 
                                type="button"
                                class="show-edit-hotel"
                                data-id="{{ $hotel->id }}"
                                data-name="{{ $hotel->name }}"
                                data-street="{{ $hotel->street }}"
                                data-zip="{{ $hotel->zip_code }}"
                                data-city="{{ $hotel->city }}"
                                data-country="{{ $hotel->country }}"
                                data-phone="{{ $hotel->phone }}"
                                data-link="{{ $hotel->link }}"
                                data-image1="{{ url('view-image/1/' . substr($hotel->image1, 33)) }}"
                                data-image2="{{ url('view-image/1/' . substr($hotel->image2, 33)) }}">
                                Edit
                            </button>
                            </td>
                            <td style="padding: 10px; border: 2px black solid; text-align: center;">
                                <form method="POST" action="{{ route('hotels.deletepopup', $hotel->id) }}">
                                    @csrf
                                    <button type="submit" style="width: 100px; background-color: red;" class="delete-hotel">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        @include('content.hotelinfo')
        @include('content.createhotel')
        @include('content.editHotel')
</x-layout.home>
</body>

</html>

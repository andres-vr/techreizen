<!DOCTYPE html>
<html>

<head>
    <title>{{ $title ?? 'Hotel Info' }}</title>

</head>

<body>
    <x-layout.home>  
    <div>
        @php
            $trips = DB::table('trips')->get();
            $selectedTrip = request()->get('trips', null); // Get the selected trip from the request
        @endphp
        <form id="trip-form" action="{{ route('hotels.filter') }}" method="POST">
            @csrf
            <p>Filter op Trip:</p>

            <select id="trip-select" name="trips">
                <option value="" disabled selected>--- Selecteer een Trip ---</option>
                @foreach($trips as $trip)
                    <option value="{{ $trip->id }}"
                        @if($trip->name == $selectedTrip) selected @endif>
                        {{ $trip->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
            <!-- Hotel info -->
            <div class="p-4">
                <div style="text-align: right;">
                    @if (Auth::user()->role == "admin")
                        <button style="background-color: blue; color:white;" class="create-hotel">Add Hotel</button>
                    @endif
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
                        @if (Auth::user()->role == "admin")
                            <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Edit
                            </th>
                            <th style="padding: 10px; border: 2px black solid; text-align: center; font-size: 1.5em;">Delete
                            </th>
                        @endif

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
                            @if (Auth::user()->role == "admin")
                                <td style="padding: 10px; border: 2px black solid; text-align: center;">
                                <button style="width: 100px; background-color: blue; color: white;" 
                                type="button"
                                class="edit-hotel"
                                data-id="{{ $hotel->id }}"
                                data-name="{{ $hotel->name }}"
                                data-street="{{ $hotel->street }}"
                                data-zip="{{ $hotel->zip_code }}"
                                data-city="{{ $hotel->city }}"
                                data-country="{{ $hotel->country }}"
                                data-phone="{{ $hotel->phone }}"
                                data-link="{{ $hotel->link }}"
                                data-trip="{{ $hotel->trip_id }}"
                                data-image1="{{ url('view-image/1/' . substr($hotel->image1, 33)) }}"
                                data-image2="{{ url('view-image/1/' . substr($hotel->image2, 33)) }}">
                                Edit
                            </button>
                            </td>
                            <td style="padding: 10px; border: 2px black solid; text-align: center;">
                                    <button type="button" 
                                    style="width: 100px; background-color: red;" 
                                    class="delete-hotel" 
                                    data-id="{{ $hotel->id }}">Delete</button>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        @include('content.hotelinfo')
        @include('content.createhotel')
        @include('content.editHotel')
        @include('content.deleteHotel')
</x-layout.home>
</body>

</html>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('trip-select').addEventListener('change', function () {
        document.getElementById('trip-form').submit();
    });
});
</script>

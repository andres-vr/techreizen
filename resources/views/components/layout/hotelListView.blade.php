<!DOCTYPE html>
<html>

<head>
    <title>{{ $title ?? 'Hotel Info' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <x-layout.home>
        <div class="p-4">
            @php
                $trips = DB::table('trips')->get();
                $selectedTrip = request()->get('trips', null);
            @endphp

            <!-- Trip Filter -->
            <form id="trip-form" action="{{ route('hotels.filter') }}" method="POST" class="mb-6">
                @csrf
                <label class="block mb-2 font-semibold">Filter op Trip:</label>
                <select id="trip-select" name="trips" class="w-full p-2 border rounded-md">
                    <option value="" disabled selected>--- Selecteer een Trip ---</option>
                    @foreach ($trips as $trip)
                        <option value="{{ $trip->id }}" @if ($trip->name == $selectedTrip) selected @endif>
                            {{ $trip->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Add Hotel Button -->
            @if (Auth::user()->role == 'admin')
                <div class="text-right mb-4">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 create-hotel">
                        Add Hotel
                    </button>
                </div>
            @endif

            <!-- Hotels Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($hotels as $hotel)
                    <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200 relative">
                        <!-- Info Button -->
                        <button type="button" class="absolute top-2 right-2 text-lg show-hotel-info" title="Hotel Info"
                            data-id="{{ $hotel->id }}" data-name="{{ $hotel->name }}"
                            data-street="{{ $hotel->street }}" data-zip="{{ $hotel->zip_code }}"
                            data-city="{{ $hotel->city }}" data-country="{{ $hotel->country }}"
                            data-phone="{{ $hotel->phone }}" data-link="{{ $hotel->link }}"
                            data-image1="{{ url('view-image/1/' . substr($hotel->image1, 33)) }}"
                            data-image2="{{ url('view-image/1/' . substr($hotel->image2, 33)) }}">
                            ℹ️
                        </button>

                        <!-- Hotel Details -->
                        <h3 class="text-xl font-bold mb-1">{{ $hotel->name }}</h3>
                        <p class="text-sm text-gray-700 mb-1">{{ $hotel->street }}</p>
                        <p class="text-sm text-gray-700">{{ $hotel->zip_code }} {{ $hotel->city }}</p>

                        <!-- Admin Buttons -->
                        @if (Auth::user()->role == 'admin')
                            <div class="mt-4 flex gap-2">
                                <button type="button"
                                    class="flex-1 bg-blue-500 text-white py-1 px-3 rounded edit-hotel"
                                    data-id="{{ $hotel->id }}" data-name="{{ $hotel->name }}"
                                    data-street="{{ $hotel->street }}" data-zip="{{ $hotel->zip_code }}"
                                    data-city="{{ $hotel->city }}" data-country="{{ $hotel->country }}"
                                    data-phone="{{ $hotel->phone }}" data-link="{{ $hotel->link }}"
                                    data-trip="{{ $hotel->trip_id }}"
                                    data-image1="{{ url('view-image/1/' . substr($hotel->image1, 33)) }}"
                                    data-image2="{{ url('view-image/1/' . substr($hotel->image2, 33)) }}">
                                    Edit
                                </button>

                                <button type="button"
                                    class="flex-1 bg-red-600 text-white py-1 px-3 rounded delete-hotel"
                                    data-id="{{ $hotel->id }}">
                                    Delete
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modals -->
        @include('content.hotelinfo')
        @include('content.createhotel')
        @include('content.editHotel')
        @include('content.deleteHotel')
    </x-layout.home>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('trip-select').addEventListener('change', function() {
            document.getElementById('trip-form').submit();
        });
    });
</script>

<!DOCTYPE html>
<html>

<head>
    <title>{{ $title ?? 'Hotel Info' }}</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 1rem;
        }

        form {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
        }

        .text-right {
            text-align: right;
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-blue {
            background-color: #2563eb;
            color: white;
        }

        .btn-blue:hover {
            background-color: #1d4ed8;
        }

        .btn-red {
            background-color: #dc2626;
            color: white;
        }

        .btn-red:hover {
            background-color: #b91c1c;
        }

        .grid {
            display: grid;
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 768px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .card {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            position: relative;
        }

        .info-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 1.25rem;
            background: none;
            border: none;
            cursor: pointer;
        }

        .hotel-name {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }

        .text-sm {
            font-size: 0.875rem;
            color: #374151;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .flex-1 {
            flex: 1;
        }
    </style>
</head>

<body>
    <x-layout.home>
        <div class="container">
            @php
                $trips = DB::table('trips')->get();
                $selectedTrip = request()->get('trips', null);
            @endphp

            <!-- Trip Filter -->
            <form id="trip-form" action="{{ route('hotels.filter') }}" method="POST">
                @csrf
                <label>Filter op Trip:</label>
                <select id="trip-select" name="trips">
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
                <div class="text-right">
                    <button class="btn btn-blue create-hotel" style="background-color: #2563eb; color:white;">Add Hotel</button>
                </div>
            @endif

            <!-- Hotels Grid -->
            <div class="grid">
                @foreach ($hotels as $hotel)
                    <div class="card">
                        <!-- Info Button -->
                        <button type="button" class="info-button show-hotel-info" title="Hotel Info"
                            data-id="{{ $hotel->id }}" data-name="{{ $hotel->name }}"
                            data-street="{{ $hotel->street }}" data-zip="{{ $hotel->zip_code }}"
                            data-city="{{ $hotel->city }}" data-country="{{ $hotel->country }}"
                            data-phone="{{ $hotel->phone }}" data-link="{{ $hotel->link }}"
                            data-image1="{{ url('view-image/1/' . substr($hotel->image1, 33)) }}"
                            data-image2="{{ url('view-image/1/' . substr($hotel->image2, 33)) }}">
                            ℹ️
                        </button>

                        <!-- Hotel Details -->
                        <h3 class="hotel-name">{{ $hotel->name }}</h3>
                        <p class="text-sm">{{ $hotel->street }}</p>
                        <p class="text-sm">{{ $hotel->zip_code }} {{ $hotel->city }}</p>

                        <!-- Admin Buttons -->
                        @if (Auth::user()->role == 'admin')
                            <div class="btn-group">
                                <button type="button" class="btn btn-blue flex-1 edit-hotel" style="background-color: #2563eb; color:white;"
                                    data-id="{{ $hotel->id }}" data-name="{{ $hotel->name }}"
                                    data-street="{{ $hotel->street }}" data-zip="{{ $hotel->zip_code }}"
                                    data-city="{{ $hotel->city }}" data-country="{{ $hotel->country }}"
                                    data-phone="{{ $hotel->phone }}" data-link="{{ $hotel->link }}"
                                    data-trip="{{ $hotel->trip_id }}"
                                    data-image1="{{ url('view-image/1/' . substr($hotel->image1, 33)) }}"
                                    data-image2="{{ url('view-image/1/' . substr($hotel->image2, 33)) }}">
                                    Edit
                                </button>

                                <button type="button" class="btn btn-red flex-1 delete-hotel" style="background-color: #dc2626; color: white;"
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
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('trip-select').addEventListener('change', function () {
            document.getElementById('trip-form').submit();
        });
    });
</script>
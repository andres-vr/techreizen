<x-layout.createPopup>
    <!-- Overlay for popup effect -->
    <div id="create-hotel-popup-container" class="hotel-popup-overlay" style="display: none;">
        <!-- Popup Container -->
        <div class="hotel-popup-container">
            <!-- Close Button -->
            <button class="hotel-popup-close" id="close-hotel">&times;</button>
            
            <!-- Form Content -->
            <div class="hotel-info">
                <h1>Create New Hotel</h1>
                <form class="hotel-create" method="POST" action="{{ route('hotels.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="hotel-details">
                        <!-- Left Column -->
                        <div class="detail-column">
                            <div class="detail-item">
                                <label class="detail-label">Hotel Name:</label>
                                <input type="text" class="form-input" id="hotelName" name="addHotelName" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Type:</label>
                                <select class="form-input" id="typeHotel" name="addTypeHotel" required>
                                    <option value="hotel">Hotel</option>
                                    <option value="jeugdherberg">Jeugdherberg</option>
                                </select>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Website:</label>
                                <input type="url" class="form-input" id="linkSiteHotel" name="addLinkSiteHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Phone:</label>
                                <input type="tel" class="form-input" id="phoneNumber" name="addPhoneNumber" required>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="detail-column">
                            <div class="detail-item">
                                <label class="detail-label">Street:</label>
                                <input type="text" class="form-input" id="streetHotel" name="addStreetHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Zip Code:</label>
                                <input type="text" class="form-input" id="postcodeHotel" name="addPostcodeHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">City:</label>
                                <input type="text" class="form-input" id="cityHotel" name="addCityHotel" required>
                            </div>
                           @php
                                $uniqueTrips = collect($trips)->unique('id');
                            @endphp
                             <!-- Country Dropdown (filtered based on trip) -->
                            <div class="detail-item">
                                    <label class="detail-label">Country:</label>
                                    <div id="new-create-country-select" style="display: none;">

                                    </div>
                                    <div id="country-input" style="display: none;">
                                        <label class="detail-label">New Trip Countries (comma separated):</label>
                                        <input type="text" name="country_input" placeholder="e.g. Frankrijk, Duitsland"/>
                                    </div>
                            </div>
                    </div>       
                    <!-- Trip Dropdown -->
                             <div style="display: flex; flex-direction: column;">
                                    <label class="detail-label">Trip:</label>
                                      <select id="create-trip-select" name="trip" required>
                                        <option value="" disabled selected>-- Select a Trip --</option>
                                        @foreach($trips as $trip)
                                            <option value="{{ $trip->id }}">{{ $trip->name }}</option>
                                        @endforeach
                                        <option value="newtrip">Nieuwe trip</option>
                                    </select>
                                    <!-- Add New Trip -->
                                    <div id="new-trip" style="display: none;">
                                        <label class="detail-label">Trip name:</label>
                                        <input type="text" name="trip_input" placeholder="e.g. Frankrijk, Duitsland"/>
                                    </div>
                            </div>
                    <!-- Images Section -->
                    <div class="image-upload-section">
                        <h2>Hotel Images</h2>
                        <div class="image-upload-container">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm-btn" data-input="pdf1-path" class="btn btn-secondary">Choose Image 1</button>
                                </span>
                                <input id="pdf1-path" name="pdf1_path" type="text" readonly class="form-control" required />
                            </div>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm2-btn" data-input="pdf2-path" class="btn btn-secondary">Choose Image 2</button>
                                </span>
                                <input id="pdf2-path" name="pdf2_path" type="text" readonly class="form-control"/>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="hotel-website-btn" name="createHotel">Create Hotel</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- CSS Styles -->
    <style>
    .hotel-popup-overlay {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        background-color: rgba(0, 0, 0, 0.6);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
    }

    .hotel-popup-container {
        display: flex;
        flex-direction: column;
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        max-width: 900px;
        width: 90%;
        height: auto;
        position: relative;
        animation: fadeIn 0.3s ease-out;
        padding: 2rem;
    }

    .hotel-popup-close {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #fff;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        font-size: 22px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }

    .hotel-popup-close:hover {
        background-color: #f3f3f3;
    }

    .hotel-info h1 {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #2a2a2a;
        text-align: center;
    }

    .hotel-details {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .detail-column {
        flex: 1;
        min-width: 300px;
    }

    .detail-item {
        margin-bottom: 1rem;
    }

    .detail-label {
        display: block;
        font-weight: 600;
        color: #555;
        margin-bottom: 0.3rem;
    }

    .form-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        font-size: 0.95rem;
    }

    .form-input:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }

    .image-upload-section {
        margin: 1.5rem 0;
    }

    .image-upload-section h2 {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        color: #2a2a2a;
    }

    .image-upload-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group-btn {
        margin-right: 0.5rem;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .hotel-website-btn {
        display: block;
        width: 100%;
        background-color: #3498db;
        color: #fff;
        padding: 0.8rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 1rem;
    }

    .hotel-website-btn:hover {
        background-color: #2980b9;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeout {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }
    </style>

@php
    $tripCountryMap = [];
    foreach ($trips as $trip) {
        $tripCountryMap[$trip->id] = json_decode($trip->countries);
    }
@endphp

    <script>
// Function to show the create hotel popup
function showCreateHotelPopup() {
    const popup = document.getElementById('create-hotel-popup-container');
    popup.style.display = 'flex';
    popup.style.animation = "fadeIn 0.3s ease";
    console.log("Create popup opened");
}

// Function to close the create hotel popup
function closeCreateHotelPopup() {
    const popup = document.getElementById('create-hotel-popup-container');
    popup.style.animation = "fadeout 0.3s ease";
    setTimeout(() => {
        popup.style.display = 'none';
    }, 300);
}

// Add event listener to the close button
document.getElementById('close-hotel').addEventListener('click', function() {
    closeCreateHotelPopup();
    console.log('Create popup closed');
});

// Add event listener to the "Add Hotel" button
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.create-hotel').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            showCreateHotelPopup();
        });
    });
});

    document.addEventListener('DOMContentLoaded', function() {
    const tripCountryMap = @json($tripCountryMap);
    const countrySelect = document.getElementById('country-select');
    const coutriesInput = document.getElementById('country-input');
    const newTripInput = document.getElementById('new-trip');
    const selectedTripId = this.value;

        document.getElementById('create-trip-select').addEventListener('change', function () {
             if (this.value == "newtrip") {
                    console.log("New trip selected");
                    coutriesInput.style.display = 'block';
                    newTripInput.style.display = 'block';
                    console.log("New trip input shown");
                    newTripInput.required = true;
                    newTripInput.style.display = 'block';

                    const newCountrySelectContainer = document.getElementById('new-create-country-select');
            } else {
            coutriesInput.style.display = 'none';
            coutriesInput.required = false;
            console.log("coutnries hidden");
            newTripInput.style.display = 'none';
            newTripInput.required = false;
            console.log("New trip input hidden");
            const selectedTripId = this.value;
            const countries = tripCountryMap[selectedTripId] || [];

            // Create a fresh <select> element
            const newCountrySelect = document.createElement('select');
            newCountrySelect.id = 'country-select';
            newCountrySelect.name = 'country';
            newCountrySelect.className = 'form-input';

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Select a Country --';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            newCountrySelect.appendChild(defaultOption);

            // Add new options
            countries.forEach(function (country) {
                const option = document.createElement('option');
                option.value = country;
                option.textContent = country;
                newCountrySelect.appendChild(option);
            });
            const newCountrySelectContainer = document.getElementById('new-create-country-select');
            newCountrySelectContainer.innerHTML = "";
            newCountrySelectContainer.appendChild(newCountrySelect);
            newCountrySelectContainer.style.display = 'block';
            }
        });
    });

    // File manager functions
    window.SetUrl = function (items, pathInputId) {
        const url = Array.isArray(items) ? items[0].url : items.url;
        const filename = url.split('/').pop();
        const targetInput = document.getElementById(pathInputId);
        if (targetInput) {
            targetInput.value = filename;
            console.log("Selected file:", filename);
        }
    };
    </script>

    <!-- Load jQuery and File Manager AFTER SetUrl -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script>
        $(document).ready(function() {
            $('#lfm-btn').filemanager('file', {prefix: '/laravel-filemanager'});
            $('#lfm2-btn').filemanager('file', {prefix: '/laravel-filemanager'});
        });
    </script>
</x-layout.createPopup>
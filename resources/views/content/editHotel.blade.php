<x-layout.popup>
    <!-- Overlay for popup effect -->
    <div id="edit-hotel-popup-container" class="hotel-popup-overlay" style="display: none;">
        <!-- Popup Container -->
        <div class="hotel-popup-container">
            <!-- Close Button -->
            <button class="hotel-popup-close" onclick="closeCreateHotelPopup()">&times;</button>
            
            <!-- Form Content -->
            <div class="hotel-info">
                <h1>Edit Hotel</h1>
                <form id="edit-hotel-form" class="hotel-create" method="POST" action="{{ route('hotels.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="currentHotelId" name="currentHotelId" value="">
                    <div class="hotel-details">
                        <!-- Left Column -->
                        <div class="detail-column">
                            <div class="detail-item">
                                <label class="detail-label">Hotel Name:</label>
                                <input readonly type="text" class="form-input" id="edithotelName" name="addHotelName" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Type:</label>
                                <select class="form-input" id="edittypeHotel" name="addTypeHotel" required>
                                    <option value="hotel">Hotel</option>
                                    <option value="jeugdherberg">Jeugdherberg</option>
                                </select>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Website:</label>
                                <input type="url" class="form-input" id="editlinkSiteHotel" name="addLinkSiteHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Phone:</label>
                                <input type="tel" class="form-input" id="editphoneNumber" name="addPhoneNumber" required>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="detail-column">
                            <div class="detail-item">
                                <label class="detail-label">Street:</label>
                                <input type="text" class="form-input" id="editstreetHotel" name="addStreetHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Zip Code:</label>
                                <input type="text" class="form-input" id="editpostcodeHotel" name="addPostcodeHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">City:</label>
                                <input type="text" class="form-input" id="editcityHotel" name="addCityHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Country:</label>
                                <input type="text" class="form-input" id="editcountryHotel" name="addCountryHotel" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Images Section -->
                    <div class="image-upload-section">
                        <h2>Hotel Images</h2>
                        <div class="image-upload-container">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm-btn" data-input="editpdf1-path" class="btn btn-secondary">Choose Image 1</button>
                                </span>
                                <input id="editpdf1-path" name="pdf1_path" type="text" readonly class="form-control" required />
                            </div>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm2-btn" data-input="editpdf2-path" class="btn btn-secondary">Choose Image 2</button>
                                </span>
                                <input id="editpdf2-path" name="pdf2_path0"  type="text" readonly class="form-control" required />
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="hotel-website-btn" name="createHotel">Edit Hotel</button>
                </form>
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

    <script>
            document.querySelectorAll('.show-edit-hotel').forEach(button => {
            button.addEventListener('click', () => {
            console.log("Edit button clicked");
            
            // Get hotelId from data attribute
            const hotelId = button.dataset.id;
            
            //Set the form action with the Laravel route
            // const form = document.getElementById('edit-hotel-form');
            // form.action = " " + hotelId; // Adjust this based on your actual route structure
            
            // Also store hotelId in hidden input field
            document.getElementById('currentHotelId').value = hotelId;
            
            // Set hotel information
            document.getElementById('edithotelName').value = button.dataset.name;
            document.getElementById('editstreetHotel').value = button.dataset.street;
            document.getElementById('editcityHotel').value = button.dataset.city;
            document.getElementById('editpostcodeHotel').value = button.dataset.zip;
            document.getElementById('editcountryHotel').value = button.dataset.country;
            document.getElementById('editphoneNumber').value = button.dataset.phone;
            document.getElementById('editlinkSiteHotel').value = button.dataset.link;
            // Set image paths
            document.getElementById('editpdf1-path').value = button.dataset.image1;
            document.getElementById('editpdf2-path').value = button.dataset.image2;
            
            const popup = document.getElementById('edit-hotel-popup-container');
            popup.style.display = 'flex';
            popup.style.animation = "fadeIn 0.3s ease";

             // Initialize file manager after popup is shown
            $('#lfm-btn').filemanager('file', {prefix: '/laravel-filemanager'});
            $('#lfm2-btn').filemanager('file', {prefix: '/laravel-filemanager'});
        });
    });

    // Function to close the create hotel popup
    function closeCreateHotelPopup() {
        const popup = document.getElementById('edit-hotel-popup-container');
        popup.style.animation = "fadeout 0.3s ease";
        setTimeout(() => {
            popup.style.display = 'none';
        }, 300);
    }

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
</x-layout.popup>
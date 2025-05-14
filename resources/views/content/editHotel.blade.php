<x-layout.popup>  
    <!-- Overlay for popup effect -->
    <div id="edit-hotel-info" class="hotel-popup-overlay">
        <!-- Popup Container -->
        <div class="hotel-popup-container">
            <!-- Close Button -->
            <button class="hotel-popup-close" onclick="closeHotelPopup()">&times;</button>

            <form class="hotel-create" method="POST" id="editHotelForm" action="">
                @csrf
                <!-- Hidden input to store the hotel ID -->
                <input type="hidden" id="currentHotelId" name="hotelId" value="">
                <div style="box-sizing: border-box; display: flex; flex-direction: row; justify-content: space-between; gap: 10px;">
                    <div class="hotel-details">
                        <!-- Left Column -->
                        <div class="detail-column">
                            <div class="detail-item">
                                <label class="detail-label">Hotel Name:</label>
                                <input type="text" class="form-input" id="popup-name" name="addHotelName" required>
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
                                <input type="url" class="form-input" id="popup-link" name="addLinkSiteHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Phone:</label>
                                <input type="tel" class="form-input" id="popup-phone" name="addPhoneNumber" required>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="detail-column">
                            <div class="detail-item">
                                <label class="detail-label">Street:</label>
                                <input type="text" class="form-input" id="popup-street" name="addStreetHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Zip Code:</label>
                                <input type="numeric" class="form-input" id="popup-zip" name="addPostcodeHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">City:</label>
                                <input type="text" class="form-input" id="popup-city" name="addCityHotel" required>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Country:</label>
                                <input type="text" class="form-input" id="popup-country" name="addCountryHotel" required>
                            </div>
                        </div>
                    </div>
            </div>         
             <div id="pdf-chooser">
                    <div id=pdf-container>
                        <div id="pdf-main">
                            <h1>Kies 2 foto's van het hotel</h1>
                            <!-- Eerste afbeelding -->
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm-btn" data-input="pdf1-path" class="btn btn-secondary" style="background-color: blue">Choose Image</button>
                                </span>
                                <input id="pdf1-path" name="pdf1_path" type="text" readonly class="form-control" required value="" />
                            </div>
                            <br>
                            <!-- Tweede afbeelding -->
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm2-btn" data-input="pdf2-path" class="btn btn-secondary" style="background-color: blue" >Choose Image</button>
                                </span>
                                <input id="pdf2-path" name="pdf2_path" type="text" readonly class="form-control" required value=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="editHotel" style="background-color: #3498db">edit</button>
            </form>
        </div>
    </div>

    <!-- CSS Styles -->
   <style>
label {
    color: #555;
}

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
    flex-direction: row;
    background-color: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    max-width: 900px;
    width: "800px";
    height: "1000x";
    position: relative;
    animation: fadeIn 0.3s ease-out;
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
}

.hotel-popup-close:hover {
    background-color: #f3f3f3;
}

.hotel-create {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.hotel-create h1 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #2a2a2a;
}

.detail-item {
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    color: #444;
}

.detail-label {
    font-weight: 600;
    color: #555;
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
       document.addEventListener('DOMContentLoaded', function() {
    // Initially hide the popup
    const editPopup = document.getElementById('edit-hotel-info');
    if (editPopup) {
        editPopup.style.display = 'none';
    }
    
    // Add click event listeners to all edit buttons
    document.querySelectorAll('.show-edit-hotel').forEach(button => {
        button.addEventListener('click', () => {
            console.log("Edit button clicked");
            
            // Get hotelId from data attribute
            const hotelId = button.dataset.id;
            
            // Set the form action with the Laravel route
            const form = document.getElementById('editHotelForm');
            form.action = "/hotels/" + hotelId; // Adjust this based on your actual route structure
            
            // Also store hotelId in hidden input field
            document.getElementById('currentHotelId').value = hotelId;
            
            // Set hotel information
            document.getElementById('popup-name').value = button.dataset.name;
            document.getElementById('popup-street').value = button.dataset.street;
            document.getElementById('popup-city').value = button.dataset.city;
            document.getElementById('popup-zip').value = button.dataset.zip;
            document.getElementById('popup-country').value = button.dataset.country;
            document.getElementById('popup-phone').value = button.dataset.phone;
            document.getElementById('popup-link').value = button.dataset.link;
            // Set image paths
            document.getElementById('pdf1-path').value = button.dataset.image1;
            document.getElementById('pdf2-path').value = button.dataset.image2;
            
            const popup = document.getElementById('edit-hotel-info');
            popup.style.display = 'flex';
            popup.style.animation = "fadeIn 0.3s ease";
        });
    });
    
    // Function to close the edit hotel popup
    window.closeHotelPopup = function() {
        const popup = document.getElementById('edit-hotel-info');
        popup.style.animation = "fadeout 0.3s ease";
        setTimeout(() => {
            popup.style.display = 'none';
        }, 300);
    }
});

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
        });
        $(document).ready(function() {
            $('#lfm2-btn').filemanager('file', {prefix: '/laravel-filemanager'});
        });
    </script>
</x-layout.popup>

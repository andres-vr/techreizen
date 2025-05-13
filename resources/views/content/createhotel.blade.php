<x-layout.popup>
    
    <!-- Overlay for popup effect -->
    <div class="hotel-popup-overlay">
        <!-- Popup Container -->
        <div class="hotel-popup-container">
            <!-- Close Button -->
            <button class="hotel-popup-close" onclick="closeHotelPopup()">&times;</button>

            <form class="hotel-create" method="POST" action="{{ route('hotels.store') }}">
                @csrf
                <div id="hotel-div" style="box-sizing: border-box; display: flex; flex-direction: row; justify-content: space-between; gap: 10px;">
                    <div id="hotel-info">
                        <div class="row justify-content-center">
                            <div class="col-2 align">
                                <label for="hotelName" class="form-label">Hotel naam </label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="hotelName" name="addHotelName">
                            </div>
                        </div>
                        <div class="row my-3 justify-content-center">
                            <div class="col-2">
                                <label for="typeHotel" class="form-label">Type</label>
                            </div>
                             <div class="col-3">
                               <select class="form-control" id="typeHotel" name="addTypeHotel" required>
                                    <option value="hotel" {{ $hoteldata->type == 'hotel' ? 'selected' : '' }}>hotel</option>
                                    <option value="jeugdherberg" {{ $hoteldata->type == 'jeugdherberg' ? 'selected' : '' }}>jeugdherberg</option>
                                </select>
                            </div>
                        </div>
                                            <div class="row my-3 justify-content-center">
                            <div class="col-2">
                                <label for="linkSiteHotel" class="form-label">Website link</label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="linkSiteHotel" name="addLinkSiteHotel" required>
                            </div>
                        </div>
                        <div class="row my-3 justify-content-center">
                            <div class="col-2">
                                <label for="phoneNumber" class="form-label">telefoon nummer</label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="phoneNumber" name="addPhoneNumber" required>
                            </div>
                        </div>
                    </div>
                    <div id="hotel-adress">
                        <div class="row my-3 justify-content-center">
                            <div class="col-2">
                                <label for="streetHotel" class="form-label">Straat naam </label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="streetHotel" name="addStreetHotel" required>
                            </div>
                        </div>
                        <div class="row my-3 justify-content-center">
                            <div class="col-2">
                                <label for="postcodeHotel" class="form-label">Postcode</label>
                            </div>
                            <div class="col-3">
                                <input type="number" class="form-control" id="postcodeHotel" name="addPostcodeHotel" required>
                            </div>
                        </div>
                        <div class="row my-3 justify-content-center">
                            <div class="col-2">
                                <label for="cityHotel" class="form-label">Stad</label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="cityHotel" name="addCityHotel" required>
                            </div>
                        </div>
                        <div class="row my-3 justify-content-center">
                            <div class="col-2">
                                <label for="countryHotel" class="form-label">Land</label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="countryHotel" name="addCountryHotel" required>
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
                                <input id="pdf1-path" name="pdf1_path" type="text" readonly class="form-control" required />
                            </div>
                            <br>
                            <!-- Tweede afbeelding -->
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm2-btn" data-input="pdf2-path" class="btn btn-secondary" style="background-color: blue">Choose Image</button>
                                </span>
                                <input id="pdf2-path" name="pdf2_path" type="text" readonly class="form-control" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="createHotel" style="background-color: #3498db">Maak</button>
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
        // Function to close the popup
        function closeHotelPopup() {
            const overlay = document.querySelector('.hotel-popup-overlay');
            if (overlay) {
                overlay.style.animation = "fadeout 0.3s ease";
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 300);
            }
        }
    </script>
   <script>
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

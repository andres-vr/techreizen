<x-layout.popup>
    {{-- @php
        $hotels = DB::table('hotels')->
        $hotel = $hotels[/*$id*/0];
    @endphp --}}
    
    <!-- Overlay for popup effect -->
    <div class="hotel-popup-overlay">
        <!-- Popup Container -->
        <div class="hotel-popup-container">
            <!-- Close Button -->
            <button class="hotel-popup-close" onclick="closeHotelPopup()">&times;</button>

            <form class="hotel-create" method="POST" action="{{ route('hotels.update', $hoteldata->id) }}">
                @csrf
                @method('PUT')
                <div class="row justify-content-center">
                    <div class="col-2 align">
                        <label for="hotelName" class="form-label">Hotel naam </label>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="hotelName" name="addHotelName" value="{{$hoteldata->name}}" required readonly>
                    </div>
                </div>
                <div class="row my-3 justify-content-center">
                    <div class="col-2">
                        <label for="typeHotel" class="form-label">Type</label>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="typeHotel" name="addTypeHotel" required value="{{$hoteldata->type}}">
                    </div>
                </div>
                <div class="row my-3 justify-content-center">
                    <div class="col-2">
                        <label for="streetHotel" class="form-label">Straat naam </label>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="streetHotel" name="addStreetHotel" required value="{{$hoteldata->street}}">
                    </div>
                </div>
                <div class="row my-3 justify-content-center">
                    <div class="col-2">
                        <label for="postcodeHotel" class="form-label">Postcode</label>
                    </div>
                    <div class="col-3">
                        <input type="number" class="form-control" id="postcodeHotel" name="addPostcodeHotel" required value="{{$hoteldata->zip_code}}">
                    </div>
                </div>
                <div class="row my-3 justify-content-center">
                    <div class="col-2">
                        <label for="cityHotel" class="form-label">Stad</label>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="cityHotel" name="addCityHotel" required value="{{$hoteldata->city}}">
                    </div>
                </div>
                <div class="row my-3 justify-content-center">
                    <div class="col-2">
                        <label for="countryHotel" class="form-label">Land</label>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="countryHotel" name="addCountryHotel" required value="{{$hoteldata->country}}"> 
                    </div>
                </div>
                <div class="row my-3 justify-content-center">
                    <div class="col-2">
                        <label for="linkSiteHotel" class="form-label">Link site</label>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="linkSiteHotel" name="addLinkSiteHotel" required value="{{$hoteldata->link}}">
                    </div>
                </div>
                <div class="row my-3 justify-content-center">
                    <div class="col-2">
                        <label for="phoneNumber" class="form-label">telefoon nummer</label>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="phoneNumber" name="addPhoneNumber" required value="{{$hoteldata->phone}}">
                    </div>
                </div>
                <div id="pdf-chooser">
                    <div id=pdf-container>
                        <div id="pdf-main">
                            <h1>Kies een 2 images van het hotel</h1>
                            <!-- Eerste afbeelding -->
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm-btn" data-input="pdf1-path" class="btn btn-secondary">Choose Image</button>
                                </span>
                                <input id="pdf1-path" name="pdf1_path" type="text" readonly class="form-control" required value="{{$hoteldata->image1}}" />
                            </div>
                            <br>
                            <!-- Tweede afbeelding -->
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" id="lfm2-btn" data-input="pdf2-path" class="btn btn-secondary" >Choose Image</button>
                                </span>
                                <input id="pdf2-path" name="pdf2_path" type="text" readonly class="form-control" required value="{{$hoteldata->image2}}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="editHotel">edit</button>
            </form>
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
    flex-direction: row;
    background-color: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    max-width: 900px;
    width: 90%;
    height:  750px;
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

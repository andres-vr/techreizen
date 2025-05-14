<x-layout.hotelinfo>
<div id="hotel-popup-container" class="hotel-popup-overlay" style="display: none;">
    <div class="hotel-popup-container">
        <button class="hotel-popup-close" onclick="closeHotelPopup()">&times;</button>
        <div class="hotel-image-gallery" id="popup-images">
            <!-- Images will be inserted here by JavaScript -->
        </div>
        <div class="hotel-info">
            <h1 id="popup-name"></h1>
            <div class="hotel-details">
                <div class="detail-item">
                    <span class="detail-label">Address:</span>
                    <span id="popup-address"></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">City:</span>
                    <span id="popup-city"></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Country:</span>
                    <span id="popup-country"></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone:</span>
                    <span id="popup-phone"></span>
                </div>
            </div>
            <a id="popup-link" href="#" target="_blank" class="hotel-website-btn">Visit Website</a>
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
    flex-direction: row;
    background-color: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    max-width: 900px;
    width: 90%;
    height: auto;
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

.hotel-image-gallery {
    min-width: 300px;
    max-width: 300px;
    height: 400px;
    overflow: hidden;
    position: relative;
    display: flex;
    flex-direction: column;
}

.hotel-image-gallery img {
    width: 100%;
    height: 50%;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}

.hotel-info {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex: 1;
}

.hotel-info h1 {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 1rem;
    color: #2a2a2a;
}

.hotel-details {
    margin: 1rem 0;
}

.detail-item {
    margin-bottom: 0.8rem;
    font-size: 1rem;
    color: #444;
    display: flex;
    align-items: flex-start;
}

.detail-label {
    font-weight: 600;
    color: #555;
    min-width: 80px;
    display: inline-block;
}

.hotel-website-btn {
    margin-top: 1.5rem;
    display: inline-block;
    background-color: #3498db;
    color: #fff;
    padding: 0.8rem 1.5rem;
    border-radius: 0.5rem;
    text-decoration: none;
    font-weight: 600;
    text-align: center;
    transition: background-color 0.2s ease;
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

/* Responsive adjustments */
@media (max-width: 768px) {
    .hotel-popup-container {
        flex-direction: column;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .hotel-image-gallery {
        min-width: 100%;
        max-width: 100%;
        height: 300px;
        flex-direction: row;
    }
    
    .hotel-image-gallery img {
        width: 50%;
        height: 100%;
        border-bottom: none;
        border-right: 1px solid #eee;
    }
}
</style>

<script>
     window.closeHotelPopup = function() {
        const popup = document.getElementById('edit-hotel-info');
        popup.style.animation = "fadeout 0.3s ease";
        setTimeout(() => {
            popup.style.display = 'none';
        }, 300);
    }

document.querySelectorAll('.show-hotel-info').forEach(button => {
    button.addEventListener('click', () => {
        // Set hotel information
        document.getElementById('popup-name').textContent = button.dataset.name;
        document.getElementById('popup-address').textContent = button.dataset.street;
        document.getElementById('popup-city').textContent = `${button.dataset.zip} ${button.dataset.city}`;
        document.getElementById('popup-country').textContent = button.dataset.country;
        document.getElementById('popup-phone').textContent = button.dataset.phone;
        document.getElementById('popup-link').href = button.dataset.link;

        // Set images
        const imageContainer = document.getElementById('popup-images');
        imageContainer.innerHTML = `
            <img src="${button.dataset.image1}" alt="Hotel Image 1">
            <img src="${button.dataset.image2}" alt="Hotel Image 2">
        `;

        // Show popup with animation
        const popup = document.getElementById('hotel-popup-container');
        popup.style.display = 'flex';
        popup.style.animation = "fadeIn 0.3s ease";
    });
});
</script>
</x-layout.hotelinfo>
<x-layout.hotelinfo>
    <div id="hotel-info-popup-container" class="hotel-info-popup-overlay" style="display: none;">
        <div class="hotel-info-popup-content">
            <button id="close-hotel-info-button" class="hotel-info-popup-close">&times;</button>
            <div id="hotel-info-popup-grid">
                <div class="hotel-info-image-gallery" id="hotel-info-popup-images">
                    <!-- Images will be inserted here by JavaScript -->
                </div>
                <div class="hotel-info-content">
                    <h1 id="hotel-info-popup-name"></h1>
                    <div class="hotel-info-details">
                        <div class="hotel-info-detail-item">
                            <span class="hotel-info-detail-label">Address:</span>
                            <span id="hotel-info-popup-address"></span>
                        </div>
                        <div class="hotel-info-detail-item">
                            <span class="hotel-info-detail-label">City:</span>
                            <span id="hotel-info-popup-city"></span>
                        </div>
                        <div class="hotel-info-detail-item">
                            <span class="hotel-info-detail-label">Country:</span>
                            <span id="hotel-info-popup-country"></span>
                        </div>
                        <div class="hotel-info-detail-item">
                            <span class="hotel-info-detail-label">Phone:</span>
                            <span id="hotel-info-popup-phone"></span>
                        </div>
                    </div>
                </div>
                <a id="hotel-info-popup-link" href="#" target="_blank" class="hotel-info-website-btn">Visit
                    Website</a>
            </div>
        </div>
    </div>

    <!-- CSS Styles -->
    <style>
        #hotel-info-popup-grid {
            display: grid;
            grid-template-columns: auto auto auto;
            gap: 10px;
            padding: 10px;
        }

        .hotel-info-popup-overlay {
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

        .hotel-info-popup-content {
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
            animation: hotel-info-fadeIn 0.3s ease-out;
        }

        .hotel-info-popup-close {
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

        .hotel-info-popup-close:hover {
            background-color: #f3f3f3;
        }

        .hotel-info-image-gallery {
            min-width: 300px;
            max-width: 300px;
            height: 400px;
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .hotel-info-image-gallery img {
            height: 100%;
            object-fit: cover;
            border-right: 1px solid #eee;
        }

        .hotel-info-image-gallery img:last-child {
            border-right: none;
        }

        .hotel-info-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
            grid-column: 2 / span 2;
        }

        .hotel-info-content h1 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #2a2a2a;
            display: flex;
        }

        .hotel-info-details {
            margin: 1rem 0;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .hotel-info-detail-item {
            margin-bottom: 0.8rem;
            font-size: 1rem;
            color: #444;
            display: flex;
            align-items: flex-start;
        }

        .hotel-info-detail-label {
            font-weight: 600;
            color: #555;
            min-width: 80px;
            display: inline-block;
        }

        .hotel-info-website-btn {
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

        .hotel-info-website-btn:hover {
            background-color: #2980b9;
        }

        @keyframes hotel-info-fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes hotel-info-fadeout {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        /* Responsive aanpassingen */
        @media (max-width: 768px) {
            .hotel-info-popup-content {
                flex-direction: column;
                max-height: 90vh;
                overflow-y: auto;
            }

            .hotel-info-image-gallery {
                min-width: 100%;
                max-width: 100%;
                height: 300px;
                flex-direction: row;
            }

            .hotel-info-image-gallery img {
                width: 50%;
                height: 100%;
            }
        }
    </style>

    <script>
        const closeHotelInfoButton = document.getElementById('close-hotel-info-button');
        closeHotelInfoButton.addEventListener('click', closeHotelInfoPopup);

        function closeHotelInfoPopup() {
            const popup = document.getElementById('hotel-info-popup-container');
            popup.style.display = 'none';
            console.log('Hotel info popup closed');
        }

        document.querySelectorAll('.show-hotel-info').forEach(button => {
            button.addEventListener('click', () => {
                // Set hotel information
                document.getElementById('hotel-info-popup-name').textContent = button.dataset.name;
                document.getElementById('hotel-info-popup-address').textContent = button.dataset.street;
                document.getElementById('hotel-info-popup-city').textContent =
                    `${button.dataset.zip} ${button.dataset.city}`;
                document.getElementById('hotel-info-popup-country').textContent = button.dataset.country;
                document.getElementById('hotel-info-popup-phone').textContent = button.dataset.phone;
                document.getElementById('hotel-info-popup-link').href = button.dataset.link;

                // Set images
                const imageContainer = document.getElementById('hotel-info-popup-images');
                imageContainer.innerHTML = `
                    <img src="${button.dataset.image1}" alt="Hotel Image 1">
                    <img src="${button.dataset.image2}" alt="Hotel Image 2">
                `;

                // Show popup with animation
                const popup = document.getElementById('hotel-info-popup-container');
                popup.style.display = 'flex';
                popup.style.animation = "hotel-info-fadeIn 0.3s ease";
            });
        });
    </script>
</x-layout.hotelinfo>

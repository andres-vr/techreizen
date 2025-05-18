<x-layout.deletePopup>
    <div id="delete-popup-overlay" style="display: none; padding: 2rem; background-color: rgba(0, 0, 0, 0.6); position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000;">
        <div class="hotel-popup-container" style="display: flex; flex-direction: column; background-color: #fff; border-radius: 1rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); overflow: hidden; max-width: 900px; width: 90%; height: auto; position: relative;">
            <h1 style="color: #333; margin-bottom: 20px;">Hotel verwijderen</h1>
            <p style="color: #666; margin-bottom: 25px;">Weet u zeker dat u dit hotel wilt verwijderen?<br>Alles gaat verloren!</p>

            <form id="delete-form" method="POST" action="" style="margin-bottom: 15px;">
                @csrf
                <button type="submit" id="delete-button" style="background-color: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-size: 16px; width: 125px; margin-right: 10px;">Verwijderen</button>
            </form>

            <button onclick="closeHotelPopup()" style="background-color: #95a5a6; color: white; border: none; width: 125px; padding: 10px 20px; border-radius: 5px; font-size: 16px;">Annuleren</button>
        </div>
    </div>

<style>
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
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-hotel').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const hotelId = button.dataset.id;
                    
                    const popup = document.getElementById('delete-popup-overlay');
                    const form = document.getElementById('delete-form');
                    
                    form.action = `/delete-hotels/${hotelId}`;
                    console.log("Form action set to:", form.action);

                    popup.style.display = 'flex';
                    popup.style.justifyContent = 'center';
                    popup.style.alignItems = 'center';
                    popup.style.animation = "fadeIn 0.3s ease";
                    console.log("Delete popup opened for hotel ID:", hotelId);
                });
            });
        });

        function closeHotelPopup() {
            const overlay = document.getElementById('delete-popup-overlay');
            if (overlay) {
                overlay.style.animation = "fadeOut 0.3s ease";
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 300);
            }
        }
</script>
</x-layout.deletePopup>
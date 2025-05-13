<x-layout.deleteHotelPopup>
    <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif;" class="delete-hotel">
        <h1 style="color: #333; margin-bottom: 20px;">Hotel verwijderen</h1>
        <p style="color: #666; margin-bottom: 25px;">Weet u zeker dat u dit hotel wilt verwijderen?
            <br> alles gaat verloren!
        </p>
        <form method="POST" action="{{ route('hotels.delete', $id) }}" style="margin-bottom: 15px;">
            @csrf
            <button type="submit"
                style="
                background-color: #e74c3c;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 16px;
                width: 125px;
                margin-right: 10px;
            ">Verwijderen</button>
        </form>

        <form method="GET" action="{{ route('hotels.show') }}">
            <button
                style="
            background-color: #95a5a6;
            color: white;
            border: none;
            width: 125px;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            margin-right: 10px;
        ">Annuleren</button>
        </form>
    </div>
</x-layout.deleteHotelPopup>

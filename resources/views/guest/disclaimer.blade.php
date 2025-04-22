@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-start" style="min-height: 100vh; padding-top: 20px;">
        <div style="width: 100%; max-width: 600px;">
            <h1 style="padding-bottom: 15px; text-align: center;">Disclaimer</h1>
            <ul>
                <li>De gegevens die u verstrekt, worden uitsluitend gebruikt voor het verwerken van uw aanvraag voor een
                    buitenlandse reis.</li>
                <li>Wij zullen uw gegevens niet delen met derden zonder uw toestemming, tenzij dit wettelijk verplicht is.
                </li>
                <li>Uw gebruik van deze website en het verstrekken van uw gegevens is geheel op eigen risico.</li>
            </ul>
            <form action="{{ route('guest.disclaimer') }}" method="POST" style="text-align: center;">
                @csrf
                <button type="submit" class="btn btn-primary">Accepteer en Doorgaan</button>
            </form>
            <p style="font-size: 0.8em; padding-top: 10px;  text-align: center;">Als u vragen heeft over deze disclaimer, neem dan contact met ons op.</p>

        </div>
    </div>
@endsection
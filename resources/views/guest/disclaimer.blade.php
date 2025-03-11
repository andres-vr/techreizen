@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Disclaimer</h1>
        <ul>
            <li>De gegevens die u verstrekt, worden uitsluitend gebruikt voor het verwerken van uw aanvraag voor een
                buitenlandse reis.</li>
            <li>Wij zullen uw gegevens niet delen met derden zonder uw toestemming, tenzij dit wettelijk verplicht is.</li>
            <li>Uw gebruik van deze website en het verstrekken van uw gegevens is geheel op eigen risico.</li>
        </ul>
        <p>Als u vragen heeft over deze disclaimer, neem dan contact met ons op.</p>
        <form action="{{ route('guest.disclaimer') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Accepteer en Doorgaan</button>
        </form>
    </div>
@endsection
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie Bevestiging</title>
</head>

<body>
    <h1>Bevestiging van uw registratie</h1>
    <p>Beste {{ $registration->first_name }} {{ $registration->last_name }},</p>
    <p>Bedankt voor uw registratie. Hieronder vindt u een overzicht van de door u ingevulde gegevens:</p>

    <h3>Basisgegevens</h3>
    <ul>
        <li><strong>Reis:</strong> {{ $registration->trip ?? 'Niet ingevuld' }}</li>
        <li><strong>Studentnummer:</strong> {{ $registration->student_number ?? 'Niet ingevuld' }}</li>
        <li><strong>Opleiding:</strong> {{ App\Models\Education::find($registration->education)->name ?? 'Niet ingevuld' }}</li>
        <li><strong>Afstudeerrichting:</strong> {{ $registration->major ?? 'Niet ingevuld' }}</li>
    </ul>

    <h3>Persoonlijke Gegevens</h3>
    <ul>
        <li><strong>Naam:</strong> {{ $registration->first_name }} {{ $registration->last_name }}</li>
        <li><strong>Geslacht:</strong> {{ $registration->gender }}</li>
        <li><strong>Geboortedatum:</strong> {{ $registration->date_of_birth }}</li>
        <li><strong>Geboorteplaats:</strong> {{ $registration->place_of_birth }}</li>
        <li><strong>Nationaliteit:</strong> {{ $registration->nationality ?? 'Niet ingevuld' }}</li>
        <li><strong>Adres:</strong> {{ $registration->address }}</li>
        <li><strong>Gemeente:</strong> {{ $registration->city }}</li>
        <li><strong>Land:</strong> {{ $registration->country }}</li>
    </ul>

    <h3>Contactgegevens</h3>
    <ul>
        <li><strong>E-mailadres:</strong> {{ $registration->email }}</li>
        <li><strong>Telefoon:</strong> {{ $registration->phone }}</li>
        <li><strong>Noodnummer 1:</strong> {{ $registration->emergency_contact }}</li>
        <li><strong>Noodnummer 2:</strong> {{ $registration->optional_emergency_contact ?? 'Niet ingevuld' }}</li>
    </ul>

    <h3>Medische Gegevens</h3>
    <ul>
        <li><strong>Medische informatie:</strong>
            @if(isset($registration->medical_info) && $registration->medical_info == 'yes')
                Ja
            @else
                Nee
            @endif
        </li>
        @if(isset($registration->medical_info) && $registration->medical_info == 'yes')
            <li><strong>Details:</strong> {{ $registration->medical_details ?? 'Geen details opgegeven' }}</li>
        @endif
    </ul>
    
    <p>Als u vragen heeft, neem dan contact met ons op.</p>
    <p>Met vriendelijke groet,</p>
    <p>Het Techreizen Team</p>
</body>

</html>
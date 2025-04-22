<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie Bevestiging</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
        h1 {
            color: #0066cc;
        }
        h3 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 5px;
        }
        .credentials {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #0066cc;
        }
        .password {
            font-family: monospace;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Bevestiging van uw registratie</h1>
    </div>
    
    <div class="content">
        <p>Beste {{ $registration->first_name }} {{ $registration->last_name }},</p>
        <p>Bedankt voor uw registratie. Uw account is succesvol aangemaakt en u bent nu geregistreerd voor de reis.</p>
        
        <div class="credentials">
            <h3>Uw inloggegevens</h3>
            <p><strong>Gebruikersnaam:</strong> {{ $registration->student_number }}</p>
            <p><strong>Wachtwoord:</strong> <span class="password">{{ $registration->password ?? 'Uw bestaande wachtwoord' }}</span></p>
            <p>U kunt inloggen op <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
        </div>

        <h3>Uw geregistreerde gegevens</h3>
        
        <h4>Basisgegevens</h4>
        <ul>
            <li><strong>Reis:</strong> {{ $registration->trip ?? 'Niet ingevuld' }}</li>
            <li><strong>Studentnummer:</strong> {{ $registration->student_number ?? 'Niet ingevuld' }}</li>
            <li><strong>Opleiding:</strong> {{ App\Models\Education::find($registration->education)->name ?? 'Niet ingevuld' }}</li>
            <li><strong>Afstudeerrichting:</strong> {{ $registration->major ?? 'Niet ingevuld' }}</li>
        </ul>

        <h4>Persoonlijke Gegevens</h4>
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

        <h4>Contactgegevens</h4>
        <ul>
            <li><strong>E-mailadres:</strong> {{ $registration->email }}</li>
            <li><strong>Telefoon:</strong> {{ $registration->phone }}</li>
            <li><strong>Noodnummer 1:</strong> {{ $registration->emergency_contact }}</li>
            <li><strong>Noodnummer 2:</strong> {{ $registration->optional_emergency_contact ?? 'Niet ingevuld' }}</li>
        </ul>

        <h4>Medische Gegevens</h4>
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
        
        <p>Als u vragen heeft of wijzigingen wilt aanbrengen in uw gegevens, neem dan contact met ons op.</p>
        
        <p>Met vriendelijke groet,<br>
        Het TechReizen Team</p>
    </div>
    
    <div class="footer">
        <p>Dit is een automatisch gegenereerd bericht. Gelieve niet te antwoorden op deze e-mail.</p>
        <p>&copy; {{ date('Y') }} TechReizen. Alle rechten voorbehouden.</p>
    </div>
</body>
</html>
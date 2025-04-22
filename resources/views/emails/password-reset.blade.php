<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Wachtwoord Reset</title>
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
        .password {
            font-family: monospace;
            font-size: 18px;
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            display: inline-block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>TechReizen</h2>
    </div>

    <div class="content">
        <h3>Uw wachtwoord is gereset</h3>
        
        <p>Beste {{ $user->login }},</p>
        
        <p>Uw wachtwoord voor TechReizen is gereset volgens uw verzoek. Hieronder vindt u uw nieuwe inloggegevens:</p>
        
        <p><strong>Gebruikersnaam:</strong> {{ $user->login }}</p>
        <p><strong>Nieuw wachtwoord:</strong> <span class="password">{{ $password }}</span></p>
        
        <p>U kunt inloggen met deze gegevens via <a href="{{ config('app.url') . route('login', [], false) }}">onze website</a>.</p>
        
        <p>Wij raden u aan om dit wachtwoord zo snel mogelijk te wijzigen na het inloggen.</p>
        
        <p>Als u dit verzoek niet heeft gedaan, neem dan direct contact op met onze klantenservice.</p>
        
        <p>Met vriendelijke groet,<br>
        Het TechReizen Team</p>
    </div>

    <div class="footer">
        <p>Dit is een automatisch gegenereerd bericht. Gelieve niet te antwoorden op deze e-mail.</p>
        <p>&copy; {{ date('Y') }} TechReizen. Alle rechten voorbehouden.</p>
    </div>
</body>
</html>

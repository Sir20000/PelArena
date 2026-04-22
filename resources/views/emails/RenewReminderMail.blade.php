<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renouvellement de votre service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rappel : Renouvellement de votre service</h2>
        <p>Bonjour,</p>
        <p>Votre service <strong>{{ $service->name }}</strong> expirera le <strong>{{ $service->expiry_date }}</strong>. Pour éviter toute interruption, nous vous recommandons de renouveler votre abonnement dès maintenant.</p>
        <p><a href="{{ $renewalLink }}" class="btn">Renouveler maintenant</a></p>
        <p>Merci de votre confiance.</p>
        <p>L'équipe {{ config('app.name') }}</p>
    </div>
</body>
</html>
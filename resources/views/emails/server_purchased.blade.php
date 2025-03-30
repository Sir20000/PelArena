<!DOCTYPE html>
<html>
<head>
    <title>Votre commande de serveur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #0056b3;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bonjour,</h1>
        <p>Merci d'avoir commandé un serveur chez nous. Voici les détails de votre commande :</p>
        
        <ul>
            <li><strong>Nom du serveur :</strong> {{ $serverDetails['server_name'] }}</li>
            <li><strong>Coût total :</strong> {{ number_format($serverDetails['cost'], 2) }} €</li>
        </ul>
        
        <p>Nous espérons que vous apprécierez votre nouveau serveur. Si vous avez des questions, n'hésitez pas à nous contacter.</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ env('APP_NAME') }}. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>

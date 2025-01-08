<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de devis</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto my-8 px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-green-600 p-4">
                <h3 class="text-white text-lg font-semibold">Nouvelle demande de devis de <strong>{{$quote->name}}</strong></h3>
            </div>
            <div class="p-6">
                <p class="text-gray-700">Bonjour,</p>
                <p class="mt-2 text-gray-700">Vous avez reçu une nouvelle demande de devis. Voici les détails fournis par le client :</p>
                <ul class="mt-4 space-y-3">
                    <li class="bg-gray-100 p-4 rounded-lg">
                        <span class="font-semibold">Nom :</span> {{$quote->name}}
                    </li>
                    <li class="bg-gray-100 p-4 rounded-lg">
                        <span class="font-semibold">Email :</span> {{$quote->email}}
                    </li>
                    <li class="bg-gray-100 p-4 rounded-lg">
                        <span class="font-semibold">Téléphone :</span> {{$quote->tel}}
                    </li>
                    <li class="bg-gray-100 p-4 rounded-lg">
                        <span class="font-semibold">Type de service :</span> {{$quote->dev}}
                    </li>
                    <li class="bg-gray-100 p-4 rounded-lg">
                        <span class="font-semibold">Personnalité:</span>{{$quote->personality}}
                    </li>
                    <li class="bg-gray-100 p-4 rounded-lg">
                        <span class="font-semibold">Description du projet :</span><br> {{$quote->description}}
                    </li>
                    <li class="bg-gray-100 p-4 rounded-lg">
                        <span class="font-semibold">Budget estimé :</span> {{$quote->budget}}
                    </li>
                    
                </ul>
                <p class="mt-6 text-gray-700">Veuillez contacter le client pour discuter plus en détail de cette demande de devis.</p>
                <p class="mt-2 text-gray-700">Cordialement,</p>
            </div>
            <div class="bg-gray-100 p-4 text-center text-gray-500">
                <small>Ce message a été envoyé automatiquement depuis le formulaire de demande de devis de votre application.</small>
            </div>
        </div>
    </div>
</body>
</html>

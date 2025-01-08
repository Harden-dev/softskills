<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de contact</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Nouvelle demande de contact de <strong>{{$contact->name}}</strong></h3>
            </div>
            <div class="card-body">
                <p>Bonjour,</p>
                <p>Vous avez reçu une nouvelle demande de contact. Voici les détails fournis par le client :</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nom :</strong>{{$contact->name}}</li>
                    <li class="list-group-item"><strong>Email :</strong> {{$contact->email}}</li>
                    <li class="list-group-item"><strong>Téléphone :</strong> {{$contact->tel}}</li>
                    <li class="list-group-item"><strong>Message :</strong> <br> {{$contact->message}}</li>
                </ul>
                <p class="mt-3">Veuillez répondre à cette demande dans les plus brefs délais.</p>
                <p>Cordialement,</p>
                <p><strong>{{$contact->name}}/strong></p>
            </div>
            <div class="card-footer text-muted text-center">
                <small>Ce message a été envoyé automatiquement depuis le formulaire de contact de votre application.</small>
            </div>
        </div>
    </div>
</body>
</html>

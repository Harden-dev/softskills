<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Devis Notification</title>
    <style>
        /* Styles Bootstrap manuellement ajoutés */
        .bg-red-100 {
            background: linear-gradient(to bottom, #29265B, #6c2d33); /* Dégradé de fond */
            color: #fff; /* Couleur du texte */
            min-height: 100vh; /* Hauteur minimum pour occuper toute la hauteur de la vue */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }

        .card {
            margin: 10% auto; /* Centrer la carte verticalement et horizontalement */
            max-width: 600px; /* Largeur maximale de la carte */
            padding: 20px;
            min-width: 0;
            word-wrap: break-word;
            background-color: #000000;
            background-clip: border-box;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
       
          

        .rounded-3xl {
            border-radius: 3rem;
        }

        .px-4 {
            padding-right: 1rem !important;
            padding-left: 1rem !important;
        }

        .py-8 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        .p-lg-10 {
            padding: 6rem !important;
        }

        .mb-6 {
            margin-bottom: 1.5rem !important;
        }

        .text-center {
            text-align: center !important;
        }

        .p-2 {
            padding: 0.5rem !important;
        }

        .w-full {
            width: 100% !important;
        }

        .text-right {
            text-align: right !important;
        }

        

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .my-6 {
            margin-top: 3rem !important;
            margin-bottom: 3rem !important;
        }

        h3{
            color: #fdfdfd;
            font-size: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>

<body class="bg-red-100">
    <div class="container">
      
        <div class="card rounded-3xl px-4 py-8 p-lg-10 mb-6">
            {{-- <img class="img" src={{URL::asset('assets/images/softskills.jpeg')}} alt=""> --}}
            <h3 class="text-center">RECEPTION DE LA PART DE  {{ $devisDetails['nom_client'] }}</h3>
            <table class="p-2 w-full">
                <tbody>
                    <tr>
                        <td>Type de Service</td>
                        <td class="text-right">{{ $devisDetails['type_service'] }}</td>
                    </tr>
                    <tr>
                        <td>Budget</td>
                        <td class="text-right">{{ $devisDetails['budget'] }}</td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td class="text-right">{{ $devisDetails['email'] }}</td>
                    </tr>
                    <tr>
                        <td>Numero de télephone</td>
                        <td class="text-right">{{ $devisDetails['num_tel'] }}</td>
                    </tr>
                    <tr>
                        <td class="fw-700 border-top">Description</td>
                        <td class="fw-700 text-right border-top">{{ $devisDetails['description'] }}</td>
                    </tr>
                </tbody>
            </table>
            <hr class="my-6">
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Traite du Chèque</title>
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>
    <h1>Traite du Chèque #{{ $cheque->numero }}</h1>
    <p><strong>Montant :</strong> {{ $cheque->montant }} DH</p>
    <p><strong>Tiers :</strong> {{ $cheque->tiers }}</p>
    <p><strong>Banque :</strong> {{ $cheque->banque }}</p>
    <p><strong>Date d’échéance :</strong> {{ $cheque->date_echeance->format('d/m/Y') }}</p>
</body>
</html>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression directe - Chèque n°{{ $cheque->numero }}</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; }
        .contenu { border: 2px solid black; padding: 20px; width: 80%; margin: auto; }
    </style>
</head>
<body onload="window.print()">
    <div class="contenu">
        <h2>Traite du Chèque</h2>
        <p><strong>Numéro :</strong> {{ $cheque->numero }}</p>
        <p><strong>Montant :</strong> {{ number_format($cheque->montant, 2) }} DT</p>
        <p><strong>Tiers :</strong> {{ $cheque->tiers }}</p>
        <p><strong>Banque :</strong> {{ $cheque->banque }}</p>
        <p><strong>Échéance :</strong> {{ $cheque->date_echeance->format('d/m/Y') }}</p>
    </div>
</body>
</html>

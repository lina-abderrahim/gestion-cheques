<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Traite - Chèque n°{{ $cheque->numero }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #000; }
    </style>
</head>
<body>
    <h2>TRAITE - Chèque n°{{ $cheque->numero }}</h2>
    <table>
        <tr><th>Montant</th><td>{{ number_format($cheque->montant, 3, ',', ' ') }} TND</td></tr>
        <tr><th>Tiers</th><td>{{ $cheque->tiers }}</td></tr>
        <tr><th>Banque</th><td>{{ $cheque->banque }}</td></tr>
        <tr><th>Date d’échéance</th><td>{{ $cheque->date_echeance->format('d/m/Y') }}</td></tr>
        <tr><th>Type</th><td>{{ ucfirst($cheque->type) }}</td></tr>
    </table>
</body>
</html>

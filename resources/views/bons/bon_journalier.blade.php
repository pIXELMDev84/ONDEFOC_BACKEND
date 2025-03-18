<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon Journalier</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .details, .products { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details td, .products td, .products th { border: 1px solid #000; padding: 5px; text-align: left; }
        .products th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bon Journalier</h1>
        <p><strong>Date :</strong> {{ $bonJournalier->date }}</p>
    </div>

    <table class="products">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité Retirée</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bonJournalier->consommations as $consommation)
                <tr>
                    <td>{{ $consommation->produit->nom }}</td>
                    <td>{{ $consommation->quantite_retirer }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Quantité Retirée :</strong> {{ $bonJournalier->consommations->sum('quantite_retirer') }}</p>
</body>
</html>

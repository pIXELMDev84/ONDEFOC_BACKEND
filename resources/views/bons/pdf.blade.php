<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .details, .products {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bon de Commande</h1>
    </div>
    <div class="details">
        <p><strong>Code :</strong> {{ $bon->code }}</p>
        <p><strong>Fournisseur :</strong> {{ $bon->fournisseur->nom }}</p>
        <p><strong>Téléphone du Fournisseur :</strong> {{ $bon->fournisseur->num_telephone }}</p>
        <p><strong>Date :</strong> {{ $bon->date }}</p>
    </div>
    <div class="products">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>TVA (%)</th>
                    <th>Prix Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $bon->produit_name }}</td>
                    <td>{{ $bon->quantite }}</td>
                    <td>{{ number_format($bon->prix_unitaire, 2) }} DA</td>
                    <td>{{ $bon->tva }}</td>
                    <td>{{ number_format($bon->prix_total, 2) }} DA</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

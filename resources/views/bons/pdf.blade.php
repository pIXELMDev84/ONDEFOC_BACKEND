<!DOCTYPE html>
<html lang="fr">
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-center {
            text-align: center;
        }
        .header-center h1, .header-center h2, .header-center h3 {
            margin: 5px 0;
        }
        .header-center h1 {
            font-size: 18px;
        }
        .header-center h2 {
            font-size: 16px;
        }
        .header-center h3 {
            font-size: 14px;
        }
        .details, .products {
            margin-bottom: 20px;
        }
        .details p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .totaux {
            text-align: right;
            margin-top: 10px;
        }
        .totaux p {
            font-weight: bold;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-center">
            <h1>RÉPUBLIQUE ALGÉRIENNE DÉMOCRATIQUE ET POPULAIRE</h1>
            <h2>MINISTÈRE DE LA FORMATION ET DE L'ENSEIGNEMENT PROFESSIONNELS</h2>
            <h3>OFFICE NATIONAL DE DÉVELOPPEMENT ET DE PROMOTION DE LA FORMATION CONTINUE</h3>
        </div>
    </div>

    <div class="details">
        <p><strong>Code :</strong> {{ $bon->code }}</p>
        <p><strong>Fournisseur :</strong> {{ $bon->fournisseur->nom }}</p>
        <p><strong>Téléphone du Fournisseur :</strong> {{ $bon->fournisseur->num_telephone }}</p>
        <p><strong>Date :</strong> {{ $bon->date }}</p>
    </div>

    <div class="products">
        <table>
            <tr>
                <th>Produit</th>
                <th>Unité</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>TVA (%)</th>
                <th>Prix Total</th>
            </tr>
            <tr>
                <td>{{ $bon->produit_name }}</td>
                <td>{{ $bon->unite }}</td>
                <td>{{ $bon->quantite }}</td>
                <td>{{ number_format($bon->prix_unitaire, 2) }} DA</td>
                <td>{{ $bon->tva }}</td>
                <td>{{ number_format($bon->prix_total, 2) }} DA</td>
            </tr>
        </table>

        <div class="totaux">
            <p>Total HT : {{ number_format($total_ht, 2) }} DA</p>
            <p>TVA ({{ $bon->tva }}%) : {{ number_format($total_tva, 2) }} DA</p>
            <p><strong>Total TTC : {{ number_format($total_ttc, 2) }} DA</strong></p>
        </div>
</body>
</html>

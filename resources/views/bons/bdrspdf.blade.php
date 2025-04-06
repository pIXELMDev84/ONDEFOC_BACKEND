<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Réception</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-left img {
            width: 200px;
            height: auto;
        }

        .header-right {
            text-align: right;
        }

        .header-right h1 {
            font-size: 24px;
            color: #82354B;
            margin: 0;
        }

        .header-right p {
            margin: 5px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #82354B;
            color: white;
            text-align: center;
        }

        table, th, td {
            border: 1px solid #82354B;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .totaux {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
        }

        .totaux strong {
            font-size: 16px;
        }

    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <img src="{{ $base64Image }}" alt="Logo">
        </div>
        <div class="header-right">
            <h1>Bon de Réception N° {{ $bonInfo->code }}</h1>
            <p>Date de création : {{ $bonInfo->created_at }}</p>
        </div>
    </div>

    <div class="details">
        <p><strong>Fournisseur :</strong> {{ $fournisseur->nom }}</p>
        <p><strong>Code Commande :</strong> {{ $bon_commande_code }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité Reçue</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $produit)
                <tr>
                    <td>{{ $produit->produit }}</td>
                    <td>{{ $produit->quantite_recu }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totaux">
        <p><strong>Total Quantité Reçue : {{ $total_quantite }}</strong></p>
    </div>
</body>
</html>

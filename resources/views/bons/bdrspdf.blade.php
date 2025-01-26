<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Réception</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 150px;
        }
        .details, .products {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details td, .products td, .products th {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .products th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $base64Image }}" alt="Logo">
        <h1>Bon de Réception</h1>
        <p><strong>Code :</strong> {{ $bonInfo->code }}</p>
        <p><strong>Date :</strong> {{ $bonInfo->created_at }}</p>
    </div>

    <table class="details">
        <tr>
            <td><strong>Fournisseur :</strong> {{ $fournisseur->nom }}</td>
            <td><strong>Code Commande :</strong> {{ $bon_commande_code }}</td>
        </tr>
    </table>

    <table class="products">
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

    <p><strong>Total Quantité Reçue :</strong> {{ $total_quantite }}</p>
</body>
</html>

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
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid black;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.header-left img {
    width: 200px; /* Augmentez cette valeur pour agrandir le logo */
    height: auto; /* Maintenir les proportions */
}

.header-right {
    text-align: right;
}

.header-right h1 {
    font-size: 24px; /* Augmentez la taille du titre si nécessaire */
    color: #82354B;
    margin: 0;
}

.header-right p {
    margin: 5px 0;
    font-size: 12px;
}


        .details {
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

        .totaux p {
            margin: 5px 0;
        }

        .totaux strong {
            font-size: 16px;
        }

        .summary {
            border-top: 2px solid #82354B;
            padding-top: 10px;
        }
    </style>
</head>
<body>
        <div class="header-left">
            <img src="{{$base64Image}}" alt="Logo">
        </div>
        <div class="header-right">
            <h1>Bon de Commande N° {{$bonInfo->code}}</h1>
            <p>Date de création : {{$bonInfo->created_at}}</p>
        </div>

    <div class="details">
        <p><strong>Fournisseur :</strong> {{ $fournisseur->nom }}</p>
        <p><strong>Téléphone du Fournisseur :</strong> {{ $fournisseur->num_telephone }}</p>
    </div>

    <div class="products">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Unité</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>TVA (%)</th>
                    <th>Prix Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bon as $index => $produit)
                <tr>
                    <td>{{ $produit->produit_name }}</td>
                    <td>{{ $produit->unite }}</td>
                    <td>{{ $produit->quantite }}</td>
                    <td>{{ number_format($produit->prix_unitaire, 2) }} DA</td>
                    <td>{{ $produit->tva }}</td>
                    <td>{{ number_format($produit->prix_total, 2) }} DA</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totaux summary">
            <p>Total HT : {{ number_format($total_ht, 2) }} DA</p>
             <p>Total TVA :{{ number_format($total_tva, 2) }} DA</p>
            <p><strong>Total TTC : {{ number_format($total_ttc, 2) }} DA</strong></p>
        </div>
    </div>
</body>
</html>

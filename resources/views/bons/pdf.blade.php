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
        .logo-left img, .logo-right img {
            height: 80px;
        }
        .header-center {
            text-align: center;
        }
        .header-center h1 {
            font-size: 18px;
            margin: 5px 0;
        }
        .header-center h2 {
            font-size: 16px;
            margin: 5px 0;
        }
        .header-center h3 {
            font-size: 14px;
            margin: 5px 0;
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

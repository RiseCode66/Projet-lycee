<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">


        <div style="display: none">{!! $sumCoeff=0 !!}</div>
        <div style="display: none">{!! $sumTotal=0 !!}</div>
        <div class="card-title">Resultat du {{ $myItems[1]->nom }}</div>
        <table class="table">
                <thead>
                    <th>Nom et prénom</th>
                    <th>moyenne</th>
                </thead>
                <tbody>
                    @if (count($myItems)==0)
                            <tr>
                                <td colspan="6">Pas de note pour le moment</td>
                            </tr>
                    @endif

                        @foreach ($myItems[0] as $item)
                            <tr>
                            <td>{{ $item->nom }} {{ $item->prenom }}</td>

                            @if (number_format($item->moyenne,0)-number_format($item->moyenne,2)<0.05)
                            <td>{{ number_format($item->moyenne+(number_format($item->moyenne,0)-number_format($item->moyenne,2)),2) }}</td>

                            @else
                            <td>{{ number_format($item->moyenne,2) }}</td>
                            @endif
                                </tr>
                    @endforeach
                </tbody>
            </table>

        <div class="footer">
            <p>Fait le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>

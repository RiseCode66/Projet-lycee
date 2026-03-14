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
        <h1>Bulletin de Notes</h1>

        <table>
            <tr>
                <th>Nom de l'élève</th>
                <td>{{ $myItems[0][0]->nom }} {{ $myItems[0][0]->prenom }}</td>
            </tr>
            <tr>
                <th>Date de Naissance</th>
                <td>{{ \Carbon\Carbon::parse($myItems[0][0]->dtn)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Niveau</th>
                <td>{{ $myItems[0][0]->nom }}</td>
            </tr>
        </table>

        <div style="display: none">{!! $sumCoeff=0 !!}</div>
        <div style="display: none">{!! $sumTotal=0 !!}</div>
        <table class="table">
                <thead>
                    <th>Matière</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @if (count($myItems[1])==0)
                            <tr>
                                <td colspan="6">Pas de note pour le moment</td>
                            </tr>
                    @endif

                        @foreach ($myItems[1] as $item)
                            <tr>
                                <div style="display: none">{!! $sumCoeff+=$item->coeff !!}</div>
                                <div style="display: none">{!! $sumTotal+=$item->coeff*$item->note !!}</div>                                            <td>{{ $item->nomM }}</td>
                            <td>{{ number_format($item->note,2) }}</td>
                            <td>{{ $item->coeff }}</td>
                            <td>{{ number_format($item->coeff*$item->note,2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p>Total des points : {{ number_format($sumTotal,2) }}</p>
            <p>Moyenne : {{ number_format($sumTotal/$sumCoeff,2) }}</p>

        <div class="footer">
            <p>Fait le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>

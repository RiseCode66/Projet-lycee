<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes {{ $myItems[0][0]->nom }} {{ $myItems[0][0]->prenom }}</title>
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
        @page {
    size: A4;
    margin: 20mm;
}
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    font-size: 10pt;
}
.container {
    page-break-inside: avoid;
}
table {
    page-break-inside: avoid;
}
tr, td, th {
    page-break-inside: avoid;
}
    </style>
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 800px;
                margin: auto;
                padding: 20px;
                border: 1px solid #ffffff;
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
            <div style="display: flex;height: 100px;">
            <div style="border: 0px solid black;width:20%;height:100px;float:left;text-align: center;"><img src="{{asset('assets/img/region.PNG')}}" alt="Logo Gauche" style="height: 100px;"></div>
            <div style="border: 1px solid black;width:30%;text-align: center;margin: 15%;margin-top: 0;margin-bottom: 0;padding-top: 30px;">Bulletin de notes</div>
            <div style="border: 0px solid black;width:20%;height:100px;float:right;text-align: center;"><img src="{{asset('assets/img/logo.PNG')}}" alt="Logo Droit" style="height: 150px;margin-top: -17px;"></div>
        </div>
        <h5>E-high<br>
            Adresse <br>
            mail@gmail.com</h5>

        <h5>De l’élève: {{ $myItems[0][0]->nom }} {{ $myItems[0][0]->prenom }}<br>
        Matricule: Elv00{{ $myItems[0][0]->id }} <br>
        Date de naissance: {{  \Carbon\Carbon::parse($myItems[0][0]->dtn)->translatedFormat('j F Y')  }}</h5>
        <h5 style="width: 100%">Classe :{{ $myItems[0][0]->nomN }} <div style="float: right">{{ $myItems[2]->nom }} <br>Année scolaire :{{ $myItems[2]->nomA }} </div> </h5>
        <div style="display: none">{!! $sumnotes=0 !!}</div>
        <div style="display: none">{!! $sumcoeff=0 !!}</div>
        <div style="display: none">{!! $sumTotal=0 !!}</div>
        <div style="display: flex">
            <table class="table" border="0.25" style="font-size: 8pt">
                <thead>
                    <th style="max-width: 100px;">Matière</th>
                    <!--@foreach ( $myItems[3] as $item)
                        <th>{{ $item['nom'] }}</th>
                    @endforeach-->
                    <th>Moyenne</th>
                    <th>Coef</th>
                    <th>Total</th>
                    <th>Emargement</th>

                </thead>
                <tbody>
                    @if (count($myItems)==0)
                            <tr>
                                <td colspan="6">Pas de note pour le moment</td>
                            </tr>
                    @endif
                        @foreach ($myItems[1] as $item)
                        <tr>
                            <div style="display: none">{{ $sumnotesM=0 }}</div>
                            <div style="display: none">{{ $nbr=0 }}</div>
                            <td style="max-width: 75px;">{{ $item[array_key_first($item)]['nom'] }}</td>
                                @for ($i=0;$i<array_key_last($item)+1;$i++)
                                @if (array_key_exists($i,$item))
                                <div style="display: none">{{ number_format($item[$i]['valeur'],2)  }}</div>
                                <div style="display: none">{{ $sumnotesM+=$item[$i]['valeur'] }}</div>
                                <div style="display: none">{{ $nbr+=1 }}</div>
                                @else
                                <div style="display: none"></div>
                                @endif
                            @endfor
                            <td><div style="display:none">{{ $sum=$sumnotesM/$nbr }}</div>
                                @if ($sum>0)
                                {{ number_format($sumnotesM/$nbr,2) }}
                                @else
                                    ABS
                                @endif
                                </td>
                            <td>{{ $coeff=$item[array_key_first($item)]['coeff'] }}</td>
                            <td> <div style="display: none">{{ $total=$sum*$coeff }}</div>{{ number_format($sum*$coeff,2) }} </td>
                            <div style="display: none">{{ $sumnotes+=$total }}</div>
                            <div style="display: none">{{ $sumcoeff+=$coeff }}</div>
                            @php
                            $a="";
                            for ($i=0; $i <count($myItems[5]) ; $i++) {
                                if ($myItems[5][$i]->idm==$item[array_key_first($item)]['id']) {
                                    $a=$myItems[5][$i]->valeur;
                                }
                            }
                            if($a=="")
                            {
                                if ($sum >= 18) {
        $a = "Excellente prestation. Travail sérieux et rigoureux. Bravo !";
    } elseif ($sum >= 16) {
        $a = "Très bon travail. L’élève maîtrise bien les notions. Continue ainsi.";
    } elseif ($sum >= 14) {
        $a = "Bon ensemble. Les résultats sont satisfaisants. Poursuis les efforts.";
    } elseif ($sum >= 12) {
        $a = "Travail correct. Quelques imprécisions à corriger pour progresser.";
    } elseif ($sum >= 10) {
        $a = "Résultats justes. Des efforts sont nécessaires pour consolider les bases.";
    } elseif ($sum >= 8) {
        $a = "Niveau fragile. L’élève doit redoubler d’efforts et revoir ses méthodes.";
    } elseif ($sum >= 6) {
        $a = "Travail insuffisant. Notions mal comprises. Une remise à niveau est urgente.";
    } else {
        $a = "Échec. Travail inexistant ou non adapté. Réaction immédiate attendue.";
    }
                            }
                        @endphp
<td>
    <div style="display: flex; align-items: center; gap: 10px;">
        <span>{{ $a }}</span>

        @php
            $idm = $item[array_key_first($item)]['id']; // ID de la matière
            $prof = $sig->firstWhere('idm', $idm); // Cherche le prof pour cette matière
        @endphp

        @if ($prof)
            <img src="{{ asset('storage/' . $prof->sign) }}" width="50px" alt="Signature">
        @else
            <span style="color: gray"></span>
        @endif
    </div>
</td>
        </tr>
                    @endforeach
                    <tr><td>Rang</td><td>{{ $myItems[4][2]['rang_annuel'] }}</td></tr>
                    <tr><td>Moyenne de classe:</td><td>{{ number_format($myItems[4][1]->moyenne,2) }}</td></tr>
                    @php
                        $sa=0;
                    @endphp
                    <tr>
                            @foreach ($na as $a)
                            @php
                                $sa+=$a->moyenne;
                            @endphp
                                <td>{{ $a->nom_periode }} : {{ number_format($a->moyenne,2) }}</td>
                            @endforeach
                </tr>
                @php
                $moy_annuelle = ($sa + ($sumnotes / $sumcoeff)) / (count($na) + 1);
            @endphp
            <tr>
                <td>Moyenne annuelle</td>
                <td>{{ number_format($moy_annuelle, 2) }}</td>
<!--                @if ($moy_annuelle < 12)
                    <td colspan="3" style="background-color: #ccc; font-weight: bold;">Hors tableau d'honneur</td>
                @endif-->
            </tr>
                                <tr></tr>
                    <tr style="width: 100%">
                        <td>Nombre d'absences</td><td style="80%">0</td>
                    </tr>
                    <tr>
                        <td>Professeur(e) principal(e)</td>
                        @if ($p)
                            <td>{{ $p->nom }} </td>
                            <td><img src="{{ asset('storage/' . $p->sign) }}" width="50px" alt="Signature"></td>
                        @else
                            <td>Non assigné</td>
                            <td><span style="color: gray">N/A</span></td>
                        @endif
                    </tr>
                </tbody>
            </table>

        </div>
        <div style="width: 100%"><div>Décision du conseil de classe :
            @if ($myAps!=null)
             {{ $myAps->valeur }}
             @else
             Admis en classe supérieure.
            @endif
        </div>
    <div style="width: 580px;float:right"> <hr></div></div>
        <div class="footer">
            <p>LE / LA PROVISEUR (E)</p>
            <br>
            <br>
            <p>Fait le {{ "20 Juin 2025 " /* \Carbon\Carbon::now()->format('d/m/Y')*/ }}</p>
        </div>
        </div>
</body>
</html>

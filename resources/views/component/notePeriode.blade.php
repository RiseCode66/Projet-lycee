@extends('base/baseAdmin')
@section('content')
<div style="display: none">{{ $sumnotes=0 }}</div>
<div style="display: none">{{ $sumcoeff=0 }}</div>
<div class="card">
    <div class="card-body">
        <div class="card-title">Bullettin de note {{ $myItems[2]->nom }} {{ $myItems[2]->nomA }}</div>
        <h6>Nom: {{ $myItems[0][0]->nom }}</h6>
        <h6>Prénom: {{ $myItems[0][0]->prenom }}</h6>
        <h6>Date de naissance: {{  \Carbon\Carbon::parse($myItems[0][0]->dtn)->translatedFormat('j F Y')  }}</h6>
        <h6>Classe :{{ $myItems[0][0]->nomN }}</h6>
        <div style="display: none">{!! $sumCoeff=0 !!}</div>
        <div style="display: none">{!! $sumTotal=0 !!}</div>
        <table class="table" border="1" style="font-size: 8pt">
                <thead>
                    <th style="max-width: 75px">Matière</th>
                    <th>Moyenne</th>
                    <th>Coefficient</th>
                    <th>Total</th>
                    <th>Professeur (e)</th>
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
                            <td style="max-width: 75px">{{ $item[array_key_first($item)]['nom'] }}</td>
                                @for ($i=0;$i<array_key_last($item)+1;$i++)
                                @if (array_key_exists($i,$item))
                                <div style="display: none">{{ number_format($item[$i]['valeur'],2)  }}</div>
                                <div style="display: none">{{ $sumnotesM+=$item[$i]['valeur'] }}</div>
                                <div style="display: none">{{ $nbr+=1 }}</div>
                                @else
                                <div style="display: none"></div>
                                @endif
                            @endfor
                            <td><div style="display:none">{{ $sum=$sumnotesM/$nbr }}</div>{{ number_format($sumnotesM/$nbr,2) }} </td>
                            <td>{{ $coeff=$item[array_key_first($item)]['coeff'] }}</td>
                            <td> <div style="display: none">{{ $total=$sum*$coeff }}</div>{{ number_format($sum*$coeff,2) }} </td>
                            <div style="display: none">{{ $sumnotes+=$total }}</div>
                            <div style="display: none">{{ $sumcoeff+=$coeff }}</div>
                            <td>
                                <form action="/saveImp" method="post">
                                    @csrf
                                    <input type="hidden" name="ide" value="{{ $myItems[0][0]->id }} ">
                                    <input type="hidden" name="idm" value="{{ $item[array_key_first($item)]['id'] }}">
                                    <input type="hidden" name="idp" value="{{ $myItems[2]->id }} ">
                                    @php
                                        $a="";
                                        for ($i=0; $i <count($myItems[5]) ; $i++) {
                                            if ($myItems[5][$i]->idm==$item[array_key_first($item)]['id']) {
                                                $a=$myItems[5][$i]->valeur;
                                            }
                                        }
                                    @endphp
                                    <input type="text" name="valeur" id="" value={{ $a }}>
                                    <input type="submit" value="entrer">
                                </form>
                            </td>
                            <td>
                                @php
                                    /*$idm = $item[array_key_first($item)]['id']; // ID de la matière
                                    $prof = $sig->firstWhere('idm', $idm); */// Cherche le prof pour cette matière
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                    <tr><td>Rang</td><td>{{ $myItems[4][0]->rang+1 }}</td></tr>
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
                <tr><td>Moyenne final</td><td>{{ number_format(($sa+($sumnotes/$sumcoeff))/(count($na)+1),2) }}</td></tr>
                    <tr></tr>
                </tbody>
            </table>

        </div>
        <form action="/modAppreciation" method="post">
        @csrf
        <input type="hidden" name="ide" value="{{ $myItems[0][0]->id }} ">
        <input type="hidden" name="idp" value="{{ $myItems[2]->id }} ">
        @if ($myAps!=null)
        <input type="text" name="valeur" value=" {{ $myAps->valeur }}" >
        @else
        <input type="text" name="valeur" value="" >
        @endif
        <input type="submit" value="entrer">
    </form>
</div>
@endsection

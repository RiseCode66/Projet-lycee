@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-title">Resultat du {{ $myItems[1]->nom }} pour la classe de {{ $myItems[3]->nom }}</div>
        <table class="table">
                <thead>
                    <th>Nom et prénom</th>
                    <th>moyenne</th>
                    <th>Détails</th>
                </thead>
                <tbody>
                    @if (count($myItems)==0)
                            <tr>
                                <td colspan="6">Pas de note pour le moment</td>
                            </tr>
                    @else
                    @foreach ($myItems[0] as $item)
                    <tr>
                    <td>{{ $item['nom'] }} {{ $item['prenom'] }}</td>

                    <td>{{ number_format($item->moyenne,2) }}</td>
                    <td>
                        <a href="/note?idex={{ $item->idEx }}&ide={{ $item->idE }}" class="btn btn-primary"><i class="bi bi-plus"></i></a>
                    </td>
                        </tr>
            @endforeach
            @endif

                </tbody>
            </table>
            <a href="/generateResultatExamPdf?idex={{$myItems[1]->id}}&idn={{ $myItems[2] }}">->pdf</a>
        </div>
</div>
@endsection

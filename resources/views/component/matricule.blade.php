@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Liste des élèves</h5>
    <p class="card-text"><a href="formPackage" class="btn btn-primary"><i class="bi bi-plus-square"></i></a></p>
    <form method="GET" action="/dashboard">
        <input type="text" name="nom" placeholder="Nom" value="{{ $filters['nom'] ?? '' }}">
        <input type="text" name="prenom" placeholder="Prénom" value="{{ $filters['prenom'] ?? '' }}">
        <input type="text" name="nomN" placeholder="Niveau" value="{{ $filters['nomN'] ?? '' }}">
        <input type="date" name="dtn" value="{{ $filters['dtn'] ?? '' }}">

        <button type="submit">Filtrer</button>
    </form>
        <table class="table datatable">
        <thead>
            <th></th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Classe</th>
            <th>Date de naissance</th>
        </thead>
        <tbody>
            @if (count($myItems)==0)
                    <tr>
                        <td colspan="6">Pas d'élèves pour le moment</td>
                    </tr>
            @endif
                @for($i=0;$i<count($myItems);$i++)
                <tr>
                    <td>{{ 'G'.$i }}</td>
                    <td>{{ $myItems[$i]->nom }}</td>
                    <td>{{ $myItems[$i]->prenom }}</td>
                    <td>{{ $myItems[$i]->nomN }}</td>
                    <td>{{ \Carbon\Carbon::parse($myItems[$i]->dtn)->translatedFormat('j F Y') }}</td>
                </tr>
                @endfor
        </tbody>
    </table>
    </div>
</div>
@endsection

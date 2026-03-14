@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body  border border-white">
        <h5 class="card-title text-">Détails de l'élève</h5>
        <p>Nom : {{ $nv->nom }} </p>
        <p>Prénom : {{ $nv->prenom }} </p>
        <p>Date de naissance : {{ \Carbon\Carbon::parse($nv->dtn)->translatedFormat('j F Y') }} </p>
        <p>Classe : {{ $nv->nomN }}</p>
        <p>Nombre d'absence : {{ $nv->abs }} jours</p>
        <a href="{{ url('/formAddLevel?id='.$myItems['1'] ) }}" class="btn btn-primary btn-sm">Changer classe</a>
    </div>
</div>
<div class="card">
    <div class="card-body  border border-white">
        <h5 class="card-title text-">Formulaire d'absence</h5>
        <form action="saveAbs" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="eleve_search" class="form-label">Nombre de jours d'absence</label>
                <input type="number" name="jours" class="form-control" placeholder="Taper le nombre de jour" autocomplete="off">
                <input type="hidden" name="ide" value="{{ $nv->id }}">
            </div>
            <div class="row mb-3">
                <label for="eleve_search" class="form-label">Date d'absence</label>
                <input type="date" name="dateDebut" class="form-control" placeholder="Taper la date" autocomplete="off">
            </div>
            <div class="row mb-3">
                <label for="eleve_search" class="form-label">Justification</label>
                <textarea name="raision" id="" placeholder="Décriver les raisions de l'absence"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>
</div>
<div class="card ">
    <div class="card-body  border border-white">
      <h5 class="card-title text-">Mes examens</h5>
    <p class="card-text"><a href="formNote" class="btn btn-primary">Ajouter examen</i></a></p>
    <table class="table datatable">
        <thead>
            <th>Nom</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @if (count($myItems[0])==0)
                    <tr>
                        <td colspan="6">Pas de examen pour le moment</td>
                    </tr>
            @endif

                @foreach ($myItems[0] as $item)
                    <tr>
                    <td>{{ $item->nom }}</td>
                    <td>
                        <a href="/note?idex={{ $item->id }}&ide={{ $myItems[1] }}" class="btn btn-primary"><i class="bi bi-plus"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
<div class="card ">
    <div class="card-body  border border-white">
      <h5 class="card-title text-">Mes bulletins</h5>
    <p class="card-text"><a href="formNote" class="btn btn-primary">Ajouter examen</i></a></p>
    <table class="table datatable">
        <thead>
            <th>Nom</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @if (count($myItems[2])==0)
                    <tr>
                        <td colspan="6">Pas de bulletins pour le moment</td>
                    </tr>
            @endif

                @foreach ($myItems[2] as $item)
                    <tr>
                    <td>{{ $item->nom }}</td>
                    <td>
                        <a href="/notePeriode?idp={{ $item->id }}&ide={{ $myItems[1] }}" class="btn btn-primary"><i class="bi bi-plus"></i></a>
                        <a href="/pdfPeriode?idp={{ $item->id }}&ide={{ $myItems[1] }}" class="btn btn-primary">pdf</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection

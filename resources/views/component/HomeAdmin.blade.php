@extends('base/baseAdmin')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Gestion des élèves</h5>

        <div class="mb-3">
            <a href="{{ url('formEleve') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajouter un élève
            </a>
        </div>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ url('/eleve') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="text" name="nom" class="form-control" placeholder="Nom" value="{{ request('nom') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="prenom" class="form-control" placeholder="Prénom" value="{{ request('prenom') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="nomN" class="form-control" placeholder="Classe" value="{{ request('nomN') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="dtn" class="form-control" value="{{ request('dtn') }}">
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i> Rechercher</button>
                <a href="{{ url('/eleve') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Réinitialiser</a>
            </div>
        </form>

        <!-- Tableau -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Matricules</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Classe</th>
                    <th>Date de naissance</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($myItems as $i => $eleve)
                    <tr>
                        <td>Elv00{{ $eleve->id }}</td>
                        <td>{{ $eleve->nom }}</td>
                        <td>{{ $eleve->prenom }}</td>
                        <td>{{ $eleve->nomN }}</td>
                        <td>{{ \Carbon\Carbon::parse($eleve->dtn)->translatedFormat('j F Y') }}</td>
                        <td class="text-center">
                            <a href="{{ url('/examEleve?id='.$eleve->id) }}" class="btn btn-info btn-sm"><i class="bi bi-journal-text"></i></a>
                            <a href="{{ url('/formModEleve?id='.$eleve->id) }}" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                            <a href="{{ url('/suprEleve?id='.$eleve->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet élève ?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Pas d'élèves trouvés</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

            {{ $myItems->links() }}

    </div>
</div>

@endsection

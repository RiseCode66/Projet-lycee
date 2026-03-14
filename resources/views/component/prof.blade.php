@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Gestion des professeurs</h5>

        <!-- Bouton Ajouter -->
        <div class="mb-3">
            <a href="{{ url('formProf') }}" class="btn btn-primary">
                <i class="bi bi-plus-square"></i> Ajouter un professeur
            </a>
        </div>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ url('/prof') }}" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="nom" class="form-control" placeholder="Nom du professeur" value="{{ request('nom') }}">
            </div>
            <div class="col-md-6 text-end">
                <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i> Rechercher</button>
                <a href="{{ url('/prof') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Réinitialiser</a>
            </div>
        </form>

        <!-- Tableau -->
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>
                        <a href="{{ url('/prof', array_merge(request()->all(), ['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                            Id
                        </a>
                    </th>
                    <th>
                        <a href="{{ url('/prof', array_merge(request()->all(), ['sort' => 'nom', 'order' => request('order') === 'asc' ? 'desc' : 'asc'])) }}">
                            Nom
                        </a>
                    </th>
                    <th>Signature</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myItems as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nom }}</td>
                        <td style="max-width: 100px">
                            @if($item->sign)
                                <img src="{{ asset('storage/'.$item->sign) }}" width="50px" alt="Signature">
                            @endif
                        </td>
                        <td>
                            <a href="/classProf?id={{ $item->id }}" class="btn btn-primary btn-sm"><i class="bi bi-plus"></i></a>
                            <a href="/formModProf?id={{ $item->id }}" class="btn btn-success btn-sm"><i class="bi bi-pen"></i></a>
                            <a href="/suprProf?id={{ $item->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce professeur ?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Pas de professeurs pour le moment</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $myItems->appends(request()->all())->links() }}
    </div>
</div>
@endsection

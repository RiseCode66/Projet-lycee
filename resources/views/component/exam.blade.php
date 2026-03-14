@extends('base/baseAdmin')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Gestion des examens</h5>

        <!-- Bouton Ajouter -->
        <div class="mb-3">
            <a href="{{ url('formExam') }}" class="btn btn-primary">
                <i class="bi bi-plus-square"></i> Ajouter un examen
            </a>
        </div>

        <!-- 🔍 Formulaire de recherche / filtre -->
        <form method="GET" action="{{ url('/exam') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="nom" class="form-control" placeholder="Nom de l'examen" value="{{ request('nom') }}">
            </div>

            <div class="col-md-4">
                <select name="idp" class="form-select">
                    <option value="">-- Période --</option>
                    @foreach($periodes as $p)
                        <option value="{{ $p->id }}" {{ request('idp') == $p->id ? 'selected' : '' }}>
                            {{ $p->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 text-end">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Rechercher
                </button>
                <a href="{{ url('/exam') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Réinitialiser
                </a>
            </div>
        </form>

        <!-- 🧾 Tableau -->
        <table class="table table-striped table-hover datatable">
            <thead>
                <tr>
                    <th>
                        <a href="{{ url('/exam?' . http_build_query(array_merge(request()->all(), ['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc']))) }}">
                            ID
                            @if(request('sort') === 'id')
                                <i class="bi bi-caret-{{ request('order') === 'asc' ? 'up' : 'down' }}-fill"></i>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="{{ url('/exam?' . http_build_query(array_merge(request()->all(), ['sort' => 'nom', 'order' => request('order') === 'asc' ? 'desc' : 'asc']))) }}">
                            Nom de l’examen
                            @if(request('sort') === 'nom')
                                <i class="bi bi-caret-{{ request('order') === 'asc' ? 'up' : 'down' }}-fill"></i>
                            @endif
                        </a>
                    </th>
                    <th>Période</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($myItems as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nom }}</td>
                        <td>{{ $item->periode_nom ?? 'Non définie' }}</td>
                        <td>
                            <a href="{{ url('/formModExam?id='.$item->id) }}" class="btn btn-success btn-sm">
                                <i class="bi bi-pen"></i>
                            </a>
                            <a href="{{ url('/suprExam?id='.$item->id) }}" class="btn btn-danger btn-sm"
                               onclick="return confirm('Voulez-vous vraiment supprimer cet examen ?')">
                                <i class="bi bi-trash"></i>
                            </a>
                            <a href="{{ url('/examDetails?id='.$item->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-info-circle"></i> Détails
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Aucun examen trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- 📄 Pagination -->
        <div class="d-flex justify-content-center">
            {{ $myItems->appends(request()->all())->links() }}
        </div>

    </div>
</div>
@endsection

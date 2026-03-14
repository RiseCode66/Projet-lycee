@extends('base/baseAdmin')
@section('content')
    <p class="card-text"><a href="formPeriode" class="btn btn-primary"><i class="bi bi-plus-square"></i></a></p>
    <table class="table datatable">
        <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Année scolaire</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @if (count($myItems)==0)
                    <tr>
                        <td colspan="6">Pas de période pour le moment</td>
                    </tr>
            @endif

                @foreach ($myItems as $item)
                    <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nom }}</td>
                    <td>{{ $item->nomA }}</td>
                    <td>
                        <a href="/formModPeriode?id={{ $item->id }}" class="btn btn-success"><i class="bi bi-pen"></i></a>
                        <a onclick="confirmer()" href="/suprPeriode?id={{ $item->id }}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

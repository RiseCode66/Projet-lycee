@extends('base/baseAdmin')
@section('content')
    <p class="card-text"><a href="formAnnesco" class="btn btn-primary"><i class="bi bi-plus-square"></i></a></p>
    <table class="table datatable">
        <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @if (count($myItems)==0)
                    <tr>
                        <td colspan="6">Pas de examen pour le moment</td>
                    </tr>
            @endif

                @foreach ($myItems as $item)
                    <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nom }}</td>
                    <td>
                        <a href="/formModAnnesco?id={{ $item->id }}" class="btn btn-success"><i class="bi bi-pen"></i></a>
                        <a onclick="confirmer()" href="/suprAnnesco?id={{ $item->id }}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

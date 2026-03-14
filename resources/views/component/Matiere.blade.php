@extends('base/baseAdmin')
@section('content')
    <p class="card-text"><a href="formMatiere" class="btn btn-primary"><i class="bi bi-plus-square"></i></a></p>
    <table class="table datatable">
        <thead>
            <th>Id</th>
            <th>Nom</th>
            <th>Actions</th>
        </thead>
        <tbody>

                @foreach ($myItems as $item)
                    <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nom }}</td>
                    <td>
                        <a href="/formModMatiere?id={{ $item->id }}" class="btn btn-success"><i class="bi bi-pen"></i></a>
                        <a onclick="confirmer()" href="/suprMatiere?id={{ $item->id }}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

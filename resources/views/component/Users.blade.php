@extends('base/baseAdmin')
@section('content')
    <table class="table datatable">
        <thead>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach ($myItems[0] as $item)
                @if (count($myItems)==0)

                    <tr>
                        <td colspan="6">Pas de commande pour le moment</td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $item->id }} </td>
                    <td>{{ $item->name }} </td>
                    <td>{{ $item->email }} </td>
                    @foreach ($myItems[1] as $type)
                        @if ($item->type==$type->value)
                            <td>{{ $type->nom }} </td>
                        @endif
                    @endforeach
                    <td>
                        <a href="/formModUser?id={{ $item['id'] }}" class="btn btn-success"><i class="bi bi-pen"></i> </a>
                        <a onclick="confirmer()" href="/suprUser?id={{ $item['id'] }}" class="btn btn-danger"><i class="bi bi-trash"></i> </a>
                    </td>
                </tr>
            @endforeach
    </tbody>
</table>
@endsection

@extends('base/baseAdmin')

@section('content')
<div class="card p-3">
    <div class="card-title">Mr/Mme {{ $myItem[0]->nom }} </div>
</div>
<div class="card p-3">
    <div class="card-title">Assigner le professeur</div>
    <form method="POST" action="/assignProf">
        @csrf
        <input type="hidden" name="idp" value="{{ $_GET['id'] }}">

        <div class="row mb-3">
            <label for="classeSelect" class="col-sm-2 col-form-label">Classe</label>
            <div class="col-sm-10">
                <select name="idn" class="form-select" id="classeSelect">
                    @foreach ($classe as $c)
                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="matiereSelect" class="col-sm-2 col-form-label">Matière</label>
            <div class="col-sm-10">
                <select name="idm" class="form-select" id="matiereSelect">
                    @foreach ($matieres as $m)
                        <option value="{{ $m->id }}">{{ $m->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Assigner</button>
            </div>
        </div>
    </form>
</div>
<div class="card p-3">
    <table class="table datatable mt-4">
        <thead>
            <tr>
                <th>Classe</th>
                <th>Matière</th>
                <th>Horaires</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($myItems as $item)
                <tr>
                    <td>{{ $item->nomN }}</td>
                    <td>{{ $item->nomM }}</td>
                    <td>
                        <ul>
                            @foreach ($emp as $e)
                            @if ($e->idm==$item->idm && $e->idn==$item->idn)
                                <li>{{ $jour[$e->jour] }} : {{ $heure[$e->heure] }}</li>
                            @endif
                            @endforeach

                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection

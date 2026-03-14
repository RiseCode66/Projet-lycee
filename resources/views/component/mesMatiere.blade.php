@extends('base/baseAdmin')
@section('content')
<div class="card p-3">
    <p>Selectionner prof principale pour la classe {{ $nv->nom }} </p>
    <p>PP actuel : {{ $p->nom ?? 'non assigé' }} </p>
    <form method="POST" action="/assignPP">
        @csrf
        <input type="hidden" name="idn" value="{{ $nv->id }}">

        <div class="row mb-3">
            <label for="classeSelect" class="col-sm-2 col-form-label">Classe</label>
            <div class="col-sm-10">
                <select name="idp" class="form-select" id="classeSelect">
                    @foreach ($profs as $c)
                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Emploi du temps</h5>
        <table border="1" class="table table-bordered">
            <thead>
                <tr>
                    <th>Horaires</th>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                </tr>
            </thead>
            <tbody>
                @for($i=0; $i<count($heure); $i++)
                    <tr>
                        <td>{{ $heure[$i] }}</td>
                        @for($j=0; $j<5; $j++)
                            <td>
                                <form action="{{ url('saveEmp') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="idn" value="{{ $nv->id }}">
                                    <input type="hidden" name="jour" value="{{ $j }}">
                                    <input type="hidden" name="heure" value="{{ $i }}">

                                    <select name="idm" class="form-select form-select-sm">
                                        <option value="" selected>---</option>
                                        @foreach ($myItems as $item)
                                            <option value="{{ $item->id }}"
                                                @if (isset($emp[$i][$j]) && $emp[$i][$j]['idm'] == $item->id) selected @endif>
                                                {{ $item->nom }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-primary mt-1">OK</button>
                                </form>
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Mes matières</h5>
    <table class="table datatable">
        <thead>
            <th>Nom</th>
            <th>Coefficient</th>
        </thead>
        <tbody>
                @foreach ($myItems as $item)
                    <tr>
                    <td>{{ $item->nom }}</td>
                    <td>{{ $item->valeur }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
    </div>
</div>

@endsection

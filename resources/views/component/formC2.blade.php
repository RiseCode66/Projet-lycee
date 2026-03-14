@extends('base/baseAdmin')
@section('content')
<div class="card ">
    <div class="card-body  border border-white">
      <h5 class="card-title text-">Classement par période</h5>

      <!-- Horizontal Form -->
      <form action="/classement_periode" method="get">
        @csrf
        <div class="row mb-3">
            <label for="idex" class="form-label">Périodes</label>
            <select name="idp" class="form-select">
                @foreach ($p as $item)
                    <option value="{{ $item->id }}">{{ $item->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="row mb-3">
            <label for="idex" class="form-label">Classes</label>
            <select name="idN" class="form-select">
                @foreach ($niveau as $item)
                    <option value="{{ $item->id }}">{{ $item->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
<div class="card ">
    <div class="card-body  border border-white">
      <h5 class="card-title text-">Classement par examen</h5>

      <!-- Horizontal Form -->
      <form action="/classement_examen" method="get">
        @csrf
        <div class="row mb-3">
            <label for="idex" class="form-label">Examen</label>
            <select name="idEX" class="form-select">
                @foreach ($ex as $item)
                    <option value="{{ $item->id }}">{{ $item->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="row mb-3">
            <label for="idex" class="form-label">Niveaux</label>
            <select name="idN" class="form-select">
                @foreach ($niveau as $item)
                    <option value="{{ $item->id }}">{{ $item->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
@endsection

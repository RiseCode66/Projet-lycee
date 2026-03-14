@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Ajouter période</h5>

      <!-- Horizontal Form -->
      <form action="savePeriode" method="POST">
        @csrf
        <input type="hidden" name="id">
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" name="nom" class="form-control" id="inputText">
          </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="form-label">periodes</label>
        <select name="ida" class="form-select " id="">
          @foreach ($myItems as $item)
              <option selected value="{{ $item->id }}">{{ $item->nom }}</option>
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

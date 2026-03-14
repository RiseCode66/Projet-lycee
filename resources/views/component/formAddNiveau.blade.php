@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Ajouter Matière</h5>

      <!-- Horizontal Form -->
      <form action="ajouterNiveaux" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $myItems[1] }}">
        <div class="row mb-3">
            <label for="email" class="form-label">Matières</label>
        <select name="idn" class="form-select " id="">
          @foreach ($myItems[0] as $item)
              <option selected value="{{ $item->id }}">{{ $item->nom }}</option>
          @endforeach
        </select>
        </div>
        <div class="row mb-3">
            <div class="text-center">
          <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
@endsection

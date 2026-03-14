@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Modifier la matière</h5>

      <!-- Horizontal Form -->
      <form action="modMatiere" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $myItems[0]->id }}">
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" name="nom" class="form-control" value="{{ $myItems[0]->nom }}" id="inputText">
          </div>
        </div>
          </div>
            <div class="text-center">
          <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
@endsection

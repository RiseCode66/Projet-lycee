@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
      <h5 class="card-title">Entrer les données d'un(e) professeur(e) </h5>

      <!-- Horizontal Form -->
      <form action="saveProf" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id">
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Nom complet</label>
          <div class="col-sm-10">
            <input type="text" name="nom" class="form-control" id="inputText">
          </div>
        </div>

        <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Signature</label>
            <div class="col-sm-10">
              <input type="file" name="sign" accept="image/*" class="form-control" id="inputText">
            </div>
          </div>        <div class="text-center">
          <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
@endsection

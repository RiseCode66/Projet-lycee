@extends('base/baseAdmin')
@section('content')
<div class="card ">
    <div class="card-body  border border-white">
      <h5 class="card-title text-">Creer la page</h5>

      <!-- Horizontal Form -->
      <form action="storeCMS" method="POST">
        @csrf
            <div class="row mb-3 ">
          <label for="inputEmail3" class="col-sm-2 col-form-label text-">Titre</label>
          <div class="col-sm-10">
            <input type="text" name="title" class="form-control  border " id="inputText">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label text-">Slug</label>
          <div class="col-sm-10">
            <input type="text" name="slug" class="form-control  border " id="inputNumber">
          </div>
        </div>
        <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0">Afficher</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="afficher" id="gridRadios1" value="1" checked="">
                <label class="form-check-label" for="gridRadios1">
                  Oui
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="afficher" id="gridRadios2" value="0">
                <label class="form-check-label" for="gridRadios2">
                  Non
                </label>
              </div>
            </div>
          </fieldset>
        <!--        <select name="afficher" class="form-select " id="">
              <option selected value="0">Non</option>
              <option value="1">Oui</option>
        </select>-->
<label for="">Contenue de page</label>
        <trix-editor></trix-editor>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
@endsection

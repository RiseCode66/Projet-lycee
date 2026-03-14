@extends('base/baseAdmin')
@section('content')
<!-- Bloc d’import CSV séparé -->
<div class="card border shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Importer des élèves via CSV</h5>

        <form action="/eleve" method="get" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="csv_file" class="form-label">Fichier CSV</label>
                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Importer CSV
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Ajouter un élève</h5>

      <form action="saveEleve" method="POST">
        @csrf
        <input type="hidden" name="id">
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Nom</label>
          <div class="col-sm-10">
            <input type="text" name="nom" class="form-control" id="inputText">
          </div>
        </div>
        <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Prénom</label>
            <div class="col-sm-10">
              <input type="text" name="prenom" class="form-control" id="inputText">
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Date de naissance</label>
            <div class="col-sm-10">
              <input type="date" name="dtn" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Classe</label>
            <div class="col-sm-10">
                <select name="classe" class="form-select" id="classeSelect">
                    <option>--classe--</option>
                    <option>Terminale stmg</option>
                    <option>Seconde </option>
                </select>
            </div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
@endsection

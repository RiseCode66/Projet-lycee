@extends('base/baseAdmin')

@section('content')
<div class="card p-3">
    <div class="card-title">Examen : {{ $exam->nom }}</div>
</div>

<div class="card p-3 mt-3">
    <div class="card-title">Ajouter une épreuve</div>
    <form method="POST" action="#">
        @csrf
        <div class="row mb-3">
            <label for="classeSelect" class="col-sm-2 col-form-label">Classe</label>
            <div class="col-sm-10">
                <select name="classe" class="form-select" id="classeSelect">
                    <option></option>
                    <option>Terminale stmg</option>
                    <option>Seconde </option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="matiereSelect" class="col-sm-2 col-form-label">Matière</label>
            <div class="col-sm-10">
                <select name="matiere" class="form-select" id="matiereSelect">
                    <option>Mathématiques</option>
                    <option>Physique-Chimie</option>
                    <option>Français</option>
                    <option>Histoire-Géo</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="date" class="col-sm-2 col-form-label">Date</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="date" name="date">
            </div>
            <label for="heure" class="col-sm-2 col-form-label">Heure</label>
            <div class="col-sm-4">
                <input type="time" class="form-control" id="heure" name="heure">
            </div>
        </div>
        <div class="row mb-3">
            <label for="heure" class="col-sm-2 col-form-label">Durée</label>
            <div class="col-sm-4">
                <input type="time" class="form-control" id="heure" name="heure">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>
</div>

<div class="card p-3 mt-3">
    <div class="card-title">Liste des épreuves programmées</div>
    <table class="table datatable mt-4">
        <thead>
            <tr>
                <th>Classe</th>
                <th>Matière</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Seconde</td>
                <td>Physique-Chimie</td>
                <td>20/03/2025</td>
                <td>08:00</td>
                <td>02:00</td>
            </tr>
            <tr>
                <td>Seconde</td>
                <td>Histoire-Géo</td>
                <td>20/03/2025</td>
                <td>10:00</td>
                <td>02:00</td>
            </tr>
            <tr>
                <td>Seconde</td>
                <td>Mathématiques</td>
                <td>21/03/2025</td>
                <td>08:00</td>
                <td>02:30</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

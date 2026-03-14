@extends('base/baseAdmin')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Insérer note</h5>

        <form action="saveNote" method="POST">
            @csrf
            <div class="row mb-3">
                <label for="eleve_search" class="form-label">Elèves</label>
                <input type="text" id="eleve_search" name="ide" class="form-control" placeholder="Taper le nom de l'élève... ou son matricule" autocomplete="off">
                <input type="hidden" name="ide" id="eleve_id">
                <ul id="eleve_list" style=" list-style-type: none; margin-top: 5px;"></ul>
            </div>

            <div class="row mb-3">
                <label for="idm" class="form-label">Matières</label>
                <select name="idm" class="form-select">
                    @foreach ($myItems[1] as $item)
                        <option value="{{ $item->id }}">{{ $item->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <label for="idex" class="form-label">Examen</label>
                <select name="idex" class="form-select">
                    @foreach ($myItems[2] as $item)
                        <option value="{{ $item->id }}">{{ $item->nom }}</option>
                    @endforeach
                </select>
            </div>

            <label for="valeur" class="col-sm-2 col-form-label">Valeur</label>
            <div class="col-sm-10">
                <input type="text" name="valeur" class="form-control" id="valeur" autocomplete="off">
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>
</div>

<!-- Bloc d’import CSV séparé -->
<div class="card border border-secondary shadow-sm">
    <div class="card-body">
        <h5 class="card-title">Importer des notes via CSV</h5>

        <form action="importNote" method="post" enctype="multipart/form-data">
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

<!-- jQuery -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

<script>
    $(document).ready(function () {
        const eleves = @json($myItems[0]);

        $('#eleve_search').on('keyup', function () {
            let query = $(this).val().toLowerCase();
            if (query.length >= 2) {
                let filteredEleves = eleves.filter(eleve =>
                    eleve.nom.toLowerCase().includes(query) || eleve.prenom.toLowerCase().includes(query)
                );

                let list = $('#eleve_list');
                list.empty();
                filteredEleves.forEach(function (eleve) {
                    list.append(`<li data-id="${eleve.id}" style="padding: 5px; cursor: pointer; border-bottom: 1px solid #ccc;">${eleve.nom} ${eleve.prenom}</li>`);
                });

                $('#eleve_list li').on('click', function () {
                    $('#eleve_search').val($(this).text());
                    $('#eleve_id').val($(this).data('id'));
                    $('#eleve_list').empty();
                });
            } else {
                $('#eleve_list').empty();
            }
        });
    });
</script>
@endsection

@extends('base/baseAdmin')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Créer l'examen</h5>

        <!-- Horizontal Form -->
        <form action="{{ url('saveExam') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="">

            <div class="row mb-3">
                <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                <div class="col-sm-10">
                    <input type="text" name="nom" class="form-control" id="nom" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="periode" class="col-sm-2 col-form-label">Période</label>
                <div class="col-sm-10">
                    <select name="idp" class="form-select" id="periode" required>
                        @foreach ($myItems as $item)
                            <option value="{{ $item->id }}">{{ $item->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
        <!-- End Horizontal Form -->

    </div>
</div>
@endsection

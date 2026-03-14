@extends('base/baseAdmin')
@section('content')
<div class="container">

    <div class="card mb-4">
        <div class="card-body border border-white">
            <h5 class="card-title">Classement des élèves</h5>

            <form action="/stats" method="get" class="mb-4">
                @csrf
                <div class="row g-2 align-items-end">

                    <div class="col">
                        <label for="idp" class="form-label">Période</label>
                        <select name="idp" class="form-select" required>
                            @foreach ($p as $item)
                                <option value="{{ $item->id }}" {{ request('idp') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="idN" class="form-label">Niveau</label>
                        <select name="idN" class="form-select" required>
                            @foreach ($niveau as $item)
                                <option value="{{ $item->id }}"  {{ request('idN') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="idEX" class="form-label">Examen (optionnel)</label>
                        <select name="idEX" class="form-select">
                            <option value="">-- Tous les examens --</option>
                            @foreach ($ex as $item)
                                <option value="{{ $item->id }}" {{ request('idEX') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="idM" class="form-label">Matière (optionnel)</label>
                        <select name="idM" class="form-select">
                            <option value="">-- Moyenne générale --</option>
                            @foreach ($matieres as $item)
                                <option value="{{ $item->id }}" {{ request('idM') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @isset($resultats)
    <div class="card">
        <div class="card-title"></div>
        <div class="card-body">
            <h4>Résultats - {{ $periode['nom'] }} pour la classe de {{ $niveauS['nom'] }}
                @if($exam) de l'examen : {{ $exam->nom }} @endif
                @if($matiere) | Matière : {{ $matiere->nom }} @endif
            </h4>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Élève</th>
                        <th>Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultats as $r)
                        <tr>
                            <td>{{ $r->nom }} {{ $r->prenom }}</td>
                            <td>{{ number_format($r->moyenne, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <canvas id="reussiteChart"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="mentionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('reussiteChart'), {
            type: 'pie',
            data: {
                labels: ['Réussite (>=10)', 'Échec (<10)'],
                datasets: [{
                    data: [{{ $reussite }}, {{ $echec }}],
                    backgroundColor: ['#4CAF50', '#F44336']
                }]
            }
        });

        new Chart(document.getElementById('mentionsChart'), {
            type: 'pie',
            data: {
                labels: @json(array_keys($mentions)),
                datasets: [{
                    data: @json(array_values($mentions)),
                    backgroundColor: ['#2E86C1','#28B463','#F1C40F','#E67E22','#E74C3C']
                }]
            }
        });
    </script>
    @endisset

</div>
@endsection

@extends('base/baseAdmin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-title">Résultats du {{ $myItems[1]->nom }}</div>
        <table class="table table-bordered align-middle text-center">
            <thead class="table">
                <tr>
                    <th>Nom et prénom</th>
                    <th>Moyenne</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                @if (count($myItems[0]) == 0)
                    <tr>
                        <td colspan="3">Pas de note pour le moment</td>
                    </tr>
                @else
                    @php
                        $sum = 0;
                        $count = count($myItems[0]);
                        $success = 0;
                        $mentions = [
                            'Très Bien' => 0,
                            'Bien' => 0,
                            'Assez Bien' => 0,
                            'Passable' => 0,
                            'Échec' => 0,
                        ];
                    @endphp

                    @foreach ($myItems[0] as $item)
                        @php
                            $sum += $item->moyenne;
                            if ($item->moyenne >= 10) $success++;

                            if ($item->moyenne >= 16) $mentions['Très Bien']++;
                            elseif ($item->moyenne >= 14) $mentions['Bien']++;
                            elseif ($item->moyenne >= 12) $mentions['Assez Bien']++;
                            elseif ($item->moyenne >= 10) $mentions['Passable']++;
                            else $mentions['Échec']++;
                        @endphp
                        <tr>
                            <td>{{ $item->nom }} {{ $item->prenom }}</td>
                            <td>{{ number_format($item->moyenne, 2) }}</td>
                            <td>
                                <a href="/notePeriode?idp={{ $item->idp }}&ide={{ $item->ide }}" class="btn btn-primary">
                                    <i class="bi bi-plus"></i>
                                </a>
                                <a href="/pdfPeriode?idp={{ $item->idp }}&ide={{ $item->ide }}" class="btn btn-primary">
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@if (count($myItems[0]) > 0)
@php
    $avg = $sum / $count;
    $taux = ($success / $count) * 100;
@endphp

<!-- Bloc Statistiques -->
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Statistiques générales</h5>
        <div class="row text-center">
            <div class="col-md-6">
                <h6>Moyenne générale</h6>
                <p class="fw-bold fs-5 text-primary">{{ number_format($avg, 2) }}/20</p>
            </div>
            <div class="col-md-6">
                <h6>Taux de réussite</h6>
                <p class="fw-bold fs-5 text-success">{{ number_format($taux, 2) }}%</p>
            </div>
        </div>
    </div>
</div>

<!-- Bloc Graphique -->
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title">Répartition par mention</h5>
        <canvas id="mentionsChart" height="120"></canvas>
    </div>
</div>

@endif

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('mentionsChart');
        const mentions = @json(array_values($mentions));
        const labels = @json(array_keys($mentions));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nombre d\'élèves',
                    data: mentions,
                    backgroundColor: [
                        '#007bff',
                        '#28a745',
                        '#ffc107',
                        '#17a2b8',
                        '#dc3545'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Effectif' } },
                    x: { title: { display: true, text: 'Mentions' } }
                }
            }
        });
    });
</script>
@endsection

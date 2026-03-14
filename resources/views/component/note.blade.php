@extends('base/baseAdmin')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="card-title">Bullettin de note {{ $myItems[2]->nom }}</div>
        <a href="/pdfExam?ide={{ $myItems[0][0]->id }}&idex={{ $myItems[2]->id }}">-> Pdf</a>
        <h6>Nom: {{ $myItems[0][0]->nom }}</h6>
        <h6>Prénom: {{ $myItems[0][0]->prenom }}</h6>
        <h6>Date de naissance: {{  \Carbon\Carbon::parse($myItems[0][0]->dtn)->translatedFormat('j F Y')  }}</h6>
        <h6>Classe :{{ $myItems[0][0]->nomN }}</h6>
        <div style="display: none">{!! $sumCoeff=0 !!}</div>
        <div style="display: none">{!! $sumTotal=0 !!}</div>
        <table class="table">
                <thead>
                    <th>Matière</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Total</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @if (count($myItems)==0)
                            <tr>
                                <td colspan="6">Pas de note pour le moment</td>
                            </tr>
                    @endif

                        @foreach ($myItems[1] as $item)
                            <tr>
                                <div style="display: none">{!! $sumCoeff+=$item->coeff !!}</div>
                                <div style="display: none">{!! $sumTotal+=$item->coeff*$item->note !!}</div>
                            <td>{{ $item->nomM }}</td>
                            <td>{{ number_format($item->note,2) }}</td>
                            <td>{{ $item->coeff }}</td>
                            <td>{{ number_format($item->coeff*$item->note,2) }}</td>
                            <td><a href="/suprNoteEx?ide={{ $myItems[0][0]->id }}&idex={{ $myItems[2]->id }}&idm={{ $myItems[2]->id }}&idm={{ $item->idm }}">Supprimer la note</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p>Total des points : {{ number_format($sumTotal,2) }}</p>
            <p>Moyenne : {{ number_format($sumTotal/$sumCoeff,2) }}</p>
        </div>
</div>
@endsection

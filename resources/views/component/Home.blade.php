@extends('base/base')
@section('content')
<div class="row row-cols-md-3 mb-3 ">
    <div class="col">
        @csrf
            <div class="card">
                <div class="card-body">
                    Bonjour
                </div>
            </div>
        </div>
</div>
@endsection

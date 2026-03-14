@extends('base/base')
@section('content')
<div class="card b">
    <div class="card-body">
        <h5 class="card-title ">Contactez nous</h5>

        <!-- Horizontal Form -->
        <form action="creerContact" method="POST">
        @csrf
            <div class="row mb-3 ">
          <label for="inputEmail3" class="col-sm-2 col-form-label ">Email</label>
          <div class="col-sm-10">
            <input type="email" name="email" class="form-control " id="inputText">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputEmail3" class="col-sm-2 col-form-label ">sujet</label>
          <div class="col-sm-10">
            <input type="text" name="sujet" class="form-control" id="inputNumber">
          </div>
        </div>
        <div class="row mb-3">
            <label for="inputPassword" class="col-sm-2 col-form-label ">Message</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="message" style="height: 100px"></textarea>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-warning">Valider</button>
        </div>
      </form><!-- End Horizontal Form -->

    </div>
  </div>
@endsection

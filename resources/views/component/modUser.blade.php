@extends('base/baseAdmin')
@section('content')
            <!-- Register Card -->
            <div class="card mb-3">
              <div class="card-body">

                <!-- Register Form Title -->
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Modifier un compte</h5>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="/modUser" class="row g-3 needs-validation" novalidate>
                  @csrf
                  <input type="hidden" name="id" value="{{ $myItems[0]['id'] }}">
                  <!-- Name -->
                  <div class="col-12">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $myItems[0]['name'] }}" required>
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Email -->
                  <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $myItems[0]['email'] }}" required>
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <!-- Type -->
                  <label for="email" class="form-label">Type utilisateur</label>
                  <select name="type_user" class="form-select " id="">
                    @foreach ($myItems[1] as $item)
                    @if ($item->value==$myItems[0]['type'])
                        <option selected value="{{ $item->value }}">{{ $item->nom }}</option>
                        @else
                        <option value="{{ $item->value }}">{{ $item->nom }}</option>
                    @endif
                    @endforeach
                  </select>

                  <!-- Password -->
                  <div class="col-12">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password"  required>
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Confirm Password -->
                  <div class="col-12">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" required>
                    @error('password_confirmation')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <!-- Submit Button -->
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Modifier compte</button>
                  </div>
                </form>

              </div>
            </div><!-- End Register Card -->
@endsection

@extends('base/base')

@section('content')
<div class="component">
    <form action="/checkout" method="POST">
        @csrf
        <input type="hidden" name="_tokken" value="{{ csrf_token() }}">
        <button type="submit">Checkout</button>
    </form>
</div>

@endsection

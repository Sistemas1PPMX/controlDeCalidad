@extends('layouts.dump')
@section('navbar')
<div class="col-2">
	<button class="btn btn-danger" style="width: 40%" id="btnLogin">login</button>
	<button class="btn btn-danger" style="width: 40%" id="btnRegister">register</button>
</div>
@endsection
@section('content')

@endsection()


@section('scripts')
{!! Html::script('js\main.js') !!}
@endsection()

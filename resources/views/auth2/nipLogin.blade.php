@extends('layouts.dump')
@section('content')
<div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<div class="card-title text-center">Login</div>
		</div>
		<div class="card-body">
			<div class="row flex-row">
				<input type="password" id="nip" class="form-control easy-get">
			</div>
			<div class="keypadContainer">
				
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js\main.js') !!}
{!! Html::script('js\keypad.js') !!}
@endsection
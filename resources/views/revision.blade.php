@extends('layouts.dump')
@if(Session::has('id'))
@section('navbar')
<div class="col-2 text-center p-0 align-bottom">
	<label class="text-center p-0 align-bottom align-text-bottom" style="font-family: 'Roboto', sans-serif; color: white;"><h2 id="usuario"></h2></label>
</div>
@endsection
@section('content')
<div class="row w-100 h-25">
	<div class="col-2"></div>
	<div class="col-8">
		<div class="row w-100 mt-5">
			<div class="col-6">
				<div class="row"><label>PIEZA:</label></div>
				<div class="row">
					<select id="pieza"></select>
				</div>
			</div>
			<div class="col-6">
				<div class="row"><label>ESTACION:</label></div>
				<div class="row">
					<select id="estacion"></select>
				</div>
			</div>
		</div>
	</div>
	<div class="col-2"></div>
</div>
<div class="row">
	<div class="col-2"></div>
	<div class="col-8">
		<button class="btn btn-primary btn-block" id="btnIniciar">Iniciar Inspeccion</button>
	</div>
	<div class="col-2"></div>
</div>
@endsection
@endif
@section('scripts')
{!! Html::script('js\revision.js') !!}
@endsection
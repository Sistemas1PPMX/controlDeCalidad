@extends('layouts.dump')
@section('navbar')
@if(Session::has('id'))
<div class="col-2">
	<button class="btn btn-danger" id="btnLogout">Logout</button>
</div>
@else
<div class="col-2">
	<button class="btn btn-danger" style="width: 40%" id="btnLogin">login</button>
	<button class="btn btn-danger" style="width: 40%" id="btnRegister">register</button>
</div>
@endif		
@endsection
@section('content')
<div class="row flex-row" style="height: 50px; width: 100%">

</div>
<div class="row flex-row m-0" style="height: 100px; width: 100%">
	<div class="col-4 p-0">
		@if(Session::has('id'))
		<a class="btn btn-primary btn-block text-left" href="/cyp" style="height: 100%;"><h1>Corte y perforado</h1></a>
		@endif
	</div>
	<div class="col-4">
	</div>
	<div class="col-4 p-0">
		@if(Session::has('id'))
		<a class="btn btn-primary btn-block text-right" href="/miscelaneos" style="height: 100%;"><h1>Miscelaneos</h1></a>
		@endif
	</div>
</div>
<div class="row flex-row" style="height: 50px; width: 100%">

</div> 
<div class="row flex-row m-0" style="height: 100px; width: 100%">
	<div class="col-4 p-0">
		@if(Session::has('id'))
		<a class="btn btn-primary btn-block text-left" href="/armado2" style="height: 100%;"><h1>Armado</h1></a>
		@endif
	</div>
	<div class="col-4">
	</div>
	<div class="col-4 p-0">
		@if(Session::has('id'))
		<a class="btn btn-primary btn-block text-right" href="/soldadura" style="height: 100%;"><h1>Soldadura</h1></a>
		@endif
	</div>
</div>
<div class="row flex-row" style="height: 50px; width: 100%">

</div>
<div class=" row flex-row m-0" style="height: 100px; width: 100%">
	<div class="col-4 p-0">
		@if(Session::has('id'))
		<a href="/pintura" class="btn btn-primary btn-block text-left" style="height: 100%"><h1>Pintura</h1></a>
		@endif
	</div>
	<div class="col-4 p-0"></div>
	<div class="col-4 p-0">
		@if(Session::has('id'))
		<a href="/lotePintura" class="btn btn-primary btn-block text-right" style="height: 100%"><h1>LotePintura</h1></a>
		@endif
	</div>
</div>
<div class="row flex-row" style="height: 50px; width: 100%">

</div> 
{{-- <div class=" row flex-row m-0" style="height: 100px; width: 100%">
	<div class="col-4 p-0">
	</div>
	<div class="col-4 p-0"></div>
	<div class="col-4 p-0">
		@if(Session::has('id'))
		<a href="/iniciarRevision" class="btn btn-primary btn-block text-right" style="height: 100%"><h1>Iniciar Revision</h1></a>
		@endif
	</div>
</div> --}}
@endsection
@section('scripts')
{!! Html::script('js\main.js') !!}
@endsection
{{-- <a class="btn btn-primary" href="/assetTest">Asset Test</a>		 --}}
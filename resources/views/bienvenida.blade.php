@extends('app')

@section('content')

<!--
Que el usuario NO esté validado y obtenga una excepción extraña
entonces se mostrará el mensaje de "error" en esta vista.
 -->
@if (Session::has('error')) 
<div class="alert alert-danger">
	<strong>Whoops!</strong> Ha surgido un problema.<br><br>
	{{Session::get('error')}}
</div>
@endif

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Inicio</div>

				<div class="panel-body">
					Por favor inicie sesión para acceder al sistema.
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
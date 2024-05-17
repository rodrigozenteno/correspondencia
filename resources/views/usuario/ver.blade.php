@extends('template.layoutgeneral')
@section('titulo', 'Usuario')
@section('subTitulo', 'Ver')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1-1">Lista de usuarios</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1-1">
					<div class="row">
						<div class="col-md-12">
							<div>
								<input type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingrese datos de búsqueda (Enter)" onkeyup="filtrarHtml('tableUsuario', this.value, false, 0, event);">
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tableUsuario" class="table table-striped" style="min-width: 777px;">
									<thead >
										<tr  class="danger">
											<th>Grado y Nombre completo</th>
											<th>Correo electrónico</th>
											<th>Rol</th>
											
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listaTUsuario as $value)
											@if($value->codigoUsuario!=Session::get('codigoUsuario') && strpos(Session::get('rol'), 'Súper usuario')===false && strpos(Session::get('rol'), 'Administrador')===false)
												<?php continue; ?>
											@endif
											<tr class="success">
												<td>{{$value->grado.' '.$value->nombre.' '.$value->apellido}}</td>
												<td>{{$value->correoElectronico}}</td>
												<td>{{$value->rol}}</td>
												
												<td class="text-right">
													@if(strpos(Session::get('rol'), 'Súper usuario')!==false || strpos(Session::get('rol'), 'Administrador')!==false)
														<span class="btn btn-default btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Editar" onclick="dialogoAjax('dialogoGeneral', null, '{{$value->nombre.' '.$value->apellido}} (Editar)', { _token : '{{csrf_token()}}', codigoUsuario : '{{$value->codigoUsuario}}' }, '{{url('usuario/editar')}}', 'POST', null, null, false, true);"></span>
													@endif
													<span class="btn btn-default btn-xs glyphicon glyphicon-asterisk" data-toggle="tooltip" data-placement="left" title="Cambiar contraseña" onclick="dialogoAjax('dialogoGeneral', null, '{{$value->nombre.' '.$value->apellido}} (Cambiar contraseña)', { _token : '{{csrf_token()}}', codigoUsuario : '{{$value->codigoUsuario}}' }, '{{url('usuario/cambiarcontrasenia')}}', 'POST', null, null, false, true);"></span>
												</td>
												
											</tr>
											
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
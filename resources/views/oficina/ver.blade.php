@extends('template.layoutgeneral')
@section('titulo', 'Oficina')
@section('subTitulo', 'Ver')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1-1">Lista de oficinas</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1-1">
					<div class="row">
						<div class="col-md-12">
							<div>
								<input type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingrese datos de búsqueda (Enter)" onkeyup="filtrarHtml('tableOficina', this.value, false, 0, event);">
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tableOficina" class="table table-striped" style="min-width: 777px;">
									<thead>
										<tr  class="info">
											<th>Nombre</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listaTOficina as $value)
											<tr class="elementoBuscar">
												<td>{{$value->nombre}}</td>
												<td class="text-right">
													<span class="btn btn-default btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" title="Editar" onclick="dialogoAjax('dialogoGeneral', null, '{{$value->nombre}} (Editar)', { _token : '{{csrf_token()}}', codigoOficina : '{{$value->codigoOficina}}' }, '{{url('oficina/editar')}}', 'POST', null, null, false, true);"></span>
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
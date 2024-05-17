@extends('template.layoutgeneral')
@section('titulo', 'Asignación de documento')
@section('subTitulo', 'Ver')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1-1">Lista de asignación de documentos</a></li>
			
			</ul>
								
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1-1">
					<div class="row">
						<div class="col-md-12">
							<div>
								<input type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingrese datos de búsqueda (Enter)" onkeyup="filtrarHtml('tableOTDEvtAsignacion', this.value, false, 0, event);">
							</div>
							<hr>
							<div class="table-responsive">
								<table id="tableOTDEvtAsignacion" class="table table-striped" style="min-width: 777px;">
									<thead>
										<tr>
											<th>N° de Ruta</th>
											<th>Tipo del Documento</th>
											<th>N° del Documento</th>
											<th>Procedencia</th>
											<th>Objeto del Documento</th>
											<th>Oficina de Recepcion</th>
											<th class="text-center">Estado</th>
											<th class="text-center"></th>
											<th class="text-center">Fecha y Hora de registro </th>
											<th class="text-center">Fecha y Hora que se Derivo Oficina</th>
											<th>Plazo en Dias</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($listaTOTDEvtAsignacion as $value)
											<tr class="elementoBuscar">
												<td>{{$value->codigoOTDEvtAsignacion}}</td>
												<td>
													<?php $temp=$value; ?>
													@while($temp->tdocumento==null)
														<?php $temp=$temp->totdevtasignacionrecursive; ?>
													@endwhile

													{{$temp->tdocumento->tipo}}
												</td>
												<td>{{$value->dniPersonaPresenta}}</td>
						
												<td>
												<?php $temp=$value; ?>
													@while($temp->totdevtasignacion)
												<?php $temp=$temp->totdevtasignacionrecursive; ?>
													@endwhile

													{{$temp->procedencia}}
												</td>
												
												<td>
													<?php $temp=$value; ?>
													@while($temp->tdocumento==null)
														<?php $temp=$temp->totdevtasignacionrecursive; ?>
													@endwhile

													<a href="{{url('otdevtasignacion/descargararchivos/'.$value->codigoOTDEvtAsignacion)}}">{{$temp->tdocumento->nombre.'.'.$temp->tdocumento->extension}}</a>
												</td>
												<td>{{$value->toficina->nombre}}</td>
												<td class="text-center"><span class="label {{$value->estado=='Por revisar' ? 'label-warning' : ($value->estado=='Revisado' ? 'label-success' : ($value->estado=='Derivado' ? 'label-default' : 'label-info'))}}">{{$value->estado}}</span></td>
												<td class="text-center">{!!($value->codigoOTDEvtAsignacionPadre==null || ($value->totdevtasignacionrecursive->codigoOTDEvtAsignacionPadre==null && $value->totdevtasignacionrecursive->estado=='Cerrado')) ? '<span class="label label-info" data-toggle="tooltip" data-placement="left" title="Tipo de recepción: Registrado">R</span>' : '<span class="label label-default" data-toggle="tooltip" data-placement="left" title="Tipo de recepción: Derivado">D</span>'!!}</td>
												<td class="text-center">{{$value->created_at}}</td>
												<td class="text-center">{{$value->updated_at}}</td>
												<?php
													 $date1 =new dateTime($value->fechaEntregaCmte);
													 $date2= new dateTime( date("Y-m-d") );
												$valordiferencia = $date1->diff($date2);
												//echo $valordiferencia ;
							
												?>
												
												<td class="text-center"> 
												@if ($valordiferencia->days >= 0 && $valordiferencia->days <= 4) 
														
													<label class='alert alert-danger'>{{$valordiferencia->days}}</label>
													
													 @endif 
													 @if ($valordiferencia->days >= 5 && $valordiferencia->days <= 10)
													<label class='alert alert-warning'>{{$valordiferencia->days}}</label>
													 @endif 
													 @if ($valordiferencia->days >= 10)
													<label class='alert alert-success'>{{$valordiferencia->days}}</label>
													 @endif 

												</td>
												<td class="text-right">
													@if($value->estado!='Revisado' && $value->estado!='Derivado' && $value->estado!='Atendido')
														<span class="btn btn-default btn-xs glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="left" title="Marcar como revisado" onclick="cambiarEstado('{{$value->codigoOTDEvtAsignacion}}', 'Revisado');"></span>
													@endif
													@if($value->estado=='Revisado')
														<span class="btn btn-default btn-xs glyphicon glyphicon-share-alt" data-toggle="tooltip" data-placement="left" title="Derivar" onclick="dialogoAjax('dialogoGeneral', 77, '{{$temp->tdocumento->nombre}} (Derivar)', { _token : '{{csrf_token()}}', codigoOTDEvtAsignacion : '{{$value->codigoOTDEvtAsignacion}}' }, '{{url('otdevtasignacion/derivar')}}', 'POST', null, null, false, true);"></span>
													@endif
													<span class="btn btn-default btn-xs glyphicon glyphicon-screenshot" data-toggle="tooltip" data-placement="left" title="Rastrear documento" onclick="dialogoAjax('dialogoGeneral', 77, '{{$temp->nombreCompletoPersonaPresenta.' - '.$temp->tdocumento->nombre}} (Rastrear)', { _token : '{{csrf_token()}}', codigoOTDEvtAsignacion : '{{$value->codigoOTDEvtAsignacion}}' }, '{{url('otdevtasignacion/rastrear')}}', 'POST', null, null, false, true);"></span>
													@if($value->estado=='Revisado')
														<span class="btn btn-default btn-xs glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="left" title="Atender (Cerrar)" onclick="dialogoAjax('dialogoGeneral', 77, '{{$temp->tdocumento->nombre}} (Atender (Cerrar))', { _token : '{{csrf_token()}}', codigoOTDEvtAsignacion : '{{$value->codigoOTDEvtAsignacion}}' }, '{{url('otdevtasignacion/atender')}}', 'POST', null, null, false, true);"></span>
													@endif

												</td>
												<td>
												<?php
														$valor="";  
														$valor=$value->dniPersonaPresenta ;
														$valornuevo="";
														$valornuevo=str_replace( '/' , '-' ,$valor );
												?>
												<form action="<?php echo e(url('reporte/reporteindividual/'  )) ; ?>" method="post">
											 		{{csrf_field()}}
													<input type="hidden" class="text" name="codigoDocumento" value="{{$valor}}">
													<input type="submit" value="PDF" title="Generar Reporte en PDF" class="btn btn-warning btn-xs glyphicon glyphicon-print">
												</form>
												<br>
												
								
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
<script>
	function cambiarEstado(codigoOTDEvtAsignacion, estado)
	{
		swal(
		{
			title : 'Confirmar operación',
			text : '¿Realmente desea continuar con la acción?',
			icon : 'warning',
			buttons : ['No, cancelar.', 'Si, proceder.']
		})
		
		.then((proceed) =>
		{
			if(proceed)
			{
				$('#modalLoading').modal('show');
				
				window.location.href='{{url('otdevtasignacion/cambiarestado')}}/'+codigoOTDEvtAsignacion+'/'+estado;
			}
		});
	}
</script>
@endsection
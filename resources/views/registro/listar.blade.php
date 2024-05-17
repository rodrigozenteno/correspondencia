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
								<input type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingrese datos de búsqueda (Enter)" onkeyup="filtrarHtml('tableregistros', this.value, false, 0, event);">
							</div>
							<hr>
							<a class="btn btn-warning btn-xs glyphicon glyphicon-print"  title="Generar Reporte en PDF"  href="<?php echo e(url('registro/reportegeneral'  )) ; ?>"> PDF </a>
						
							<div class="table-responsive">
								<table id="tableregistros" class="table table-striped" style="min-width: 777px;">
									<thead>
										<tr>
                                            <th>N° Documento</th>											
                                            <th>Fecha Entrega </th>
											<th>Fecha Comandante</th>
                                            <th>Plazo en Dias</th>
                                            <th>Procedencia</th>
                                            <th>Objeto del Documento</th>
                                            <th>Tipo Documento</th>
                                            <th>Archivo</th>
                                            <th class="text-center">Opciones</th>
										
										</tr>
									</thead>
									<tbody>
										@foreach($registros as $value)
											<tr class="elementoBuscar">
												<td>{{$value->nroDoc}}</td>
											
												<td>{{$value->fechaEntrega}}</td>
                                                <td>{{$value->fechaEntregaCmte}}</td>
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
                                                
												<td>
													{{$value->procedenciaDoc}}
												</td>
                                                <td>
													{{$value->objetoDoc }}
												</td>
                                                
                                                


												<td>
													{{$value->tipoDoc}}
												</td>
												<td>		
													<a href="{{url('registros/descargararchivos/'.$value->nroDoc)}}">{{$value->archivo}}</a>
												</td>
												
												<td class="text-right">                               
														<td class="text-right">
																@if($value->estado =='Habilitado')
																		<button  onclick="cambiarEstado('{{$value->nroDoc}}', 'Desabilitado');"  >  Desabilitar  </button>
																@endif
																@if($value->estado=='Desabilitado')
																		<button onclick="cambiarEstado('{{$value->nroDoc}}', 'Habilitado');" >  Habilitar  </button>
																@endif
																

																@if(strpos(Session::get('rol'), 'Súper usuario')!==false || strpos(Session::get('rol'), 'Administrador')!==false)

																<button  onclick="dialogoAjax('dialogoGeneral', null, 'N° Registro:  {{$value->nroDoc.' '.$value->estado}} (Editar)', { _token : '{{csrf_token()}}', CodigoRegistro : '{{$value->nroDoc}}' }, '{{url('registro/edit')}}', 'POST', null, null, false, true);" >  editar </button>
																@endif
																
														</td>

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
	function cambiarEstado(codigoregistros, estado)
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
			console.log("log");
		
				if(proceed)
				{
					$('#modalLoading').modal('show');
					//alert('{{url('registro/cambiarestado')}}/'+codigoregistros+'/'+estado);
					
					window.location.href='{{url('registro/cambiarestado')}}/'+codigoregistros+'/'+estado;
				}
			
		});
	}
</script>
@endsection
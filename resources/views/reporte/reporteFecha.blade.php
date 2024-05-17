@extends('template.layoutgeneral')
@section('titulo', 'Reporte')
@section('subTitulo', 'Por Fechas')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1-1">Generar reporte por fechas</a></li>
			</ul>
			<div class="tab-content">
				 <form method="post" action="<?php echo e(url('reporte/reporteGral'  )) ; ?>" id="formFechas" name="getOrderReportForm">
					<div class="tab-pane active" id="tab_1-1">
						<div class="row">
							<div class="form-group col-md-12">
								<label for="txtInicio">inicio</label>
								<input type="date" id="txtInicio" name="txtInicio" class="form-control" placeholder="Obligatorio" value="{{old('txtNombre')}}">
							</div>
                            <div class="form-group col-md-12">
								<label for="txtFinal">final</label>
								<input type="date" id="txtFinal" name="txtFinal" class="form-control" placeholder="Obligatorio" value="{{old('txtNombre')}}">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								{{csrf_field()}}
								
							 <input type="submit" class="btn btn-primary pull-right" value="Generar Reporte" >
								<!-- <button id="liMenuItemGestionReporteGral" class="btn btn-warning pull-right"><a href="<?php echo e(url('reporte/reporteGral')); ?>">Generar Reporte.</a></button> -->
							
							</div>
						</div> 
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(function()
	{
		$('#frmInsertarOficina').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				txtNombre :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						regexp :
						{
							message : '<b style="color: red;">Formato incorrecto. [Sólo se permite texto, números y espacios].</b>',
							regexp : /^[a-zA-Z0-9ñÑàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚ\s*]*$/
						}
					}
				}
			}
		});
	});

	function enviarFrmInsertarOficina()
	{
		var isValid=null;

		$('#frmInsertarOficina').data('formValidation').validate();

		isValid=$('#frmInsertarOficina').data('formValidation').isValid();

		if(!isValid)
		{
			new PNotify(
			{
				title : 'No se pudo proceder',
				text : 'Por favor complete y corrija toda la información necesaria antes de continuar.',
				type : 'error'
			});

			return;
		}

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
				
				$('#frmInsertarOficina')[0].submit();	
			}
		});
	}
</script>
@endsection
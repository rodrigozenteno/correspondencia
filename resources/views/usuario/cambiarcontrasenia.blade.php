<form id="frmCambiarContraseniaUsuario" action="{{url('usuario/cambiarcontrasenia')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="form-group col-md-12">
				<label for="passContraseniaActual">Contraseña actual</label>
				<input type="password" id="passContraseniaActual" name="passContraseniaActual" class="form-control" placeholder="Obligatorio" value="{{old('passContraseniaActual')}}">
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="passContrasenia">Nueva contraseña</label>
				<input type="password" id="passContrasenia" name="passContrasenia" class="form-control" placeholder="Obligatorio" value="{{old('passContrasenia')}}">
			</div>
			<div class="form-group col-md-6">
				<label for="passContraseniaRepita">Repita nueva contraseña</label>
				<input type="password" id="passContraseniaRepita" name="passContraseniaRepita" class="form-control" placeholder="Obligatorio" value="{{old('passContraseniaRepita')}}">
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoUsuario" value="{{$tUsuario->codigoUsuario}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmCambiarContraseniaUsuario();">
			</div>
		</div>
	</div>
</form>
<script>
	$(function()
	{
		$('#frmCambiarContraseniaUsuario').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				passContraseniaActual :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				passContrasenia :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						identical :
						{
							message : '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
							field : 'passContraseniaRepita'
						}
					}
				},
				passContraseniaRepita :
				{
					validators : 
					{
						identical :
						{
							message : '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
							field : 'passContrasenia'
						}
					}
				}
			}
		});
	});

	$('.select').select2(
	{
		language :
		{
			noResults : function()
			{
				return "No se encontraron resultados.";        
			},
			searching : function()
			{
				return "Buscando...";
			}
		},
		placeholder : 'Buscar...',
		minimumInputLength: 3
	});

	function enviarFrmCambiarContraseniaUsuario()
	{
		var isValid=null;

		$('#frmCambiarContraseniaUsuario').data('formValidation').validate();

		isValid=$('#frmCambiarContraseniaUsuario').data('formValidation').isValid();

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
				
				$('#frmCambiarContraseniaUsuario')[0].submit();	
			}
		});
	}
</script>
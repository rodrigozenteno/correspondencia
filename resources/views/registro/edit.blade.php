<form id="frmEditarRegistro" action="{{url('registro/edit')}}" enctype = "multipart/form-data" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="txtNombreCompletoPersonaPresenta">nroDoc</label>
				<input type="text" id="inpnroDoc" value="{{ $tRegistro->nroDoc }}" name="inpnroDoc" class="form-control" placeholder="Obligatorio">
			</div>
			<div class="form-group col-md-6">
                <label for="txtProcedencia">Procedencia</label>
                <input type="text" id="inpprocedenciaDoc" value="{{ $tRegistro->procedenciaDoc }}" name="inpprocedenciaDoc" class="form-control" placeholder="Obligatorio">
            </div>
			<div class="form-group col-md-6">
				<label for="txtDniPersonaPresenta">Fecha Entrega</label>
				<input type="Date" id="indfechaEntrega" value="{{ $tRegistro->fechaEntrega }}" name="indfechaEntrega" class="form-control" >
			</div>
			<div class="form-group col-md-6">
				<label for="txtDniPersonaPresenta">Fecha EntregaCmte</label>
				<input type="Date" id="indfechaEntregaCmte" value="{{ $tRegistro->fechaEntregaCmte }}" name="indfechaEntregaCmte" class="form-control" >
			</div>
		</div>
		<hr>
		<div class="row">
			

            <div class="form-group col-md-6">
                <label for="txtNombre">N° Doc</label>
                <input type="text" id="inpnumeroDoc" value="{{ $tRegistro->numeroDoc }}" name="inpnumeroDoc" class="form-control" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="txtFolio">Objeto del documento</label>
                <input type="text" id="inpobjetoDoc" value="{{ $tRegistro->objetoDoc }}" name="inpobjetoDoc" class="form-control" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="selectTipo">Tipo de Documento</label>
                <select id="selectTipo" name="selectTipo" class="form-control">
                    <option style="display: none;">{{ $tRegistro->tipoDoc }}</option>
                    	<option value="Radiograma">Radiograma</option>
						<option value="Informe">Informe</option>
						<option value="Solicitud">Solicitud</option>
						<option value="Oficio">Oficio</option>
						<option value="Resolución">Resolución</option>
                    
                </select>
            </div>
			<div class="form-group col-md-12">
                <label for="fileArchivo">Archivo</label>
                <input type="file" id="fileArchivo" value="{{ $tRegistro->archivo }}" name="fileArchivo" class="form-control" onchange="handleFiles(this.files)"  accept=".docx, .pdf" required>
				<input type="text" id="fileArchivo1" value="{{ $tRegistro->archivo }}" name="fileArchivo1" class="form-control" style="display: none;">
            </div>
            <div class="form-group col-md-12">
                <label for="txtObservacion">Observaciones</label>
                <input type="text" id="txtObservacion" rows="2" value="{{ $tRegistro->observacionesDoc }}" name="txtObservacion" class="form-control" placeholder="Obligatorio">
                <!--<textarea type="text" id="txtObservacion" rows="2" value="{{ $tRegistro->observacionesDoc }}" name="txtObservacion" class="form-control" placeholder="Obligatorio"  ></textarea>-->
            </div> 
            
        
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdCodigoRegistro" value="{{$tRegistro->nroDoc}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="enviarFrmEditarUsuario();">
			</div>
		</div>
	</div>
</form>
<script>
	$(function()
	{
		$('#frmEditarRegistro').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				txtGrado :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},

				txtNombre :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				txtApellido :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				txtCorreoElectronico :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						regexp :
						{
							message : '<b style="color: red;">Formato incorrecto. [Ejemplo: nombre@gmail.com].</b>',
							regexp : /^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.[a-zA-Z]+(\.[a-zA-Z]+)?$/
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
			},
			inputTooShort : function()
			{ 
				return 'Por favor ingrese 3 o más caracteres';
			}
		},
		placeholder : 'Buscar...',
		minimumInputLength: 3
	});

	function enviarFrmEditarUsuario()
	{
		var isValid=null;

		$('#frmEditarRegistro').data('formValidation').validate();

		isValid=$('#frmEditarRegistro').data('formValidation').isValid();

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
				
				$('#frmEditarRegistro')[0].submit();	
			}
		});
	}
</script>
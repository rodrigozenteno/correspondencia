@extends('template.layoutgeneral')
@section('titulo', 'Asignación de documento')
@section('subTitulo', 'Insertar')
@section('cuerpoGeneral')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1-1">Registro de documento</a></li>
			</ul>
			<div class="tab-content">
				<form id="frmInsertarDocumento" action="{{url('registro/insertar')}}" method="post" enctype="multipart/form-data">
					<div class="tab-pane active" id="tab_1-1">
						<div class="row">
							
							<div class="form-group col-md-4">
								<label for="txtNombreCompletoPersonaPresenta">N°</label>
								<input type="text" id="inpnroDoc" value="" name="inpnroDoc" class="form-control" placeholder="Obligatorio">
							</div>
							<div class="form-group col-md-4">
								<label for="txtDniPersonaPresenta">Fecha del Documento</label>
								<input type="Date" id="indfechaEntrega" name="indfechaEntrega" class="form-control" >
							</div>
                            <div class="form-group col-md-4">
								<label for="txtDniPersonaPresenta">Fecha del Documento para el CMTE</label>
								<input type="Date" id="indfechaEntregaCmte" name="indfechaEntregaCmte" class="form-control" >
							</div>
							
						</div>
						<div class="row">							
							<div class="form-group col-md-4">
								<label for="txtProcedencia">Procedencia del Documento</label>
								<input type="text" id="inpprocedenciaDoc" value="Bolivia" name="inpprocedenciaDoc" class="form-control" placeholder="Obligatorio">
							</div>
							<div class="form-group col-md-4">
								<label for="txtNombre">Objeto del documento</label>
								<input type="text" id="inpobjetoDoc" value="no se" name="inpobjetoDoc" class="form-control" placeholder="">
							</div>
							<div class="form-group col-md-4">
								<label for="txtFolio">Número del Documento</label>
								<input type="text" id="inpnumeroDoc" value="12345" name="inpnumeroDoc" class="form-control" placeholder="">
							</div>
							<div class="form-group col-md-4">
								<label for="selectTipo">Tipo de Documento</label>
								<select id="selectTipo" name="selectTipo" class="form-control">
									<option value="Radiograma">Radiograma</option>
									<option value="Radiograma">Informe</option>
									<option value="Solicitud">Solicitud</option>
									<option value="Oficio">Oficio</option>
									<option value="Resolución">Resolución</option>
									
								</select>
							</div>
							<div class="form-group col-md-12">
								<label for="fileArchivo">Archivo</label>
								<input type="file" id="fileArchivo" value="Cargando" name="fileArchivo" class="form-control" onchange="handleFiles(this.files)"  accept=".docx, .pdf" type="file" required>
							</div>
                            <div class="form-group col-md-12">
								<label for="txtObservacion">Observaciones</label>
								<textarea type="text" id="txtObservacion" rows="2" value="Se esta Insertando" name="txtObservacion" class="form-control" placeholder="Obligatorio"  ></textarea>
							</div> 					
						<hr>
						<div class="row">
							<div class="col-md-12">
								{{csrf_field()}}
								<input type="button" class="btn btn-primary pull-right" value="Registrar datos ingresados" onclick="enviarFrmInsertarDocumento();">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
    //  function mayuscula(elemento){
	// 	 let texto = elemento.value;
	// 	 elemento.value = texto.toUpperCase();
	//  }
//	$('#selectTipo').change(alert('Holaa'));
	$(function()
	{
		$('#frmInsertarDocumento').formValidation(
		{
			framework : 'bootstrap',
			excluded : [':disabled', ':hidden', ':not(:visible)', '[class*="notValidate"]'],
			live : 'enabled',
			message : '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
			trigger : null,
			fields :
			{
				selectCodigoOficina :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				},
				// txtNombreCompletoPersonaPresenta :
				// {
				// 	validators : 
				// 	{
				// 		notEmpty :
				// 		{
				// 			message : '<b style="color: red;">Este campo es requerido.</b>'
				// 		}
				// 	}
				// },
				txtDniPersonaPresenta :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						regexp :
						{
							message : '<b style="color: red;">Formato incorrecto. [Ejemplo: 077/21].</b>',
							regexp : /\d{1}$/
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
				txtFolio :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						},
						regexp :
						{
							message : '<b style="color: red;">Formato incorrecto. [Ejemplo: 1, 2, 3, ...].</b>',
							regexp : /^[0-9]+$/
						}
					}
				},
				fileArchivo :
				{
					validators : 
					{
						notEmpty :
						{
							message : '<b style="color: red;">Este campo es requerido.</b>'
						}
					}
				}
			}
		});
	});

	function onChangeSelectedFile()
	{
		window.setTimeout(function()
		{
			$('#frmInsertarDocumento').data('formValidation').resetForm();

			$('#frmInsertarDocumento').data('formValidation').validateField('selectCodigoOficina');
			$('#frmInsertarDocumento').data('formValidation').validateField('txtNombreCompletoPersonaPresenta');
			$('#frmInsertarDocumento').data('formValidation').validateField('txtDniPersonaPresenta');

			$('#frmInsertarDocumento').data('formValidation').validateField('txtProcedencia');
		
			$('#frmInsertarDocumento').data('formValidation').validateField('txtNombre');
			$('#frmInsertarDocumento').data('formValidation').validateField('txtFolio');
			
			$('#frmInsertarDocumento').data('formValidation').validateField('txtEntrega');
			$('#frmInsertarDocumento').data('formValidation').validateField('txtEntregaCmte');
			$('#frmInsertarDocumento').data('formValidation').validateField('txtObservacion');

			$('#frmInsertarDocumento').data('formValidation').validateField('fileArchivo');

		}, 250);
	}

	function agregarQuitarAdjunto(direct, element)
	{
		if(direct || ($(element).val()!=null && $(element).val().trim()!=''))
		{
			var existeFormularioLibre=false;

			$('#divContenedorAdjuntos > div').each(function(index1, element1)
			{
				if($($(element1).find('input[id^=txtNombre]')[0]).val()!=null && $($(element1).find('input[id^=txtNombre]')[0]).val().trim()=='')
				{
					existeFormularioLibre=true;

					return false;
				}
			});

			if(!existeFormularioLibre)
			{
				var htmlTemp='<div class="row">'
					+'<div class="form-group col-md-4">'
						+'<label for="txtNombreX" style="color: orange;">Nombre del documento</label>'
						+'<input type="text" id="txtNombreX" name="txtNombreAdjunto[]" class="form-control" onkeyup="agregarQuitarAdjunto(false, this);">'
					+'</div>'
					+'<div class="form-group col-md-2">'
						+'<label for="txtFolioX" style="color: orange;">Folio</label>'
						+'<input type="text" id="txtFolioX" name="txtFolioAdjunto[]" class="form-control">'
					+'</div>'
					+'<div class="form-group col-md-3">'
						+'<label for="selectTipoX" style="color: orange;">Tipo</label>'
						+'<select id="selectTipoX" name="selectTipoAdjunto[]" class="form-control">'
							+'<option value="Solicitud">Solicitud</option>'
							+'<option value="Carta">Carta</option>'
							+'<option value="Oficio">Oficio</option>'
							+'<option value="Resolución">Resolución</option>'
							+'<option value="Otros">Otros</option>'
						+'</select>'
					+'</div>'
					+'<div class="form-group col-md-3">'
						+'<label for="fileArchivoX" style="color: orange;">Archivo</label>'
						+'<input type="file" id="fileArchivoX" name="fileArchivoAdjunto[]" class="form-control" onchange="onChangeSelectedFile();" style="border: none;">'
					+'</div>'
				'</div>';

				$('#divContenedorAdjuntos').append(htmlTemp);
			}
		}
		else
		{
			$('#divContenedorAdjuntos > div').each(function(index1, element1)
			{
				if(($($(element1).find('input[id^=txtNombre]')[0]).val()!=null && $($(element1).find('input[id^=txtNombre]')[0]).val().trim()=='') && !($($(element1).find('input[id^=txtNombre]')[0]).is(':focus')))
				{
					$(element1).remove();
				}
			});
		}

		enumerarComponentes();

		$('#frmInsertarDocumento').data('formValidation').resetForm();

		$('#frmInsertarDocumento').data('formValidation').validateField('selectCodigoOficina');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtNombreCompletoPersonaPresenta');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtDniPersonaPresenta');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtProcedencia');

		$('#frmInsertarDocumento').data('formValidation').validateField('txtNombre');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtFolio');
		
		$('#frmInsertarDocumento').data('formValidation').validateField('txtEntrega');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtEntregaCmte');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtObservacion');

		$('#frmInsertarDocumento').data('formValidation').validateField('fileArchivo');

		$('#divContenedorAdjuntos > div').each(function(index1, element1)
		{
			if(($($(element1).find('input[id^=txtNombre]')[0]).val()!=null && $($(element1).find('input[id^=txtNombre]')[0]).val().trim()!='') || $($(element1).find('input[id^=fileArchivo]')[0]).val()!='')
			{
				agregarValidacion(element1);

				$('#frmInsertarDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=txtNombre]')[0]));
				$('#frmInsertarDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=txtFolio]')[0]));
				$('#frmInsertarDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=fileArchivo]')[0]));
			}
		});
	}

	function enumerarComponentes()
	{
		$('#divContenedorAdjuntos > div').each(function(index, element)
		{
			var posicionActual=index+1;

			$(element).attr('id', 'divAdjunto'+posicionActual);

			$($('#'+$(element).attr('id')+' label[for^=txtNombre]')[0]).attr('for', 'txtNombre'+posicionActual);
			$($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]).attr('id', 'txtNombre'+posicionActual);

			$($('#'+$(element).attr('id')+' label[for^=txtFolio]')[0]).attr('for', 'txtFolio'+posicionActual);
			$($('#'+$(element).attr('id')+' input[id^=txtFolio]')[0]).attr('id', 'txtFolio'+posicionActual);

			$($('#'+$(element).attr('id')+' label[for^=selectTipo]')[0]).attr('for', 'selectTipo'+posicionActual);
			$($('#'+$(element).attr('id')+' input[id^=selectTipo]')[0]).attr('id', 'selectTipo'+posicionActual);

			$($('#'+$(element).attr('id')+' label[for^=fileArchivo]')[0]).attr('for', 'fileArchivo'+posicionActual);
			$($('#'+$(element).attr('id')+' input[id^=fileArchivo]')[0]).attr('id', 'fileArchivo'+posicionActual);
		});
	}

	function agregarValidacion(element)
	{
		$('#frmInsertarDocumento').formValidation('addField', $($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]),
		{
			validators :
			{
				notEmpty :
				{
					message : '<b style="color: red;">Este campo es requerido.</b>'
				}
			}
		});

		$('#frmInsertarDocumento').formValidation('addField', $($('#'+$(element).attr('id')+' input[id^=txtFolio]')[0]),
		{
			validators :
			{
				notEmpty :
				{
					message : '<b style="color: red;">Este campo es requerido.</b>'
				},
				regexp :
				{
					message : '<b style="color: red;">Formato incorrecto. [Ejemplo: 1, 2, 3, ...].</b>',
					regexp : /^[0-9]+$/
				}
			}
		});

		$('#frmInsertarDocumento').formValidation('addField', $($('#'+$(element).attr('id')+' input[id^=fileArchivo]')[0]),
		{
			validators :
			{
				notEmpty :
				{
					message : '<b style="color: red;">Este campo es requerido.</b>'
				}
			}
		});
	}

	function enviarFrmInsertarDocumento()
	{
		var isValid=null;

		$('#frmInsertarDocumento').data('formValidation').resetForm();

		$('#divContenedorAdjuntos > div').each(function(index, element)
		{
			if(($($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]).val()!=null && $($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]).val().trim()!='') || $($('#'+$(element).attr('id')+' input[id^=fileArchivo]')[0]).val()!='')
			{
				agregarValidacion(element);

				$('#frmInsertarDocumento').data('formValidation').validateField($($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]));
				$('#frmInsertarDocumento').data('formValidation').validateField($($('#'+$(element).attr('id')+' input[id^=txtFolio]')[0]));
				$('#frmInsertarDocumento').data('formValidation').validateField($($('#'+$(element).attr('id')+' input[id^=fileArchivo]')[0]));
			}
			else
			{
				$(element).remove();
			}
		});

		$('#frmInsertarDocumento').data('formValidation').validateField('selectCodigoOficina');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtNombreCompletoPersonaPresenta');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtDniPersonaPresenta');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtProcedencia');

		$('#frmInsertarDocumento').data('formValidation').validateField('txtNombre');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtFolio');
		
		$('#frmInsertarDocumento').data('formValidation').validateField('txtEntrega');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtEntregaCmte');
		$('#frmInsertarDocumento').data('formValidation').validateField('txtObservacion');

		$('#frmInsertarDocumento').data('formValidation').validateField('fileArchivo');

		isValid=$('#frmInsertarDocumento').data('formValidation').isValid();

		if(!isValid)
		{
			agregarQuitarAdjunto(true, null);

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
				
				$('#frmInsertarDocumento')[0].submit();	
			}
			else
			{
				agregarQuitarAdjunto(true, null);
			}
		});
	}
</script>
@endsection
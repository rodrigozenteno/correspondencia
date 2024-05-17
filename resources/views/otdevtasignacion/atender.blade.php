<form id="frmAtenderDocumento" action="{{url('otdevtasignacion/atender')}}" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="form-group col-md-4">
			<label for="selectCodigoOficina">Oficina donde se atiende</label>
			<select id="selectCodigoOficina" name="selectCodigoOficina" disabled style="width: 100%;">
				@foreach($listaTOficina as $value)
					<option value="{{$value->codigoOficina}}" {{Session::get('codigoOficina')==$value->codigoOficina ? 'selected' : ''}}>{{$value->nombre}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-5">
			<label for="txtNombreCompletoPersonaPresenta">Proveido</label>
			<input type="text" id="txtNombreCompletoPersonaPresenta" name="txtNombreCompletoPersonaPresenta" class="form-control" readonly="readonly" value="{{$tOTDEvtAsignacion->nombreCompletoPersonaPresenta}}">
		</div>
		<div class="form-group col-md-3">
			<label for="txtDniPersonaPresenta">N° de Documento</label>
			<input type="text" id="txtDniPersonaPresenta" name="txtDniPersonaPresenta" class="form-control" readonly="readonly" value="{{$tOTDEvtAsignacion->dniPersonaPresenta}}">
		</div>
	</div>
	<hr>
	<h4>
		<a onclick="showHideCollapse();" style="cursor: pointer;">Emitir documento de atención</a>
		<input type="checkbox" id="cbAtenderNuevoDocumentoTemp" disabled>
		<input type="checkbox" id="cbAtenderNuevoDocumento" name="cbAtenderNuevoDocumento" value="Nuevo documento" style="display: none;">
	</h4>
	<hr>
	<div id="divContenedorAtenderDocumento" class="panel-collapse collapse">
		<div class="row">
			<div class="form-group col-md-4">
				<label for="txtNombre">Nombre del documento</label>
				<input type="text" id="txtNombre" name="txtNombre" class="form-control" placeholder="Obligatorio">
			</div>
			<div class="form-group col-md-2">
				<label for="txtFolio">Folio</label>
				<input type="text" id="txtFolio" name="txtFolio" class="form-control" placeholder="Obligatorio">
			</div>
			<div class="form-group col-md-3">
				<label for="selectTipo">Tipo</label>
				<select id="selectTipo" name="selectTipo" class="form-control">
					<option value="Solicitud">Solicitud</option>
					<option value="Carta">Radiograma</option>
					<option value="Oficio">Oficio</option>
					<option value="Resolución">Resolución</option>
					<option value="Informe">Informe</option>
				</select>
			</div>
		
			<div class="form-group col-md-3">
				<label for="fileArchivo">Archivo</label>
				<input type="file" id="fileArchivo" name="fileArchivo" class="form-control" style="border: none;">
			</div>
		</div>
		<hr>
		<h4>
			<a data-toggle="collapse" data-parent="#accordion" href="#divContenedorAdjuntos">Documentos adjuntos (Ver/Ocultar)</a>
		</h4>
		<hr>
		<div id="divContenedorAdjuntos" class="panel-collapse collapse">
			<div class="row">
				<div class="form-group col-md-4">
					<label for="txtNombre1" style="color: orange;">Nombre del documento</label>
					<input type="text" id="txtNombre1" name="txtNombreAdjunto[]" class="form-control" onkeyup="agregarQuitarAdjunto(false, this);">
				</div>
				<div class="form-group col-md-2">
					<label for="txtFolio1" style="color: orange;">Folio</label>
					<input type="text" id="txtFolio1" name="txtFolioAdjunto[]" class="form-control">
				</div>
				<div class="form-group col-md-3">
					<label for="selectTipo1" style="color: orange;">Tipo</label>
					<select id="selectTipo1" name="selectTipoAdjunto[]" class="form-control">
						<option value="Solicitud">Solicitud</option>
						<option value="Carta">Carta</option>
						<option value="Oficio">Oficio</option>
						<option value="Resolución">Resolución</option>
						<option value="Otros">Otros</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="fileArchivo1" style="color: orange;">Archivo</label>
					<input type="file" id="fileArchivo1" name="fileArchivoAdjunto[]" class="form-control" onchange="onChangeSelectedFile();" style="border: none;">
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			{{csrf_field()}}
			<input type="hidden" name="hdCodigoOTDEvtAsignacion" value="{{$tOTDEvtAsignacion->codigoOTDEvtAsignacion}}">
			<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
			<input type="button" class="btn btn-primary pull-right" value="Atender documento" onclick="enviarFrmAtenderDocumento();">
		</div>
	</div>
</form>
<script>
	$('#frmAtenderDocumento').formValidation(
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

	$('#selectCodigoOficina').select2(
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

	var activeCollapse=true;

	function showHideCollapse()
	{
		if(activeCollapse)
		{
			activeCollapse=false;

			$('#cbAtenderNuevoDocumentoTemp').prop('checked', true);
			$('#cbAtenderNuevoDocumento').prop('checked', true);

			$('#divContenedorAtenderDocumento').collapse('show');
		}
		else
		{
			activeCollapse=true;

			$('#cbAtenderNuevoDocumentoTemp').prop('checked', false);
			$('#cbAtenderNuevoDocumento').prop('checked', false);

			$('#divContenedorAtenderDocumento').collapse('hide');
		}
	}

	function onChangeSelectedFile()
	{
		window.setTimeout(function()
		{
			$('#frmAtenderDocumento').data('formValidation').resetForm();

			$('#frmAtenderDocumento').data('formValidation').validateField('txtNombre');
			$('#frmAtenderDocumento').data('formValidation').validateField('txtFolio');
			$('#frmAtenderDocumento').data('formValidation').validateField('fileArchivo');

			$('#divContenedorAdjuntos > div').each(function(index1, element1)
			{
				if(($($(element1).find('input[id^=txtNombre]')[0]).val()!=null && $($(element1).find('input[id^=txtNombre]')[0]).val().trim()!='') || $($(element1).find('input[id^=fileArchivo]')[0]).val()!='')
				{
					agregarValidacion(element1);

					$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=txtNombre]')[0]));
					$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=txtFolio]')[0]));
					$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=fileArchivo]')[0]));
				}
			});
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

		$('#frmAtenderDocumento').data('formValidation').resetForm();

		$('#frmAtenderDocumento').data('formValidation').validateField('txtNombre');
		$('#frmAtenderDocumento').data('formValidation').validateField('txtFolio');
		$('#frmAtenderDocumento').data('formValidation').validateField('fileArchivo');

		$('#divContenedorAdjuntos > div').each(function(index1, element1)
		{
			if(($($(element1).find('input[id^=txtNombre]')[0]).val()!=null && $($(element1).find('input[id^=txtNombre]')[0]).val().trim()!='') || $($(element1).find('input[id^=fileArchivo]')[0]).val()!='')
			{
				agregarValidacion(element1);

				$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=txtNombre]')[0]));
				$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=txtFolio]')[0]));
				$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element1).attr('id')+' input[id^=fileArchivo]')[0]));
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
		$('#frmAtenderDocumento').formValidation('addField', $($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]),
		{
			validators :
			{
				notEmpty :
				{
					message : '<b style="color: red;">Este campo es requerido.</b>'
				}
			}
		});

		$('#frmAtenderDocumento').formValidation('addField', $($('#'+$(element).attr('id')+' input[id^=txtFolio]')[0]),
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

		$('#frmAtenderDocumento').formValidation('addField', $($('#'+$(element).attr('id')+' input[id^=fileArchivo]')[0]),
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

	function enviarFrmAtenderDocumento()
	{
		var isValid=null;

		$('#frmAtenderDocumento').data('formValidation').resetForm();

		if($('#cbAtenderNuevoDocumento').is(':checked'))
		{
			$('#divContenedorAdjuntos > div').each(function(index, element)
			{
				if(($($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]).val()!=null && $($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]).val().trim()!='') || $($('#'+$(element).attr('id')+' input[id^=fileArchivo]')[0]).val()!='')
				{
					agregarValidacion(element);

					$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element).attr('id')+' input[id^=txtNombre]')[0]));
					$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element).attr('id')+' input[id^=txtFolio]')[0]));
					$('#frmAtenderDocumento').data('formValidation').validateField($($('#'+$(element).attr('id')+' input[id^=fileArchivo]')[0]));
				}
				else
				{
					$(element).remove();
				}
			});

			$('#frmAtenderDocumento').data('formValidation').validateField('txtNombre');
			$('#frmAtenderDocumento').data('formValidation').validateField('txtFolio');
			$('#frmAtenderDocumento').data('formValidation').validateField('fileArchivo');
		}

		isValid=$('#cbAtenderNuevoDocumento').is(':checked') ? $('#frmAtenderDocumento').data('formValidation').isValid() : true;

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
				
				$('#frmAtenderDocumento')[0].submit();
			}
			else
			{
				agregarQuitarAdjunto(true, null);
			}
		});
	}
</script>
var evtTimeOutJsBuscar='';

function agregarSlashes(cadena)
{
	return cadena.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function textAdapter(cadena)
{
	var expresionRegular;
	var tildes="ÀÁÈÉÌÍÒÓÙÚàáèéìíòóùú";
	var silabasNormales="AAEEIIOOUUaaeeiioouu";

	for(var i=0; i<tildes.length; i++)
	{
		expresionRegular=new RegExp(tildes.charAt(i),"g");
		cadena=cadena.replace(expresionRegular, silabasNormales.charAt(i));
	}

	return cadena;
}

function filtrarHtml(idContenedor, cadena, onKeyUp, retardo, event)
{
	var evt=event || window.event;

	var code=evt.charCode || evt.keyCode || evt.which;

	if(code==13 || onKeyUp)
	{
		if(evtTimeOutJsBuscar!='')
		{
			clearTimeout(evtTimeOutJsBuscar);
			evtTimeOutJsBuscar='';
		}

		evtTimeOutJsBuscar=setTimeout(function()
		{
			cadena=textAdapter(cadena);

			var palabras=cadena.split(/ /);

			var palabrasTratadas='';

			for(var i=0; i<palabras.length; i++)
			{
				if(palabras[i]!='')
				{
					palabrasTratadas+=' '+palabras[i];
				}
			}

			palabrasTratadas=palabrasTratadas.substring(1);
			palabrasTratadas=agregarSlashes(palabrasTratadas);
			palabrasTratadas=palabrasTratadas.split(/ /);

			var palabraExpresionRegular;
			var expresionRegular;
			var muestraBusqueda;
			var contenedorBuscar=document.getElementById(idContenedor);
			var elementoBuscar=contenedorBuscar.getElementsByClassName('elementoBuscar');

			var longitudElementosBuscar=elementoBuscar.length;
			var longitudPalabrasTratadas=palabrasTratadas.length;

			var displayDefecto='';
			var displayDefectoAsignado=false;

			if(!displayDefectoAsignado)
			{
				for(var i=0; i<longitudElementosBuscar; i++)
				{
					if(elementoBuscar[i].style.display!='none')
					{
						displayDefecto=elementoBuscar[i].style.display;
						displayDefectoAsignado=true;

						break;
					}
				}
			}

			if(palabras=='')
			{
				for(var i=0; i<longitudElementosBuscar; i++)
				{
					elementoBuscar[i].style.display=displayDefecto;
				}

				return;
			}

			var elemento;

			for(var i=0; i<longitudElementosBuscar; i++)
			{
				elemento=elementoBuscar[i];

				muestraBusqueda=true;

				for(var j=0; j<longitudPalabrasTratadas; j++)
				{
					palabraExpresionRegular=palabrasTratadas[j];

					expresionRegular=new RegExp(palabraExpresionRegular, 'i');

					if(!expresionRegular.test(textAdapter((elemento.textContent!='undefined' ? elemento.textContent : elemento.innerText).replace(/\s/g,''))))
					{
						muestraBusqueda=false;

						break;
					}
				}

				if(muestraBusqueda)
				{
					elemento.style.display=displayDefecto;
				}
				else
				{
					elemento.style.display='none';
				}
			}
		}, retardo);
	}
}
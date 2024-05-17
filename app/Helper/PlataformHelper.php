<?php
namespace App\Helper;

use Session;
use Mail;

use App\Model\TExcepcion;
use App\Model\TUsuario;

class PlataformHelper
{
	public function redirectCorrecto($mensaje, $routeRedirect)
	{
		Session::flash('mensajeGlobal', $mensaje);
		Session::flash('tipo', 'success');

		return redirect($routeRedirect);
	}

	public function redirectAlerta($mensaje, $routeRedirect)
	{
		Session::flash('mensajeGlobal', $mensaje);
		Session::flash('tipo', 'notice');

		return redirect($routeRedirect);
	}

	public function redirectError($mensaje, $routeRedirect)
	{
		Session::flash('mensajeGlobal', $mensaje);
		Session::flash('tipo', 'error');

		return redirect($routeRedirect);
	}

	public function capturarExcepcion($controller, $action, $ex, $routeRedirect)
	{
		try
		{
			$tExcepcion=new TExcepcion();

			$tExcepcion->codigoExcepcion=uniqid();
			$tExcepcion->codigoUsuario=Session::has('codigoUsuario') ? Session::get('codigoUsuario') : null;
			$tExcepcion->controlador=$controller;
			$tExcepcion->accion=$action;
			$tExcepcion->error=$ex;
			$tExcepcion->estado='Pendiente';

			$tExcepcion->save();

			Session::flash('mensajeGlobal', 'Ocurrió un error inesperado. Se está trabajando para solucionar este problema, gracias por su paciencia.');
			Session::flash('tipo', 'error');
		}
		catch(\Exception $ex)
		{
			Session::flash('mensajeGlobal', 'Ocurrió un error inesperado. Se está trabajando para solucionar este problema, gracias por su paciencia.');
			Session::flash('tipo', 'error');
		}

		return redirect($routeRedirect);
	}

	public function cadenaAleatoria($length=10)
	{
		$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength=strlen($characters);
		$randomString='';
		
		for ($i=0;$i<$length; $i++)
		{
			$randomString.=$characters[rand(0, $charactersLength-1)];
		}

		return $randomString;
	}

	public function fechaHoraSumar($fechaHora, $tipo, $cantidad)
	{
		$nuevaFechaHora=strtotime( '+'.$cantidad.' '.$tipo , strtotime($fechaHora));
		$nuevaFechaHora=date('Y-m-d H:i:s' , $nuevaFechaHora);

		return $nuevaFechaHora;
	}

	public function verificarSesion()
	{
		$tUsuario=TUsuario::find(Session::get('codigoUsuario'));

		if($tUsuario==null)
		{
			return $this->plataformHelper->redirectError('No existe una sesión iniciada.', '/');
		}

		return $tUsuario;
	}

	public function verificarExistenciaAutorizacion($objeto, $codigoObjeto, $codigoActual, &$mensajeOut)
	{
		if($objeto==null)
		{
			$mensajeOut='Datos inexistentes.';

			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
			{
				echo '<div class="alert alert-danger"><h4><i class="icon fa fa-ban"></i> Prohibido!</h4>'.$mensajeOut.'</div>';exit;
			}

			return false;
		}

		if($codigoObjeto===true && $codigoActual===true)
		{
			return true;
		}

		if($objeto->$codigoObjeto!=$codigoActual)
		{
			$mensajeOut='Esta información no es de su propiedad. Por favor no trate de alterar el comportamiento del sistema.';

			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
			{
				echo '<div class="alert alert-danger"><h4><i class="icon fa fa-ban"></i> Prohibido!</h4>'.$mensajeOut.'</div>';exit;
			}

			return false;
		}

		return true;
	}

	public function prepararPaginacion($consulta, $registrosPagina, $paginaActual)
	{
		$cantidadRegistrosConsiderar=$registrosPagina;
		$paginaActual=$paginaActual<=0 ? 1 : $paginaActual;
		$cantidadPaginas=ceil(($consulta->count())/$cantidadRegistrosConsiderar);
		$paginaActual=$paginaActual>$cantidadPaginas ? ($cantidadPaginas > 0 ? $cantidadPaginas : 1) : $paginaActual;
		$listaRegistros=$consulta->skip(($paginaActual*$cantidadRegistrosConsiderar)-$cantidadRegistrosConsiderar)->take($cantidadRegistrosConsiderar)->get();
		$cantidadPaginas=($cantidadPaginas==0 ? 1 : $cantidadPaginas);

		return ['listaRegistros' => $listaRegistros, 'paginaActual' => $paginaActual, 'cantidadPaginas' => $cantidadPaginas];
	}

	public function renderizarPaginacion($urlPagina, $cantidadPaginas, $paginaActual, $parametroBusqueda)
	{
		$parametroBusqueda=($parametroBusqueda!='' && $parametroBusqueda!=null) ? '?parametroBusqueda='.$parametroBusqueda : '';

		$seccionPaginacion=''
			.'<div class="divPaginacion">'
				.'<span><a class="divPaginacionSalto" href="'.url($urlPagina.'/'.(($paginaActual-1)<=0 ? 1 : ($paginaActual-1))).$parametroBusqueda.'">Anterior</a>...</span>'
				.'<a href="'.url($urlPagina.'/1').$parametroBusqueda.'" class="divPaginacionNumeroPagina" '.(1==$paginaActual ? 'style="background-color: #6195ce;color: #ffffff;"' : '').'>1</a>';
		if($paginaActual-2>1)
		{
			$seccionPaginacion.='...';
		}
		
		for($i=($paginaActual-2<=1 ? 2 : $paginaActual-2); $i<=($cantidadPaginas<($paginaActual+2) ? $cantidadPaginas : $paginaActual+2); $i++)
		{
			$seccionPaginacion.='<a href="'.url($urlPagina.'/'.$i).$parametroBusqueda.'" class="divPaginacionNumeroPagina" '.($i==$paginaActual ? 'style="background-color: #6195ce;color: #ffffff;"' : '').'>'.$i.'</a>';
		}
		if($cantidadPaginas>($paginaActual+2))
		{
			$seccionPaginacion.='...'
				.'<a href="'.url($urlPagina.'/'.$cantidadPaginas).$parametroBusqueda.'" class="divPaginacionNumeroPagina" '.($cantidadPaginas==$paginaActual ? 'style="background-color: #6195ce;color: #ffffff;"' : '').'>'.$cantidadPaginas.'</a>';
		}
		
		$seccionPaginacion.='<span>...<a class="divPaginacionSalto" href="'.url($urlPagina.'/'.(($paginaActual+1)>$cantidadPaginas ? $cantidadPaginas : ($paginaActual+1))).$parametroBusqueda.'">Siguiente</a></span>'
			.'</div>';

		return $seccionPaginacion;
	}

	public function borrarSaltosCKEditor($contenido)
	{
		$descripcion=trim($contenido);

		while(substr($descripcion, 0, 13)=='<p>&nbsp;</p>')
		{
			$descripcion=substr($descripcion, 13, strlen($descripcion));
		}

		$longitudDescripcion=strlen($descripcion);

		while(substr($descripcion, $longitudDescripcion-13, 13)=='<p>&nbsp;</p>')
		{
			$descripcion=substr($descripcion, 0, $longitudDescripcion-13);

			$longitudDescripcion=strlen($descripcion);
		}

		return $descripcion;
	}

	public function limpiarTextoEntreComas($etiquetas)
	{
		$arrayEtiquetas=explode(',', $etiquetas);

		$etiquetasNuevas='';

		foreach($arrayEtiquetas as $key => $value)
		{
			if(trim($value)!='')
			{		
				$etiquetasNuevas.=','.trim($value);
			}
		}

		$etiquetasNuevas=substr($etiquetasNuevas, 1, strlen($etiquetasNuevas));

		return $etiquetasNuevas;
	}
}
?>
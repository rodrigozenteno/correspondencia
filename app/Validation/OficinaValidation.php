<?php
namespace App\Validation;

use Validator;
use Session;

use App\Model\TOficina;

class OficinaValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$tOficina=TOficina::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '')", [$request->input('txtNombre')])->get();

		if(count($tOficina)>0)
		{
			$this->mensajeGlobal.='La oficina ya se encuentra registrada en el sistema (Nombre de la oficina existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$tOficina=TOficina::whereRaw("replace(nombre, ' ', '')=replace(?, ' ', '') and codigoOficina!=?", [$request->input('txtNombre'), $request->input('hdCodigoOficina')])->get();

		if(count($tOficina)>0)
		{
			$this->mensajeGlobal.='La oficina ya se encuentra registrada en el sistema (Nombre de la oficina existente).__SALTOLINEA__';
		}

		return $this->mensajeGlobal;
	}
}
?>
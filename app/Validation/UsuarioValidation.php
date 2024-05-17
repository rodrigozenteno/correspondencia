<?php
namespace App\Validation;

use Validator;
use Session;
use Illuminate\Validation\Rule;

use App\Model\TUsuario;

class UsuarioValidation
{
	private $mensajeGlobal='';

	public function validationInsertar($request)
	{
		$validator=Validator::make(
		[
			'correoElectronico' => trim($request->input('txtCorreoElectronico'))
		],
		[
			'correoElectronico' => ['unique:tusuario,correoElectronico']
		],
		[
			'correoElectronico.unique' => 'El usuario ya se encuentra registrado en el sistema (Correo electrónico del usuario existente).__SALTOLINEA__'
		]);

		if($validator->fails())
		{
			$errors=$validator->errors()->all();

			foreach($errors as $value)
			{
				$this->mensajeGlobal.=$value;
			}
		}

		return $this->mensajeGlobal;
	}

	public function validationEditar($request)
	{
		$validator=Validator::make(
		[
			'correoElectronico' => trim($request->input('txtCorreoElectronico'))
		],
		[
			'correoElectronico' => [Rule::unique('tusuario')->where(function($query) use($request){ return $query->where('codigoUsuario', '<>', $request->input('hdCodigoUsuario')); })]
		],
		[
			'correoElectronico.unique' => 'El usuario ya se encuentra registrado en el sistema (Correo electrónico del usuario existente).__SALTOLINEA__'
		]);

		if($validator->fails())
		{
			$errors=$validator->errors()->all();

			foreach($errors as $value)
			{
				$this->mensajeGlobal.=$value;
			}
		}

		return $this->mensajeGlobal;
	}
}
?>
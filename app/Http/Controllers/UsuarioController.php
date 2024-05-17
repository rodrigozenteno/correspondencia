<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Encryption\Encrypter;

use App\Validation\UsuarioValidation;

use DB;
use App\Model\TUsuario;
use App\Model\TOficina;

class UsuarioController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager, Encrypter $encrypter)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new UsuarioValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'usuario/insertar');
				}

				$tUsuario=new TUsuario();

				$tUsuario->codigoUsuario=uniqid();
				$tUsuario->grado=trim($request->input('txtGrado'));
				$tUsuario->nombre=trim($request->input('txtNombre'));
				$tUsuario->apellido=trim($request->input('txtApellido'));
				$tUsuario->correoElectronico=trim($request->input('txtCorreoElectronico'));
				$tUsuario->contrasenia=$encrypter->encrypt($request->input('passContrasenia'));
				$tUsuario->rol=implode(',', $request->input('selectRol'));

				$tUsuario->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'usuario/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('usuario/insertar');
	}

	public function actionVer(SessionManager $sessionManager)
	{
		$listaTUsuario=TUsuario::whereRaw('rol not like ?', ['%Súper usuario%'])->get();

		return view('usuario/ver', ['listaTUsuario' => $listaTUsuario]);
	}

	public function actionLogIn(Request $request, SessionManager $sessionManager, Encrypter $encrypter)
	{
		if($_POST)
		{
			$sessionManager->flush();

			$tUsuario=TUsuario::whereRaw('correoElectronico=?', [trim($request->input('txtCorreoElectronico'))])->first();

			if($tUsuario!=null)
			{
				if($encrypter->decrypt($tUsuario->contrasenia)===$request->input('passContrasenia'))
				{
					$sessionManager->put('codigoUsuario', $tUsuario->codigoUsuario);
					$sessionManager->put('correoElectronico', $tUsuario->correoElectronico);
					$sessionManager->put('grado', $tUsuario->grado);
					$sessionManager->put('nombreCompleto', $tUsuario->nombre);
					$sessionManager->put('rol', $tUsuario->rol);
					$sessionManager->put('codigoOficina', $request->input('selectCodigoOficina'));
					$sessionManager->put('nombreOficina', TOficina::find($request->input('selectCodigoOficina'))->nombre);

					return $this->plataformHelper->redirectCorrecto('Se bienvenido(a) al sistema, '.$tUsuario->nombre.'.', '/');
				}
			}

			return $this->plataformHelper->redirectError('Usuario y/o contraseña incorrecta.', 'usuario/login');
		}

		$listaTOficina=TOficina::all();

		return view('usuario/login', ['listaTOficina' => $listaTOficina]);
	}

	public function actionLogOut(SessionManager $sessionManager)
	{
		$sessionManager->flush();

		return $this->plataformHelper->redirectCorrecto('Sesión cerrada correctamente.', '/');
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoUsuario'))
		{
			try
			{
				DB::beginTransaction();

				$tUsuario=TUsuario::whereRaw('codigoUsuario=?', [$request->input('hdCodigoUsuario')])->first();

				if(strpos($sessionManager->get('rol'), 'Administrador')===false && strpos($sessionManager->get('rol'), 'Súper usuario')===false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut)))
				{
					return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
				}

				$this->mensajeGlobal=(new UsuarioValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'usuario/ver');
				}
				$tUsuario->grado=trim($request->input('txtGrado'));
				$tUsuario->nombre=trim($request->input('txtNombre'));
				$tUsuario->apellido=trim($request->input('txtApellido'));
				$tUsuario->correoElectronico=trim($request->input('txtCorreoElectronico'));
				$tUsuario->rol=implode(',', $request->input('selectRol'));

				$tUsuario->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'usuario/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tUsuario=TUsuario::whereRaw('codigoUsuario=?', [$request->input('codigoUsuario')])->first();

		if(strpos($sessionManager->get('rol'), 'Administrador')===false && strpos($sessionManager->get('rol'), 'Súper usuario')===false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut)))
		{
			return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
		}

		return view('usuario/editar', ['tUsuario' => $tUsuario]);
	}

	public function actionCambiarContrasenia(Request $request, SessionManager $sessionManager, Encrypter $encrypter)
	{
		if($request->has('hdCodigoUsuario'))
		{
			try
			{
				DB::beginTransaction();

				$tUsuario=TUsuario::whereRaw('codigoUsuario=?', [$request->input('hdCodigoUsuario')])->first();

				if(strpos($sessionManager->get('rol'), 'Administrador')===false && strpos($sessionManager->get('rol'), 'Súper usuario')===false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut)))
				{
					return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
				}

				if($encrypter->decrypt($tUsuario->contrasenia)!=$request->input('passContraseniaActual') && strpos($sessionManager->get('rol'), 'Administrador')===false && strpos($sessionManager->get('rol'), 'Súper usuario')===false)
				{
					return $this->plataformHelper->redirectError('La contraseña actual no es la correcta.', 'usuario/ver');
				}

				$tUsuario->contrasenia=$encrypter->encrypt($request->input('passContrasenia'));

				$tUsuario->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'usuario/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tUsuario=TUsuario::whereRaw('codigoUsuario=?', [$request->input('codigoUsuario')])->first();

		if(strpos($sessionManager->get('rol'), 'Administrador')===false && strpos($sessionManager->get('rol'), 'Súper usuario')===false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut)))
		{
			return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
		}

		return view('usuario/cambiarcontrasenia', ['tUsuario' => $tUsuario]);
	}
}
?>
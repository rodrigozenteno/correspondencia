<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\OficinaValidation;

use DB;
use App\Model\TOficina;

class OficinaController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->mensajeGlobal=(new OficinaValidation())->validationInsertar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					$request->flash();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'oficina/insertar');
				}

				$tOficina=new TOficina();

				$tOficina->codigoOficina=uniqid();
				$tOficina->nombre=trim($request->input('txtNombre'));

				$tOficina->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'oficina/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('oficina/insertar');
	}

	public function actionVer(SessionManager $sessionManager)
	{
		$listaTOficina=TOficina::all();

		return view('oficina/ver', ['listaTOficina' => $listaTOficina]);
	}

	public function actionEditar(Request $request, SessionManager $sessionManager)
	{
		if($request->has('hdCodigoOficina'))
		{
			try
			{
				DB::beginTransaction();

				$tOficina=TOficina::find($request->input('hdCodigoOficina'));

				$this->mensajeGlobal=(new OficinaValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'oficina/ver');
				}

				$tOficina->nombre=trim($request->input('txtNombre'));

				$tOficina->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'oficina/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$tOficina=TOficina::find($request->input('codigoOficina'));

		return view('oficina/editar', ['tOficina' => $tOficina]);
	}
}
?>
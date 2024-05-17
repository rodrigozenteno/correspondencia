<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Session\SessionManager;
use Illuminate\Contracts\Filesystem\Factory as FileSystem;
use ZipArchive;

use App\Validation\DocumentoValidation;

use DB;
use App\Model\TDocumento;
use App\Model\TOficina;
use App\Model\TOTDEvtAsignacion;
use App\Model\TOTDEvtArchivo;

class OTDEvtAsignacionController extends Controller
{
	public function actionInsertar(Request $request, SessionManager $sessionManager, FileSystem $fileSystem)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$codigoOTDEvtAsignacion=uniqid();

				$tDocumento=new TDocumento();

				$codigoDocumento=uniqid();

				$tDocumento->codigoDocumento=$codigoDocumento;
				$tDocumento->nombre=trim($request->input('txtNombre'));
				$tDocumento->folio=$request->input('txtFolio');
				$tDocumento->tipo=$request->input('selectTipo');

				$fileGetClientOriginalExtension=strtolower($request->file('fileArchivo')->getClientOriginalExtension());

				$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/'.$codigoDocumento.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivo')->getRealPath()));

				$tDocumento->extension=$fileGetClientOriginalExtension;

				$tDocumento->save();

				$tOTDEvtAsignacion=new TOTDEvtAsignacion();

				$tOTDEvtAsignacion->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
				$tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre=null;
				$tOTDEvtAsignacion->codigoDocumento=$codigoDocumento;
				$tOTDEvtAsignacion->codigoOficina=$request->has('selectCodigoOficina') ? $request->input('selectCodigoOficina') : $sessionManager->get('codigoOficina');
				$tOTDEvtAsignacion->codigoUsuario=$sessionManager->get('codigoUsuario');
				$tOTDEvtAsignacion->nombreCompletoPersonaPresenta=trim($request->input('txtNombreCompletoPersonaPresenta'));
				$tOTDEvtAsignacion->dniPersonaPresenta=$request->input('txtDniPersonaPresenta');
				//$tOTDEvtAsignacion->observacion='';
				$tOTDEvtAsignacion->procedencia=$request->input('txtProcedencia');
				$tOTDEvtAsignacion->fechaEntrega=$request->input('txtEntrega');
				$tOTDEvtAsignacion->fechaEntregaCmte=$request->input('txtEntregaCmte');
				$tOTDEvtAsignacion->observacion=$request->input('txtObservacion');

				$tOTDEvtAsignacion->activo=true;
				$tOTDEvtAsignacion->estado='Revisado';

				$tOTDEvtAsignacion->save();

				foreach($request->input('txtNombreAdjunto') as $key => $value)
				{
					if(trim($value)=='')
					{
						continue;
					}

					$tDocumentoTemp=new TDocumento();

					$codigoDocumentoTemp=uniqid();

					$tDocumentoTemp->codigoDocumento=$codigoDocumentoTemp;
					$tDocumentoTemp->nombre=trim($value);
					$tDocumentoTemp->folio=$request->input('txtFolioAdjunto')[$key];
					$tDocumentoTemp->tipo=$request->input('selectTipoAdjunto')[$key];

					$fileGetClientOriginalExtension=strtolower($request->file('fileArchivoAdjunto')[$key]->getClientOriginalExtension());

					$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/adjunto/'.$codigoDocumentoTemp.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivoAdjunto')[$key]->getRealPath()));

					$tDocumentoTemp->extension=$fileGetClientOriginalExtension;

					$tDocumentoTemp->save();

					$tOTDEvtArchivo=new TOTDEvtArchivo();

					$tOTDEvtArchivo->codigoOTDEvtArchivo=uniqid();
					$tOTDEvtArchivo->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
					$tOTDEvtArchivo->codigoDocumento=$codigoDocumentoTemp;

					$tOTDEvtArchivo->save();
				}

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'otdevtasignacion/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$listaTOficina=TOficina::all();

		return view('otdevtasignacion/insertar', ['listaTOficina' => $listaTOficina]);
	}

	public function actionFechas(Request $request, SessionManager $sessionManager, FileSystem $fileSystem)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$codigoOTDEvtAsignacion=uniqid();

				$tDocumento=new TDocumento();

				$codigoDocumento=uniqid();

				$tDocumento->codigoDocumento=$codigoDocumento;
				$tDocumento->nombre=trim($request->input('txtNombre'));
				$tDocumento->folio=$request->input('txtFolio');
				$tDocumento->tipo=$request->input('selectTipo');

				$fileGetClientOriginalExtension=strtolower($request->file('fileArchivo')->getClientOriginalExtension());

				$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/'.$codigoDocumento.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivo')->getRealPath()));

				$tDocumento->extension=$fileGetClientOriginalExtension;

				$tDocumento->save();

				$tOTDEvtAsignacion=new TOTDEvtAsignacion();

				$tOTDEvtAsignacion->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
				$tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre=null;
				$tOTDEvtAsignacion->codigoDocumento=$codigoDocumento;
				$tOTDEvtAsignacion->codigoOficina=$request->has('selectCodigoOficina') ? $request->input('selectCodigoOficina') : $sessionManager->get('codigoOficina');
				$tOTDEvtAsignacion->codigoUsuario=$sessionManager->get('codigoUsuario');
				$tOTDEvtAsignacion->nombreCompletoPersonaPresenta=trim($request->input('txtNombreCompletoPersonaPresenta'));
				$tOTDEvtAsignacion->dniPersonaPresenta=$request->input('txtDniPersonaPresenta');
				//$tOTDEvtAsignacion->observacion='';
				$tOTDEvtAsignacion->procedencia=$request->input('txtProcedencia');
				$tOTDEvtAsignacion->fechaEntrega=$request->input('txtEntrega');
				$tOTDEvtAsignacion->fechaEntregaCmte=$request->input('txtEntregaCmte');
				$tOTDEvtAsignacion->observacion=$request->input('txtObservacion');

				$tOTDEvtAsignacion->activo=true;
				$tOTDEvtAsignacion->estado='Revisado';

				$tOTDEvtAsignacion->save();

				foreach($request->input('txtNombreAdjunto') as $key => $value)
				{
					if(trim($value)=='')
					{
						continue;
					}

					$tDocumentoTemp=new TDocumento();

					$codigoDocumentoTemp=uniqid();

					$tDocumentoTemp->codigoDocumento=$codigoDocumentoTemp;
					$tDocumentoTemp->nombre=trim($value);
					$tDocumentoTemp->folio=$request->input('txtFolioAdjunto')[$key];
					$tDocumentoTemp->tipo=$request->input('selectTipoAdjunto')[$key];

					$fileGetClientOriginalExtension=strtolower($request->file('fileArchivoAdjunto')[$key]->getClientOriginalExtension());

					$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/adjunto/'.$codigoDocumentoTemp.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivoAdjunto')[$key]->getRealPath()));

					$tDocumentoTemp->extension=$fileGetClientOriginalExtension;

					$tDocumentoTemp->save();

					$tOTDEvtArchivo=new TOTDEvtArchivo();

					$tOTDEvtArchivo->codigoOTDEvtArchivo=uniqid();
					$tOTDEvtArchivo->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
					$tOTDEvtArchivo->codigoDocumento=$codigoDocumentoTemp;

					$tOTDEvtArchivo->save();
				}

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'otdevtasignacion/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$listaTOficina=TOficina::all();

		return view('otdevtasignacion/insertar', ['listaTOficina' => $listaTOficina]);
	}

	public function actionVer(SessionManager $sessionManager)
	{

		
		$listaTOTDEvtAsignacion=TOTDEvtAsignacion::with(['tdocumento', 'totdevtasignacionrecursive.tdocumento'])->whereRaw('codigoOficina=? and estado!=?', [$sessionManager->get('codigoOficina'), 'Cerrado'])->OrderBy('created_at', 'desc')->get();
		
		
		return view('otdevtasignacion/ver', ['listaTOTDEvtAsignacion' => $listaTOTDEvtAsignacion]);
	}

	public function actionCambiarEstado( $codigoOTDEvtAsignacion, $estado)
	{
		$arrayEstado=['Por revisar', 'Revisado', 'Derivado', 'Atendido'];

		if(!in_array($estado, $arrayEstado))
		{
			return $this->plataformHelper->redirectError('Estado incorrecto. Por favor no trate de alterar el comportamiento del sistema.', 'otdevtasignacion/ver');
		}

		$tOTDEvtAsignacion=TOTDEvtAsignacion::find($codigoOTDEvtAsignacion);

		if($tOTDEvtAsignacion->estado!='Por revisar')
		{
			return $this->plataformHelper->redirectError('No se puede realizar esta operación porque el documento ya fue derivado.', 'otdevtasignacion/ver');
		}

		$tOTDEvtAsignacion->estado=$estado;

		$tOTDEvtAsignacion->save();

		return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'otdevtasignacion/ver');
	}

	public function actionDerivar(Request $request, SessionManager $sessionManager, FileSystem $fileSystem)
	{
		if($request->has('hdCodigoOTDEvtAsignacion'))
		{
			try
			{
				DB::beginTransaction();

				$tOTDEvtAsignacion=TOTDEvtAsignacion::find($request->input('hdCodigoOTDEvtAsignacion'));

				if($tOTDEvtAsignacion->estado!='Revisado')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError('Sólo se pueden derivar documentos revisados.', 'otdevtasignacion/ver');
				}

				$codigoOTDEvtAsignacion=uniqid();
				$codigoDocumento=null;

				if($request->input('cbDerivarNuevoDocumento')!='')
				{
					$tDocumento=new TDocumento();

					$codigoDocumento=uniqid();

					$tDocumento->codigoDocumento=$codigoDocumento;
					$tDocumento->nombre=trim($request->input('txtNombre'));
					$tDocumento->folio=$request->input('txtFolio');
					$tDocumento->tipo=$request->input('selectTipo');

					$fileGetClientOriginalExtension=strtolower($request->file('fileArchivo')->getClientOriginalExtension());

					$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/'.$codigoDocumento.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivo')->getRealPath()));

					$tDocumento->extension=$fileGetClientOriginalExtension;

					$tDocumento->save();
				}

				$tOTDEvtAsignacion->estado='Derivado';

				do
				{
					$tOTDEvtAsignacion->activo=false;

					$tOTDEvtAsignacion->save();

					$tOTDEvtAsignacion=$tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre!=null ? TOTDEvtAsignacion::find($tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre) : null;
				}
				while($tOTDEvtAsignacion!=null);

				$tOTDEvtAsignacion=new TOTDEvtAsignacion();
			
				$tOTDEvtAsignacion->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
				$tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre=$request->input('hdCodigoOTDEvtAsignacion');
				$tOTDEvtAsignacion->codigoDocumento=$codigoDocumento;
				$tOTDEvtAsignacion->codigoOficina=$request->input('selectCodigoOficina');
				$tOTDEvtAsignacion->codigoUsuario=$sessionManager->get('codigoUsuario');
				$tOTDEvtAsignacion->nombreCompletoPersonaPresenta=trim($request->input('txtNombreCompletoPersonaPresenta'));
				$tOTDEvtAsignacion->dniPersonaPresenta=$request->input('txtDniPersonaPresenta');
				//$tOTDEvtAsignacion->observacion='';
				$tOTDEvtAsignacion->procedencia=$request->input('txtProcedencia');
				$tOTDEvtAsignacion->fechaEntrega=$request->input('txtEntrega');
				$tOTDEvtAsignacion->fechaEntregaCmte=$request->input('txtEntregaCmte');
				$tOTDEvtAsignacion->observacion=$request->input('txtObservacion');

				$tOTDEvtAsignacion->activo=true;
				$tOTDEvtAsignacion->estado='Por revisar';

				$tOTDEvtAsignacion->save();

				if($request->input('cbDerivarNuevoDocumento')!='')
				{
					foreach($request->input('txtNombreAdjunto') as $key => $value)
					{
						if(trim($value)=='')
						{
							continue;
						}

						$tDocumentoTemp=new TDocumento();

						$codigoDocumentoTemp=uniqid();

						$tDocumentoTemp->codigoDocumento=$codigoDocumentoTemp;
						$tDocumentoTemp->nombre=trim($value);
						$tDocumentoTemp->folio=$request->input('txtFolioAdjunto')[$key];
						$tDocumentoTemp->tipo=$request->input('selectTipoAdjunto')[$key];

						$fileGetClientOriginalExtension=strtolower($request->file('fileArchivoAdjunto')[$key]->getClientOriginalExtension());

						$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/adjunto/'.$codigoDocumentoTemp.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivoAdjunto')[$key]->getRealPath()));

						$tDocumentoTemp->extension=$fileGetClientOriginalExtension;

						$tDocumentoTemp->save();

						$tOTDEvtArchivo=new TOTDEvtArchivo();

						$tOTDEvtArchivo->codigoOTDEvtArchivo=uniqid();
						$tOTDEvtArchivo->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
						$tOTDEvtArchivo->codigoDocumento=$codigoDocumentoTemp;

						$tOTDEvtArchivo->save();
					}
				}

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'otdevtasignacion/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

			
				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$listaTOficina=TOficina::all();

		$tOTDEvtAsignacion=TOTDEvtAsignacion::find($request->input('codigoOTDEvtAsignacion'));

		return view('otdevtasignacion/derivar', ['listaTOficina' => $listaTOficina, 'tOTDEvtAsignacion' => $tOTDEvtAsignacion]);
	}

	public function actionAtender(Request $request, SessionManager $sessionManager, FileSystem $fileSystem)
	{
		if($request->has('hdCodigoOTDEvtAsignacion'))
		{
			try
			{
				DB::beginTransaction();

				$tOTDEvtAsignacion=TOTDEvtAsignacion::find($request->input('hdCodigoOTDEvtAsignacion'));

				if($tOTDEvtAsignacion->estado!='Revisado')
				{
					DB::rollBack();

					return $this->plataformHelper->redirectError('Sólo se pueden atender (Cerrar) documentos revisados.', 'otdevtasignacion/ver');
				}

				$codigoOTDEvtAsignacion=uniqid();
				$codigoDocumento=null;

				if($request->input('cbAtenderNuevoDocumento')!='')
				{
					$tDocumento=new TDocumento();

					$codigoDocumento=uniqid();

					$tDocumento->codigoDocumento=$codigoDocumento;
					$tDocumento->nombre=trim($request->input('txtNombre'));
					$tDocumento->folio=$request->input('txtFolio');
					$tDocumento->tipo=$request->input('selectTipo');

					$fileGetClientOriginalExtension=strtolower($request->file('fileArchivo')->getClientOriginalExtension());

					$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/'.$codigoDocumento.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivo')->getRealPath()));

					$tDocumento->extension=$fileGetClientOriginalExtension;

					$tDocumento->save();
				}

				$tOTDEvtAsignacion->estado='Cerrado';

				do
				{
					$tOTDEvtAsignacion->activo=false;

					$tOTDEvtAsignacion->save();

					$tOTDEvtAsignacion=$tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre!=null ? TOTDEvtAsignacion::find($tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre) : null;
				}
				while($tOTDEvtAsignacion!=null);

				$tOTDEvtAsignacion=new TOTDEvtAsignacion();

				$tOTDEvtAsignacion->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
				$tOTDEvtAsignacion->codigoOTDEvtAsignacionPadre=$request->input('hdCodigoOTDEvtAsignacion');
				$tOTDEvtAsignacion->codigoDocumento=$codigoDocumento;
				$tOTDEvtAsignacion->codigoOficina=$sessionManager->get('codigoOficina');
				$tOTDEvtAsignacion->codigoUsuario=$sessionManager->get('codigoUsuario');
				$tOTDEvtAsignacion->nombreCompletoPersonaPresenta=trim($request->input('txtNombreCompletoPersonaPresenta'));
				$tOTDEvtAsignacion->dniPersonaPresenta=$request->input('txtDniPersonaPresenta');
				//$tOTDEvtAsignacion->observacion='';
				$tOTDEvtAsignacion->procedencia=$request->input('txtProcedencia');
				$tOTDEvtAsignacion->fechaEntrega=$request->input('txtEntrega');
				$tOTDEvtAsignacion->fechaEntregaCmte=$request->input('txtEntregaCmte');
				$tOTDEvtAsignacion->observacion=$request->input('txtObservacion');
				
				$tOTDEvtAsignacion->activo=true;
				$tOTDEvtAsignacion->estado='Atendido';

				$tOTDEvtAsignacion->save();

				if($request->input('cbAtenderNuevoDocumento')!='')
				{
					foreach($request->input('txtNombreAdjunto') as $key => $value)
					{
						if(trim($value)=='')
						{
							continue;
						}

						$tDocumentoTemp=new TDocumento();

						$codigoDocumentoTemp=uniqid();

						$tDocumentoTemp->codigoDocumento=$codigoDocumentoTemp;
						$tDocumentoTemp->nombre=trim($value);
						$tDocumentoTemp->folio=$request->input('txtFolioAdjunto')[$key];
						$tDocumentoTemp->tipo=$request->input('selectTipoAdjunto')[$key];

						$fileGetClientOriginalExtension=strtolower($request->file('fileArchivoAdjunto')[$key]->getClientOriginalExtension());

						$fileSystem->put('documento/'.$codigoOTDEvtAsignacion.'/adjunto/'.$codigoDocumentoTemp.'.'.$fileGetClientOriginalExtension, file_get_contents($request->file('fileArchivoAdjunto')[$key]->getRealPath()));

						$tDocumentoTemp->extension=$fileGetClientOriginalExtension;

						$tDocumentoTemp->save();

						$tOTDEvtArchivo=new TOTDEvtArchivo();

						$tOTDEvtArchivo->codigoOTDEvtArchivo=uniqid();
						$tOTDEvtArchivo->codigoOTDEvtAsignacion=$codigoOTDEvtAsignacion;
						$tOTDEvtArchivo->codigoDocumento=$codigoDocumentoTemp;

						$tOTDEvtArchivo->save();
					}
				}

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'otdevtasignacion/ver');
			}
			catch(\Exception $e)
			{
				DB::rollback();

				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$listaTOficina=TOficina::all();

		$tOTDEvtAsignacion=TOTDEvtAsignacion::find($request->input('codigoOTDEvtAsignacion'));

		return view('otdevtasignacion/atender', ['listaTOficina' => $listaTOficina, 'tOTDEvtAsignacion' => $tOTDEvtAsignacion]);
	}

	public function actionRastrear(Request $request)
	{
		$tOTDEvtAsignacion=TOTDEvtAsignacion::with(['toficina', 'totdevtasignacionrecursivechild.toficina'])->whereRaw('codigoOTDEvtAsignacion=?', [$request->input('codigoOTDEvtAsignacion')])->first();

		return view('otdevtasignacion/rastrear', ['tOTDEvtAsignacion' => $tOTDEvtAsignacion]);
	}

	private function deleteDir($dirPath)
	{
		if(!is_dir($dirPath))
		{
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if(substr($dirPath, strlen($dirPath) - 1, 1) != '/')
		{
			$dirPath .= '/';
		}

		$files=glob($dirPath . '*', GLOB_MARK);

		foreach($files as $file)
		{
			if(is_dir($file))
			{
				self::deleteDir($file);
			}
			else
			{
				unlink($file);
			}
		}

		rmdir($dirPath);
	}

	private function addFileRecursive($item, $nivel, $carpetaRaiz, $zip)
	{
		if($item->tdocumento==null)
		{
			$this->addFileRecursive($item->totdevtasignacionrecursive, $nivel, $carpetaRaiz, $zip);

			return;
		}

		$rutaContenedor=storage_path().'/app/documento/'.$item->codigoOTDEvtAsignacion;

	    $zip->addFile($rutaContenedor.'/'.$item->tdocumento->codigoDocumento.'.'.$item->tdocumento->extension, $carpetaRaiz.'/'.str_repeat('Documentos anteriores/', $nivel).$item->tdocumento->nombre.'.'.$item->tdocumento->extension);

		if(count($item->totdevtarchivo)>0)
		{
			foreach($item->totdevtarchivo as $value)
			{
				$zip->addFile($rutaContenedor.'/adjunto/'.$value->tdocumento->codigoDocumento.'.'.$value->tdocumento->extension, $carpetaRaiz.'/'.str_repeat('Documentos anteriores/', $nivel).'Archivos adjuntos/'.$value->tdocumento->nombre.'.'.$value->tdocumento->extension);
			}
		}

	    if($item->totdevtasignacionrecursive!=null)
	    {
	    	$nivel++;

	    	$this->addFileRecursive($item->totdevtasignacionrecursive, $nivel, $carpetaRaiz, $zip);
	    }
	}

	public function actionDescargarArchivos(ResponseFactory $responseFactory, $codigoOTDEvtAsignacion)
	{
		$tOTDEvtAsignacion=TOTDEvtAsignacion::with(['tdocumento', 'totdevtarchivo.tdocumento', 'totdevtasignacionrecursive.tdocumento', 'totdevtasignacionrecursive.totdevtarchivo', 'totdevtasignacionrecursivechild.tdocumento', 'totdevtasignacionrecursivechild.totdevtarchivo'])->whereRaw('codigoOTDEvtAsignacion=?', [$codigoOTDEvtAsignacion])->first();

		$temp=$tOTDEvtAsignacion;

		while($temp->tdocumento==null)
		{
			$temp=$temp->totdevtasignacionrecursive;
		}

		$rutaZipTemp=public_path().'/temp/'.$temp->tdocumento->nombre.'.zip';

		$this->deleteDir(public_path().'/temp');

		mkdir(public_path().'/temp');

	    $zip=new ZipArchive();
	    
	    $zip->open($rutaZipTemp, ZipArchive::CREATE);

	    $this->addFileRecursive($tOTDEvtAsignacion, 0, $temp->tdocumento->nombre, $zip);

	    if(count($tOTDEvtAsignacion->totdevtasignacionrecursivechild)>0)
	    {
	    	foreach($tOTDEvtAsignacion->totdevtasignacionrecursivechild as $value)
	    	{
	    		if($value->tdocumento!=null)
	    		{
	    			$rutaContenedor=storage_path().'/app/documento/'.$value->codigoOTDEvtAsignacion;

	    			$zip->addFile($rutaContenedor.'/'.$value->tdocumento->codigoDocumento.'.'.$value->tdocumento->extension, $temp->tdocumento->nombre.'/Documento emitido/'.$value->tdocumento->nombre.'.'.$value->tdocumento->extension);
	    		}

	    		if(count($value->totdevtarchivo)>0)
				{
					foreach($value->totdevtarchivo as $item)
					{
						$zip->addFile($rutaContenedor.'/adjunto/'.$item->tdocumento->codigoDocumento.'.'.$item->tdocumento->extension, $temp->tdocumento->nombre.'/Documento emitido/Archivos adjuntos/'.$item->tdocumento->nombre.'.'.$item->tdocumento->extension);
					}
				}
	    	}
	    }

	    $zip->close();
			//ZipArchive::close();
			//echo "$rutaZipTemp";		
			if (file_exists($rutaZipTemp)) {
				return $responseFactory->download($rutaZipTemp);
			} else {
				
				//echo "El fichero $rutaZipTemp no existe";
				//echo " No existe tal documento FALLA DE LA SRA MONICA";
				//return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'otdevtasignacion/ver');
				
					DB::rollBack();

					return $this->plataformHelper->redirectError('No existe tal Documento!!!! Por mala escritura en el Nombre del Documento. FALLA DE LA SRA MONICA.', 'otdevtasignacion/ver');
			
			}
	    	//return $responseFactory->download($rutaZipTemp);



	}
}
?>

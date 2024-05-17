<?php

namespace App\Http\Controllers;

use App\Model\Registro;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Session\SessionManager;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Filesystem\Factory as FileSystem;
use Illuminate\Support\Facades\Input;
use ZipArchive;
use DB;
use Response ;
use File;
class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
          $registros = Registro::all()->where('estado', "Habilitado")          ;
          return view('registro/listar', compact('registros'));
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actionInsertar(Request $request, SessionManager $sessionManager, FileSystem $fileSystem)
    {
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$codigoOTDEvtAsignacion=uniqid();

				$Registro=new Registro();

				$Registro->nroDoc=$request->input('inpnroDoc');
            //  $Registro->nroDocPadre=null;
                $Registro->fechaEntregaCmte= trim($request->input('indfechaEntregaCmte'));
                $Registro->fechaEntrega=trim($request->input('indfechaEntrega'));
                $Registro->procedenciaDoc=trim($request->input('inpprocedenciaDoc'));
                $Registro->numeroDoc=trim($request->input('inpnumeroDoc'));
                $Registro->objetoDoc=trim($request->input('inpobjetoDoc'));
                //$tOTDEvtAsignacion->observacion='';
                //  $Registro->tipoDoc=trim($request->input('selectTipo'));
                $Registro->observacionesDoc=trim($request->input('txtObservacion'));
                
                //$Registro->archivo=trim($request->input('fileArchivo'));
                if (Input::hasFile('fileArchivo')) {
                    $liFile=Input::file('fileArchivo');
                    $liFile->move(public_path(). '/documento/registro/',$liFile->getClientOriginalName());
                    $Registro->archivo=$liFile->getClientOriginalName();
                }
            //  $Registro->activo=true;
                $Registro->estado='Habilitado';
                
                $lcTipoDoc = explode('.',$Registro->archivo);
                $TipoDocArray = array('docx'=>'Solicitud', 'pdf'=>'Informe');
                $TipoDoc = $TipoDocArray[end($lcTipoDoc)];
                $Registro->tipoDoc=trim($TipoDoc);
                
				$Registro->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'registro/listar');
			}
			catch(\Exception $e)
			{
				DB::rollback();
                return 'Mensaje: '.$e->getMessage().' Linea: '.$e->getLine();
				return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}


		return view('registro/create');
	}

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nroDoc' => 'required',
            'fechaEntregaCmte' => 'required',
            'fechaEntrega' => 'required',
            'procedenciaDoc' => 'required',
            'numeroDoc' => 'required',
            'objetoDoc' => 'required',
            'tipoDoc' => 'required',
            'observacionesDoc' => 'required',
            
        ]);

        Registro::create($request->all());
        return redirect()->route('registro/listar');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actionEditar(Request $request, SessionManager $sessionManager)
    {
        if($request->has('inpnroDoc'))
		{
			try
			{
				DB::beginTransaction();

				$tRegistro=Registro::whereRaw('nroDoc=?', [$request->input('hdCodigoRegistro')])->first();
                
				if(strpos($sessionManager->get('rol'), 'Administrador')===false && strpos($sessionManager->get('rol'), 'Súper usuario')===false && !($this->plataformHelper->verificarExistenciaAutorizacion($tRegistro, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut)))
				{
					return $this->plataformHelper->redirectError($mensajeOut, 'registro/listar');
				}

				//$this->mensajeGlobal=(new UsuarioValidation())->validationEditar($request);

				if($this->mensajeGlobal!='')
				{
				    return "OK";
					DB::rollBack();

					return $this->plataformHelper->redirectError($this->mensajeGlobal, 'registro/listar');
				}
				$tRegistro->nroDoc=$request->input('inpnroDoc');
            //  $Registro->nroDocPadre=null;
                $tRegistro->fechaEntregaCmte= trim($request->input('indfechaEntregaCmte'));
                $tRegistro->fechaEntrega=trim($request->input('indfechaEntrega'));
                $tRegistro->procedenciaDoc=trim($request->input('inpprocedenciaDoc'));
                $tRegistro->numeroDoc=trim($request->input('inpnumeroDoc'));
                $tRegistro->objetoDoc=trim($request->input('inpobjetoDoc'));
                //$tOTDEvtAsignacion->observacion='';
                $tRegistro->tipoDoc=trim($request->input('selectTipo'));
                $tRegistro->observacionesDoc=trim($request->input('txtObservacion'));
                
              //  $tRegistro->archivo=trim($request->input('fileArchivo'));
                $lcArchivo=trim($request->input('fileArchivo1'));

                if (Input::hasFile('fileArchivo')) {
                    $liFile=Input::file('fileArchivo');
                    File::delete(public_path('img/registro/'.$lcArchivo));
                    $liFile->move(public_path(). '/img/registro/',$liFile->getClientOriginalName());
                    $tRegistro->archivo=$liFile->getClientOriginalName();
                }
                $lcTipoDoc = explode('.',$tRegistro->archivo);
                $TipoDocArray = array('docx'=>'Solicitud', 'pdf'=>'Informe');
                $TipoDoc = $TipoDocArray[end($lcTipoDoc)];
                $tRegistro->tipoDoc=trim($TipoDoc);

				$tRegistro->save();

				DB::commit();

				return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'registro/listar');
			}
			catch(\Exception $e)
			{
			    return 'Mensaje: '.$e->getMessage().' Linea: '.$e->getLine();
				DB::rollback();

			//	return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}
        
		$tRegistro=Registro::whereRaw('nroDoc=?', [$request->input('CodigoRegistro')])->first();
		
		if(strpos($sessionManager->get('rol'), 'Administrador')===false && strpos($sessionManager->get('rol'), 'Súper usuario')===false && !($this->plataformHelper->verificarExistenciaAutorizacion($tRegistro, 'CodigoRegistro', $sessionManager->get('CodigoRegistro'), $mensajeOut)))
		{
			return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
		}
		return view('registro/edit', ['tRegistro' => $tRegistro]);
     //   return view('registro/edit', compact('registros'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registro $registro)
    {
        $request->validate([
            'nroDoc' => 'required',
            'fechaEntregaCmte' => 'required',
            'fechaEntrega' => 'required',
            'procedenciaDoc' => 'required',
            'numeroDoc' => 'required',
            'objetoDoc' => 'required',
            'tipoDoc' => 'required',
            'observacionesDoc' => 'required',
        ]);
        $registro->update($request->all());
        return redirect()->route('registro/listar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registro $registro)
    {
        $registro->delete();
        return redirect()->route('registro/listar');

    }


    public function actionCambiarEstado( $registros, $estado)
	{

     
		$arrayEstado=['Habilitado', 'Desabilitado', 'Derivado', 'Atendido'];

		if(!in_array($estado, $arrayEstado))
		{
			return $this->plataformHelper->redirectError('Estado incorrecto. Por favor no trate de alterar el comportamiento del sistema.', '/registro/listar');
		}
        

        $Registros = Registro::find($registros);


		$Registros->estado="$estado";

		$Registros->save();

		return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', '/registro/listar');
    
	}


    public function reporteIndividualdocumento( )
	 {
		//$valor=$iddocumento ;
        $datos = Registro::all()->where('estado', "Habilitado")          ;
 
		$titulo = "Registro";
		
       
       
	 
		  $pdf = PDF::loadView('reporte.reporteGralregistro', compact('titulo','datos'));
          
		 return $pdf->setPaper(array(0,0,612.00,792.00), 'letter', 'landscape')->stream('listado.pdf'); 
		 
	 }

     public function actionDescargarArchivos(ResponseFactory $responseFactory, $registro)
	{
		//$tOTDEvtAsignacion=TOTDEvtAsignacion::with(['tdocumento', 'totdevtarchivo.tdocumento', 'totdevtasignacionrecursive.tdocumento', 'totdevtasignacionrecursive.totdevtarchivo', 'totdevtasignacionrecursivechild.tdocumento', 'totdevtasignacionrecursivechild.totdevtarchivo'])->whereRaw('codigoOTDEvtAsignacion=?', [$codigoOTDEvtAsignacion])->first();
        $registros = Registro::all()->where('nroDoc', $registro)  ;
		$temp=$registros;
        
        foreach ($temp as $key => $value) {
           
            //header('Content-Type', 'application/pdf');

            $rutaZipTemp=public_path().'/documento/registro/'.$value->archivo;
            //echo   $rutaZipTemp ;

            return Response::make(file_get_contents($rutaZipTemp), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$value->archivo.'"'
               ]);


        }
       

	//	$rutaZipTemp=public_path().'/documento/registro/'.$temp->archivo;
        return  1 ; // response()->download($rutaZipTemp);


	}


}

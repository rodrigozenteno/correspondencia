<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use DB;
use Barryvdh\DomPDF\Facade as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PhpOffice\PhpWord\TemplateProcessor;
class GeneralController extends Controller


{
	public function actionIndex()
	{
		// aqui viene los datos de usuario 
		$totalUsuario = count( DB::table('tusuario')->get() );
		$totalOficina = count( DB::table('toficina')->get() );
		$totalDocumentos = count( DB::table('totdevtasignacion')->where("estado","Derivado" )->get() );
		$totalDocumentosAtendidos = count( DB::table('totdevtasignacion')->where("estado","Atendido" )->get() );
		$totalDocumentosRegistrados = count( DB::table('totdevtasignacion')->get() );
		$totalDocumentosPendientes = count( DB::table('totdevtasignacion')->where("estado","Revisado" )->get() );
		$fechaactual=date("Y-m-d");
		$totalDocumentosFplazo = count( DB::table('totdevtasignacion')->where("fechaEntregaCmte","<=",	$fechaactual )->get() );
		$totalDocumentosCplazo = count( DB::table('totdevtasignacion')->where("fechaEntregaCmte",">=",	$fechaactual )->get() );
		return view('general/index', compact('totalUsuario', 'totalOficina', 'totalDocumentos', 'totalDocumentosAtendidos', 'totalDocumentosRegistrados', 'totalDocumentosPendientes', 'totalDocumentosFplazo', 'totalDocumentosCplazo'));
	}
	public function reporteGralFecha()
	{
		return view('reporte/reporteFecha'); //vista
	}

	public function reporteGral( Request $request, SessionManager $sessionManager)
	{

		$fechainicial=$request->input('txtInicio');
		$fechafinal=$request->input('txtFinal');
		$codigooficina=$sessionManager->get('codigoOficina');
		$lcSql="SELECT
		doc.codigoDocumento as codigodocumento,
		doc.tipo as tipo,
		asig.codigoOTDEvtAsignacion codigoasignacion,
		asig.codigoOTDEvtAsignacionPadre ,
		asig.dniPersonaPresenta as numero,
        ofi.nombre as nombreoficina,
		asig.fechaEntrega as fechaentrega,
		asig.fechaEntregaCmte as fechaentregacmte,
		asig.observacion as observaciones,
		asig.procedencia as procedencia,
		 IF (
		 ISNULL( doc.nombre ),
		(SELECT 	td3.nombre FROM	tdocumento AS td3 WHERE	td3.codigoDocumento =  (SELECT MAX(asig2.codigoDocumento) FROM totdevtasignacion AS asig2 WHERE asig2.dniPersonaPresenta = asig.dniPersonaPresenta AND asig2.codigoDocumento IS NOT NULL )  
		),
		doc.nombre 
		 )AS nombredocumento,
		
		 IF (
		 ISNULL( doc.folio ),
		(SELECT 	td3.folio FROM	tdocumento AS td3 WHERE	td3.codigoDocumento =  (SELECT MAX(asig2.codigoDocumento) FROM totdevtasignacion AS asig2 WHERE asig2.dniPersonaPresenta = asig.dniPersonaPresenta AND asig2.codigoDocumento IS NOT NULL )
		),
		doc.folio
		 )AS hojas,

		 IF (
		 ISNULL( doc.tipo ),
		(SELECT 	td3.tipo FROM	tdocumento AS td3 WHERE	td3.codigoDocumento =  (SELECT MAX(asig2.codigoDocumento) FROM totdevtasignacion AS asig2 WHERE asig2.dniPersonaPresenta =asig.dniPersonaPresenta AND asig2.codigoDocumento IS NOT NULL )
		),
		doc.tipo
		 )AS tipo,

		asig.estado AS estadoasignacion,
		usu.rol AS gradoremitente,
		(
	SELECT
		usu3.rol 
	FROM
		tusuario AS usu3 
	WHERE
		usu3.codigoUsuario = ( SELECT asig2.codigoUsuario FROM totdevtasignacion AS asig2 WHERE asig2.codigoOTDEvtAsignacionPadre = asig.codigoOTDEvtAsignacion ) 
		) gradoconsignatario,
		usu.grado as grado, usu.nombre as nombre, usu.apellido AS nombreremitente,
		(
	SELECT
		usu3.nombre 
	FROM
		tusuario AS usu3 
	WHERE
		usu3.codigoUsuario = ( SELECT asig2.codigoUsuario FROM totdevtasignacion AS asig2 WHERE asig2.codigoOTDEvtAsignacionPadre = asig.codigoOTDEvtAsignacion ) 
		) AS nombreconsignatario,
		asig.nombreCompletoPersonaPresenta AS DatosComplementarios ,
	asig.created_at as fecha
	FROM
		totdevtasignacion asig
		LEFT JOIN tdocumento AS doc ON asig.codigoDocumento = doc.codigoDocumento
		LEFT JOIN tusuario AS usu ON asig.codigoUsuario = usu.codigoUsuario
        LEFT JOIN toficina AS ofi ON asig.codigoOficina = ofi.codigoOficina
	WHERE
	asig.created_at BETWEEN   '$fechainicial' and '$fechafinal'
	and asig.codigoOficina = '$codigooficina'
		ORDER BY asig.created_at asc";
		//return view('/reporte/reporteGral2');
		$datos=DB::select($lcSql);
		//print_r ($datos);
   	    $titulo = "mireporte";
        $pdf = PDF::loadView('reporte.reporteGral2', compact('titulo','datos'));
		return $pdf->setPaper(array(0,0,612.00,792.00), 'letter')->stream('listado.pdf');
		//return view('reporte.reporteGral2');
	}

	 public function printpdf($isbn)
	 {
		$data = [
		   'isbn' => $isbn
			 ];
 
		 $pdf = PDF::loadView('main.inventory.view_pdf ', $data);  
		 return $pdf->stream($isbn.'.pdf');
	 }


	 public function reporteIndividualdocumento( Request $request)
	 {
		//$valor=$iddocumento ;
		$iddocumento=$request->input('codigoDocumento');
		
 
		$lcSql="SELECT
		doc.codigoDocumento as codigodocumento,
		doc.tipo as tipo,
		asig.codigoOTDEvtAsignacion codigoasignacion,
		asig.codigoOTDEvtAsignacionPadre ,
		asig.dniPersonaPresenta as numero,
        ofi.nombre as nombreoficina,
		asig.fechaEntrega as fechaentrega,
		asig.fechaEntregaCmte as fechaentregacmte,
		asig.observacion as observaciones,
		asig.procedencia as procedencia,
		 IF (
		 ISNULL( doc.nombre ),
		(SELECT 	td3.nombre FROM	tdocumento AS td3 WHERE	td3.codigoDocumento =  (SELECT MAX(asig2.codigoDocumento) FROM totdevtasignacion AS asig2 WHERE asig2.dniPersonaPresenta ='$iddocumento' AND asig2.codigoDocumento IS NOT NULL )  
		),
		doc.nombre 
		 )AS nombredocumento,
		
		 IF (
		 ISNULL( doc.folio ),
		(SELECT 	td3.folio FROM	tdocumento AS td3 WHERE	td3.codigoDocumento =  (SELECT MAX(asig2.codigoDocumento) FROM totdevtasignacion AS asig2 WHERE asig2.dniPersonaPresenta ='$iddocumento' AND asig2.codigoDocumento IS NOT NULL )
		),
		doc.folio
		 )AS hojas,

		 IF (
		 ISNULL( doc.tipo ),
		(SELECT 	td3.tipo FROM	tdocumento AS td3 WHERE	td3.codigoDocumento =  (SELECT MAX(asig2.codigoDocumento) FROM totdevtasignacion AS asig2 WHERE asig2.dniPersonaPresenta ='$iddocumento' AND asig2.codigoDocumento IS NOT NULL )
		),
		doc.tipo
		 )AS tipo,

		asig.estado AS estadoasignacion,
		usu.rol AS gradoremitente,
		(
	SELECT
		usu3.rol 
	FROM
		tusuario AS usu3 
	WHERE
		usu3.codigoUsuario = ( SELECT asig2.codigoUsuario FROM totdevtasignacion AS asig2 WHERE asig2.codigoOTDEvtAsignacionPadre = asig.codigoOTDEvtAsignacion ) 
		) gradoconsignatario,
		usu.grado as grado, usu.nombre as nombre, usu.apellido AS nombreremitente,
		(
	SELECT
		usu3.nombre 
	FROM
		tusuario AS usu3 
	WHERE
		usu3.codigoUsuario = ( SELECT asig2.codigoUsuario FROM totdevtasignacion AS asig2 WHERE asig2.codigoOTDEvtAsignacionPadre = asig.codigoOTDEvtAsignacion ) 
		) AS nombreconsignatario,
		asig.nombreCompletoPersonaPresenta AS DatosComplementarios ,
	asig.created_at as fecha
	FROM
		totdevtasignacion asig
		LEFT JOIN tdocumento AS doc ON asig.codigoDocumento = doc.codigoDocumento
		LEFT JOIN tusuario AS usu ON asig.codigoUsuario = usu.codigoUsuario
        LEFT JOIN toficina AS ofi ON asig.codigoOficina = ofi.codigoOficina
	WHERE
	asig.dniPersonaPresenta='$iddocumento'
	ORDER BY asig.created_at asc";
		$datos=DB::select($lcSql);
		$titulo = "ecem";
		
	 
		  $pdf = PDF::loadView('reporte.reporteGralindividual', compact('titulo','datos'));
		 return $pdf->setPaper(array(0,0,612.00,792.00), 'Letter')->stream('listado.pdf'); 
		 
	 }
 
}
?>
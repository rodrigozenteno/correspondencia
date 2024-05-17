<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TOTDEvtAsignacion extends Model
{
	protected $table='totdevtasignacion';
	protected $primaryKey='codigoOTDEvtAsignacion';
	public $incrementing=false;
	public $timestamps=true;

	public function tUsuario()
	{
		return $this->belongsTo('App\Model\TUsuario', 'codigoUsuario');
	}

	public function tOficina()
	{
		return $this->belongsTo('App\Model\TOficina', 'codigoOficina');
	}

	public function tDocumento()
	{
		return $this->belongsTo('App\Model\TDocumento', 'codigoDocumento');
	}

	public function tOTDEvtAsignacion()
	{
		return $this->belongsTo('App\Model\TOTDEvtAsignacion', 'codigoOTDEvtAsignacionPadre', 'codigoOTDEvtAsignacion');
	}

	public function tOTDEvtAsignacionRecursive()
	{
		return $this->tOTDEvtAsignacion()->with(['tOTDEvtAsignacionRecursive']);
	}

	public function tOTDEvtAsignacionChild()
	{
		return $this->hasMany('App\Model\TOTDEvtAsignacion', 'codigoOTDEvtAsignacionPadre', 'codigoOTDEvtAsignacion');
	}

	public function tOTDEvtAsignacionRecursiveChild()
	{
		return $this->tOTDEvtAsignacionChild()->with(['tOTDEvtAsignacionRecursiveChild']);
	}

	public function tOTDEvtArchivo()
	{
		return $this->hasMany('App\Model\TOTDEvtArchivo', 'codigoOTDEvtAsignacion');
	}
}
?>
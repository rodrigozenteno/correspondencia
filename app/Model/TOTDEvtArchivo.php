<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TOTDEvtArchivo extends Model
{
	protected $table='totdevtarchivo';
	protected $primaryKey='codigoOTDEvtArchivo';
	public $incrementing=false;
	public $timestamps=true;

	public function tDocumento()
	{
		return $this->belongsTo('App\Model\TDocumento', 'codigoDocumento');
	}

	public function tOTDEvtAsignacion()
	{
		return $this->belongsTo('App\Model\TOTDEvtAsignacion', 'codigoOTDEvtAsignacion');
	}
}
?>
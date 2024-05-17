<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TDocumento extends Model
{
	protected $table='tdocumento';
	protected $primaryKey='codigoDocumento';
	public $incrementing=false;
	public $timestamps=true;

	public function tOTDEvtAsignacion()
	{
		return $this->hasMany('App\Model\TOTDEvtAsignacion', 'codigoDocumento');
	}

	public function tOTDEvtArchivo()
	{
		return $this->hasMany('App\Model\TOTDEvtArchivo', 'codigoDocumento');
	}
}
?>
<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table='registro';
	protected $primaryKey='nroDoc';
	public $incrementing=false;
	public $timestamps=false;
	
    protected $fillable = [
    'nroDoc',
    'fechaEntregaCmte',
    'fechaEntrega',
    'procedenciaDoc',
    'numeroDoc',
    'objetoDoc',
    'tipoDoc',
    'observacionesDoc'
                        ];
    protected $guarded=[

    ];
		

    
}

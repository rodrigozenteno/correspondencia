<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Helper\PlataformHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $mensajeGlobal;
    protected $plataformHelper;

    public function __construct()
    {
    	$this->mensajeGlobal='';
    	$this->plataformHelper=new PlataformHelper();
    }
}

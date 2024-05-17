<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use DB;

use App\Model\TEmpresa;
use App\Model\TUsuario;

class GenericMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url=explode('/', $request->url());

        $protocolo=$url[0];
        $dominio=$url[1].$url[2];
        $url=$url[0].'//'.$url[1].$url[2].env('URL_ADICIONAL_FILTRO');


        // if($dominio!='localhost')
        // {
        //     if($protocolo=='https:')
        //     {
        //         return redirect(str_replace('https', 'http', $request->url()));
        //     }
        // }

        $accesoUrl=false;

        $permisosUrl=
        [
            //TGeneral
            ['Súper usuario,Administrador,Usuario general', false, $url, 'liMenuPanelControl', 'liMenuItemPanelControlInicio'],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/general/index', 'liMenuPanelControl', 'liMenuItemPanelControlInicio'],

            //TUsuario
            ['Súper usuario,Administrador', false, $url.'/usuario/insertar', 'liMenuGestionUsuario', 'liMenuItemGestionUsuarioRegistrarUsuario'],
            ['Súper usuario,Administrador,Usuario general,Público', false, $url.'/usuario/login', null, null],
            ['Súper usuario,Administrador,Usuario general,Público', false, $url.'/usuario/logout', null, null],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/usuario/ver', 'liMenuGestionUsuario', 'liMenuItemGestionUsuarioListarUsuarios'],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/usuario/editar', null, null],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/usuario/cambiarcontrasenia', null, null],

            //TOficina
            ['Súper usuario,Administrador', false, $url.'/oficina/insertar', 'liMenuGestionOficinas', 'liMenuItemGestionOficinasRegistrarOficina'],
            ['Súper usuario,Administrador', false, $url.'/oficina/ver', 'liMenuGestionOficinas', 'liMenuItemGestionOficinasListarOficinas'],
            ['Súper usuario,Administrador', false, $url.'/oficina/editar', null, null],

            //registro
            ['Súper usuario,Administrador,Usuario general', false, $url.'/registro/listar', 'liMenuGestionDocumentos', 'liMenuItemGestionDocumentosRegistrarDocumento'],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/registro/insertar', 'liMenuGestionDocumentos', 'liMenuItemGestionDocumentosRegistrarDocumento'],
            //['Súper usuario,Administrador,Usuario general', false, $url.'/registro/editar', null, null],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/registro/edit', 'liMenuGestionDocumentos', 'liMenuItemGestionDocumentosRegistrarDocumento'],
            ['Súper usuario,Administrador,Usuario general', true, $url.'/registro/cambiarestado', null, null],
            ['Súper usuario,Administrador,Usuario general', false, $url. '/registro/reportegeneral', '/registro/reportegeneral', '/registro/reportegeneral'],
            ['Súper usuario,Administrador,Usuario general', true, $url.'/registros/descargararchivos', null, null],
        


            //TOTDEvtAsignacion
            ['Súper usuario,Administrador,Usuario general', false, $url.'/otdevtasignacion/insertar', 'liMenuGestionDocumentos', 'liMenuItemGestionDocumentosRegistrarDocumento'],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/otdevtasignacion/fechas', 'liMenuGestionDocumentos', 'liMenuItemGestionDocumentosRegistrarDocumento'],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/otdevtasignacion/ver', 'liMenuGestionDocumentos', 'liMenuItemGestionDocumentosListarDocumentos'],
            ['Súper usuario,Administrador,Usuario general', true, $url.'/otdevtasignacion/cambiarestado', null, null],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/otdevtasignacion/derivar', null, null],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/otdevtasignacion/atender', null, null],
            ['Súper usuario,Administrador,Usuario general', false, $url.'/otdevtasignacion/rastrear', null, null],
            ['Súper usuario,Administrador,Usuario general', true, $url.'/otdevtasignacion/descargararchivos', null, null],
        
             //TReportes
            ['Súper usuario,Administrador,Usuario general', false, $url.'/reporte/reporteFecha', '/reporte/reporteFecha', '/reporte/reporteFecha'],
            ['Súper usuario,Administrador,Usuario general', false, $url. '/reporte/reporteGral', '/reporte/reporteGral', '/reporte/reporteGral'],
            ['Súper usuario,Administrador,Usuario general', false, $url. '/reporte/reporteindividual', '/reporte/reporteindividual', '/reporte/reporteindividual'],
            ['Súper usuario,Administrador,Usuario general', false, $url.''],
           
        ];

        $miRol=Session::get('rol', 'Público');
        $miRol=$miRol=='' ? 'Público' : $miRol;

       foreach($permisosUrl as $key => $value)
        {
            if($request->url()==$value[2] || ($value[1] && strlen(strpos($request->url(), $value[2]))>0))
            {
                $permisos=explode(',', $value[0]);
                $roles=explode(',', $miRol);

                foreach($permisos as $key2 => $value2)
                {
                    foreach($roles as $item)
                    {
                        if($value2==$item)
                        {
                            $accesoUrl=true;

                            Session::put('menuItemPadreSelected', $value[3]);
                            Session::put('menuItemHijoSelected', $value[4]);

                            break 3;
                        }
                    }
                }
            }
        }

        if(!$accesoUrl)
        {
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) =='xmlhttprequest')
            {
                echo '<div class="alert alert-danger"><h4><i class="icon fa fa-ban"></i> Prohibido!</h4>No tiene autorización para realizar esta operación o su "sesión de usuario" ya ha finalizado.</div>';exit;
            }
            else
            {
                return redirect('/usuario/login');
              echo "askdlaksjdlaksjdlkj";
            }
        }

        return $next($request);
    }
}
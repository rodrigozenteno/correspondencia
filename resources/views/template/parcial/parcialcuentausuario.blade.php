<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="{{asset('plugin/adminlte/dist/img/ecem.png')}}" class="user-image" alt="User Image">
        <span class="hidden-xs">{{Session::get('nombreCompleto', 'Anónimo')}}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <img src="{{asset('plugin/adminlte/dist/img/ecem.png')}}" class="img-circle" alt="User Image">
            <p>
                {{Session::get('nombreCompleto', 'Anónimo')}}
                <small>{{Session::get('rol', 'Acceso público')}}</small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a href="#">Sistema de Seguimiento de Documentación (ECEME.)</a>
                </div>
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                
                <a href="{{url('usuario/ver')}}" class="btn btn-default btn-flat">Usuarios</a>
            </div>
            <div class="pull-right">
                <a href="{{url('usuario/logout')}}" class="btn btn-default btn-flat">Salir</a>
                <!--logout -->
            </div>
        </li>
    </ul>
</li>
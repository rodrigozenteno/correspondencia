<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CORRESPONDENCIA ECEME.</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('plugin/adminlte/dist/css/AdminLTE.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugin/adminlte/plugins/iCheck/square/blue.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="{{asset('js/html5shiv.min.js')}}"></script>
	<script src="{{asset('js/respond.min.js')}}"></script>
	<![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="{{asset('css/googlefont.css')}}">

    <link rel="stylesheet" href="{{asset('plugin/pnotify/pnotify.custom.min.css')}}">

    <!-- jQuery 3 -->
    <script src="{{asset('plugin/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>

    <script src="{{asset('plugin/pnotify/pnotify.custom.min.js')}}"></script>
</head>
<style>
body {
    /* background-color: #ffdd90;
    background-image: url("../public/img/logo1.png"); */
}
</style>

<body class="hold-transition login-page">
    @if(Session::has('mensajeGlobal'))
    <script>
    $(function() {
        @foreach(explode('__SALTOLINEA__', Session::get('mensajeGlobal')) as $value)
        @if(trim($value) != '')
        new PNotify({
            title: '{{Session::get('
            tipo ')=='
            error ' ? '
            No se pudo proceder ' : (Session::get('
            tipo ')=='
            success ' ? '
            Correcto ' : '
            Advertencia ')}}',
            text: '{{$value}}',
            type: '{{Session::get('
            tipo ')}}'
        });
        @endif
        @endforeach
    });
    </script>
    @endif
   
    <div class="login-box">
        <div class="login-logo">
        <!-- <img src="{{asset('plugin/adminlte/dist/img/logo1.png')}}" class="img-circle" alt="User Image"> -->
        <h1  align="center"  > INGRESO AL SISTEMA ECEME. </h1> 
        </div>
        
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Datos de usuario para el acceso al sistema  de Correspondencia</p>
            <form action="{{url('usuario/login')}}" method="post">
                <div class="form-group has-feedback">
                    <input type="text" id="txtCorreoElectronico" name="txtCorreoElectronico" class="form-control"
                        placeholder="Correo electrónico o usuario">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="passContrasenia" name="passContrasenia" class="form-control"
                        placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <select id="selectCodigoOficina" name="selectCodigoOficina" class="select" style="width: 100%;">
                        @foreach($listaTOficina as $value)
                        <option value="{{$value->codigoOficina}}">{{$value->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ingreso al sistema</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('plugin/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('plugin/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
    $(function() {
        $('.select').select2({
            language: {
                noResults: function() {
                    return "No se encontraron resultados.";
                },
                searching: function() {
                    return "Buscando...";
                },
                inputTooShort: function() {
                    return 'Por favor ingrese 3 o más caracteres';
                }
            },
            placeholder: 'Buscar...',
            minimumInputLength: 3
        });
    });
    </script>
</body>

</html>
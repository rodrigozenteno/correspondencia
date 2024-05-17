@extends('template.layoutgeneral')
@section('titulo', 'General')
@section('subTitulo', 'Página principal')
@section('cuerpoGeneral')
<!-- //Cuerpo general de la vista -->


<div class="container-fluid" style="border:2px solid">
  <div class="row" style="margin-top:10px">
    <div class="col-sm-4" style="background-color:lavender;">
      <div class="panel panel-info">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
            Total Usuarios
            <span class="badge pull pull-right">{{ $totalUsuario }}</span>
          </a>
        </div>
      </div>
      <div class="panel panel-success">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
            Total Oficinas 
            <span class="badge pull pull-right">{{ $totalOficina }}</span>
        </div>
      </div>
      <div class="panel panel-warning ">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
            Total Documentos Derivados
            <span class="badge pull pull-right">{{ $totalDocumentos }}</span>
          </a>
        </div>
      </div>
    </div>

    <div class="col-sm-4" style="background-color:lavenderblush;">
      <div class="panel panel-info">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
          Total Documentos Atendidos
          <span class="badge pull pull-right">{{ $totalDocumentosAtendidos }}</span>
          </a>
        </div>
      </div>
      <div class="panel panel-warning">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
          Total Documentos Registrados
          <span class="badge pull pull-right">{{ $totalDocumentosRegistrados }}</span>
          </a>
        </div>
      </div>
     
      <div class="panel panel-success">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
          Total Documentos Pendientes
            <span class="badge pull pull-right">{{$totalDocumentosPendientes}}</span>
          </a>
        </div>
      </div>
    </div>

    <div class="col-sm-4" style="background-color:lavenderblush;">
      <div class="panel panel-danger ">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
            Total Documentos con fuera de plazo
            <span class="badge pull pull-right">{{$totalDocumentosFplazo}}</span>
          </a>
        </div>
      </div>
      <div class="panel panel-default ">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
          Total Documentos con plazo
            <span class="badge pull pull-right">{{$totalDocumentosCplazo}}</span>
          </a>
        </div>
      </div>
      <div class="panel panel-info">
        <div class="panel-heading">
          <a href="#" style="text-decoration:none;color:black;">
            Total
            <span class="badge pull pull-right">{{$totalDocumentosCplazo + $totalDocumentosFplazo}}</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
       



@endsection
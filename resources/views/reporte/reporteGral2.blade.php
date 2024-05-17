
<style type="text/css">
    * {
        font-family: Verdana, Arial(8), sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }

    footer{
      text-align:center;
      
}
@page {
                margin-top: 1cm;
                margin-left: 0cm;
                margin-right: 0cm;
                margin-bottom: 2cm;
	}
  header {
    
                text-align:center;
                position: fixed;
                top: -80px;
                left: 0px;
                right: 0px;
                height: 20px;
       
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 100px; 

                /** Extra personal styles **/
               
                text-align: center;
                line-height: 35px;
            }
</style>


<table width="100%">
      <!-- <tr>
          <td valign="top" ><img src="./img/ecem.png" alt="" width="140px" height="100px"></td>  
          
          <td>  <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate('sistema de control de documentacion 2021')) !!}"></td>
      </tr> -->

    <tr align="center">
        <td >
            <!-- <h4>DEPARTAMENTO IV EDUCACION</h4>
            <h4 style="margin:-3.5% 0;">ESCUELA DE COMANDO Y ESTADO MAYOR</h3>
            <h4 >"MARISCAL ANDRES DE SANTA CRUZ"</h4>
            <h4 style="margin:-1.5% 0;">BOLIVIA</h4> -->
             
                  <h2>REPORTE DE CORRESPONDENCIA DE FECHA <?php $mytime = Carbon\Carbon::now(); echo $mytime->toDateTimeString(); ?></h2>
              
        </td>
    </tr>
   

  </table>
          <header>
    
        
        </header> 
                  
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-condensed" width="100%">
                        <thead class="text-center" style="background-color: lightgray;">
                            <tr>
                                <th class="col-lg-4">NTD <br> Oficina <br> Fecha Derivado <br> </th>
                                <th > Nro. Documento <br> Hojas <br>  Objeto</th> 
                                 <th>  Estado <br> Fecha Req. Doc. <br> Fecha Req. CMTE. </th>
                                <th>Remitente <br> Consignatario <br> Proveido</th>
                                <th>Observaciones <br> Plazo Cumplimiento </th>
                            </tr>
                        </thead>
                          <tbody>
                          @foreach($datos as $dat)

<tr>
  
      <th scope="row">{{ $dat->codigodocumento}} <br> {{ $dat->nombreoficina }} <br> {{ $dat->fecha }}</th>
      
      <td>  {{ $dat->numero }} <br> {{ $dat->hojas }} <br> {{ $dat->nombredocumento }}  </td>

      <td align="center">{{ $dat->estadoasignacion }} <br>{{ $dat->fechaentrega }} <br>  {{ $dat->fechaentregacmte }}</td>
      
      <td align="center">{{ $dat->grado }}{{ $dat->nombre }}{{ $dat->nombreremitente }} <br> {{ $dat->nombreconsignatario }} <br>  {{ $dat->DatosComplementarios }}</td>

      <?php
                         $date1 =new dateTime($dat->fechaentregacmte );
                         $date2= new dateTime( date("Y-m-d") );
                    $valordiferencia = $date1->diff($date2);
                    //echo $valordiferencia ;
                    ?>
                
      <td align="center">{{ $dat->observaciones }} <br> {{   $valordiferencia->days   }} </td>
   

  
</tr>

@endforeach


                            </tbody>
                    </table>
                </div>
            </div>
        </div>
  <footer>
           <!-- Copyright &copy; <?php echo date("Y");?>  -->
        </footer>
  <footer>
      <h4>Cnl. DAEN. Douglas Vladimir Sejas Crespo </h4> 
      <h4  style="margin:-35% 0;"> COMANDANTE DE LA ESCUELA DE COMANDO Y ESTADO MAYOR</h4> 
      <h5><?php echo date("Y");?> </h5>
        
      </footer>



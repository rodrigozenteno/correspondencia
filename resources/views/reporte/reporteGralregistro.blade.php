
<style type="text/css">
    * {
        font-family: Verdana, Arial(6), sans-serif;
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
                margin-top: 2cm;
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


<table width="110%">
      
    

    <tr align="center">
        <td >
            <!-- <h4>DEPARTAMENTO IV EDUCACION</h4>
            <h4 style="margin:-3.5% 0;">ESCUELA DE COMANDO Y ESTADO MAYOR</h3>
            <h4 >"MARISCAL ANDRES DE SANTA CRUZ"</h4>
            <h4 style="margin:-1.5% 0;">BOLIVIA</h4> -->
             
                  <h2>REPORTE DE REGISTRO <?php $mytime = Carbon\Carbon::now(); echo $mytime->toDateTimeString(); ?></h2>
              
        </td>
    </tr>
   

  </table>

        <header>
    
    <h5>DEPARTAMENTO VI - EDUCACIÓN</h5>
            <h5 style="margin:-2.5% 0;">ESCUELA DE COMANDO Y ESTADO MAYOR  DEL EJÉRCITO</h5>
            <h5 >"MARISCAL ANDRES DE SANTA CRUZ"</h5>
            <h5 style="margin:-2.5% 0;">BOLIVIA</h5>  
        </header> 
       
                  
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <table class="table table-striped table-bordered table-condensed" width="100%">
                        <thead class="text-center" style="background-color: lightgray;">
                            <tr>
                                <th class="col-lg-4">nroDoc </th>
                                <th > fecha Ingreso  <br> Tipo de Documento. </th> 
                                 <th>  procedencia <br> Objeto doc   </th>
                                 <th>  Plazo del Documento. <br> Plazo del CMTE.   </th>
                                <!-- <th>Observacion.</th> -->
                                <th> Plazo <br> para el  <br> 
                                Cumplimiento</th>

                            </tr>
                        </thead>
                          <tbody>
                              @foreach($datos as $dat)

                            <tr>
                              
                                  <th scope="row"> {{ $dat->nroDoc }} </th>
                                  <td align="center" >  {{ $dat->create_at }} <br> {{ $dat->tipoDoc }}  </td>
                                  <td align="left">{{ $dat->procedenciaDoc }} <br>{{ $dat->objetoDoc }} <br> {{ $dat->numeroDoc }}  </td>
                                  <td align="left" >  {{ $dat->fechaEntrega }} <br> {{ $dat->fechaEntregaCmte }}  </td>
                                  <!-- <td align="center">{{ $dat->observacionesDoc }}   </td>  -->
                                  <?php
													 $date1 =new dateTime($dat->fechaEntregaCmte );
													 $date2= new dateTime( date("Y-m-d") );
												$valordiferencia = $date1->diff($date2);
												//echo $valordiferencia ;
                                                echo $valordiferencia->format('%R%a días');
												?>
                                  <td align="center">{{   $valordiferencia->days   }}  </td> 
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
      <h5>My. DEM. Roberto Prudencio Salinas  </h5> 
      <h5  style="margin:-35% 0;"> AYUDANTE DE LA ECEME.</h5> 
      <h5><?php echo date("Y");?> </h5>
        
      </footer>



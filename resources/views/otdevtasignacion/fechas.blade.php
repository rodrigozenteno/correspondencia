
    <div class="container" >
        <div class="row">
            <div class="col-lg-12" align="center"> 
                <div class="panel panel-default"> 
                    <button class="btn btn-outline-primary" type="button" id="imprimirReporteherram2"><i class='fa fa-download'></i> Generar Reporte Gral. de Documentación</button><br>   <br>
                        <form method="post" action="<?php echo e(url('reporte/reporteindividual/'  )) ; ?>" id="formFechas" name="getOrderReportForm">
                            <div class="form-group">
                                <label for="fechaInicio" class="col-sm-2 control-label">Fecha Inicial</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" autocomplete="on" min="2014-01-01" max="<?php echo (date("Y-m-d"));; ?>" />
                                    </div>
                            </div>
                            <br><br><br>
                                        <div class="form-group">
                                            <label for="fechaFinal" class="col-sm-2 control-label">Fecha Final</label>
                                                <div class="col-sm-10">
                                                     <input type="date" class="form-control" id="fechaFinal" name="fechaFinal" placeholder="Fecha final" min="2014-01-01" max="<?php echo (date("Y-m-d")); ?>" />
                                                </div>
                                        </div>
                                                    <button  class="btn btn-outline-primary" type="submit" id="imprimirReporteherram3"><i class='fa fa-download'></i>  Generar Reporte de fecha</button>
                        </form>  
                            </div>
                           
                </div> 
            </div>
        </div>       

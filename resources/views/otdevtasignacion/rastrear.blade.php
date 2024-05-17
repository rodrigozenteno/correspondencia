<?php
function mostrarNodosPadres($nodoRaiz)
{
	if($nodoRaiz!=null)
	{
		mostrarNodosPadres($nodoRaiz->totdevtasignacionrecursive);

		if($nodoRaiz->estado!='Cerrado')
		{
			echo '<li class="item"><span><b class="label label-default">'.$nodoRaiz->codigoOTDEvtAsignacion.' ('.$nodoRaiz->estado.')</b><br>'.$nodoRaiz->toficina->nombre.'</span></li><li class="arrow"><span class="glyphicon glyphicon-arrow-right"></span></li>';
		}
	}
}

function mostrarNodosHijos($nodosRaiz)
{
	if(count($nodosRaiz)==0)
	{
		return;
	}

	foreach($nodosRaiz as $key => $value)
	{
		if($key==0 && $value->estado!='Cerrado')
		{
			echo '<li class="arrow"><span class="glyphicon glyphicon-arrow-right"></span></li>';
		}

		if($value->estado!='Cerrado')
		{
			echo '<li class="item" '.(count($value->totdevtasignacionrecursivechild)==0 ? 'style="background-color: #4778ff;color: #ffffff;"' : '').'><span><b class="label label-default">'.$value->codigoOTDEvtAsignacion.' ('.$value->estado.')</b><br>'.$value->toficina->nombre.'</span></li>';
		}

		mostrarNodosHijos($value->totdevtasignacionrecursivechild);
	}
}
?>

<style>
	.ulNodos
	{
		list-style: none;
		margin: 0px;
		padding: 0px;
	}

	.ulNodos > li[class=arrow]
	{
		display: inline-table;
		height: 70px;
		margin: 0px;
		padding: 0px;
		text-align: center;
		vertical-align: middle;
	}

	.ulNodos > li[class=item]
	{
		background-color: #eeeeee;
		border: 1px solid #999999;
		border-radius: 0px 70px 70px 0px;
		color: #000000;
		display: inline-table;
		height: 70px;
		margin: 10px;
		padding: 7px;
		text-align: center;
		vertical-align: middle;
		width: 170px;
	}

	.ulNodos > li > span
	{
		display: table-cell;
		vertical-align: middle;
	}
</style>
<div class="text-center">
	<ul class="ulNodos" style="overflow-x: scroll;white-space: nowrap;">
		<?php mostrarNodosPadres($tOTDEvtAsignacion->totdevtasignacionrecursive); ?>@if($tOTDEvtAsignacion->estado!='Cerrado') <li class="item" style="background-color: #47b879;color: #ffffff;"><span><b class="label label-default">{{$tOTDEvtAsignacion->codigoOTDEvtAsignacion}} ({{$tOTDEvtAsignacion->estado}})</b><br>{{$tOTDEvtAsignacion->toficina->nombre}}</span></li> @endif<?php mostrarNodosHijos($tOTDEvtAsignacion->totdevtasignacionrecursivechild); ?>
	</ul>
</div>
<hr>
<div class="row">
	<div class="col-md-12">
		{{csrf_field()}}
		<input type="button" class="btn btn-default pull-right" value="Cerrar ventana" onclick="$('#dialogoGeneralModal').modal('hide');">
	</div>
</div>
<script>
	$('[data-toggle="tooltip"]').tooltip();
</script>
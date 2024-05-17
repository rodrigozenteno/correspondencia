<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
	<li class="header">MENÚ DE NAVEGACIÓN</li>
	@if(strpos(Session::get('rol'), 'Súper usuario')!==false || strpos(Session::get('rol'), 'Administrador')!==false)
		<li id="liMenuPanelControl" class="treeview">
			<a href="#">
				<i class="fa fa-dashboard"></i> <span>Panel de control</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li id="liMenuItemPanelControlInicio"><a href="{{url('/')}}"><i class="fa fa-circle-o"></i> Inicio</a></li>
			</ul>
		</li>
		<li id="liMenuGestionUsuario" class="treeview">
			<a href="#">
				<i class="fa fa-users"></i> <span>Gestión de usuario</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li id="liMenuItemGestionUsuarioRegistrarUsuario"><a href="{{url('usuario/insertar')}}"><i class="fa fa-circle-o"></i> Registrar usuario</a></li>
				<li id="liMenuItemGestionUsuarioListarUsuarios"><a href="{{url('usuario/ver')}}"><i class="fa fa-circle-o"></i> Listar usuarios</a></li>
			</ul>
		</li>
		<li id="liMenuGestionOficinas" class="treeview">
			<a href="#">
				<i class="fa fa-institution"></i> <span>Gestión de oficinas</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li id="liMenuItemGestionOficinasRegistrarOficina"><a href="{{url('oficina/insertar')}}"><i class="fa fa-circle-o"></i> </a></li>
				<li id="liMenuItemGestionOficinasListarOficinas"><a href="{{url('oficina/ver')}}"><i class="fa fa-circle-o"></i> Listar oficinas</a></li>
			</ul>
		</li>
	@endif
	<li id="liMenuGestionDocumentos" class="treeview">
		<a href="#">
			<i class="fa fa-file"></i> <span>Gestión de documentos</span>
			<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">

			<li id="liMenuItemGestionDocumentosRegistrarDocumento"><a href="{{url('otdevtasignacion/insertar')}}"><i class="fa fa-circle-o"></i> Registrar documento</a></li>
			<li id="liMenuItemGestionDocumentosListarDocumentos"><a href="{{url('otdevtasignacion/ver')}}"><i class="fa fa-circle-o"></i> Listar documentos</a></li>
		</ul>
</li>

<li id="liMenuGestionDocumentos" class="treeview">
		<a href="#">
			<i class="fa fa-file"></i> <span>Gestión Registro</span>
			<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">
			<li id="liMenuItemGestionDocumentosRegistrarDocumento"><a href="{{url('registro/listar')}}"><i class="fa fa-circle-o"></i> Listar</a></li>
			<li id="liMenuItemGestionDocumentosRegistrarDocumento"><a href="{{url('registro/insertar')}}"><i class="fa fa-circle-o"></i> Crear</a></li>
		
		</ul>
</li>

	<li id="liMenuGestionReportes" class="treeview">
		<a href="#">
			<i class="fa fa-file"></i> <span>Reportes</span>
			<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
			</span>
		</a>
		<ul class="treeview-menu">
			<li id="liMenuItemGestionReportePorFecha"><a href="{{url('reporte/reporteFecha')}}"><i class="fa fa-circle-o"></i> Reportes por Fecha</a></li>
			
		</ul>
	
	</li>

</ul>
<script>
	$('#{{Session::get('menuItemPadreSelected')}}').addClass('active');
	$('#{{Session::get('menuItemHijoSelected')}}').addClass('active');
</script>
<!-- {{url('reporte/reporteGral')}} -->
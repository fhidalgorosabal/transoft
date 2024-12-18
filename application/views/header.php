<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TranSoft | <?php if(isset($titulo)): echo $titulo; endif;?></title>
  <link rel="stylesheet" href="<?php echo base_url()?>bootstrap/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()?>bootstrap/css/icons.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/styles.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/custom.css" media="screen">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/DT_bootstrap.css" media="screen">
  
  <script src="<?php echo base_url()?>vendors/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url()?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>

<body>
	<!-- Begin Header -->
	<header class="banner navbar-fixed-top">        
        <div class="banner-img">
            <a href="<?php echo base_url()?>">
                <div class="logo"></div>    
                <div class="span1 title">TranSoft</div>             
            </a>
        </div> 
        <div class="navbar">
            <div class="navbar-inner">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> 
                                    <i class="icon-user-2"></i> <?php echo $this->session->userdata('user_name');?> <i class="caret"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="<?php echo base_url() ?>auth/edit_perfil"><i class="icon-cog"></i> Editar mi perfil</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="<?php echo base_url() ?>auth/logout"><i class="icon-switch"></i> Cerrar sesi&oacute;n</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <?php if(isset($titulo) && $titulo=='Inicio'){
                               $clase='class="active"'; 
                               $link='#';
                               $cursor='style="cursor: default"';
                            }
                            else{
                                $clase='';
                                $link=base_url();
                                $cursor='';
                            }
                            ?>
                            <li <?php echo $clase ?>>
                                <a href="<?php echo $link ?>" class="dropdown-toggle" <?php echo $cursor ?>><i class="icon-home"></i> Inicio</a>
                            </li>
                            <?php
                                function es_carro($titulo){
                                    return ($titulo=='Carro' || $titulo=='Insertar Carro' || $titulo=='Modificar Carro' || $titulo=='Ver Carro');
                                }
                                function es_chofer($titulo){
                                    return ($titulo=='Chofer' || $titulo=='Insertar Chofer' || $titulo=='Modificar Chofer' || $titulo=='Ver Chofer');
                                }
                                function es_ayudante($titulo){
                                    return ($titulo=='Ayudante' || $titulo=='Insertar Ayudante' || $titulo=='Modificar Ayudante' || $titulo=='Ver Ayudante');
                                }                                 
                                function es_licencia($titulo){
                                    return ($titulo=='Licencia' || $titulo=='Insertar Licencia' || $titulo=='Modificar Licencia' || $titulo=='Ver Licencia');
                                }                               
                                function es_tarjeta($titulo){
                                    return ($titulo=='Tarjeta' || $titulo=='Insertar Tarjeta' || $titulo=='Modificar Tarjeta' || $titulo=='Ver Tarjeta');
                                }                               
                                function es_actividad($titulo){
                                    return ($titulo=='Actividad' || $titulo=='Insertar Actividad' || $titulo=='Modificar Actividad' || $titulo=='Ver Actividad');
                                }
                                function es_usuario($titulo){
                                    return ($titulo=='Usuario' || $titulo=='Crear Usuario' || $titulo=='Modificar Usuario');
                                }
                                function es_gestionar($titulo){
                                    return (es_carro($titulo) || es_chofer($titulo) || es_ayudante($titulo) || es_licencia($titulo) || es_tarjeta($titulo) || es_actividad($titulo) || es_usuario($titulo));
                                }
                            ?>
                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))) {
                                    $gestionar = 'Gestionar'; 
                                } 
                                else 
                                    $gestionar = 'Listar';
                            ?>
                            <li class="dropdown <?php if(isset($titulo) && es_gestionar($titulo)):?>active<?php endif;?>">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <i class="icon-cabinet"></i> <?php echo $gestionar?> <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li class="dropdown-submenu">
                                        <a href="#"><i class="icon-cars"></i> Carro</a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                                            <li><a class="" href="<?php echo base_url() ?>carro/insertar"><i class="icon-plus-2"></i> Adicionar carro</a></li>
                                            <?php endif;?>
                                            <li><a class="" href="<?php echo base_url() ?>carro"><i class="icon-list"></i> Listar carros</a></li>                                            
                                        </ul>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu">
                                        <a href="#"><i class="icon-user-3"></i> Chofer</a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                                            <li><a class="" href="<?php echo base_url() ?>chofer/insertar"><i class="icon-plus-2"></i> Adicionar chofer</a></li>
                                            <?php endif;?>
                                            <li><a class="" href="<?php echo base_url() ?>chofer"><i class="icon-list"></i> Listar choferes</a></li>                                            
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a href="#"><i class="icon-user"></i> Ayudante</a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                                            <li><a class="" href="<?php echo base_url() ?>ayudante/insertar"><i class="icon-plus-2"></i> Adicionar ayudante</a></li>
                                            <?php endif;?>
                                            <li><a class="" href="<?php echo base_url() ?>ayudante"><i class="icon-list"></i> Listar ayudantes</a></li>                                            
                                        </ul>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu">
                                        <a href="#"><i class="icon-newspaper"></i> Licencia</a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                                            <li><a class="" href="<?php echo base_url() ?>licencia/insertar"><i class="icon-plus-2"></i> Adicionar licencia</a></li>
                                            <?php endif;?>
                                            <li><a class="" href="<?php echo base_url() ?>licencia"><i class="icon-list"></i> Listar licencias</a></li>                                            
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu">
                                        <a href="#"><i class="icon-credit-card"></i> Tarjeta</a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                                            <li><a class="" href="<?php echo base_url() ?>tarjeta/insertar"><i class="icon-plus-2"></i> Adicionar tarjeta</a></li>
                                            <?php endif;?>
                                            <li><a class="" href="<?php echo base_url() ?>tarjeta"><i class="icon-list"></i> Listar tarjetas</a></li>                                            
                                        </ul>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu">
                                        <a href="#"><i class="icon-paragraph-justify"></i> Actividad</a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                                            <li><a class="" href="<?php echo base_url() ?>actividad/insertar"><i class="icon-plus-2"></i> Adicionar actividad</a></li>
                                            <?php endif;?>
                                            <li><a class="" href="<?php echo base_url() ?>actividad"><i class="icon-list"></i> Listar actividades</a></li>                                            
                                        </ul>
                                    <?php if($this->ion_auth->logged_in() && $this->ion_auth->is_admin()): ?>    
                                    </li><li class="divider"></li>
                                    <li class="dropdown-submenu">
                                        <a href="#"><i class="icon-user-2"></i> Usuario</a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <li><a class="" href="<?php echo base_url() ?>auth/create_user"><i class="icon-plus-2"></i> Crear usuario</a></li>
                                            <li><a class="" href="<?php echo base_url() ?>auth"><i class="icon-list"></i> Listar usuario</a></li>                                            
                                        </ul>
                                    </li>
                                    <?php endif;?>
                                </ul>
                            </li>
                            <li class="dropdown <?php if(isset($titulo) && ($titulo=='Recorridos' || $titulo=='Captar Recorrido' || $titulo=='Ver Recorrido' || $titulo=='Modificar Recorrido')):?>active<?php endif;?>">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-bus"></i> Recorridos <i class="caret"></i>
				</a>
				<ul class="dropdown-menu">
                                    <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))): ?>
                                    <li class="dropdown-submenu">
					<a class="dropdown-toggle menu-menumgr" data-toggle="dropdown" href="#"><i class="icon-plus-2"></i> Captar recorrido </a>
					<?php if(isset($actividades)):?>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php foreach ($actividades as $value): ?>
                                            <li><a href="<?php echo base_url() ?>recorrido/captar/<?php echo $value->id_actividad ?>"><?php echo $value->nombre_act ?></a></li>
                                            <?php endforeach;?>
                                        </ul>
                                        <?php endif;?>
                                    </li>
                                    <?php endif;?>
                                    <li class="dropdown-submenu">
					<a class="dropdown-toggle menu-menumgr" data-toggle="dropdown" href="#"><i class="icon-list"></i> Listar recorridos</a>
					<?php if(isset($actividades)):?>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <?php foreach ($actividades as $value): ?>
                                            <li><a href="<?php echo base_url() ?>recorrido/listar/<?php echo $value->id_actividad ?>/<?php if(isset($carro)) { echo $carro->id_carro; } ?>"><?php echo $value->nombre_act ?></a></li>
                                            <?php endforeach;?>
                                        </ul>
                                        <?php endif;?>
                                    </li>
				</ul>
                            </li>
                            <li class="dropdown <?php if(isset($titulo) && ($titulo=='Ver Habilitados' || $titulo=='Habilitar')):?>active<?php endif;?>">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-droplet"></i> Combustible <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))): ?>
                                    <li>
                                        <a href="<?php echo base_url() ?>combustible/habilitar"><i class="icon-download"></i> Habilitar combustible</a>
                                    </li>
                                    <?php endif;?>
                                    <li>
                                        <a href="<?php echo base_url() ?>combustible"><i class="icon-list"></i> Ver habilitados</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown ">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-clipboard-2 large"></i> Reportes <i class="caret"></i>
                                </a>
				<ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-toggle menu-menumgr" data-toggle="dropdown" href="#">
                                            <i class="icon-bus"></i> Recorridos
                                        </a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <li>
                                                <a href="<?php echo base_url() ?>recorrido/reporte_recorrido" ><< General >></a>
                                            </li>
                                            <li class="divider"></li>
                                            <?php if(isset($actividades)):?>
                                            <?php foreach ($actividades as $value): ?>
                                            <li><a href="<?php echo base_url() ?>recorrido/reporte_por_actividad/<?php echo $value->id_actividad ?>" ><?php echo $value->nombre_act ?></a></li>
                                            <?php endforeach;?>
                                            <?php endif;?>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>combustible/reporte_combustible" ><i class="icon-droplet"></i> Combustible habilitado</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>recorrido/reporte_carga_transportada" ><i class="icon-shipping large"></i> Cargas transportadas</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>principal/reporte_indicadores" ><i class="icon-equalizer large"></i> Indicadores</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-toggle menu-menumgr" data-toggle="dropdown" href="#">
                                            <i class="icon-clock"></i> Acumulado
                                        </a>
                                        <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                            <li>
                                                <a href="<?php echo base_url() ?>recorrido/reporte_recorrido_acumulado" ><i class="icon-bus"></i> Recorridos</a>
                                            </li>                                            
                                            <li>
                                                <a href="<?php echo base_url() ?>combustible/reporte_combustible_acumulado" ><i class="icon-droplet"></i> Combustible habilitado</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url() ?>recorrido/reporte_carga_transportada_acumulado" ><i class="icon-shipping large"></i> Cargas transportadas</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url() ?>principal/reporte_indicadores_acumulado" ><i class="icon-equalizer large"></i> Indicadores</a>
                                            </li>
                                        </ul>
                                    </li>
				</ul>
                            </li>  
                            <?php 
                            if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))) {
                                function is_baja($titulo){
                                    return ($titulo=='Bajas Carro' || $titulo=='Bajas Chofer' || $titulo=='Bajas Ayudante');
                                }
                                function is_otros($titulo){
                                    return ($titulo=='Asignaci&oacute;n de tarjetas' || $titulo=='Configuraci&oacute;n' || $titulo=='Mes a procesar');
                                }                                
                            ?>
                            <li class="dropdown <?php if(isset($titulo) && (is_baja($titulo) || is_otros($titulo))):?>active<?php endif;?>">
                                <a href="#"role="button" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-tools large"></i> Operaciones <i class="caret"></i>
                                </a>
                                <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-toggle menu-menumgr" data-toggle="dropdown" href="#">
                                        <i class="icon-remove"></i> Listado de Bajas
                                    </a>
                                    <ul id="menu-com-menus-menus" class="dropdown-menu menu-component">
                                        <li>
                                            <a href="<?php echo base_url() ?>carro/baja"><i class="icon-cars"></i> Carros de baja</a>    
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() ?>chofer/baja"><i class="icon-user-3"></i> Choferes de baja</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url() ?>ayudante/baja"><i class="icon-user"></i> Ayudantes de baja</a>
                                        </li>
                                    </ul>     
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo base_url() ?>combustible/asignar_tarjetas"><i class="icon-tab"></i> Asignaci&oacute;n de tarjetas</a>
                                </li>
                                <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                                <li>
                                    <a href="<?php echo base_url() ?>recorrido/configuracion"><i class="icon-cog"></i> Configuraci&oacute;n</a>
                                </li>
                                <?php endif;?>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo base_url() ?>principal/mes_procesar" ><i class="icon-calendar"></i> Mes a procesar</a> 
                                </li>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
            </div>
        </div>         
	</header>
	<!-- End Header -->
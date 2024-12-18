<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($titulo)): echo $titulo; endif;?></title>
    
<link rel="stylesheet" href="<?php echo base_url()?>bootstrap/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()?>bootstrap/css/icons.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url()?>assets/styles.css" type="text/css">
  
<script src="<?php echo base_url()?>vendors/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body class="reporte">
<div class="container-fluid container-main">     
    <section id="content">
	<div class="row-fluid">	
            <div class="well well-small">
		<h2 class="module-title box-header"><?php if(isset($titulo)){ echo $titulo; }?></h2>
		<div class="row-striped"> 
                    <div class="table-toolbar"> 
                        <?php if((isset($meses) && $meses!=NULL) && (isset($anno) && $meses!=$anno) && (isset($actividades) && $actividades!=NULL)): ?>
                        <div class="btn-group">
                            <form method="post" id="form_1" action="<?php echo base_url() ?>recorrido/reporte_recorrido_acumulado" class="form-search">
                                <div class="search-controls">
                                    <label class="search-label">Actividad:
                                    <div class="input-prepend input-append">
                                        <span class="add-on">
                                        <span data-original-title="Actividad" class="icon-search hasTooltip"></span>						
                                        </span>
                                        <select name="actividad" style="width: 170px">
                                            <option value="general" onclick="buscar()">--General--</option>
                                            <?php foreach ($actividades as $value): ?>
                                            <option value="<?php echo $value->id_actividad ?>" <?php if(isset($actividad) && $value->id_actividad==$actividad){ echo 'selected="selected"'; }?> onclick="buscar()"><?php echo $value->nombre_act ?></option>
                                            <?php endforeach; ?>                                      
                                        </select>  
                                    </div>    
                                    </label>
                                    <label class="search-label">Mes:
                                    <div class="input-prepend input-append">
                                        <span class="add-on">
                                        <span data-original-title="mes" class="icon-search hasTooltip"></span>						
                                        </span>
                                        <select name="mes" style="width: 130px">
                                            <?php foreach ($meses as $mes): ?>
                                            <option value="<?php echo $mes['id'] ?>" <?php if($mes['id']==$fecha['mes']){ echo 'selected="true"';} ?> onclick="buscar()">
                                                <?php echo $mes['nombre'] ?>
                                            </option>  
                                            <?php endforeach;?>
                                        </select>  
                                    </div>    
                                    </label>
                                    <label class="search-label">A&ntilde;o:
                                    <div class="input-prepend input-append">
                                        <span class="add-on">
                                        <span data-original-title="mes" class="icon-search hasTooltip"></span>						
                                        </span>
                                        <select name="anno" style="width: 70px">
                                            <?php foreach ($anno as $data_anno): ?>
                                            <option value="<?php echo $data_anno['id'] ?>" <?php if($data_anno['id']==$fecha['anno']){ echo 'selected="true"';} ?> onclick="buscar()">
                                                <?php echo $data_anno['id'] ?>
                                            </option>  
                                            <?php endforeach;?> 
                                        </select>  
                                    </div>    
                                    </label>
                                </div>
                            </form>
                        </div>
                        <?php elseif(isset($actividades) && $actividades!=NULL):?>
                        <div class="btn-group">
                            <form method="post" id="form_1" action="<?php echo base_url() ?>recorrido/reporte_por_actividad_post" class="form-search">
                                <div class="search-controls">  
                                    <label class="search-label">Actividad:
                                    <div class="input-prepend input-append">
                                        <span class="add-on">
                                        <span data-original-title="Actividad" class="icon-search hasTooltip"></span>						
                                        </span>
                                        <select name="actividad">
                                            <?php foreach ($actividades as $value): ?>
                                            <option value="<?php echo $value->id_actividad ?>" <?php if(isset($actividad) && $value->id_actividad==$actividad){ echo 'selected="selected"'; }?> onclick="buscar()"><?php echo $value->nombre_act ?></option>
                                            <?php endforeach; ?>                                      
                                        </select>  
                                    </div>    
                                    </label>
                                </div>
                            </form>
                        </div>
                        <?php endif; ?>  
                        <div class="pull-right" style="padding-top: 4px;"> 
                            <a class="btn" href="<?php echo base_url() ?>">
                                <i class="icon-arrow-left fg-lightBlue"></i> Atr&aacute;s
                            </a>
                            <a class="btn" <?php if(count($listado)>0): ?>href="<?php echo base_url() ?>recorrido/<?php if(isset($titulo)){ echo url_title(strtolower($titulo), 'underscore').'_exportar'; } if(isset($actividad) && !isset($meses) && !isset($anno)){ echo '/'.$actividad; } else if(isset($actividad) && isset($meses) && isset($anno)){ echo '/'.$actividad.'/'.$fecha['mes'].'/'.$fecha['anno']; }else if(!isset($actividad) && (isset($meses) && isset($anno))){ echo '/NULL/'.$fecha['mes'].'/'.$fecha['anno']; }?>"<?php else: ?>href="#"<?php endif;?>>
                                <i class="icon-file-excel fg-darkGreen"></i> Exportar a Excel
                            </a> 
                        </div>
                    </div>
                    <div style="margin-top: 38px;">
                        <?php if(isset($reporte)) { echo $reporte; }?>
                    </div>    
                </div>
            </div>
        </div>
    </section>
</div> 
<script>
    function buscar() {
        var form1 = document.getElementById('form_1');
        form1.submit(); 
    }
    $('.tooltip-bottom').tooltip({ placement: 'bottom' });
</script> 
</body>
</html>	
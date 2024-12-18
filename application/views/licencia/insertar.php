<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Insertar Licencia</h2>
            <div class="row-striped">
                <div class="block-content"> 
                    <?php if (isset($mensaje) && $mensaje==true): ?>           
                        <div class="alert alert-success alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-checkmark"></i>&nbsp; ¡ Los datos de la licencia se guardaron correctamente !, <a href="<?php echo base_url() ?>licencia">desea regresar al listado</a>.
                            </p>    
                        </div>  
                    <?php elseif (validation_errors() || (isset($error) && $error)): ?>            
                        <div class="alert alert-error alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <h4 class="alert-heading"><i class="icon-cancel"></i>&nbsp;<?php if (isset($error) && $error) { echo '¡ ERROR !';} else { echo '¡Datos incorrectos!'; } ?></h4>
                            <p>
                                <?php if (isset($error) && $error) { echo $error;} else { echo validation_errors(); } ?>
                            </p>    
                        </div>  
                    <?php endif; ?>
                </div>
                <div class="block-content collapse in">
                <div class="span2"></div>
                    <div class="span8">
                        <form method="post" action="<?php echo base_url() ?>licencia/insertar_post" name="insertar_licencia" id="insertar_licencia" class="form-horizontal">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label">C&oacute;digo:</label>
                                    <div class="controls">
                                        <input name="codigo_licencia" type="text" maxlength="7" class="span12" autofocus="true" value="<?php if (isset($codigo_licencia)): echo $codigo_licencia; endif;?>" placeholder="Entre el c&oacute;digo de la licencia"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Fecha de vencimiento:</label>
                                    <div class="controls">
                                        <input name="fecha_vencimiento" type="date" class="input-xlarge datepicker" id="date01" class="span12" value="<?php if (isset($fecha_vencimiento)): echo $fecha_vencimiento; endif;?>" placeholder="Entre la fecha de vencimiento"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Puntos acumulados:</label>
                                    <div class="controls">
                                        <input name="puntos_acumulados" type="text" class="span12" value="<?php if (isset($puntos_acumulados)): echo $puntos_acumulados; endif;?>" placeholder="Entre los puntos acumulados"/>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                                    <a class="btn btn-danger" href="<?php echo base_url()?>licencia"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                                </div>
                            </fieldset>
                        </form>  
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<link href="<?php echo base_url()?>vendors/datepicker.css" rel="stylesheet" media="screen">
<script src="<?php echo base_url()?>vendors/bootstrap-datepicker.js"></script>
<script>
    $(".datepicker").datepicker();
</script>
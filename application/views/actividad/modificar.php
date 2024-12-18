<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Modificar Actividad</h2>
            <div class="row-striped">
                <div class="block-content">
                <?php if (isset($mensaje) && $mensaje==true): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; ¡ La actividad se ha modificado correctamente !, <a href="<?php echo base_url() ?>actividad">desea regresar al listado</a>.
                        </p>    
                    </div>  
                <?php endif; ?> 
                <?php if (validation_errors()): ?>   
                    <div class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <h4 class="alert-heading"><i class="icon-cancel"></i> ¡Datos incorrectos!</h4>
                        <p>
                            <?php echo validation_errors(); ?>
                       </p>    
                    </div>    
                <?php endif; ?>
                </div>
                <div class="block-content collapse in">
                <div class="span2"></div>
                    <div class="span8">
                        <form method="post" action="<?php echo base_url() ?>actividad/modificar_post/<?php echo $id_actividad ?>" name="modificar_actividad" id="modificar_actividad" class="form-horizontal">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label">N&uacute;mero:</label>
                                    <div class="controls">
                                        <input name="id_actividad" type="text" class="span12" disabled="disabled" value="<?php echo $id_actividad?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Nombre:</label>
                                    <div class="controls">
                                        <input name="nombre_act" type="text" class="span12" value="<?php echo $nombre_act?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Tipo de combustible:</label>
                                    <div class="controls">
                                        <select name="tipo_combustible" class="span12">
                                            <option value="">--Seleccionar--</option>
                                            <?php foreach ($combustible as $value): ?>
                                                <option value="<?php echo $value->id_combustible?>" <?php if(isset($tipo) && $tipo==$value->id_combustible):?>selected="selected"<?php endif;?>>
                                                    <?php echo $value->tipo_combustible?>
                                                </option> 
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div> 
                                <div class="control-group">
                                    <label class="control-label">Estado:</label>
                                    <div class="controls">
                                        <select name="estado" class="span12">
                                            <option value="">--Seleccionar--</option>
                                            <option value="Activa" <?php if($estado=='Activa'):?>selected="selected"<?php endif;?>>Activa</option>                                        
                                            <option value="Inactiva" <?php if($estado=='Inactiva'):?>selected="selected"<?php endif;?>>Inactiva</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                                    <a class="btn btn-danger" href="<?php echo base_url()?>actividad"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
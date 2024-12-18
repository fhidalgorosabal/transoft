<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Insertar Tarjeta</h2>
            <div class="row-striped">
                <div class="block-content"> 
                    <?php if (isset($mensaje) && $mensaje==true): ?>           
                        <div class="alert alert-success alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-checkmark"></i>&nbsp; ¡ Los datos de la tarjeta se guardaron correctamente !, <a href="<?php echo base_url() ?>tarjeta">desea regresar al listado</a>.
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
                        <form method="post" action="<?php echo base_url() ?>tarjeta/insertar_post" name="insertar_tarjeta" id="insertar_tarjeta" class="form-horizontal">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label">C&oacute;digo:</label>
                                    <div class="controls">
                                        <input name="codigo_tarjeta" type="text" class="span12" maxlength="4" autofocus="true" value="<?php if (isset($codigo_tarjeta)): echo $codigo_tarjeta; endif;?>" placeholder="Entre el c&oacute;digo de la tarjeta"/>
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
                                    <label class="control-label">Cr&eacute;dito inicial:</label>
                                    <div class="controls">
                                        <input name="credito" type="text" class="span12" value="<?php if (isset($credito)): echo $credito; endif;?>"  placeholder="Entre el cr&eacute;dito inicial de la tarjeta"/>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                                    <a class="btn btn-danger" href="<?php echo base_url()?>tarjeta"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                                </div>
                            </fieldset>
                        </form>  
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Modificar Chofer</h2>
            <div class="row-striped">
                <div class="block-content">
                <?php if (isset($mensaje) && $mensaje==true): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; ¡ El chofer se ha modificado correctamente !, <a href="<?php echo base_url() ?>chofer">desea regresar al listado</a>.
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
                        <form method="post" action="<?php echo base_url() ?>chofer/modificar_post/<?php echo $id_chofer ?>" name="modificar_chofer" id="modificar_chofer" class="form-horizontal">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label">Carnet de identidad:</label>
                                    <div class="controls">
                                        <input name="ci" type="text" class="span12" maxlength="11" placeholder="Entre el carnet de identidad del chofer" value="<?php echo $ci ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Nombre del chofer:</label>
                                    <div class="controls">
                                        <input name="nombre_chf" type="text" class="span12" placeholder="Entre el nombre del chofer" value="<?php echo $nombre_chf ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Apellidos del chofer:</label>
                                    <div class="controls">
                                        <input name="apellidos" type="text" class="span12" placeholder="Entre los apellidos del chofer" value="<?php echo $apellidos ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Licencia de conducci&oacute;n:</label>
                                    <div class="controls">
                                        <select name="id_licencia" class="span9">
                                            <option value="">--Seleccionar--</option>
                                            <?php foreach($licencias as $item): ?>
                                            <option <?php if($item->id_licencia==$id_licencia):?>selected="selected"<?php endif;?> value="<?php echo $item->id_licencia ?>"><?php echo $item->codigo_licencia ?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <a href="<?php echo base_url() ?>/licencia/insertar" title="Adicionar nueva licencia" class="badge badge-success" style="float: right; margin-top: 5px;"><i class="icon-plus-2"></i> Adicionar</a>
                                    </div>
                                </div>  
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                                    <a class="btn btn-danger" href="<?php echo base_url()?>chofer"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
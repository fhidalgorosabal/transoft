<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Modificar Ayudante</h2>
            <div class="row-striped">
                <div class="block-content">
                <?php if (isset($mensaje) && $mensaje==true): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; ¡ El ayudante se ha modificado correctamente !, <a href="<?php echo base_url() ?>ayudante">desea regresar al listado</a>.
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
                        <form method="post" action="<?php echo base_url() ?>ayudante/modificar_post/<?php echo $id_ayudante ?>" name="modificar_ayudante" id="modificar_ayudante" class="form-horizontal">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Carnet de identidad:</label>
                                <div class="controls">
                                    <input name="ci" type="text" class="span12" maxlength="11" value="<?php echo $ci ?>" placeholder="Entre el carnet de identidad del ayudante""/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nombre del ayudante:</label>
                                <div class="controls">
                                    <input name="nombre_ayd" type="text" class="span12" value="<?php echo $nombre_ayd ?>" placeholder="Entre el nombre del ayudante"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Apellidos del ayudante:</label>
                                <div class="controls">
                                    <input name="apellidos" type="text" class="span12" value="<?php echo $apellidos ?>" placeholder="Entre los apellidos del ayudante"/>
                                </div>
                            </div> 
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                                <a class="btn btn-danger" href="<?php echo base_url()?>ayudante"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                            </div>
                        </fieldset>
                        </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
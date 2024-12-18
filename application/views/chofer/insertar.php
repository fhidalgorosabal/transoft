<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Insertar Chofer</h2>
            <div class="row-striped">
                <div class="block-content"> 
                    <?php if (isset($mensaje) && $mensaje==true): ?>           
                        <div class="alert alert-success alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-checkmark"></i>&nbsp; ¡ Los datos del chofer se guardaron correctamente !, <a href="<?php echo base_url() ?>chofer">desea regresar al listado</a>.
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
                        <form method="post" action="<?php echo base_url() ?>chofer/insertar_post" name="insertar_chofer" id="insertar_chofer" class="form-horizontal">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label">Carnet de identidad:</label>
                                    <div class="controls">
                                        <input name="ci" type="text" class="span12" autofocus="true" maxlength="11" value="<?php if (isset($ci)): echo $ci; endif;?>" placeholder="Entre el carnet de identidad del chofer"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Nombre del chofer:</label>
                                    <div class="controls">
                                        <input name="nombre_chf" type="text" class="span12" value="<?php if (isset($nombre_chf)): echo $nombre_chf; endif;?>" placeholder="Entre el nombre del chofer"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Apellidos del chofer:</label>
                                    <div class="controls">
                                        <input name="apellidos" type="text" class="span12" value="<?php if (isset($apellidos)): echo $apellidos; endif;?>" placeholder="Entre los apellidos del chofer"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Licencia de conducci&oacute;n:</label>
                                    <div class="controls">
                                        <select name="id_licencia" class="span9">
                                            <option value="">--Seleccionar--</option>
                                            <?php foreach($licencias as $item): ?>
                                            <option value="<?php echo $item->id_licencia ?>" <?php if(isset($id_licencia) && $item->id_licencia==$id_licencia):?>selected="selected"<?php endif;?>><?php echo $item->codigo_licencia ?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <a href="<?php echo base_url() ?>licencia/insertar" data-original-title="Adicionar nueva licencia" class="badge badge-success tooltip-bottom" style="float: right; margin-top: 5px;"><i class="icon-plus-2"></i> Adicionar</a>
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
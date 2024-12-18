<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Modificar Carro</h2>
            <div class="row-striped">
            <div class="block-content">
            <?php if (isset($mensaje) && $mensaje==true): ?>           
                <div class="alert alert-success alert-block">
                    <a class="close" data-dismiss="alert" href="#">&times;</a>
                    <p>
                        <i class="icon-checkmark"></i>&nbsp; ¡ El carro se ha modificado correctamente !, <a href="<?php echo base_url() ?>carro">desea regresar al listado</a>.
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
                <div class="span12"> 
                    <form method="post" action="<?php echo base_url() ?>carro/modificar_post/<?php echo $id_carro ?>" name="modificar_carro" id="modificar_carro" class="form-horizontal">
                        <fieldset>
                        <div class="span12">
                            <div class="span6">
                            <div class="control-group">
                                <label class="control-label">C&oacute;digo del carro:</label>
                                <div class="controls">
                                    <input name="codigo" type="text" class="span12" value="<?php echo $codigo?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Chapa del carro:</label>
                                <div class="controls">
                                    <input name="chapa" type="text" class="span12" maxlength="7" value="<?php echo $chapa?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Marca y modelo:</label>
                                <div class="controls">
                                    <input name="marca" type="text" class="span12" value="<?php echo $marca?>" 
                                    data-provide="typeahead" data-items="4" 
                                    data-source='["Zil-130","Kamaz","Gaz-66","HYUNDAI","Girón-V","Yun-6","CHEROSKEE","Lada-2105","Jupiter"]'>
                                </div>
                            </div>     
                            <div class="control-group">
                                <label class="control-label">A&ntilde;o de fabricación:</label>
                                <div class="controls">
                                    <input name="anno" type="text" class="span12" placeholder="Introduzca el a&ntilde;o del carro" maxlength="4" value="<?php echo $anno?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tipo:</label>
                                <div class="controls">
                                    <select name="tipo" class="span12">
                                        <option value="">--Seleccionar--</option>
                                        <option value="C. Furgón" <?php if($tipo=='C. Furgón'):?>selected="selected"<?php endif;?>>C. Furgón</option>                                        
                                        <option value="C. Plataforma" <?php if($tipo=='C. Plataforma'):?>selected="selected"<?php endif;?>>C. Plataforma</option>
                                        <option value="C. Volteo" <?php if($tipo=='C. Volteo'):?>selected="selected"<?php endif;?>>C. Volteo</option>                                                                
                                        <option value="Otro" <?php if($tipo=='Otro'):?>selected="selected"<?php endif;?>>Otro</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="span6">
                            <div class="control-group">
                                <label class="control-label">Estado t&eacute;cnico:</label>
                                <div class="controls">
                                    <select name="estado_tecnico" class="span12">
                                        <option value="">--Seleccionar--</option>
                                        <option value="Bueno" <?php if($estado_tecnico=='Bueno'):?>selected="selected"<?php endif;?>>Bueno</option>                                        
                                        <option value="Regular" <?php if($estado_tecnico=='Regular'):?>selected="selected"<?php endif;?>>Regular</option>                                        
                                        <option value="Malo" <?php if($estado_tecnico=='Malo'):?>selected="selected"<?php endif;?>>Malo</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="control-group">
                                <label class="control-label">Capacidad de carga:</label>
                                <div class="controls">
                                    <input name="capacidad" type="text" class="span12" value="<?php echo $capacidad?>"/>
                                </div>
                            </div> 
                            <div class="control-group">
                                <label class="control-label">Tipo de combustible:</label>
                                <div class="controls">
                                    <select name="tipo_combustible" class="span12">
                                    <option value="">--Seleccionar--</option>
                                    <?php foreach ($combustible as $value): ?>
                                        <option value="<?php echo $value->id_combustible?>" <?php if(isset($tipo_combustible) && $tipo_combustible==$value->id_combustible):?>selected="selected"<?php endif;?>>
                                        <?php echo $value->tipo_combustible?>
                                        </option> 
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>          
                            <div class="control-group">
                                <label class="control-label">Norma de Consumo:</label>
                                <div class="controls">
                                    <input name="norma_consumo" type="text" class="span12" value="<?php echo $norma_consumo?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Capacidad del tanque:</label>
                                <div class="controls">
                                    <input name="capacidad_tanque" type="text" class="span12" value="<?php echo $capacidad_tanque?>" placeholder="Entre la capacidad del tanque"/>
                                </div>
                            </div>     
                            </div>    
                        </div>
                        <div class="form-actions span12">
                            <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                            <a class="btn btn-danger" href="<?php echo base_url()?>carro"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                        </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
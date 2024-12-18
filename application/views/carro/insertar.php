<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Insertar Carro</h2>
            <div class="row-striped">
                <div class="block-content"> 
                    <?php if (isset($mensaje) && $mensaje==true): ?>           
                        <div class="alert alert-success alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-checkmark"></i>&nbsp; ¡ Los datos del carro se guardaron correctamente !, <a href="<?php echo base_url() ?>carro">desea regresar al listado</a>.
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
                        <form method="post" action="<?php echo base_url() ?>carro/insertar_post" name="insertar_carro" id="insertar_carro" class="form-horizontal">
                            <fieldset>
                                <div class="span12">
                                    <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">C&oacute;digo del carro:</label>
                                        <div class="controls">
                                            <input name="codigo" type="text" class="span12" autofocus="true" value="<?php if (isset($codigo)): echo $codigo; endif;?>" placeholder="Entre el c&oacute;digo del carro"/>
                                        </div>
                                    </div>                        
                                    <div class="control-group">
                                        <label class="control-label">Chapa del carro:</label>
                                        <div class="controls">
                                            <input name="chapa" type="text" class="span12" maxlength="7" value="<?php if (isset($chapa)): echo $chapa; endif;?>" placeholder="Entre la chapa del carro"/>
                                        </div>
                                    </div> 
                                    <div class="control-group">
                                        <label class="control-label">Marca y modelo:</label>
                                        <div class="controls">
                                            <input name="marca" type="text" class="span12" placeholder="Entre la marca y el modelo del carro" 
                                            value="<?php if (isset($marca)): echo $marca; endif;?>" data-provide="typeahead" data-items="4"
                                            data-source='["Zil-130","Kamaz","Gaz-66","HYUNDAI","Girón-V","Yun-6","CHEROSKEE","Lada-2105","Jupiter"]'>
                                        </div>
                                    </div> 
                                    <div class="control-group">
                                        <label class="control-label">A&ntilde;o de fabricación:</label>
                                        <div class="controls">
                                            <input name="anno" type="text" class="span12" maxlength="4" value="<?php if (isset($anno)): echo $anno; endif;?>" placeholder="Entre el a&ntilde;o del carro"/>
                                        </div>
                                    </div>             
                                    <div class="control-group">
                                        <label class="control-label">Tipo:</label>
                                        <div class="controls">
                                            <select name="tipo" class="span12">
                                                <option value="">--Seleccionar--</option>
                                                <option value="C. Furgón" <?php if(isset($tipo) && $tipo=='C. Furgón'):?>selected="selected"<?php endif;?>>C. Furgón</option>                                        
                                                <option value="C. Plataforma" <?php if(isset($tipo) && $tipo=='C. Plataforma'):?>selected="selected"<?php endif;?>>C. Plataforma</option>
                                                <option value="C. Volteo" <?php if(isset($tipo) && $tipo=='C. Volteo'):?>selected="selected"<?php endif;?>>C. Volteo</option>
                                                <option value="Otro" <?php if(isset($tipo) && $tipo=='Otro'):?>selected="selected"<?php endif;?>>Otro</option>
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
                                                <option value="Bueno" <?php if(isset($estado_tecnico) && $estado_tecnico=='Bueno'):?>selected="selected"<?php endif;?>>Bueno</option>                                        
                                                <option value="Regular" <?php if(isset($estado_tecnico) && $estado_tecnico=='Regular'):?>selected="selected"<?php endif;?>>Regular</option>                                        
                                                <option value="Malo" <?php if(isset($estado_tecnico) && $estado_tecnico=='Malo'):?>selected="selected"<?php endif;?>>Malo</option>
                                            </select>
                                        </div>
                                    </div>   
                                    <div class="control-group">
                                        <label class="control-label">Capacidad de carga:</label>
                                        <div class="controls">
                                            <input name="capacidad" type="text" class="span12" value="<?php if (isset($capacidad)): echo $capacidad; endif;?>" placeholder="Entre la capacidad de carga"/>
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
                                        <label class="control-label">Norma de consumo:</label>
                                        <div class="controls">
                                            <input name="norma_consumo" type="text" class="span12" value="<?php if (isset($norma_consumo)): echo $norma_consumo; endif;?>" placeholder="Entre la norma de consumo del carro"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Capacidad del tanque:</label>
                                        <div class="controls">
                                            <input name="capacidad_tanque" type="text" class="span12" value="<?php if (isset($capacidad_tanque)): echo $capacidad_tanque; endif;?>" placeholder="Entre la capacidad del tanque"/>
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
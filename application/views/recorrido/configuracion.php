<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
            <h2 class="module-title box-header"><?php if(isset($titulo)){echo $titulo;}?></h2>
        <div class="row-striped">
            <div class="table-toolbar">
                <div class="btn-group">
                    <form method="post" id="form_1" action="<?php echo base_url() ?>recorrido/configuracion" class="form-search">
                        <div class="search-controls">    
                            <label class="search-label">Actividad:
                                <div class="input-prepend input-append">
                                    <span class="add-on">
                                    <span data-original-title="Actividad" class="icon-search hasTooltip"></span>						
                                    </span>
                                    <select name="actividad">
                                        <?php if(isset($actividades)):?>
                                        <?php foreach ($actividades as $value): ?>
                                        <option value="<?php echo $value->id_actividad ?>" <?php if(isset($actividad) && $value->id_actividad==$actividad){ echo 'selected="selected"'; }?> onclick="buscar()"><?php echo $value->nombre_act ?></option>
                                        <?php endforeach;
                                        endif;?>                                        
                                    </select>  
                                </div>    
                            </label>  
                        </div>
                    </form>
                </div>
            </div>    
            <div class="block-content"> 
                <?php if (isset($mensaje) && $mensaje==true): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; ¡ Los datos de la configuraci&oacute;n se guardaron correctamente en la BD !
                        </p>    
                    </div>  
                <?php endif; ?> 
            </div>            
        <div class="block-content collapse in">            
            <form method="post" action="<?php echo base_url() ?>recorrido/configuracion_post" name="captar_recorrido" id="captar_recorrido" class="form-horizontal">
                <fieldset>
                    <div class="span12">
                        <div class="span1">
                        </div>                       
                        <div class="span4">
                            <div class="checkbox" style="margin-bottom: 25px;">
                                <label>
                                    <input type="checkbox" name="fecha" checked="true" disabled="true"> Fecha
				</label>
                            </div>
                            <div class="checkbox" style="margin-bottom: 25px;">
				<label>
                                    <input type="checkbox" name="hoja_ruta" value="1" <?php if(isset($configuracion->numero_hoja_ruta) && $configuracion->numero_hoja_ruta==1){ echo 'checked="true"';}?>> No. hoja de ruta
				</label>
                            </div>
                            <div class="checkbox" style="margin-bottom: 25px;">
				<label>
                                    <input type="checkbox" name="viajes_carga" value="1" <?php if(isset($configuracion->viajes_carga) && $configuracion->viajes_carga==1){ echo 'checked="true"';}?>> Viajes con carga
				</label>
                            </div>
                            <div class="checkbox">
				<label>
                                    <input type="checkbox" name="consumo_combustible" value="1" <?php if(isset($configuracion->consumo_combustible) && $configuracion->consumo_combustible==1){ echo 'checked="true"';}?>> C. de combustible
				</label>
                            </div>
                            </div>                      
                            <div class="span4">
                            <div class="checkbox" style="margin-bottom: 25px;">
				<label>
                                    <input type="checkbox" name="conduce" value="1" <?php if(isset($configuracion->conduce) && $configuracion->conduce==1){ echo 'checked="true"';}?>> Conduce
				</label>
                            </div>
                            <div class="checkbox" style="margin-bottom: 25px;">
				<label>
                                    <input type="checkbox" name="distancia_total" value="1" <?php if(isset($configuracion->distancia_total) && $configuracion->distancia_total==1){ echo 'checked="true"';}?>> Distancia total
				</label>
                            </div>                        
                            <div class="checkbox" style="margin-bottom: 25px;">
				<label>
                                    <input type="checkbox" name="distancia_carga" value="1" <?php if(isset($configuracion->distancia_carga) && $configuracion->distancia_carga==1){ echo 'checked="true"';}?>> Distancia con carga
				</label>
                            </div>
                            <div class="checkbox">
				<label>
                                    <input type="checkbox" name="carga_transportada" value="1" <?php if(isset($configuracion->carga_transportada) && $configuracion->carga_transportada==1){ echo 'checked="true"';}?>> Carga transportada
				</label>
                            </div>
                            </div>                      
                            <div class="span3">
                            <div class="checkbox" style="margin-bottom: 45px;">
				<label>
                                    <input type="checkbox" name="carro" checked="true" disabled="true"> Carro
				</label>
                            </div>
                            <div class="checkbox" style="margin-bottom: 45px;">
				<label>
                                    <input type="checkbox" name="chofer" checked="true" disabled="true"> Chofer
				</label>
                            </div>
                            <div class="checkbox">
				<label>
                                    <input type="checkbox" name="ayudante" value="1" <?php if(isset($configuracion->ayudante) && $configuracion->ayudante==1){ echo 'checked="true"';}?>> Ayudante
				</label>
                            </div>
                            </div>
                        </div>
                    <input type="hidden" name="actividad" value="<?php if(isset($actividad)){ echo $actividad; }?>"/>
                    <input type="hidden" name="id_configuracion" value="<?php if(isset($configuracion->id_configuracion)){ echo $configuracion->id_configuracion; }?>"/>
                    <div class="form-actions span12" style="margin: 25px 0px;">
                        <div class="3"></div>
                        <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                        <a class="btn btn-danger" href="<?php echo base_url()?>"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                    </div>                          
                </fieldset>
            </form>    
            </div>
        </div>
        </div>
    </div>
</div> 
<script>
    function buscar() {
        var form1 = document.getElementById('form_1');
        form1.submit(); 
    }
</script>    
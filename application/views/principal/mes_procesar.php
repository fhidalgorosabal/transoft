        <?php
            $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        ?>
            <div class="well well-small">
                <h2 class="module-title box-header">Mes a procesar: <?php if(isset($mes_procesar)){ echo $nombre_mes[$mes_procesar]; }?> (Plan de indicadores)</h2>
		<div class="row-striped"> 
                    <form method="post" id="form_1" action="<?php echo base_url() ?>principal/mes_procesar_post" class="form-search">
                    <div class="block-content"> 
                        <?php if (isset($mensaje) && $mensaje==true): ?>           
                        <div class="alert alert-success alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-checkmark"></i>&nbsp; ¡ El cierre de mes se realizó satisfatoriamente, el nuevo mes a procesar es: <?php if(isset($mes_procesar)){ echo $nombre_mes[$mes_procesar]; }?> !
                            </p>    
                        </div>  
                        <?php endif; ?> 
                        <?php if (validation_errors() || (isset($error) && $error)): ?>           
                        <div class="alert alert-error alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <h4 class="alert-heading"><i class="icon-cancel"></i>&nbsp;<?php if (isset($error) && $error) { echo '¡ ERROR !';} else { echo '¡Datos incorrectos!'; } ?></h4>
                            <p>
                                <?php if (isset($error) && $error) { echo $error;} else { echo validation_errors(); } ?>
                            </p>    
                        </div>  
                        <?php endif; ?>
                        <div id="confirmacion"  class="alert alert-info alert-block hidden">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <h4 class="alert-heading"><i class="icon-warning large fg-amber"></i> ¡ Atenci&oacute;n !</h4>
                            <p>
                                Al realizar el cierre de mes se comienza a procesar un mes nuevo, tenga en cuenta que esta acción no se podr&aacute; deshacer.
                            </p> 
                            <p>
                                <a class="btn btn-small btn-success" onclick="enviar()"><i class="icon-checkmark"></i> Aceptar</a>
                            </p>
                        </div>
                    </div>
                    <div class="block-content collapse in">
                        <div class="span12">
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label span6">Carros existentes:</label>
                                    <div class="controls">
                                        <input name="carros_existentes" type="text" class="span6" value="<?php if (isset($carros_existentes)): echo $carros_existentes; endif;?>"/>
                                    </div>
                                </div>   
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Carros trabajando:</label>
                                    <div class="controls">
                                        <input name="carros_trabajando" type="text" class="span6" value="<?php if (isset($carros_trabajando)): echo $carros_trabajando; endif;?>"/>
                                    </div>
                                </div>  
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Carga transportada:</label>
                                    <div class="controls">
                                        <input name="carga_transportada" type="text" class="span6" value="<?php if (isset($carga_transportada)): echo $carga_transportada; endif;?>"/>
                                    </div>
                                </div>
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Viajes realizados:</label>
                                    <div class="controls">
                                        <input name="viajes_realizados" type="text" class="span6" value="<?php if (isset($viajes_realizados)): echo $viajes_realizados; endif;?>"/>
                                    </div>
                                </div>  
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label span6">Tr&aacute;fico:</label>
                                    <div class="controls">
                                        <input name="trafico" type="text" class="span6" value="<?php if (isset($trafico)): echo $trafico; endif;?>"/>
                                    </div>
                                </div>  
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Distancia total:</label>
                                    <div class="controls">
                                        <input name="distancia_total" type="text" class="span6" value="<?php if (isset($distancia_total)): echo $distancia_total; endif;?>"/>
                                    </div>
                                </div> 
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Distancia carga:</label>
                                    <div class="controls">
                                        <input name="distancia_carga" type="text" class="span6" value="<?php if (isset($distancia_carga)): echo $distancia_carga; endif;?>"/>
                                    </div>
                                </div>
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Carga posible:</label>
                                    <div class="controls">
                                        <input name="carga_posible" type="text" class="span6" value="<?php if (isset($carga_posible)): echo $carga_posible; endif;?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="control-group">
                                    <label class="control-label span6">Cons. combustible:</label>
                                    <div class="controls">
                                        <input name="consumo_combustible" type="text" class="span6" value="<?php if (isset($consumo_combustible)): echo $consumo_combustible; endif;?>"/>
                                    </div>
                                </div>  
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Precio diesel:</label>
                                    <div class="controls">
                                        <input name="precio_1" type="text" class="span6" value="<?php if (isset($precio_1)): echo $precio_1; endif;?>"/>
                                    </div>
                                </div> 
                                <div class="control-group" style="margin-top: 25px;">
                                    <label class="control-label span6">Precio gasolina:</label>
                                    <div class="controls">
                                        <input name="precio_2" type="text" class="span6" value="<?php if (isset($precio_2)): echo $precio_2; endif;?>"/>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-actions span12" style="margin: 25px 0px;">
                                <a class="btn" onclick="confirmacion()"><i class="icon-switch fg-darkRed"></i> Cerrar mes</a>
                                <a class="btn btn-danger" href="<?php echo base_url()?>"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                            </div>
                        </div>
                        <input type="hidden" name="nuevo_mes" value="<?php if(isset($mes_procesar)){ echo $mes_procesar+1; } ?>"/>
                    </div>     
                    </form>
                </div>
            </div>
<script>
    function confirmacion() {
        var conf = document.getElementById('confirmacion');
        conf.className = 'alert alert-info alert-block';
        
    }
    
    function enviar() {
        var form1 = document.getElementById('form_1');
        form1.submit(); 
    }
</script>
<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
            <h2 class="module-title box-header"><?php if(isset($titulo)){echo $titulo;}?></h2>
        <div class="row-striped">
            <div class="block-content"> 
                <?php if (isset($mensaje) && $mensaje==true): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; ¡ Los datos se guardaron correctamente en la base de datos !,  
                            <a href="<?php echo base_url() ?>recorrido/listar/<?php echo $actividad->id_actividad.'/'.$carro?>">
                                 desea ir al listado
                            </a>.
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
            </div>            
        <div class="block-content collapse in">            
                <form method="post" action="<?php echo base_url() ?>recorrido/captar_post/<?php echo $actividad->id_actividad ?>" name="captar_recorrido" id="captar_recorrido" class="form-horizontal">
                    <fieldset>
                    <div class="span12">    
                        <div class="span6" style="text-align: center;">
                            <div class="control-group">
                                <label class="control-label">Actividad:</label>
                                <div class="controls">
                                    <select name="id_actividad" class="span12" disabled="disabled">
                                        <option value="<?php echo $actividad->id_actividad ?>" selected="selected">
                                            <?php echo $actividad->nombre_act ?>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Fecha:</label>
                                <div class="controls">
                                    <input name="fecha" type="date" class="input-xlarge datepicker span12" id="date01" value="<?php if(isset($fecha)): echo $fecha; endif;?>"/>
                                </div>
                            </div>
                            <?php if(isset($configuracion->numero_hoja_ruta) && $configuracion->numero_hoja_ruta==1):?>
                            <div class="control-group">
                                <label class="control-label">No. hoja de ruta:</label>
                                <div class="controls">
                                    <input name="numero_hoja_ruta" type="text"  class="span12" value="<?php if(isset($numero_hoja_ruta)): echo $numero_hoja_ruta; endif;?>"/>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php if(isset($configuracion->viajes_carga) && $configuracion->viajes_carga==1):?>
                            <div class="control-group">
                                <label class="control-label">Viajes con carga:</label>
                                <div class="controls">
                                    <input name="viajes_carga" type="text"  class="span12" value="<?php if(isset($viajes_carga)): echo $viajes_carga; endif;?>"/>
                                </div>
                            </div> 
                            <?php endif;?>
                        </div>
                        <div class="span6" style="text-align: center;">
                            <div class="control-group">
                                <label class="control-label">Chapa del carro:</label>
                                <div class="controls">
                                    <select name="id_carro" class="span12">
                                        <option value="">--Seleccionar--</option>
                                        <?php foreach($carros as $item): ?>
                                        <option value="<?php echo $item->id_carro ?>" <?php if(isset($id_carro) && $item->id_carro==$id_carro):?>selected="selected"<?php endif;?>>
                                            <?php echo $item->chapa ?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>  
                            <div class="control-group">
                                <label class="control-label">Nombre del chofer:</label>
                                <div class="controls">
                                    <select name="id_chofer" class="span12">
                                        <option value="">--Seleccionar--</option>
                                        <?php foreach($choferes as $item): ?>
                                        <option value="<?php echo $item->id_chofer ?>" <?php if(isset($id_chofer) && $item->id_chofer==$id_chofer):?>selected="selected"<?php endif;?>>
                                            <?php echo $item->nombre_chf.' '.$item->apellidos ?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <?php if(isset($configuracion->ayudante) && $configuracion->ayudante==1):?>
                            <div class="control-group">
                                <label class="control-label">Nombre del ayudante:</label>
                                <div class="controls">
                                    <select name="id_ayudante" class="span12">
                                        <option value="1">--Opcional--</option>
                                        <?php foreach($ayudantes as $item): ?>
                                        <option value="<?php echo $item->id_ayudante ?>" <?php if(isset($id_ayudante) && $item->id_ayudante==$id_ayudante):?>selected="selected"<?php endif;?>>
                                            <?php echo $item->nombre_ayd.' '.$item->apellidos ?>
                                        </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php if(isset($configuracion->consumo_combustible) && $configuracion->consumo_combustible==1):?>
                            <div class="control-group">
                                <label class="control-label">C. de combustible:</label>
                                <div class="controls">
                                    <input name="consumo_combustible" type="text"  class="span12" value="<?php if(isset($consumo_combustible)): echo $consumo_combustible; endif;?>"/>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>  
                    <?php
                    $b_conduce=$b_distancia_total=$b_distancia_carga=$b_carga_transportada=FALSE;
                    if(isset($configuracion->conduce) && $configuracion->conduce==1)
                        $b_conduce = TRUE;
                    if(isset($configuracion->distancia_total) && $configuracion->distancia_total==1)    
                        $b_distancia_total = TRUE;
                    if(isset($configuracion->distancia_carga) && $configuracion->distancia_carga==1)  
                        $b_distancia_carga = TRUE;
                    if(isset($configuracion->carga_transportada) && $configuracion->carga_transportada==1)    
                        $b_carga_transportada = TRUE;
                    ?>    
                    <?php if($b_conduce || $b_distancia_total || $b_distancia_carga || $b_carga_transportada): ?>    
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Conduce</th>
                                <th>Distancia total</th>
                                <th>Distancia con carga</th>
                                <th>Carga transportada</th>
                            </tr>
                        </thead>  
                        <tbody id="cuerpo_tabla">
                            <?php if(isset($listado_conduce) && !empty($listado_conduce)):                   
                            $i=0;
                            foreach ($listado_conduce as $value): ?>
                            <tr>
                                <td><?php echo $i+1 ?></td>
                                <td>
                                    <input name="numero<?php echo $i ?>" type="text" <?php if(!$b_conduce):?>disabled="true"<?php endif;?> value="<?php echo $value['numero'] ?>" class="span9"/>
                                </td>
                                <td>
                                    <input name="distancia_total<?php echo $i ?>" type="text" <?php if(!$b_distancia_total):?>disabled="true"<?php endif;?> value="<?php echo $value['distancia_total'] ?>" class="span9"/>
                                </td>
                                <td>
                                    <input name="distancia_carga<?php echo $i ?>" type="text" <?php if(!$b_distancia_carga):?>disabled="true"<?php endif;?> value="<?php echo $value['distancia_carga'] ?>" class="span9"/>
                                </td>
                                <td>
                                    <input name="carga_transportada<?php echo $i ?>" type="text" <?php if(!$b_carga_transportada):?>disabled="true"<?php endif;?> value="<?php echo $value['carga_transportada'] ?>" class="span9"/>
                                </td>
                            </tr>                    
                            <?php $i++; endforeach;?>
                            <?php else: ?>
                            <tr>
                                <td>1</td>
                                <td>
                                    <input name="numero0" type="text" <?php if(!$b_conduce):?>disabled="true"<?php endif;?> class="span9"/>
                                </td>
                                <td>
                                    <input name="distancia_total0" type="text" <?php if(!$b_distancia_total):?>disabled="true"<?php endif;?>  class="span9"/>
                                </td>
                                <td>
                                    <input name="distancia_carga0" type="text" <?php if(!$b_distancia_carga):?>disabled="true"<?php endif;?>  class="span9"/>
                                </td>
                                <td>
                                    <input name="carga_transportada0" type="text" <?php if(!$b_carga_transportada):?>disabled="true"<?php endif;?>  class="span9"/>
                                </td>
                            </tr>                     
                            <?php endif;?>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">                               
                                    <input type="hidden" name="cont" id="cont" value="<?php if(isset($i)): echo $i; else:?>1<?php endif;?>"/>
                                    <div class="pull-right">
                                        <a id="remover" onclick="remover_fila()" data-original-title="Eliminar fila" class="badge badge-important tooltip-bottom">
                                            <i class="icon-minus-2"></i> Eliminar
                                        </a>
                                    </div>
                                    <div class="pull-right">&nbsp;</div>
                                    <div class="pull-right">
                                        <a id="add" onclick="nueva_fila()" data-original-title="Adicionar nueva fila" class="badge badge-success tooltip-bottom">
                                            <i class="icon-plus-2"></i> Adicionar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>    
                    <?php endif; ?>    
                        <div class="form-actions span12" style="margin-left: 0px;">
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
</div>    
<link href="<?php echo base_url()?>vendors/datepicker.css" rel="stylesheet" media="screen">
<link href="<?php echo base_url()?>vendors/chosen.min.css" rel="stylesheet" media="screen">
<script src="<?php echo base_url()?>vendors/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>vendors/chosen.jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>vendors/jquery.uniform.min.js" type="text/javascript"></script>
<script>
    var cont = parseInt(document.getElementById('cont').getAttribute('value'));
    $(".datepicker").datepicker();
    
    function nueva_fila(){  
       var contador = document.getElementById('cont'); 
       
       var tbody = document.getElementById('cuerpo_tabla');
       
       var tr = document.createElement('tr');
       tr.setAttribute('id','fila'+cont);
       
       var td_numero = document.createElement('td');
       var td_conduce = document.createElement('td');
       var td_distancia_total = document.createElement('td');
       var td_distancia_carga = document.createElement('td');
       var td_carga_transportada = document.createElement('td');
       
       var num = document.createTextNode(cont+1);
              
       var input_numero = document.createElement('input');
        input_numero.setAttribute('type','text');
        input_numero.setAttribute('name','numero'+cont);
        input_numero.className = 'span9';
        <?php if(!$b_conduce):?>
            input_numero.setAttribute('disabled',true);
        <?php endif;?>
            
        var input_distancia_total = document.createElement('input');
        input_distancia_total.setAttribute('type','text');
        input_distancia_total.setAttribute('name','distancia_total'+cont);
        input_distancia_total.className = 'span9';
        <?php if(!$b_distancia_total):?>
            input_distancia_total.setAttribute('disabled',true);
        <?php endif;?>
        
        var input_distancia_carga = document.createElement('input');
        input_distancia_carga.setAttribute('type','text');
        input_distancia_carga.setAttribute('name','distancia_carga'+cont);
        input_distancia_carga.className = 'span9';
        <?php if(!$b_distancia_carga):?>
            input_distancia_carga.setAttribute('disabled',true);
        <?php endif;?>
        
        var input_carga_transportada = document.createElement('input');
        input_carga_transportada.setAttribute('type','text');
        input_carga_transportada.setAttribute('name','carga_transportada'+cont);
        input_carga_transportada.className = 'span9';
        <?php if(!$b_carga_transportada):?>
            input_carga_transportada.setAttribute('disabled',true);
        <?php endif;?>
        
        <?php if($b_conduce || $b_distancia_total || $b_distancia_carga || $b_carga_transportada): ?> 
        td_numero.appendChild(num);
        td_conduce.appendChild(input_numero);
        td_distancia_total.appendChild(input_distancia_total);
        td_distancia_carga.appendChild(input_distancia_carga);
        td_carga_transportada.appendChild(input_carga_transportada);
       
        tr.appendChild(td_numero);
        tr.appendChild(td_conduce);
        tr.appendChild(td_distancia_total);
        tr.appendChild(td_distancia_carga);
        tr.appendChild(td_carga_transportada);
       
       tbody.appendChild(tr);      
       
       cont+=1;
       contador.setAttribute('value',cont);
       if(cont!=0){
            var boton = document.getElementById('remover');
            boton.className = 'badge badge-important tooltip-bottom';
            boton.setAttribute('data-original-title','Eliminar fila');
        }
        <?php endif;?>
    }
    
    function remover_fila(){
        if(cont>0){
            var contador = document.getElementById('cont');
            var tbody = document.getElementById('cuerpo_tabla');
            tbody.deleteRow(cont-1);
            cont-=1;            
            contador.setAttribute('value',cont);
            if(cont==0){
                var boton = document.getElementById('remover');
                boton.className = 'badge disabled';
                boton.setAttribute('data-original-title','');
            }
        }    
    }
</script>
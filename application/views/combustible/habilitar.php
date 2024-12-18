<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Habilitar Combustible</h2>
            <div class="row-striped">
                <div class="block-content"> 
                    <?php if (isset($mensaje) && $mensaje==true): ?>           
                        <div class="alert alert-success alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-checkmark"></i>&nbsp; ¡ Se ha realizado la operaci&oacute;n satisfactoriamente !
                            </p>    
                        </div>  
                    <?php endif; ?> 
                    <?php if (validation_errors() || (isset($error) && $error)): ?>           
                    <div class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <h4 class="alert-heading"><i class="icon-cancel"></i>&nbsp;<?php if (isset($error) && $error) { echo '¡ ERROR !';} else { echo '¡Datos incorrectos!'; } ?></h4>
                        <p>
                            <?php if (validation_errors()) { echo validation_errors(); } else { echo $error;} ?>
                        </p>    
                    </div>  
                <?php endif; ?>  
                    <?php if(isset($listado) && count($listado)==0): ?> 
                        <div class="alert alert-heading alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-warning large"></i> ¡ El criterio de b&uacute;squeda no coincide, no hay recorridos sin habilitar para este carro !
                            </p>    
                        </div> 
                    <?php endif;?>
                </div>
                <div class="block-content collapse in">                
                    <div class="span12">                        
                            <fieldset>
                                <div class="span12"> 
                                    <div class="span5">
                                        <form method="post" id="form_1" action="<?php echo base_url() ?>combustible/listar_tarjetas" name="insertar_habilitar" id="insertar_habilitar" class="form-horizontal">
                                        <div class="control-group">
                                            <label class="control-label">Fecha:</label>
                                            <div class="controls">
                                                <input name="fecha" type="date" <?php if(isset($id_carro) && isset($fecha)) { echo 'readonly="true" class="input-xlarge span12"'; } else { echo 'class="input-xlarge datepicker span12"'; }?> id="date01" value="<?php if(isset($fecha)){ echo $fecha; }?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Carro:</label>
                                            <div class="controls">
                                                <select name="carro" class="span12" <?php if(isset($b) && $b) { echo 'disabled="true"';}?>>
                                                    <option value="">--Seleccionar--</option>
                                                    <?php foreach($carros as $item): ?>
                                                    <option value="<?php echo $item->id_carro ?>" <?php if(isset($id_carro) && $item->id_carro==$id_carro):?>selected="selected"<?php endif;?> onclick="listar_tarjetas()">
                                                        <?php echo $item->chapa ?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select> 
                                            </div>
                                        </div>
                                        </form>
                                        <form method="post" id="form_2"  action="<?php echo base_url() ?>combustible/listar_recorridos" name="insertar_habilitar" id="insertar_habilitar" class="form-horizontal">
                                        <div class="control-group">
                                            <label class="control-label">Tarjeta:</label>
                                            <div class="controls">
                                                <select name="id_tarjeta" class="span12" <?php if(isset($b) && $b) { echo 'disabled="true"';}?>>
                                                    <option value="">--Seleccionar--</option> 
                                                    <?php foreach($tarjetas as $item): ?>
                                                    <option value="<?php echo $item->id_tarjeta ?>" <?php if(isset($id_tarjeta) && $item->id_tarjeta==$id_tarjeta):?>selected="selected"<?php endif;?>>
                                                        <?php 
                                                            $litros=0;
                                                            if($item->id_combustible==1)
                                                                $litros=$item->credito/$precio_1; 
                                                            else
                                                                $litros=$item->credito/$precio_2;
                                                            echo $item->codigo_tarjeta.'  -->  ';
                                                            $this->my_functions->m($this->my_functions->n($litros));
                                                            echo ' Lts'; 
                                                        ?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select> 
                                            </div>
                                        </div>
                                            <input type="hidden" name="fecha_2" value="<?php if(isset($fecha)){ echo $fecha; }?>"/>    
                                            <input type="hidden" name="id_carro" value="<?php if(isset($id_carro)){ echo $id_carro; }?>"/>  
                                        <div class="control-group">
                                            <a data-bind="" class="btn <?php if(!isset($id_carro)) { echo 'disabled'; } else { echo 'reset'; }?>" style="float: right; margin-left: 5px;"><i class="icon-cycle"></i> Reestablecer</a>
                                            <a class="btn btn-primary <?php if(!isset($id_carro) || (isset($b) && $b)) { echo 'disabled'; }?>" <?php if(isset($id_carro) && !isset($b)) { echo 'onclick="listar_recorridos()"'; }?> style="float: right;"><i class="icon-search"></i> Buscar recorridos</a>
                                        </div>
                                        </form>    
                                    </div> 
                                    <form method="post" id="form_3" action="<?php echo base_url() ?>combustible/habilitar_post">
                                        <div class="tabla-habilitar span7" style="float: right;">
                                        <table id="table"  cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="selec_todo" class="no" <?php if(!isset($b) || (isset($listado) && count($listado)==0)): ?>disabled="disabled"<?php endif;?> /></th>
                                                    <th>Fecha</th>
                                                    <th>Hoja de Ruta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(isset($listado) && count($listado)>0): 
                                            $cont=0;    
                                            foreach($listado as $recorrido): ?>
                                            <tr>
                                                <td><input type="checkbox" class="selec_fila" name="var<?php echo $cont ?>" value="<?php echo $recorrido['id_recorrido'] ?>"/></td>
                                                <td> <?php $this->my_functions->fecha($recorrido['fecha']) ?> </td>
                                                <td> <?php echo $recorrido['numero_hoja_ruta'] ?> </td>
                                            </tr>
                                            <?php 
                                            $cont+=1;
                                            endforeach;                                             
                                            endif;?>
                                            <?php if(isset($listado) && count($listado)==0): ?>                                             
                                            <tr> <td colspan="3">0 registros</td> </tr>
                                            <?php endif;?>
                                            </tbody>                                            
                                        </table>
                                    </div> 
                                        <input type="hidden" name="cont" value="<?php if(isset($cont)){ echo $cont; }?>"/>    
                                        <input type="hidden" name="fecha_habilitar" value="<?php if(isset($fecha)){ echo $fecha; }?>"/>    
                                        <input type="hidden" name="carro_habilitar" value="<?php if(isset($id_carro)){ echo $id_carro; }?>"/>  
                                        <input type="hidden" name="tarjeta_habilitar" value="<?php if(isset($id_tarjeta)){ echo $id_tarjeta; }?>"/>
                                        <?php $comb=0; if(isset($tarjetas) && !isset($comb_tarjeta)) : foreach( $tarjetas as $item): ?>
                                        <?php 
                                            if($item->id_combustible==1 && (isset($id_tarjeta) && $item->id_tarjeta==$id_tarjeta))
                                                $comb=$item->credito/$precio_1; 
                                            elseif($item->id_combustible==2 && (isset($id_tarjeta) && $item->id_tarjeta==$id_tarjeta))
                                                $comb=$item->credito/$precio_2;
                                        ?>
                                        <?php endforeach; 
                                        elseif(isset($comb_tarjeta)):
                                            $comb = $comb_tarjeta;
                                        endif;?>
                                        <input type="hidden" name="comb_tarjeta" value="<?php if(isset($comb)){ echo $comb; }?>"/> 
                                <div class="form-actions span12">
                                    <label style="float: left; padding: 8px 5px 0px 0px;">Cantidad de combustible: </label>
                                    <input type="text" id="cant_combustible" name="cant_combustible" style="margin: 5px" <?php if(!isset($b) || (isset($listado) && count($listado)==0)): ?>disabled="disabled"<?php endif;?>/>
                                    <a id="habilitar" <?php if(!isset($b) || (isset($listado) && count($listado)==0)){ echo 'class="btn btn-success disabled"'; } else { echo 'class="btn btn-success" onclick="habilitar()"'; }?>><i class="icon-download"></i> Habilitar</a>
                                    <a class="btn btn-danger" href="<?php echo base_url()?>"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                                </div>
                                </form>
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
    $(".datepicker").datepicker();
    
    $(".reset").click(function() {
        location.href = '<?php echo base_url() ?>combustible/habilitar';
    }); 
    
    function listar_tarjetas() {
        var form1 = document.getElementById('form_1');
        form1.submit(); 
    }
    
    function listar_recorridos() {
        var form2 = document.getElementById('form_2');
        form2.submit(); 
    }
    
    function habilitar() {
        var form3 = document.getElementById('form_3');
        form3.submit(); 
    }
    
    $(document).ready(function(){
       $("#selec_todo").prop("checked", false); 
       $(".selec_fila").prop("checked", false); 
    });
    
    $("#selec_todo").click(function(){        
        var caja = document.getElementById('selec_todo');            
        if(caja.getAttribute('class')=='no') {
            $(".selec_fila").prop("checked", true);
            $(".selec_fila").closest('tr').addClass('success');
            caja.className = 'si';
            caja.setAttribute('title','Desmarcar todos');
        } 
        else if(caja.getAttribute('class')=='si') {
            $(".selec_fila").prop("checked", false);
            $(".selec_fila").closest('tr').removeClass('success');
            caja.className = 'no';
            caja.setAttribute('title','Marcar todos');
        }   
    });
    
    $(".selec_fila").click(function(){ 
        if ($(this).is(':checked')) {
          $(this).closest('tr').addClass('success');
        } else {
          $(this).closest('tr').removeClass('success');
        }
    });
</script>

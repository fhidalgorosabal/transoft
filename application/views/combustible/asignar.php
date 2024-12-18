<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header"><?php if(isset($titulo)){echo $titulo;}?></h2>
            <div class="row-striped">
                <div class="block-content"> 
                    <?php if (isset($mensaje) && $mensaje==true): ?>           
                        <div id="ok" class="alert alert-success alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <p>
                                <i class="icon-checkmark"></i>&nbsp; ¡ Se ha realizado la operaci&oacute;n satisfactoriamente !
                            </p>    
                        </div>  
                    <?php endif; ?>           
                    <div id="error" class="hidden">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <h4 class="alert-heading"><i class="icon-cancel"></i> ¡Datos incorrectos!</h4>
                        <p>
                            ¡ El campo < Tarjetas asignadas > debe contener al menos un elemento !
                        </p>    
                    </div>  
                </div>
                <div class="block-content collapse in">
                    <div class="table-toolbar">
                        <form method="post" id="form_1" action="<?php echo base_url() ?>combustible/asignar_tarjetas" class="form-search">
                        <div class="search-controls">    
                            <label class="search-label">Carro: 
                                <div class="input-prepend input-append">
                                    <span class="add-on">
                                        <span data-original-title="Carro" class="icon-search hasTooltip"></span>						
                                    </span>
                                    <select name="carro">                                                        
                                    <?php foreach($carros as $value): ?>
                                        <option value="<?php echo $value->id_carro ?>" <?php if(isset($carro_select) && $value->id_carro==$carro_select):?> selected="selected" <?php endif;?> onclick="buscar()">
                                            <?php echo $value->chapa ?>
                                        </option>
                                    <?php endforeach;?>
                                    </select>  
                                </div>    
                            </label>  
                        </div>
                        </form>
                    </div>
                    <form method="post" action="<?php echo base_url() ?>combustible/asignar_post" name="asignar_tarjetas" id="asignar_tarjetas" class="form-horizontal">
                        <div class="span12" style="margin-top: 10px">
                            <div class="span0"></div>
                            <div class="span5">
                                <h4>Listado de tarjetas</h4>
                                <select id="list_tarjetas" name="list_tarjetas" size="10" style="width: 100%;">  
                                    <?php foreach ($tarjetas as $value): ?>
                                        <option value="<?php echo $value->id_tarjeta?>"><?php echo $value->codigo_tarjeta?></option>
                                <?php endforeach; ?>    
                                </select> 
                            </div>
                            <div class="span1" style="padding-left: 1%">                            
                                <a class="btn btn-info tooltip-bottom" style="margin-top: 98px" data-original-title="Agregar" onclick="agregar()"><i class="icon-next"></i></a> 
                                <a class="btn btn-danger tooltip-bottom" style="margin-top: 15px" data-original-title="Quitar" onclick="quitar()"><i class="icon-previous"></i></a> 
                            </div>
                            <div class="span5">
                                <h4>Tarjetas asignadas</h4>
                                <select id="tarjetas_asig" name="tarjetas_asig[]" multiple="multiple" size="10" style="width: 100%;">             
                                <?php foreach ($tarjetas_carro as $value): ?>
                                        <option value="<?php echo $value->id_tarjeta?>"><?php echo $value->codigo_tarjeta?></option>
                                <?php endforeach; ?>
                                </select> 
                            </div>
                            <input type="hidden" name="carro" value="<?php if(isset($carro_select)){ echo $carro_select; }?>"/>
                        </div> 
                        <div class="form-actions span12" style="margin-left: 0px">
                            <a class="btn btn-success" onclick="enviar()"><i class="icon-floppy"></i> Guardar</a>
                            <a class="btn btn-danger" href="<?php echo base_url()?>"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                        </div>
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
    
    function enviar() {
        var form2 = document.getElementById('asignar_tarjetas');
        var tarjetas_asig = document.getElementById('tarjetas_asig');
        if(tarjetas_asig.length != 0) {
        for (var i = 0; i < tarjetas_asig.length; i++) {
            var tarjeta = tarjetas_asig.options[i];
            tarjeta.selected = "selected";
        }  
        form2.submit();
        }
        else
            error();
    }
    
    function error() {
        var error = document.getElementById('error');
        error.className = 'alert alert-error alert-block';
        var ok = document.getElementById('ok');
        ok.className = 'hidden';
    }
    
    function agregar() {
        var list_tarjetas = document.getElementById('list_tarjetas');
        var tarjetas_asig = document.getElementById('tarjetas_asig');
        if(list_tarjetas.value != '') {
            var opcion = document.createElement('option');
            opcion.appendChild(document.createTextNode(list_tarjetas.options[list_tarjetas.selectedIndex].text));
            opcion.value = list_tarjetas.options[list_tarjetas.selectedIndex].value;
            tarjetas_asig.appendChild(opcion);
            list_tarjetas.removeChild(list_tarjetas.options[list_tarjetas.selectedIndex]);
        }
        else {
            alert('\xa1Seleccione un elemento del listado de tarjetas!');
        }
    }
    
    function quitar() {
        var list_tarjetas = document.getElementById('list_tarjetas');
        var tarjetas_asig = document.getElementById('tarjetas_asig');
        if(tarjetas_asig.value != '') {
            var opcion = document.createElement('option');
            opcion.appendChild(document.createTextNode(tarjetas_asig.options[tarjetas_asig.selectedIndex].text));
            opcion.value = tarjetas_asig.options[tarjetas_asig.selectedIndex].value;
            list_tarjetas.appendChild(opcion);
            tarjetas_asig.removeChild(tarjetas_asig.options[tarjetas_asig.selectedIndex]);
        }
        else {
            alert('\xa1Seleccione un elemento del listado de tarjetas asignadas!');
        }
    }
</script>

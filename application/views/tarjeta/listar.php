<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Listado de las Tarjetas de Combustible:</h2>
            <div class="row-striped">
                <div class="table-toolbar">
                    <div class="btn-group">
                        <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                        <a href="<?php echo base_url()?>tarjeta/insertar" class="btn btn-success"><i class="icon-plus-2 smaller"></i> Adicionar</a>
                        <?php endif;?>
                    </div> 
                    <div class="pull-right">
                        <a id="buscar" class="btn" onclick="buscar()" href="#">
                            <i class="icon-search fg-darkBlue"></i> Buscar 
                            <?php if((isset($codigo_b) && $codigo_b!='') || (isset($combustible_b) && $combustible_b!='') || (isset($credito_b) && $credito_b!='')):?><i id="lamp" class="icon-lamp fg-yellow" style="margin-right: -8px"></i><?php endif; ?>
                        </a>
                        <a class="btn" <?php if(count($listado)>0): ?>href="<?php echo base_url() ?>tarjeta/exportar/<?php if(isset($codigo_b) && !empty($codigo_b)): echo $codigo_b; else: echo 'NULL'; endif; ?>/<?php if(isset($combustible_b) && !empty($combustible_b)): echo $combustible_b; else: echo 'NULL'; endif; ?>/<?php if(isset($credito_b) && !empty($credito_b)): echo $credito_b; else: echo 'NULL'; endif; ?>"<?php else: ?>href="#"<?php endif;?>>
                            <i class="icon-file-excel fg-darkGreen"></i> Exportar a Excel
                        </a>                        
                    </div>
                </div>  
                <?php if (isset($delete) && !empty($delete)): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>tarjeta">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; <?php echo $delete ?>
                        </p>    
                    </div>                   
                <?php elseif(isset($error) && !empty($error)):?>
                    <div class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>tarjeta">&times;</a>
                        <h4 class="alert-heading"><i class="icon-cancel"></i> <?php echo $error;?> </h4>  
                        <p>
                            Esta tarjeta ha sido asignada a un carro, <a href="<?php echo base_url() ?>combustible/asignar_tarjetas"> si desea puede modificar esta asignación</a>.
                        </p>
                    </div>
                <?php endif;?>  
                <form method="post" action="<?php echo base_url() ?>tarjeta/buscar" id="form_buscar">                       
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                    <thead id="cabecera">
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Tipo de combustible</th>
                            <th>Cr&eacute;dito de la tarjeta</th>
                            <th>Cantidad de combustible</th>
                            <th class="nosorting-2"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($listado)>0): ?>  
                    <?php foreach($listado as $tarjeta): ?>
                        <tr>
                            <td> <?php echo $tarjeta->codigo_tarjeta ?> </td>
                            <td> <?php echo $tarjeta->tipo_combustible ?> </td>
                            <td> <?php echo '$ '; $this->my_functions->m($this->my_functions->n($tarjeta->credito)) ?> </td>
                            <td> <?php
                            if($tarjeta->tipo_combustible=='Diesel')
                                $litros=$tarjeta->credito/$diesel;
                            else
                                $litros=$tarjeta->credito/$gasolina;
                            $this->my_functions->m($this->my_functions->n($litros)); echo ' Lts'; 
                            ?> </td>
                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                            <td class="btn-group span1">
                                <a class="btn btn-info btn-right tooltip-bottom" href="<?php echo base_url() ?>tarjeta/modificar/<?php echo $tarjeta->id_tarjeta ?>" data-original-title="Editar">
                                   <i class="icon-pencil"></i> 
                                </a>
                                <a class="btn btn-danger btn-left eliminar_tarjeta tooltip-bottom" href="<?php echo base_url() ?>tarjeta/eliminar/<?php echo $tarjeta->id_tarjeta ?>" data-original-title="Eliminar">
                                    <i class="icon-remove"></i> 
                                </a> 
                            </td>
                            <?php else: ?>
                            <td>&nbsp;</td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach; ?>  
                    <?php else: ?> 
                    <div class="alert alert-heading alert-block">
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                        <p>
                            <i class="icon-warning large"></i> ¡ La tabla est&aacute; vac&iacute;a, no hay elementos para mostrar !
                        </p>    
                    </div>     
                    <?php endif;?>     
                    </tbody>
                </table>
                </form>    
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/DT_bootstrap.js"></script>
<script type="text/javascript">
   $(".eliminar_tarjeta").each(function() {
      var href = $(this).attr('href');
      $(this).attr('href', 'javascript:void(0)');
      $(this).click(function() {
         if (confirm("¿Seguro que desea eliminar esta tarjeta?")) {
            location.href = href;
         }
      });
   });
   function buscar() {       
       var thead = document.getElementById('cabecera');     
              
       var tr = document.createElement('tr');
       tr.setAttribute('id','busqueda');
       
       var td_1 = document.createElement('td');
       var td_2 = document.createElement('td');
       var td_3 = document.createElement('td');
       var td_4 = document.createElement('td');
       var td_5 = document.createElement('td');
       td_5.className ='btn-group ';
       
       var input_1 = document.createElement('input');
        input_1.setAttribute('type','text');
        input_1.setAttribute('name','codigo');
        input_1.setAttribute('value','<?php if(isset($codigo_b)): echo $codigo_b; endif; ?>');
        input_1.className = 'span12';
                
        var input_2 = document.createElement('input');
        input_2.setAttribute('type','text');
        input_2.setAttribute('name','combustible');
        input_2.setAttribute('value','<?php if(isset($combustible_b)): echo $combustible_b; endif; ?>');
        input_2.className = 'span12';
        
        var input_3 = document.createElement('input');
        input_3.setAttribute('type','text');
        input_3.setAttribute('name','credito');
        input_3.setAttribute('value','<?php if(isset($credito_b)): echo $credito_b; endif; ?>');
        input_3.className = 'span12';
                              
        var buscar = document.createElement('button');
        buscar.setAttribute('name','buscar');
        buscar.setAttribute('data-original-title','Buscar');
        buscar.className = 'btn btn-primary btn-right tooltip-bottom';
        
        var icono1 = document.createElement('i');
        icono1.className = 'icon-search';
        
        var limpiar = document.createElement('a');
        limpiar.setAttribute('data-original-title','Resetear');
        limpiar.setAttribute('onclick','reset()');
        limpiar.className = 'btn btn-left tooltip-bottom';
        
        var icono2 = document.createElement('i');
        icono2.className = 'icon-cycle';
        
        buscar.appendChild(icono1); 
        limpiar.appendChild(icono2); 
        
        td_1.appendChild(input_1);
        td_2.appendChild(input_2);
        td_3.appendChild(input_3);
        td_5.appendChild(buscar);
        td_5.appendChild(limpiar);
        
        tr.appendChild(td_1);
        tr.appendChild(td_2);
        tr.appendChild(td_3);
        tr.appendChild(td_4);
        tr.appendChild(td_5);
        
        thead.appendChild(tr);       
                
        var b = document.getElementById('buscar');
        b.setAttribute('onclick','cerrar()');
        $('.tooltip-bottom').tooltip({ placement: 'bottom' }); 
    }
        
    function reset() {
        var campos = document.getElementsByTagName('input');
        for(var i=0; i<campos.length; i++) {
            campos[i].setAttribute('value','');
        }
        var form = document.getElementById('form_buscar');
        form.reset();
        form.submit();        
    }
    
    function cerrar() {
        var thead = document.getElementById('cabecera');
        var tr = document.getElementById('busqueda');
        thead.removeChild(tr);
        
        var b = document.getElementById('buscar');    
        b.setAttribute('onclick','buscar()');
    }
</script>
<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Listado de los carros</h2>
            <div class="row-striped">
                <div class="table-toolbar">
                    <div class="btn-group">
                        <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                        <a href="<?php echo base_url()?>carro/insertar" class="btn btn-success"><i class="icon-plus-2 smaller"></i> Adicionar</a>
                        <?php endif;?>
                    </div> 
                    <div class="pull-right">
                        <a id="buscar" class="btn" onclick="buscar()" href="#">
                            <i class="icon-search fg-darkBlue"></i> Buscar
                            <?php if((isset($codigo_b) && $codigo_b!='') || (isset($chapa_b) && $chapa_b!='') || (isset($marca_b) && $marca_b!='') || (isset($tipo_b) && $tipo_b!='') || (isset($estado_b) && $estado_b!='') || (isset($tipo_combustible_b) && $tipo_combustible_b!='')):?><i id="lamp" class="icon-lamp fg-yellow" style="margin-right: -8px"></i><?php endif; ?>
                        </a>
                        <a class="btn" <?php if(count($listado)>0): ?>href="<?php echo base_url() ?>carro/exportar/<?php if(isset($codigo_b) && !empty($codigo_b)): echo $codigo_b; else: echo 'NULL'; endif; ?>/<?php if(isset($chapa_b) && !empty($chapa_b)): echo $chapa_b; else: echo 'NULL'; endif; ?>/<?php if(isset($marca_b) && !empty($marca_b)): echo $marca_b; else: echo 'NULL'; endif; ?>/<?php if(isset($tipo_b) && !empty($tipo_b)): echo $tipo_b; else: echo 'NULL'; endif; ?>/<?php if(isset($estado_b) && !empty($estado_b)): echo $estado_b; else: echo 'NULL'; endif; ?>/<?php if(isset($tipo_combustible_b) && !empty($tipo_combustible_b)): echo $tipo_combustible_b; else: echo 'NULL'; endif; ?>"<?php else: ?>href="#"<?php endif;?>>
                            <i class="icon-file-excel fg-darkGreen"></i> Exportar a Excel
                        </a>                        
                    </div>
                </div>  
                <?php if (isset($delete) && !empty($delete)): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>carro">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; <?php echo $delete ?>
                        </p>    
                    </div>  
                <?php endif; ?>  
                <form method="post" action="<?php echo base_url() ?>carro/buscar" id="form_buscar">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">                
                <thead id="cabecera"> 
                    <tr>
                        <th>C&oacute;digo</th>
                        <th>Chapa</th>
                        <th>Marca</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Combustible</th>
                        <th class="nosorting"> Acciones </th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($listado)>0): ?>                        
                <?php foreach($listado as $carro): ?>
                    <tr>
                        <td> <?php echo $carro->codigo ?> </td>
                        <td> <?php echo $carro->chapa ?> </td>
                        <td> <?php echo $carro->marca ?> </td>
                        <td> <?php echo $carro->tipo ?> </td>
                        <td> <?php echo $carro->estado_tecnico ?> </td>
                        <td> <?php echo $carro->tipo_combustible ?> </td>
                        <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                        <td class="btn-group span1">
                            <a class="btn btn-right tooltip-bottom" href="<?php echo base_url() ?>carro/ver/<?php echo $carro->id_carro ?>" data-original-title="Ver">
                               <i class="icon-eye"></i> 
                            </a>
                            <a class="btn btn-info btn-all tooltip-bottom" href="<?php echo base_url() ?>carro/modificar/<?php echo $carro->id_carro ?>" data-original-title="Editar">
                               <i class="icon-pencil"></i> 
                            </a>
                            <a class="btn btn-danger btn-left eliminar_carro tooltip-bottom" href="<?php echo base_url() ?>carro/eliminar/<?php echo $carro->id_carro ?>" data-original-title="Eliminar">
                                <i class="icon-remove"></i> 
                            </a> 
                        </td>
                        <?php else: ?>
                        <td class="btn-group span1">
                            <a class="btn tooltip-bottom" href="<?php echo base_url() ?>carro/ver/<?php echo $carro->id_carro ?>" data-original-title="Ver">
                               <i class="icon-eye"></i> Ver
                            </a>
                        </td>
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
   $(".eliminar_carro").each(function() {
      var href = $(this).attr('href');
      $(this).attr('href', 'javascript:void(0)');
      $(this).click(function() {
         if (confirm("¿Seguro que desea eliminar este carro?")) {
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
       var td_6 = document.createElement('td');
       var td_7 = document.createElement('td');
       td_7.className ='btn-group ';
       
       var input_1 = document.createElement('input');
        input_1.setAttribute('type','text');
        input_1.setAttribute('name','codigo');
        input_1.setAttribute('value','<?php if(isset($codigo_b)): echo $codigo_b; endif; ?>');
        input_1.className = 'span12';
        
        var input_2 = document.createElement('input');
        input_2.setAttribute('type','text');
        input_2.setAttribute('name','chapa');
        input_2.setAttribute('value','<?php if(isset($chapa_b)): echo $chapa_b; endif; ?>');
        input_2.className = 'span12';
        
        var input_3 = document.createElement('input');
        input_3.setAttribute('type','text');
        input_3.setAttribute('name','marca');
        input_3.setAttribute('value','<?php if(isset($marca_b)): echo $marca_b; endif; ?>');
        input_3.className = 'span12';
        
        var input_4 = document.createElement('input');
        input_4.setAttribute('type','text');
        input_4.setAttribute('name','tipo');
        input_4.setAttribute('value','<?php if(isset($tipo_b)): echo $tipo_b; endif; ?>');
        input_4.className = 'span12';
        
        var input_5 = document.createElement('input');
        input_5.setAttribute('type','text');
        input_5.setAttribute('name','estado');
        input_5.setAttribute('value','<?php if(isset($estado_b)): echo $estado_b; endif; ?>');
        input_5.className = 'span12';
        
        var input_6 = document.createElement('input');
        input_6.setAttribute('type','text');
        input_6.setAttribute('name','tipo_combustible');
        input_6.setAttribute('value','<?php if(isset($tipo_combustible_b)): echo $tipo_combustible_b; endif; ?>');
        input_6.className = 'span12';
        
        var buscar = document.createElement('button');
        buscar.setAttribute('name','buscar');
        buscar.setAttribute('data-original-title','Buscar');
        buscar.setAttribute('style','padding: 4px 22px');
        buscar.className = 'btn btn-primary btn-right tooltip-bottom';
        
        var icono1 = document.createElement('i');
        icono1.className = 'icon-search';
        
        var limpiar = document.createElement('a');
        limpiar.setAttribute('data-original-title','Resetear');
        limpiar.setAttribute('style','padding: 4px 21px');
        limpiar.setAttribute('onclick','reset()');
        limpiar.className = 'btn btn-left tooltip-bottom';
        
        var icono2 = document.createElement('i');
        icono2.className = 'icon-cycle';
        
        buscar.appendChild(icono1); 
        limpiar.appendChild(icono2); 
        
        td_1.appendChild(input_1);
        td_2.appendChild(input_2);
        td_3.appendChild(input_3);
        td_4.appendChild(input_4);
        td_5.appendChild(input_5);
        td_6.appendChild(input_6);
        td_7.appendChild(buscar);
        td_7.appendChild(limpiar);
        
        tr.appendChild(td_1);
        tr.appendChild(td_2);
        tr.appendChild(td_3);
        tr.appendChild(td_4);
        tr.appendChild(td_5);
        tr.appendChild(td_6);
        tr.appendChild(td_7);
        
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
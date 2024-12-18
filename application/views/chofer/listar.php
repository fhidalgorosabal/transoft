<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Listado de los choferes</h2>
            <div class="row-striped">
                <div class="table-toolbar">
                    <div class="btn-group">
                        <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                        <a href="<?php echo base_url()?>chofer/insertar" class="btn btn-success"><i class="icon-plus-2 smaller"></i> Adicionar</a>
                        <?php endif;?>
                    </div> 
                    <div class="pull-right">
                        <a id="buscar" class="btn" onclick="buscar()" href="#">
                            <i class="icon-search fg-darkBlue"></i> Buscar 
                            <?php if((isset($ci_b) && $ci_b!='') || (isset($nombre_b) && $nombre_b!='') || (isset($apellidos_b) && $apellidos_b!='') || (isset($licencia_b) && $licencia_b!='')):?><i id="lamp" class="icon-lamp fg-yellow" style="margin-right: -8px"></i><?php endif; ?>
                        </a>
                        <a class="btn" <?php if(count($listado)>0): ?>href="<?php echo base_url() ?>chofer/exportar/<?php if(isset($ci_b) && !empty($ci_b)): echo $ci_b; else: echo 'NULL'; endif; ?>/<?php if(isset($nombre_b) && !empty($nombre_b)): echo $nombre_b; else: echo 'NULL'; endif; ?>/<?php if(isset($apellidos_b) && !empty($apellidos_b)): echo $apellidos_b; else: echo 'NULL'; endif; ?>/<?php if(isset($licencia_b) && !empty($licencia_b)): echo $licencia_b; else: echo 'NULL'; endif; ?>"<?php else: ?>href="#"<?php endif;?>>
                            <i class="icon-file-excel fg-darkGreen"></i> Exportar a Excel
                        </a>                        
                    </div>
                </div>
                <?php if (isset($delete) && !empty($delete)): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>chofer">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; <?php echo $delete ?>
                        </p>    
                    </div>  
                <?php endif; ?>
                <form method="post" action="<?php echo base_url() ?>chofer/buscar" id="form_buscar">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                    <thead id="cabecera">
                        <tr>
                            <th>CI</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Licencia</th>
                            <th class="nosorting-2"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($listado)>0): ?> 
                    <?php foreach($listado as $chofer): ?>
                        <tr>
                            <td> <?php echo $chofer->ci ?> </td>
                            <td> <?php echo $chofer->nombre_chf ?> </td>
                            <td> <?php echo $chofer->apellidos?> </td>
                            <td> <?php echo $chofer->codigo_licencia?> </td>
                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                            <td class="btn-group span1">
                                <a class="btn btn-info btn-right tooltip-bottom" href="<?php echo base_url() ?>chofer/modificar/<?php echo $chofer->id_chofer ?>" data-original-title="Editar">
                                    <i class="icon-pencil"></i> 
                                </a>
                                <a class="btn btn-danger btn-left eliminar_chofer tooltip-bottom" href="<?php echo base_url() ?>chofer/eliminar/<?php echo $chofer->id_chofer ?>" data-original-title="Eliminar">
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
   $(".eliminar_chofer").each(function() {
      var href = $(this).attr('href');
      $(this).attr('href', 'javascript:void(0)');
      $(this).click(function() {
         if (confirm("¿Seguro que desea eliminar este chofer?")) {
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
        input_1.setAttribute('name','ci');
        input_1.setAttribute('value','<?php if(isset($ci_b)): echo $ci_b; endif; ?>');
        input_1.className = 'span12';
        
        var input_2 = document.createElement('input');
        input_2.setAttribute('type','text');
        input_2.setAttribute('name','nombre');
        input_2.setAttribute('value','<?php if(isset($nombre_b)): echo $nombre_b; endif; ?>');
        input_2.className = 'span12';
        
        var input_3 = document.createElement('input');
        input_3.setAttribute('type','text');
        input_3.setAttribute('name','apellidos');
        input_3.setAttribute('value','<?php if(isset($apellidos_b)): echo $apellidos_b; endif; ?>');
        input_3.className = 'span12';
        
        var input_4 = document.createElement('input');
        input_4.setAttribute('type','text');
        input_4.setAttribute('name','licencia');
        input_4.setAttribute('value','<?php if(isset($licencia_b)): echo $licencia_b; endif; ?>');
        input_4.className = 'span12';
                              
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
        td_4.appendChild(input_4);
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
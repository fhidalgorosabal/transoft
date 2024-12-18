<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Listado de los choferes de baja</h2>
            <div class="row-striped">
                <div class="table-toolbar"> 
                    <div class="btn-group">
                        <a class="btn" href="<?php echo base_url() ?>chofer">
                            <i class="icon-arrow-left fg-lightBlue"></i> Ir al listado
                        </a>
                    </div>
                    <div class="pull-right">                        
                        <a class="btn" <?php if(count($listado)>0): ?>href="<?php echo base_url() ?>chofer/exportar_bajas"<?php else:?>href="#"<?php endif;?>>
                            <i class="icon-file-excel fg-darkGreen"></i> Exportar a Excel
                        </a>                        
                    </div>
                </div>
                <?php if (isset($delete) && !empty($delete)): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>chofer/baja">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; <?php echo $delete ?>
                        </p>    
                    </div> 
                <?php elseif(isset($restaurar) && !empty($restaurar)):?>
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>chofer/baja">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; <?php echo $restaurar ?>
                        </p>    
                    </div>
                <?php elseif(isset($error) && !empty($error)):?>
                    <div class="alert alert-error alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>chofer/baja">&times;</a>
                        <h4 class="alert-heading"><i class="icon-cancel"></i> <?php echo $error;?> </h4>  
                        <p>
                            Los datos de este chofer est&aacute;n siendo usados, si se elimina afectaría información registrada en la BD.
                        </p>
                    </div>
                <?php endif;?>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                    <thead>
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
                            <td class="btn-group span1">                                
                                <a class="btn btn-success btn-right tooltip-bottom" href="<?php echo base_url() ?>chofer/restaurar/<?php echo $chofer->id_chofer ?>" data-original-title="Restaurar">
                                   <i class="icon-undo"></i> 
                                </a>
                                <a class="btn btn-danger btn-left eliminar_chofer tooltip-bottom" href="<?php echo base_url() ?>chofer/eliminar_baja/<?php echo $chofer->id_chofer ?>" data-original-title="Eliminar">
                                    <i class="icon-remove"></i> 
                                </a> 
                            </td>
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
</script>
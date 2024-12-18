<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
	<h2 class="module-title box-header">Listado de Recorridos Habilitados:</h2>
            <div class="row-striped">
                <div class="table-toolbar">
                    <div class="btn-group">
                        <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                        <a href="<?php echo base_url()?>combustible/habilitar" class="btn btn-success">
                            <i class="icon-download"></i> Habilitar
                        </a>
                        <?php endif;?>
                    </div> 
                    <div class="pull-right">
                        &nbsp;
                    </div>
                </div>  
                <?php if (isset($delete) && !empty($delete)): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>combustible">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; <?php echo $delete ?>
                        </p>    
                    </div>
                <?php endif;?>  
                <form method="post" action="<?php echo base_url() ?>combustible/buscar" id="form_buscar">                       
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                    <thead id="cabecera">
                        <tr>
                            <th>Fecha</th>
                            <th>Carro</th>
                            <th>Tarjeta</th>
                            <th>No. Hoja de Ruta</th>
                            <th>Cant. Combustible</th>
                            <th class="nosorting-2"> Acci&oacute;n </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($listado)>0): ?>  
                    <?php foreach($listado as $habilitado): ?>
                        <tr>
                            <td> <?php $this->my_functions->fecha($habilitado->fecha) ?> </td>
                            <td> <?php echo $habilitado->chapa ?> </td>
                            <td> <?php echo $habilitado->codigo_tarjeta ?> </td>
                            <td> <?php echo $habilitado->numero_hoja_ruta ?> </td>
                            <td> <?php $this->my_functions->m($this->my_functions->n($habilitado->cantidad_combustible)) ?> </td>
                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                            <td class="btn-group span1">                                
                                <a class="btn btn-danger eliminar_habilitado tooltip-bottom" href="<?php echo base_url() ?>combustible/eliminar/<?php echo $habilitado->id_habilitar ?>" data-original-title="Eliminar">
                                    <i class="icon-remove"></i> Eliminar
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
   $(".eliminar_habilitado").each(function() {
      var href = $(this).attr('href');
      $(this).attr('href', 'javascript:void(0)');
      $(this).click(function() {
         if (confirm("¿Seguro que lo desea eliminar, tenga en cuenta que afectará información registrada en la BD?")) {
            location.href = href;
         }
      });
   });    
</script>
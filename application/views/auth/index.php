<div style="margin-bottom: 60px"></div>
<div class="container-fluid container-main">     
    <section id="content">
        <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="well well-small">
                <h2 class="module-title box-header">Listado de los <?php echo lang('index_heading');?></h2>
                    <div class="row-striped">
                        <div class="table-toolbar">
                            <div class="btn-group">
                                <a href="<?php echo base_url()?>auth/create_user" class="btn btn-success"><i class="icon-plus-2 smaller"></i> Adicionar</a>
                            </div>
                        </div>
                        <?php 
                        function depurar1($mensaje) {
                            $array = preg_split('/(##)/', $mensaje);
                            if(count($array)>1)
                                echo $array[1];
                            else
                                echo $mensaje;
                        }
                        function depurar2($mensaje) {
                            $array = preg_split('/(<p>)/', $mensaje);
                            echo $array[0].'<i class="icon-checkmark"></i>&nbsp;&nbsp;'.$array[1];
                        }
                        ?>
                        <?php if ($message == "<p>##No se puede desactivar una cuenta en uso##</p>"): ?>
                            <div class="alert alert-error">
                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                <h4 class="alert-heading"><i class="icon-cancel"></i> ¡Error!</h4>
                                <?php depurar1($message); ?>
                            </div>
                        <?php elseif ($message != ""): ?>
                            <div class="alert alert-success">
                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                    <?php depurar2($message); ?>
                            </div> 
                        <?php endif; ?>
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                            <thead id="cabecera">
                                <tr>
                                    <th><?php echo lang('index_fname_th');?></th>
                                    <th><?php echo lang('index_lname_th');?></th>
                                    <th>Rol</th>
                                    <th><?php echo lang('index_status_th');?></th>
                                    <th class="nosorting-2"> Acciones </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(count($users)>0): ?> 
                            <?php foreach ($users as $user):?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                                    <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                                    <td>
                                    <?php foreach ($user->groups as $group):?>
                                        <?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?><br />
                                    <?php endforeach?>
                                    </td>
                                    <td>
                                        <?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'), ' class="label label-success tooltip-bottom" data-original-title="Desactivar"') : anchor("auth/activate/". $user->id, lang('index_inactive_link'), ' class="label label-important tooltip-bottom" data-original-title="Activar"');?>
                                    </td>
                                    <td class="btn-group span1">
                                        <a class="btn btn-info btn-right tooltip-bottom" href="<?php echo base_url() ?>auth/edit_user/<?php echo $user->id ?>" data-original-title="Editar">
                                            <i class="icon-pencil"></i> 
                                         </a>
                                         <a class="btn btn-danger btn-left eliminar_usuario tooltip-bottom" href="<?php echo base_url() ?>auth/delete_user/<?php echo $user->id ?>" data-original-title="Eliminar">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</div>    
<script src="<?php echo base_url()?>vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/DT_bootstrap.js"></script>
<script type="text/javascript">
   $(".eliminar_usuario").each(function() {
      var href = $(this).attr('href');
      $(this).attr('href', 'javascript:void(0)');
      $(this).click(function() {
         if (confirm("¿Seguro que desea eliminar este usuario?")) {
            location.href = href;
         }
      });
   }); 
   $(".label-success").each(function() {
      var href = $(this).attr('href');
      $(this).attr('href', 'javascript:void(0)');
      $(this).click(function() {
         if (confirm("¿Seguro que desea desactivar este usuario?")) {
            location.href = href;
         }
      });
   }); 
</script>
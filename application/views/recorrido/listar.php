<div class="span12">
    <div class="row-fluid">
	<div class="well well-small">
            <h2 class="module-title box-header">Recorridos ( <?php echo $actividad->nombre_act ?> )</h2>
            <div class="row-striped">
                <div class="table-toolbar">
                    <div class="btn-group">
                        <form method="post" id="form_1" action="<?php echo base_url() ?>recorrido/listar_post" class="form-search">
                            <div class="search-controls">    
                            <label class="search-label">Carro: 
                                <div class="input-prepend input-append">
                                    <span class="add-on">
                                    <span data-original-title="Carro" class="icon-search hasTooltip"></span>						
                                    </span>
                                    <select name="carro">
                                    <?php foreach($carros as $value): ?>
                                        <option value="<?php echo $value->id_carro ?>" <?php if($value->id_carro==$selected):?> selected="selected" <?php endif;?> onclick="buscar()">
                                            <?php echo $value->chapa ?>
                                        </option>
                                    <?php endforeach;?>
                                    </select>  
                                </div>    
                                <input type="hidden" name="actividad" value="<?php echo $actividad->id_actividad ?>"/>
                            </label>  
                            </div>
                        </form>
                    </div> 
                    <div class="pull-right">
                        <a class="btn" <?php if(count($listado)>0): ?>href="<?php echo base_url() ?>recorrido/exportar/<?php echo $actividad->id_actividad ?>/<?php echo $selected ?>"<?php else: ?>href="#"<?php endif;?>>
                            <i class="icon-file-excel fg-darkGreen"></i> Exportar a Excel
                        </a>                        
                    </div>
                </div>
                <?php if (isset($delete) && !empty($delete)): ?>           
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="<?php echo base_url() ?>recorrido/listar/<?php echo $actividad->id_actividad ?>/<?php echo $selected ?>">&times;</a>
                        <p>
                            <i class="icon-checkmark"></i>&nbsp; <?php echo $delete ?>
                        </p>    
                    </div>
                <?php endif;?>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" <?php if(count($listado)>0): ?>id="example2"<?php else:?>id="example1"<?php endif;?>>
                    <thead>
                        <tr class="reporte">
                            <th><label class="tooltip-bottom" data-original-title="Fecha">Fecha</label></th>
                            <th><label class="tooltip-bottom" data-original-title="Hoja Ruta">Hoja Ruta</label></th>
                            <th><label class="tooltip-bottom" data-original-title="Viajes con Carga">Viajes Carga</label></th> 
                            <th><label class="tooltip-bottom" data-original-title="Distancia Total">Dist. Total</label></th>
                            <th><label class="tooltip-bottom" data-original-title="Distancia con Carga">Dist. Carga</label></th>
                            <th><label class="tooltip-bottom" data-original-title="Carga Transportada">Carga Transp.</label></th>
                            <th><label class="tooltip-bottom" data-original-title="Tráfico Producido">Tráf. Prod.</label></th>                            
                            <!--<th>Comb. Hablitado</th>--> 
                            <th><label class="tooltip-bottom" data-original-title="Consumo de Combustible">Cons. Comb</label></th> 
                            <!--<th>Comb. Tanque</th>-->
                            <!--<th>Carga Posible</th>-->
                            <th><label class="tooltip-bottom" data-original-title="Aprovechamiento de la Capacidad">Aprov. Cap.</label></th>
                            <th><label class="tooltip-bottom" data-original-title="Aprovechamiento del Recorrido">Aprov. Rec.</label></th>
                            <th><label class="tooltip-bottom" data-original-title="Intensidad Energética">Intens. Energ.</label></th>                            
                            <th class="nosorting-2"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>  
                    <?php $total_v=$total_dt=$total_dc=$total_ct=$total_tp=$total_cc=$total_cp=$total_ac=$total_ar=$total_ie=0?> 
                    <?php if(count($listado)>0): ?>   
                    <?php foreach($listado as $recorrido): ?>
                        <tr>
                            <td> <?php $this->my_functions->fecha($recorrido['fecha']) ?> </td>
                            <td> <?php echo $recorrido['numero_hoja_ruta'] ?> </td>
                            <td> 
                            <?php $total_v+=$recorrido['viajes_carga']; echo $recorrido['viajes_carga']?> 
                            </td>  
                            <td><?php 
                                $total_dt+=$recorrido['distancia_total'];
                                $this->my_functions->m($this->my_functions->n($recorrido['distancia_total']))
                            ?></td>
                            <td><?php
                                $total_dc+=$recorrido['distancia_carga'];
                                $this->my_functions->m($this->my_functions->n($recorrido['distancia_carga']))
                            ?></td>
                            <td><?php
                                $total_ct+=$recorrido['carga_transportada'];
                                $this->my_functions->m($this->my_functions->n($recorrido['carga_transportada']))
                            ?></td>
                            <td><?php
                                $total_tp+=$recorrido['trafico_producido'];
                                $this->my_functions->m($this->my_functions->n($recorrido['trafico_producido']))
                            ?></td>
                            <!--<td></td>-->
                            <td><?php
                                $total_cc+=$recorrido['consumo_combustible'];
                                $this->my_functions->m($this->my_functions->n($recorrido['consumo_combustible']))
                            ?></td>
                            <!--<td></td>-->
                            <?php $carga_posible = $recorrido['viajes_carga'] * $recorrido['capacidad'];?>
                            <td><?php
                                if($carga_posible!=0)
                                    $ac=($recorrido['carga_transportada']/$carga_posible)* 100;
                                else
                                    $ac=0;
                                $total_ac+=$ac;
                                $this->my_functions->m($this->my_functions->n($ac));
                            ?></td>
                            <td><?php
                                if($recorrido['distancia_total']!=0)
                                    $ar=($recorrido['distancia_carga']/$recorrido['distancia_total'])* 100;
                                else
                                    $ar=0;
                                $total_ar+=$ar;
                                $this->my_functions->m($this->my_functions->n($ar)) 
                            ?></td>
                            <td><?php
                                if($recorrido['trafico_producido']!=0)
                                    $ie=$recorrido['consumo_combustible']/$recorrido['trafico_producido'];
                                else
                                    $ie=0;
                                $total_ie+=$ie;
                                $this->my_functions->m($this->my_functions->n($ie))
                            ?></td>
                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe'))): ?>
                            <td class="btn-group span1">
                                <a class="btn btn-right tooltip-bottom" href="<?php echo base_url() ?>recorrido/ver/<?php echo $recorrido['id_recorrido'].'/'.$actividad->id_actividad.'/'.$selected ?>" data-original-title="Ver">
                                   <i class="icon-eye"></i> 
                                </a>
                                <a class="btn btn-info btn-all tooltip-bottom" href="<?php echo base_url() ?>recorrido/modificar/<?php echo $recorrido['id_recorrido'].'/'.$actividad->id_actividad ?>" data-original-title="Editar">
                                   <i class="icon-pencil"></i> 
                                </a>
                                <a class="btn btn-danger btn-left eliminar_recorrido tooltip-bottom" href="<?php echo base_url() ?>recorrido/eliminar/<?php echo $recorrido['id_recorrido'].'/'.$actividad->id_actividad.'/'.$selected ?>" data-original-title="Eliminar">
                                    <i class="icon-remove"></i> 
                                </a> 
                            </td>
                            <?php else: ?>
                            <td>
                                <a class="btn tooltip-bottom" href="<?php echo base_url() ?>recorrido/ver/<?php echo $recorrido['id_recorrido'].'/'.$actividad->id_actividad.'/'.$selected ?>" data-original-title="Ver">
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
                            <i class="icon-warning large"></i> ¡ El criterio de b&uacute;squeda no coincide, no hay elementos que mostrar !
                        </p>    
                    </div> 
                    <tr> <td colspan="13">0 registros</td> </tr>
                    <?php endif;?>     
                    </tbody>
                    <tfoot>
                        <tr class="reporte">
                            <th colspan="2">Totales</th>
                            <th><?php $this->my_functions->m($this->my_functions->n($total_v)) ?></th>
                            <th><?php $this->my_functions->m($this->my_functions->n($total_dt)) ?></th>
                            <th><?php $this->my_functions->m($this->my_functions->n($total_dc)) ?></th>
                            <th><?php $this->my_functions->m($this->my_functions->n($total_ct)) ?></th>
                            <th><?php $this->my_functions->m($this->my_functions->n($total_tp)) ?></th>
                            <!--<th></th>-->
                            <th><?php $this->my_functions->m($this->my_functions->n($total_cc)) ?></th>
                            <!--<th></th>-->                            
                            <th><?php $this->my_functions->m($this->my_functions->n($total_ac)) ?></th>
                            <th><?php $this->my_functions->m($this->my_functions->n($total_ar)) ?></th>
                            <th><?php $this->my_functions->m($this->my_functions->n($total_ie)) ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/DT_bootstrap.js"></script>
<script type="text/javascript">
   $(".eliminar_recorrido").each(function() {
      var href = $(this).attr('href');
      $(this).attr('href', 'javascript:void(0)');
      $(this).click(function() {
         if (confirm("¿Seguro que desea eliminar este recorrido?")) {
            location.href = href;
         }
      });
   });

    function buscar() {
        var form1 = document.getElementById('form_1');
        form1.submit(); 
    }
</script> 
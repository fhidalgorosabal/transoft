                <?php
                    header("Content-type: application/x-msdownload");
                    header("Content-Disposition: attachment; filename=recorridos.xls");
                    header("Pragma: no-cache");
                    header("Expires: 0");
                ?>
                <table cellpadding="0" cellspacing="0" border="1">
                    <thead>
                        <tr class="reporte">
                            <th>Fecha</th>
                            <th>Hoja Ruta</th>
                            <th>Viajes Carga</th> 
                            <th>Dist. Total</th>
                            <th>Dist. Carga</th>
                            <th>Carga Transp.</th>
                            <th>Tráfico Producido</th>     
                            <th>Cons. Comb</th> 
                            <th>Aprov. Capacidad</th>
                            <th>Aprov. Recorrido</th>
                            <th>Intens. Energética</th>            
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
                        </tr>
                    <?php endforeach; ?> 
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
                        </tr>
                    </tfoot>
                </table>
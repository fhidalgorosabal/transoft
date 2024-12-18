        <?php
            $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $pos_mes = (int)$fecha['mes'];
        ?>
        <h1 style="text-align: center; color: rgb(0, 106, 172); margin-bottom: 30px;">
            Cargas transportadas por choferes y ayudantes en <?php echo $nombre_mes[$pos_mes].' del '.$fecha['anno']?>
        </h1>
        <?php $total_personas=$total_act=array(); $total_total=0;?>
        <?php if(count($personas)>0 && count($actividades)>0): ?> 
        <div style="overflow-x: scroll;">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed table-hover">
            <thead>
                <tr class="reporte">    
                    <th style="width: 130px;">Actividades</th>
                    <?php foreach ($personas as $persona): ?>
                    <th> 
                    <label class="tooltip-bottom" data-original-title="<?php if($persona['tipo']==1) { echo 'Chofer'; } else { echo 'Ayudante'; }?>">                         
                        <?php echo $persona['nombre']?>    
                    </label>    
                    </th>
                    <?php endforeach;?> 
                    <th>Total</th>
                </tr>
            </thead>
            <tbody> 
                <?php $i=1; ?>
                <?php foreach ($actividades as $actividad): ?>
                <tr>
                    <td><?php echo $actividad['nombre']?> </td>
                    <?php $j=1; ?>
                    <?php foreach ($personas as $persona): ?>
                    <td>
                    <label class="tooltip-bottom" data-original-title="<?php echo $actividad['nombre']?> ">    
                    <?php 
                        $carga = $listado[$actividad['id']][$persona['id']];
                        $this->my_functions->m($this->my_functions->n($carga));
                        if($i==1)
                            $total_personas[$j]=(float)$carga;
                        else {
                            $total_personas[$j]+=(float)$carga;}
                        if($j==1)  
                            $total_act[$i]=(float)$carga;
                        else
                            $total_act[$i]+=(float)$carga;
                        $total_total+=(float)$carga;
                    ?>   
                    </label>
                    </td>
                    <?php 
                        $j++;
                        endforeach;
                    ?> 
                    <td style="font-weight: bold;">
                        <?php $this->my_functions->m($this->my_functions->n($total_act[$i]))?>  
                    </td>
                </tr>
                <?php 
                    $i++;
                    endforeach;
                ?> 
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <?php for($j=1; $j<=count($personas); $j++): ?>
                    <th>                        
                        <?php $this->my_functions->m($this->my_functions->n($total_personas[$j]))?>                    
                    </th>
                    <?php endfor;?>
                    <th><?php $this->my_functions->m($this->my_functions->n($total_total))?></th>
                </tr>
            </tfoot>
        </table> 
        </div>
        <?php else: ?> 
            <div class="alert alert-heading alert-block">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
                <p>
                    <i class="icon-warning large"></i> ¡ No se pudo realizar el reporte, no hay elementos para mostrar !
                </p>    
            </div> 
        <?php endif; ?>     
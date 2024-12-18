        <?php
            $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $pos_mes = (int)$fecha['mes'];
        ?>
        <h1 style="text-align: center; color: rgb(0, 106, 172); margin-bottom: 30px;">
            Combustible habilitado por carros en el mes de <?php echo $nombre_mes[$pos_mes].' del '.$fecha['anno']?>
        </h1>
        <?php $total_dia=$total_carro=array(); $total_total=0;?>
        <?php if(count($reporte)>0): ?>    
        <div style="overflow-x: scroll;">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed table-hover">
            <thead>
                <tr class="reporte">    
                    <th style="width: 57px;">Chapa</th>
                    <?php for($j=1; $j<=$fecha['max_dias']; $j++): ?>
                    <th>                        
                        <?php echo $j?>                    
                    </th>
                    <?php endfor;?> 
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>  
                <?php for($i=1; $i<=count($chapas); $i++): ?>  
                <tr>
                    <td><?php echo $chapas[$i]?></td>
                    <?php for($j=1; $j<=$fecha['max_dias']; $j++): ?>
                    <td> 
                    <label class="tooltip-bottom" data-original-title="<?php echo $chapas[$i]?>">    
                    <?php 
                        $combustible=$reporte[$chapas[$i]][$j];
                        if((float)$combustible!=0)
                            $this->my_functions->m($this->my_functions->n($combustible));
                        else
                            echo '';
                        if($i==1)
                            $total_dia[$j]=(float)$combustible;
                        else {
                            $total_dia[$j]+=(float)$combustible;}
                        if($j==1)  
                            $total_carro[$i]=(float)$combustible;
                        else
                            $total_carro[$i]+=(float)$combustible;
                        $total_total+=(float)$combustible;
                    ?>   
                    </label>        
                    </td>
                    <?php endfor;?>
                    <td style="font-weight: bold;">
                        <?php $this->my_functions->m($this->my_functions->n($total_carro[$i]))?> 
                    </td>
                </tr>
                <?php endfor;?>   
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <?php for($j=1; $j<=$fecha['max_dias']; $j++): ?>
                    <th>                        
                        <?php $this->my_functions->m($this->my_functions->n($total_dia[$j]))?>                    
                    </th>
                    <?php endfor;?>
                    <th><?php $this->my_functions->m($this->my_functions->n($total_total))?> </th>
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
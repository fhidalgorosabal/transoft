        <?php  
            $str='carga_transportada';
            if(isset($n_mes) && isset($n_anno))
                $str=$str.'_'.$n_mes.'_'.$n_anno;
            else
                $str=$str.'_mes';
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=".$str.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
        ?>
        <?php $total_personas=$total_act=array(); $total_total=0;?>        <div style="overflow-x: scroll;">
        <table cellpadding="0" cellspacing="0" border="1">
            <thead>
                <tr class="reporte">    
                    <th style="width: 130px;">Actividades</th>
                    <?php foreach ($personas as $persona): ?>
                    <th title="<?php if($persona['tipo']==1) { echo 'Chofer'; } else { echo 'Ayudante'; }?>">                        
                        <?php echo $persona['nombre']?>                    
                    </th>
                    <?php endforeach;?> 
                    <th>Total</th>
                </tr>
            </thead>
            <tbody> 
                <?php $i=1; ?>
                <?php foreach ($actividades as $actividad): ?>
                <tr title="<?php echo $actividad['nombre']?> ">
                    <td><?php echo $actividad['nombre']?> </td>
                    <?php $j=1; ?>
                    <?php foreach ($personas as $persona): ?>
                    <td>                        
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
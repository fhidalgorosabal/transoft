        <?php
            $str='combustible_habilitado';
            if(isset($n_mes) && isset($n_anno))
                $str=$str.'_'.$n_mes.'_'.$n_anno;
            else
                $str=$str.'_mes';
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=".$str.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
        ?>
        <?php $total_general=$total_carro=array(); $total_total=0;?>
        <table cellpadding="0" cellspacing="0" border="1">
            <thead>
                <tr class="reporte">    
                    <th style="width: 58px;">Chapa</th>
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
                <tr title="<?php echo $chapas[$i]?>">
                    <td style="font-weight: bold;"><?php echo $chapas[$i]?></td>
                    <?php for($j=1; $j<=$fecha['max_dias']; $j++): ?>
                    <td>                        
                    <?php 
                        $combustible=$reporte[$chapas[$i]][$j];
                        if((float)$combustible!=0)
                            $this->my_functions->m($this->my_functions->n($combustible));
                        else
                            echo '';
                        if($i==1)
                            $total_general[$j]=(float)$combustible;
                        else {
                            $total_general[$j]+=(float)$combustible;}
                        if($j==1)  
                            $total_carro[$i]=(float)$combustible;
                        else
                            $total_carro[$i]+=(float)$combustible;
                        $total_total+=(float)$combustible;
                    ?>                   
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
                        <?php $this->my_functions->m($this->my_functions->n($total_general[$j]))?>                    
                    </th>
                    <?php endfor;?>
                    <th><?php $this->my_functions->m($this->my_functions->n($total_total))?> </th>
                </tr>
            </tfoot>
        </table>    
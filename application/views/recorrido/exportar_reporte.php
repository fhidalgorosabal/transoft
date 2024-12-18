       <?php  
            $str='recorridos';
            if(isset($n_act) && $n_act)
                $str=$str.'_actividad_'.$n_act;
            if(isset($n_mes) && isset($n_anno))
                $str=$str.'_'.$n_mes.'_'.$n_anno;
            else
                $str=$str.'_mes';
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=".$str.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
        ?>
        <?php $total_c=$total_nc=$total_vr=$total_dt=$total_dc=$total_ct=$total_tp=$total_ch=$total_cc=$total_ctq=$total_cp=$total_ac=$total_ar=$total_ie=0; ?>
        <table cellpadding="0" cellspacing="0" border="1">
            <thead>
                <tr class="reporte">
                    <th>
                        C&oacute;digo
                    </th>
                    <th>                        
                        Chapa                    
                    </th>
                    <th>                        
                        Cap.                    
                    </th>
                    <th>                        
                        Norma Cons.                    
                    </th>
                    <th>                        
                        Viaj. Realz.                    
                    </th>
                    <th>                        
                        Dist. Total                    
                    </th>
                    <th>                        
                        Dist. Carga                    
                    </th>
                    <th>                        
                        Carga Transp.                    
                    </th>
                    <th>                        
                        Tr&aacute;f. Prod.                    
                    </th>                            
                    <th>                        
                        Comb. Hab.                    
                    </th> 
                    <th>                        
                        Cons. Comb                    
                    </th> 
                    <th>                        
                        Comb. Tanque                    
                    </th>
                    <th>                        
                        Carga Posible                    
                    </th>
                    <th>                        
                        Aprov. Cap.                    
                    </th>
                    <th>                        
                        Aprov. Rec.                   
                    </th>
                    <th>                        
                        Intens. Energ.                    
                    </th>
                </tr>
            </thead>
            <tbody>                 
            <?php if(count($listado)>0): ?>  
                <?php foreach($listado as $value): ?>
                <tr>
                    <td><?php echo $value['codigo'] ?></td>
                    <td><?php echo $value['chapa'] ?></td>
                    <td><?php 
                        $total_c+=$value['capacidad'];
                        $this->my_functions->m($this->my_functions->n($value['capacidad'])) 
                    ?></td>
                    <td><?php 
                        $total_nc+=$value['norma_consumo'];
                        $this->my_functions->m($this->my_functions->n($value['norma_consumo'])) 
                    ?></td>
                    <td><?php 
                        if($value['viajes_realizados']==NULL)
                            $vr=0;
                        else
                            $vr=$value['viajes_realizados'];
                        $total_vr+=$vr;
                        $this->my_functions->m($this->my_functions->n($vr)) 
                    ?></td>
                    <td><?php 
                        if($value['distancia_total']==NULL)
                            $dt=0;
                        else
                            $dt=$value['distancia_total'];
                        $total_dt+=$dt;
                        $this->my_functions->m($this->my_functions->n($dt)) 
                    ?></td>
                    <td><?php 
                        if($value['distancia_carga']==NULL)
                            $dc=0;
                        else
                            $dc=$value['distancia_carga'];
                        $total_dc+=$dc;
                        $this->my_functions->m($this->my_functions->n($dc)) 
                    ?></td>
                    <td><?php 
                        if($value['carga_transportada']==NULL)
                            $ct=0;
                        else
                            $ct=$value['carga_transportada'];
                        $total_ct+=$ct;
                        $this->my_functions->m($this->my_functions->n($ct)) 
                    ?></td>
                    <td><?php 
                        if($value['trafico_producido']==NULL)
                            $tp=0;
                        else
                            $tp=$value['trafico_producido'];
                        $total_tp+=$tp;
                        $this->my_functions->m($this->my_functions->n($tp)) 
                    ?></td>
                    <td><?php 
                        if($value['combustible_habilitado']==NULL)
                            $ch=0;
                        else
                            $ch=$value['combustible_habilitado'];
                        $total_ch+=$ch;
                        $this->my_functions->m($this->my_functions->n($ch)) 
                    ?></td>
                    <td><?php 
                        if($value['consumo_combustible']==NULL)
                            $cc=0;
                        else
                            $cc=$value['consumo_combustible'];
                        $total_cc+=$cc;
                        $this->my_functions->m($this->my_functions->n($cc)) 
                    ?></td>
                    <td><?php 
                        if($value['capacidad_tanque']==NULL)
                            $ctq=0;
                        else
                            $ctq=($value['capacidad_tanque']+$ch)-$cc;
                        $total_ctq+=$ctq;
                        $this->my_functions->m($this->my_functions->n($ctq)) 
                    ?></td>
                    <td><?php
                        $cp=$vr*$value['capacidad'];
                        $total_cp+=$cp;
                        $this->my_functions->m($this->my_functions->n($cp)) 
                    ?></td>
                    <td><?php
                        if($cp!=0)
                            $ac=($ct/$cp)*100;
                        else
                            $ac=0;
                        $total_ac+=$ac;
                        $this->my_functions->m($this->my_functions->n($ac)) 
                    ?></td>
                    <td><?php
                        if($dt!=0)
                            $ar=($dc/$dt)*100;
                        else
                            $ar=0;
                        $total_ar+=$ar;
                        $this->my_functions->m($this->my_functions->n($ar)) 
                    ?></td>
                    <td><?php
                        if($tp!=0)
                            $ie=$cc/$tp;
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
            <tr>
                <th colspan="2">Total</th>
                <th><?php $this->my_functions->m($this->my_functions->n($total_c)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_nc)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_vr)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_dt)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_dc)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_ct)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_tp)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_ch)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_cc)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_ctq)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_cp)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_ac)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_ar)) ?></th> 
                <th><?php $this->my_functions->m($this->my_functions->n($total_ie)) ?></th> 
            </tr>
        </tfoot>
    </table>    
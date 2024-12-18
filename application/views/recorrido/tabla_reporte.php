        <?php 
        function nombreActv($actividad, $actividades) {
            foreach ($actividades as $value){
               if($value->id_actividad==$actividad) {
                   echo ' en: '.$value->nombre_act; 
                   break;
               }
            }            
        }
        $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $pos_mes = (int)$fecha['mes'];
        ?>
        <h1 style="text-align: center; color: rgb(0, 106, 172); margin-bottom: 30px;">
            Resumen de los recorridos de <?php echo $nombre_mes[$pos_mes].' del '.$fecha['anno']?><?php if((isset($actividades) && $actividades!=NULL) && (isset($actividad) && $actividad!=NULL)) { nombreActv($actividad, $actividades);} ?>
        </h1>
        <?php if(count($listado)>0): ?> 
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed table-hover">
            <thead>
                <tr class="reporte">
                    <th>
                        <label class="tooltip-bottom" data-original-title="C&oacute;digo del carro">C&oacute;digo</label>
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Chapa del carro">Chapa</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Capacidad del carro">Cap.</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Norma de consumo">Norma Cons.</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Viajes realizados">Viaj. Realz.</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Distancia total">Dist. Total</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Distancia con carga">Dist. Carga</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Carga transportada">Carga Transp.</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Tr&aacute;fico producido">Tráf. Prod.</label>                    
                    </th>                            
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Combustible habilitado">Comb. Hab.</label>                    
                    </th> 
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Consumo de combustible">Cons. Comb</label>                    
                    </th> 
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Combustible tanque">Comb. Tanque</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Carga posible">Carga Posible</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Aprovechamiento de la capacidad">Aprov. Cap.</label>                    
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Aprovechamiento del recorrido">Aprov. Rec.</label>                   
                    </th>
                    <th>                        
                        <label class="tooltip-bottom" data-original-title="Intensidad energ&eacute;tica">Intens. Energ.</label>                    
                    </th>
                </tr>
            </thead>
            <tbody> 
            <?php $total_c=$total_nc=$total_vr=$total_dt=$total_dc=$total_ct=$total_tp=$total_ch=$total_cc=$total_ctq=$total_cp=$total_ac=$total_ar=$total_ie=0; ?>    
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
        <?php else: ?> 
            <div class="alert alert-heading alert-block">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
                <p>
                    <i class="icon-warning large"></i> ¡ No se pudo realizar el reporte, no hay elementos para mostrar !
                </p>    
            </div> 
        <?php endif;?>     
<div class="well well-small span12">
    <h3 class="module-title box-header">Ver Recorrido</h3>
    <div class="row-striped"> 
        <div class="block-content collapse in">
            <div class="span12">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
                <tbody>
                    <tr>
                        <td>Fecha: <?php $this->my_functions->fecha($recorrido->fecha) ?></td>
                        <td>Actividad: <?php echo $recorrido->nombre_act ?></td>
                        <td>Hoja de Ruta: <?php echo $recorrido->numero_hoja_ruta ?></td>
                        <td>Carro: <?php echo $recorrido->chapa ?></td>
                        <td>Capacidad: <?php echo $recorrido->capacidad ?></td>
                        <td>Chofer: <?php echo $recorrido->nombre_chf ?></td>
                        <td>Ayudante: <?php echo $recorrido->nombre_ayd ?></td>
                    </tr>
                </tbody>
            </table>    
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr class="reporte">
                    <th><label class="tooltip-bottom" data-original-title="Conduce">Conduce</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Viajes con Carga">Viajes Carga</label></th> 
                    <th><label class="tooltip-bottom" data-original-title="Distancia Total">Dist. Total</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Distancia con Carga">Dist. Carga</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Carga Transportada">Carga Transp.</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Tráfico Producido">Tráf. Prod.</label></th>                             
                    <th><label class="tooltip-bottom" data-original-title="Combustible Habilitado">Comb. Hablitado</label></th> 
                    <th><label class="tooltip-bottom" data-original-title="Consumo de Combustible">Cons. Comb</label></th>  
                    <th><label class="tooltip-bottom" data-original-title="Combustible en Tanque">Comb. Tanque</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Carga Posible">Carga Posible</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Aprovechamiento de la Capacidad">Aprov. Cap.</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Aprovechamiento del Recorrido">Aprov. Rec.</label></th>
                    <th><label class="tooltip-bottom" data-original-title="Intensidad Energética">Intens. Energ.</label></th>
                </tr>
            </thead>
            <tbody> 
                <?php foreach ($conduces as $conduce): ?>
                <tr>
                    <td><?php echo $conduce['numero'] ?></td>
                    <td>&nbsp;</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($conduce['distancia_total'])) ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n($conduce['distancia_carga'])) ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n($conduce['carga_transportada'])) ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n($conduce['trafico_producido'])) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($conduce['distancia_carga']/$conduce['distancia_total'])*100)) ?></td>
                    <td></td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th> 
                        <?php echo $recorrido->viajes_carga; ?> 
                    </th> 
                    <th><?php                         
                        $this->my_functions->m($this->my_functions->n($recorrido->distancia_total))
                    ?></th>
                    <th><?php                        
                        $this->my_functions->m($this->my_functions->n($recorrido->distancia_carga))
                    ?></th>
                    <th><?php
                        
                        $this->my_functions->m($this->my_functions->n($recorrido->carga_transportada))
                    ?></th>
                    <th><?php                        
                        $this->my_functions->m($this->my_functions->n($recorrido->trafico_producido))
                    ?></th>
                    <th><?php                        
                        $this->my_functions->m($this->my_functions->n($recorrido->combustible_habilitado))
                    ?></th>
                    <th><?php                        
                        $this->my_functions->m($this->my_functions->n($recorrido->consumo_combustible))
                    ?></th>
                    <th><?php     
                        $combustible_tanque=($recorrido->combustible_tanque + $recorrido->combustible_habilitado) - $recorrido->consumo_combustible;
                        $this->my_functions->m($this->my_functions->n($combustible_tanque));
                    ?></th>
                    <th><?php
                        $carga_posible = $recorrido->viajes_carga * $recorrido->capacidad;
                        $this->my_functions->m($this->my_functions->n($carga_posible)); 
                    ?></th>
                    <th><?php
                        if($carga_posible!=0)
                            $ac=($recorrido->carga_transportada/$carga_posible)* 100;
                        else
                            $ac=0;                        
                        $this->my_functions->m($this->my_functions->n($ac));
                    ?></th>
                    <th><?php
                        if($recorrido->distancia_total!=0)
                            $ar=($recorrido->distancia_carga/$recorrido->distancia_total)* 100;
                        else
                            $ar=0;                        
                        $this->my_functions->m($this->my_functions->n($ar)) 
                    ?></th>
                    <th><?php
                        if($recorrido->trafico_producido!=0)
                            $ie=$recorrido->consumo_combustible/$recorrido->trafico_producido;
                        else
                            $ie=0;                        
                        $this->my_functions->m($this->my_functions->n($ie))
                    ?></th>        
                </tr>
            </tfoot>
            </table>
            </div>
        </div> 
        <div style="text-align: center">           
            <a class="btn" href="<?php echo base_url() ?>recorrido/listar/<?php echo $id_actividad.'/'.$id_carro?>">
                <i class="icon-arrow-left fg-lightBlue"></i> Regresar al listado 
            </a>  
        </div>     
    </div>
</div>
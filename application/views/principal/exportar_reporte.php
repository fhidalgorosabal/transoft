        <?php
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=indicadores_mes.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
        ?>
        <table cellpadding="0" cellspacing="0" border="1">
            <thead>
                <tr class="reporte">    
                    <th>Indicadores</th>
                    <th>Unidad de Medida</th>
                    <th>Plan del Mes</th>
                    <th>Real del Mes</th>
                    <th>Por Ciento (%)</th>
                </tr>
            </thead>
            <tbody>  
                <tr>
                    <td>Carros Existentes</td>
                    <td>U</td>
                    <td><?php echo $carros_existentes;?></td>
                    <td><?php echo $carros_existentes_r;?></td>
                    <td><?php echo ($carros_existentes_r/$carros_existentes)*100;?></td>
                </tr>  
                <tr>
                    <td>Carros Trabajando</td>
                    <td>U</td>
                    <td><?php echo $carros_trabajando;?></td>
                    <td><?php echo $carros_trabajando_r;?></td>
                    <td><?php echo ($carros_trabajando_r/$carros_trabajando)*100;?></td>
                </tr>  
                <tr>
                    <td>Coef. Aprovechamiento del Parque</td>
                    <td>%</td>
                    <td><?php 
                    $c_a_p=($carros_trabajando/$carros_existentes)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_p));
                    ?></td>
                    <td><?php 
                    $c_a_p_r=($carros_trabajando_r/$carros_existentes_r)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_p_r));
                    ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($c_a_p_r/$c_a_p)*100));?></td>
                </tr>  
                <tr>
                    <td>Carga Transportada</td>
                    <td>MT</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($carga_transportada));?></td>
                    <td><?php $carga_transportada_r=$carga_transportada_r/1000; $this->my_functions->m($this->my_functions->n($carga_transportada_r));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($carga_transportada_r/$carga_transportada)*100));?></td>
                </tr>  
                <tr>
                    <td>Viajes Realizados</td>
                    <td>U</td>
                    <td><?php echo $viajes_realizados;?></td>
                    <td><?php echo $viajes_realizados_r;?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($viajes_realizados_r/$viajes_realizados)*100));?></td>
                </tr>  
                <tr>
                    <td>Tr&aacute;fico</td>
                    <td>MMTKM</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($trafico));?></td>
                    <td><?php $trafico_r=$trafico_r/1000000; $this->my_functions->m($this->my_functions->n($trafico_r));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($trafico_r/$trafico)*100));?></td>
                </tr>
                <tr>
                    <td>Distancia Total</td>
                    <td>MKM</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($distancia_total));?></td>
                    <td><?php $distancia_total_r=$distancia_total_r/1000; $this->my_functions->m($this->my_functions->n($distancia_total_r));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($distancia_total_r/$distancia_total)*100));?></td>
                </tr>
                <tr>
                    <td>Distancia Carga</td>
                    <td>MKM</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($distancia_carga));?></td>
                    <td><?php $distancia_carga_r=$distancia_carga_r/1000; $this->my_functions->m($this->my_functions->n($distancia_carga_r));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($distancia_carga_r/$distancia_carga)*100));?></td>
                </tr>
                <tr>
                    <td>Coef. Aprovechamiento del Recorrido</td>
                    <td>%</td>
                    <td><?php 
                    $c_a_r=($distancia_carga/$distancia_total)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_r));
                    ?></td>
                    <td><?php 
                    $c_a_r_r=($distancia_carga_r/$distancia_total_r)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_r_r));
                    ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($c_a_r_r/$c_a_r)*100));?></td>
                </tr>
                <tr>
                    <td>Carga Posible</td>
                    <td>MT</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($carga_posible));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n($carga_posible_r));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($carga_posible_r/$carga_posible)*100));?></td>
                </tr>
                <tr>
                    <td>Coef. Aprovechamiento de la Capacidad</td>
                    <td>%</td>
                    <td><?php 
                    $c_a_c=($carga_transportada/$carga_posible)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_c));
                    ?></td>
                    <td><?php 
                    $c_a_c_r=($carga_transportada_r/$carga_posible_r)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_c_r));
                    ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($c_a_c_r/$c_a_c)*100));?></td>
                </tr>
                <tr>
                    <td>Consumo de Combustible</td>
                    <td>T</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($consumo_combustible));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n($consumo_combustible_r));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($consumo_combustible_r/$consumo_combustible)*100));?></td>
                </tr>
                <tr>
                    <td>Intensidad Energ&eacute;tica</td>
                    <td>T/MMTKM</td>
                    <td><?php 
                    $i_e=$consumo_combustible/$trafico;
                    $this->my_functions->m($this->my_functions->n($i_e));
                    ?></td>
                    <td><?php 
                    $i_e_r=$consumo_combustible_r/$trafico_r;
                    $this->my_functions->m($this->my_functions->n($i_e_r));
                    ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($i_e_r/$i_e)*100));?></td>
                </tr>
                <tr>
                    <td>Rendimiento Energ&eacute;tico</td>
                    <td>L/TKM</td>
                    <td><?php 
                    $r_e=($c_a_r/100)*($c_a_c/100)*5.8*4.84;
                    $this->my_functions->m($this->my_functions->n($r_e));
                    ?></td>
                    <td><?php 
                    $r_e_r=($c_a_r_r/100)*($c_a_c_r/100)*5.8*4.84;
                    $this->my_functions->m($this->my_functions->n($r_e_r));
                    ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($r_e_r/$r_e)*100));?></td>
                </tr>
                <tr>
                    <td>Distancia Media</td>
                    <td>KM</td>
                    <td><?php 
                    $d_m=($trafico*1000)/$carga_transportada;
                    $this->my_functions->m($this->my_functions->n($d_m));
                    ?></td>
                    <td><?php 
                    $d_m_r=($trafico_r*1000)/$carga_transportada_r;
                    $this->my_functions->m($this->my_functions->n($d_m_r));
                    ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($d_m_r/$d_m)*100));?></td>
                </tr>
                <tr>
                    <td>Rotaci&oacute;n</td>
                    <td>U</td>
                    <td><?php 
                    $rt=$viajes_realizados/($carros_existentes*26);
                    $this->my_functions->m($this->my_functions->n($rt));
                    ?></td>
                    <td><?php 
                    $rt_r=$viajes_realizados_r/($carros_existentes_r*26);
                    $this->my_functions->m($this->my_functions->n($rt_r));
                    ?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n(($rt_r/$rt)*100));?></td>
                </tr>
            </tbody>
        </table> 
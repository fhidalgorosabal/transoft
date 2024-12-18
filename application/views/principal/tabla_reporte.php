        <?php
            $nombre_mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $pos_mes = (int)$fecha['mes'];
        ?>
        <h1 style="text-align: center; color: rgb(0, 106, 172); margin-bottom: 30px;">
            Indicadores de <?php echo $nombre_mes[$pos_mes].' del '.$fecha['anno']?>
        </h1>
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed table-hover" id="example2">
            <thead>
                <tr class="reporte">   
                    <th>No </th>
                    <th>Indicadores</th>
                    <th>Unidad de Medida</th>
                    <th>Plan del Mes</th>
                    <th>Real del Mes</th>
                    <th>Por Ciento (%)</th>
                </tr>
            </thead>
            <tbody>  
                <tr>
                    <td>1</td>
                    <td>Carros Existentes</td>
                    <td>U</td>
                    <td><?php echo $carros_existentes;?></td>
                    <td><?php echo $carros_existentes_r;?></td>
                    <td><?php 
                        if($carros_existentes==0)  
                            $result_c_e = 0;
                        else
                            $result_c_e = ($carros_existentes_r/$carros_existentes)*100;
                        $this->my_functions->m($this->my_functions->n($result_c_e));
                    ?></td>
                </tr>  
                <tr>
                    <td>2</td>
                    <td>Carros Trabajando</td>
                    <td>U</td>
                    <td><?php echo $carros_trabajando;?></td>
                    <td><?php echo $carros_trabajando_r;?></td>
                    <td><?php 
                        if($carros_trabajando==0)  
                            $result_c_t = 0;
                        else
                            $result_c_t = ($carros_trabajando_r/$carros_trabajando)*100;
                        $this->my_functions->m($this->my_functions->n($result_c_t));
                        ?></td>
                </tr>  
                <tr>
                    <td>3</td>
                    <td>Coef. Aprovechamiento del Parque</td>
                    <td>%</td>
                    <td><?php 
                    if($carros_existentes==0)  
                            $c_a_p = 0;
                        else
                            $c_a_p = ($carros_trabajando/$carros_existentes)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_p));
                    ?></td>
                    <td><?php 
                    if($carros_existentes_r==0)  
                            $c_a_p_r = 0;
                        else
                            $c_a_p_r=($carros_trabajando_r/$carros_existentes_r)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_p_r));
                    ?></td>
                    <td><?php 
                        if($c_a_p==0)  
                            $result_c_a_p = 0;
                        else
                            $result_c_a_p = ($c_a_p_r/$c_a_p)*100;
                        $this->my_functions->m($this->my_functions->n($result_c_a_p));
                    ?></td>
                </tr>  
                <tr>
                    <td>4</td>
                    <td>Carga Transportada</td>
                    <td>MT</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($carga_transportada));?></td>
                    <td><?php $carga_transportada_r=$carga_transportada_r/1000; $this->my_functions->m($this->my_functions->n($carga_transportada_r));?></td>
                    <td><?php 
                        if($carga_transportada==0)  
                            $result_cg_t = 0;
                        else
                            $result_cg_t = ($carga_transportada_r/$carga_transportada)*100;
                        $this->my_functions->m($this->my_functions->n($result_cg_t));
                    ?></td>
                </tr>  
                <tr>
                    <td>5</td>
                    <td>Viajes Realizados</td>
                    <td>U</td>
                    <td><?php echo $viajes_realizados;?></td>
                    <td><?php if($viajes_realizados_r!='') echo $viajes_realizados_r; else echo '0';?></td>
                    <td><?php 
                        if($viajes_realizados==0)  
                            $result_v_r = 0;
                        else
                            $result_v_r = ($viajes_realizados_r/$viajes_realizados)*100;
                        $this->my_functions->m($this->my_functions->n($result_v_r));
                    ?></td>
                </tr>  
                <tr>
                    <td>6</td>
                    <td>Tr&aacute;fico</td>
                    <td>MMTKM</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($trafico));?></td>
                    <td><?php $trafico_r=$trafico_r/1000000; $this->my_functions->m($this->my_functions->n($trafico_r));?></td>
                    <td><?php 
                        if($trafico==0)  
                            $result_t = 0;
                        else
                            $result_t = ($trafico_r/$trafico)*100;
                        $this->my_functions->m($this->my_functions->n($result_t));
                    ?></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Distancia Total</td>
                    <td>MKM</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($distancia_total));?></td>
                    <td><?php 
                    if($distancia_total_r!='') 
                        $this->my_functions->m($this->my_functions->n($distancia_total_r));
                    else
                        echo '0.00';
                    ?></td>
                    <td><?php 
                        if($distancia_total==0)  
                            $result_d_t = 0;
                        else
                            $result_d_t = ($distancia_total_r/$distancia_total)*100;
                        $this->my_functions->m($this->my_functions->n($result_d_t));
                    ?></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Distancia Carga</td>
                    <td>MKM</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($distancia_carga));?></td>
                    <td><?php
                    if($distancia_carga_r!='') 
                        $this->my_functions->m($this->my_functions->n($distancia_carga_r));
                    else
                        echo '0.00';
                    ?></td>
                    <td><?php 
                        if($distancia_carga==0)  
                            $result_d_c = 0;
                        else
                            $result_d_c = ($distancia_carga_r/$distancia_carga)*100;
                        $this->my_functions->m($this->my_functions->n($result_d_c));
                    ?></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Coef. Aprovechamiento del Recorrido</td>
                    <td>%</td>
                    <td><?php
                        if($distancia_total==0)  
                                $c_a_r = 0;
                            else
                                $c_a_r=($distancia_carga/$distancia_total)*100;
                        $this->my_functions->m($this->my_functions->n($c_a_r));
                    ?></td>
                    <td><?php
                        if($distancia_total_r==0)  
                                $c_a_r_r = 0;
                            else
                                $c_a_r_r = ($distancia_carga_r/$distancia_total_r)*100;
                        $this->my_functions->m($this->my_functions->n($c_a_r_r));
                    ?></td>
                    <td><?php 
                        if($distancia_total_r==0)  
                                $result_c_a_r = 0;
                            else
                                $result_c_a_r = ($c_a_r_r/$c_a_r)*100;
                        $this->my_functions->m($this->my_functions->n($result_c_a_r));
                    ?></td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Carga Posible</td>
                    <td>MT</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($carga_posible));?></td>
                    <td><?php $this->my_functions->m($this->my_functions->n($carga_posible_r));?></td>
                    <td><?php 
                        if($carga_posible==0)  
                                $result_c_p = 0;
                            else
                                $result_c_p = ($carga_posible_r/$carga_posible)*100;
                        $this->my_functions->m($this->my_functions->n($result_c_p));
                    ?></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Coef. Aprovechamiento de la Capacidad</td>
                    <td>%</td>
                    <td><?php 
                    $c_a_c=($carga_transportada/$carga_posible)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_c));
                    ?></td>
                    <td><?php 
                    if($carga_posible_r==0)
                        $c_a_c_r='0.00';
                    else        
                        $c_a_c_r=($carga_transportada_r/$carga_posible_r)*100;
                    $this->my_functions->m($this->my_functions->n($c_a_c_r));
                    ?></td>
                    <td><?php 
                        if($c_a_c==0)  
                                $result_c_a_c = 0;
                            else
                                $result_c_a_c = ($c_a_c_r/$c_a_c)*100;
                        $this->my_functions->m($this->my_functions->n($result_c_a_c));
                    ?></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Consumo de Combustible</td>
                    <td>T</td>
                    <td><?php $this->my_functions->m($this->my_functions->n($consumo_combustible));?></td>
                    <td><?php
                    if($consumo_combustible_r!='')
                        $this->my_functions->m($this->my_functions->n($consumo_combustible_r));
                    else
                        echo '0.00';
                    ?></td>
                    <td><?php 
                        if($consumo_combustible==0)  
                                $result_c_c = 0;
                            else
                                $result_c_c = ($consumo_combustible_r/$consumo_combustible)*100;
                        $this->my_functions->m($this->my_functions->n($result_c_c));
                    ?></td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>Intensidad Energ&eacute;tica</td>
                    <td>T/MMTKM</td>
                    <td><?php 
                        if($trafico==0)  
                                $i_e = 0;
                            else
                                $i_e = $consumo_combustible/$trafico;
                        $this->my_functions->m($this->my_functions->n($i_e));
                    ?></td>
                    <td><?php 
                        if($trafico_r==0)  
                                $i_e_r = 0;
                            else
                                $i_e_r = $consumo_combustible_r/$trafico_r;
                        $this->my_functions->m($this->my_functions->n($i_e_r));
                    ?></td>
                    <td><?php 
                        if($i_e==0)  
                                $result_i_e = 0;
                            else
                                $result_i_e = ($i_e_r/$i_e)*100;
                        $this->my_functions->m($this->my_functions->n($result_i_e));
                    ?></td>
                </tr>
                <tr>
                    <td>14</td>
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
                    <td><?php
                        if($r_e==0)  
                                $result_r_e = 0;
                            else
                                $result_r_e = ($r_e_r/$r_e)*100;
                        $this->my_functions->m($this->my_functions->n($result_r_e));
                    ?></td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>Distancia Media</td>
                    <td>KM</td>
                    <td><?php 
                        if($carga_transportada==0)
                            $d_m = 0;
                        else
                            $d_m = ($trafico*1000)/$carga_transportada;
                        $this->my_functions->m($this->my_functions->n($d_m));
                    ?></td>
                    <td><?php 
                        if($carga_transportada_r==0)
                            $d_m_r = 0;
                        else
                            $d_m_r = ($trafico_r*1000)/$carga_transportada_r;
                        $this->my_functions->m($this->my_functions->n($d_m_r));
                    ?></td>
                    <td><?php 
                        if($d_m==0)  
                                $result_d_m = 0;
                            else
                                $result_d_m = ($d_m_r/$d_m)*100;
                        $this->my_functions->m($this->my_functions->n($result_d_m));
                    ?></td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>Rotaci&oacute;n</td>
                    <td>U</td>
                    <td><?php 
                        if($carros_existentes==0)
                            $rt = 0;
                        else
                            $rt = $viajes_realizados/($carros_existentes*26);
                        $this->my_functions->m($this->my_functions->n($rt));
                    ?></td>
                    <td><?php 
                        if($carros_existentes_r==0)
                            $rt_r = 0;
                        else
                            $rt_r = $viajes_realizados_r/($carros_existentes_r*26);
                        $this->my_functions->m($this->my_functions->n($rt_r));
                    ?></td>
                    <td><?php 
                        if($rt==0)  
                                $result_rt = 0;
                            else
                                $result_rt = ($rt_r/$rt)*100;
                        $this->my_functions->m($this->my_functions->n($result_rt));
                    ?></td>
                </tr>
            </tbody>
        </table> 
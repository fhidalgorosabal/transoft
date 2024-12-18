                                    <div class="span3">
                                        <div class="cpanel-links">
                                            <div class="sidebar-nav quick-icons">
						<div class="j-links-groups">
                                                    <h2 class="nav-header"><i class="icon-share"></i> Accesos Directos</h2>
							<ul class="j-links-group nav-side nav-list">
                                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))): ?>
                                                            <li>
                                                                <a class="dropmenu" href="#">
								<span class="icon-plus-2"></span> <span class="j-links-link">Captar recorrido</span>	
                                                                </a>
                                                                <?php if(isset($actividades)):?>
                                                                <ul class="submenu">
                                                                    <?php foreach ($actividades as $value): ?>
                                                                    <li><a href="<?php echo base_url() ?>recorrido/captar/<?php echo $value->id_actividad ?>"><span class="hidden-tablet"> <?php echo $value->nombre_act ?></span></a></li>
                                                                    <?php endforeach;?>
                                                                </ul>
                                                                <?php endif;?>
                                                            </li>
                                                            <?php endif;?>
                                                            <li>
								<a class="dropmenu" href="#">
								<span class="icon-list"></span> <span class="j-links-link">Listar recorridos</span>	
                                                                </a>
                                                                <?php if(isset($actividades)):?>
                                                                <ul class="submenu">
                                                                    <?php foreach ($actividades as $value): ?>
                                                                    <li><a href="<?php echo base_url() ?>recorrido/listar/<?php echo $value->id_actividad ?>/<?php if(isset($carro)) { echo $carro->id_carro; } ?>"><span class="hidden-tablet"> <?php echo $value->nombre_act ?></span></a></li>
                                                                    <?php endforeach;?>
                                                                </ul>
                                                                <?php endif;?>
                                                            </li>
                                                            <?php if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(array('admin','jefe','tecnico'))): ?>
                                                            <li>
                                                                <a href="<?php echo base_url() ?>combustible/habilitar">
								<span class=" icon-download"></span> <span class="j-links-link">Habilitar combustible</span>	</a>
                                                            </li>
                                                            <?php endif;?>
                                                            </ul>
                                                            <h2 class="nav-header"><i class="icon-clipboard-2"></i> Reportes</h2>
                                                            <ul class="j-links-group nav-side nav-list">   
                                                            <li>
                                                                <a class="dropmenu" href="#">
                                                                <span class="icon-bus"></span> <span class="j-links-link">Recorridos</span> 
                                                                </a>
                                                                <ul class="submenu">
                                                                    <li>
                                                                        <a href="<?php echo base_url() ?>recorrido/reporte_recorrido" ><< General >></a>
                                                                    </li>
                                                                    <?php if(isset($actividades)):?>
                                                                    <?php foreach ($actividades as $value): ?>
                                                                    <li><a href="<?php echo base_url() ?>recorrido/reporte_por_actividad/<?php echo $value->id_actividad ?>" ><?php echo $value->nombre_act ?></a></li>
                                                                    <?php endforeach;?>
                                                                    <?php endif;?>
                                                                </ul>
                                                            </li>
                                                            <li>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url() ?>combustible/reporte_combustible" ><i class="icon-droplet"></i> Combustible habilitado</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url() ?>recorrido/reporte_carga_transportada" ><i class="icon-shipping large"></i> Cargas transportadas</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo base_url() ?>principal/reporte_indicadores" ><i class="icon-equalizer large"></i> Indicadores</a>
                                                            </li>
							</ul>
                                                    </div>
                                                </div>
                                            </div>
					</div>

                            <script src="<?php echo base_url()?>assets/custom.js"></script>
	<!-- Begin Footer -->
        <footer>
	<div id="status" class="navbar navbar-fixed-bottom hidden-phone">
		<div class="btn-toolbar">
			<div class="btn-group pull-right">
                            <p>Empresa PescaGran © 2017 | Creado por: UDG Facultad de Ciencias Informáticas, Naturales y Exactas </p>
			</div>			
            <!-- Breadcrumb -->
            	<div class="btn-group">Usted est&aacute; en:</div>
				<div class="btn-group divider"></div>
				<?php 
				$cont=1;
				$max=count($crumb);
				foreach ($crumb as $value): ?>
				<?php
					if ($cont<$max): ?>
						<div class="btn-group">
                                                    <a href="<?php echo $value['direccion'];?>"><?php echo $value['nombre'];?></a>
							<i class="icon-arrow-right-5"></i>
						</div>
					<?php else: ?>  
						<div class="btn-group">
							<?php echo $value['nombre'];?></li>
						</div>	
				<?php endif; 
				$cont++;                            
				endforeach; ?>
            <!-- End Breadcrumb -->
		</div>
	</div> 
        </footer>        
	<!-- End Footer --> 
        <script>
            $('.tooltip-bottom').tooltip({ placement: 'bottom' });
        </script>    
</body>
</html>

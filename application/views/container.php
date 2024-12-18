    <div style="margin-bottom: 60px"></div>    
        <!-- Begin Container -->
	<div class="container-fluid container-main">     
	<section id="content">
            <div class="row-fluid">	
            <?php if(isset($sidebar)):?>
            <!-- Begin Sidebar -->
            <?php echo $sidebar; ?>				
            <!-- End Sidebar -->
            <?php endif;?>    
            <!-- Begin Content -->            
            <?php echo $content;?>
            <!-- End Content -->
            </div>
	</section>
	</div>	
	<!-- End Container -->
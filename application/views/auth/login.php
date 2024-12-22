<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TranSoft | Autenticarse</title>
    
    <link href="<?php echo base_url()?>bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url()?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url()?>bootstrap/css/icons.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url()?>assets/styles.css" rel="stylesheet" media="screen">
    
</head>
    <body id="login">
        <div class="container">
        <?php echo form_open("auth/login", 'id="form-login" class="form-signin"');?>   
            <fieldset class="loginform">		
            <img src="../assets/images/login-logo.png" alt="TranSoft"><div class="banner-img">
            <hr>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend input-append">
                        <span class="add-on">
                        <span data-original-title="Username" class="icon-user-2 hasTooltip" title=""></span>						
                        </span>
                        <?php echo form_input($identity, 'type="text"', 'tabindex="1" id="mod-login-username" placeholder="Usuario" autofocus="true"');?>				
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend input-append">
                        <span class="add-on">
                        <span data-original-title="Password" class="icon-key hasTooltip" title=""></span>
                        </span>
                        <?php echo form_input($password, '','tabindex="2" id="mod-login-password" placeholder="Contrase&ntilde;a"');?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="btn-group">
                        <p><?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary"');?></p>
                    </div>
            </div>
            </div>
            </fieldset>
        <?php echo form_close();?>
            <div class="span5" style="margin-left:  30%;">
            <?php if ($message) : ?>
                <div class="alert alert-error alert-block center">
                    <h4 class="alert-heading"><i class="icon-cancel"></i> ¡Datos incorrectos!</h4>
                    <p>
                        <?php echo $message;?>
                    </p>    
                </div>  
            <?php endif; ?>  
            </div>  
        </div>     
    </body>
</html>
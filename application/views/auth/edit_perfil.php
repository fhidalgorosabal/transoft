<div style="margin-bottom: 60px"></div>
<div class="container-fluid container-main">     
    <section id="content">
        <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="well well-small">
                    <h2 class="module-title box-header"><?php if(isset($titulo)) { echo $titulo;} ?></h2>
                <div class="row-striped">
                    <?php 
                        function depurar1($mensaje) {
                            $array = preg_split('/(##)/', $mensaje);
                            if(count($array)>1)
                                echo $array[1];
                            else
                                echo $mensaje;
                        }
                    
                        function depurar2($mensaje) {
                            $array = preg_split('/(<p>)/', $mensaje);
                            echo '<i class="icon-checkmark"></i>&nbsp;&nbsp;'.$array[1];
                        }
                        ?>
                    <?php if ($message=='<p>Información de la cuenta actualizada con éxito</p>'): ?>
                        <div class="alert alert-success">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                                <?php depurar2($message); ?>
                        </div> 
                    <?php elseif ($message!=''): ?>    
                    <div class="block-content"> 
                        <div class="alert alert-error alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <h4 class="alert-heading"><i class="icon-cancel"></i> ¡Datos incorrectos!</h4>
                            <p>
                                <?php depurar1($message); ?>
                            </p>    
                        </div>  
                    </div>
                    <?php endif; ?> 
                    <div class="block-content collapse in">
                    <?php echo form_open(uri_string());?>  
                        <fieldset>
                            <div class="span1"></div>
                            <div class="span4">
                                <div class="control-group">
                                    <?php echo lang('edit_user_fname_label', 'first_name', 'class="control-label"');?>
                                    <div class="controls">
                                        <?php echo form_input($first_name, '', 'class="span12" autofocus="true"');?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo lang('edit_user_lname_label', 'last_name', 'class="control-label"');?>
                                    <div class="controls">
                                        <?php echo form_input($last_name, '', 'class="span12"');?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo lang('create_user_identity_label', 'identity', 'class="control-label"');?>
                                    <div class="controls">
                                        <?php echo form_input($identity, '', 'class="span12"');?>
                                    </div>
                                </div>
                            <?php echo form_hidden('id', $user->id);?>
                            <?php echo form_hidden($csrf); ?>
                            </div>  
                            <div class="span2"></div>
                            <div class="span4">
                                <div class="control-group">
                                    <label for="old_password" class="control-label">Antigua Contraseña: (si quieres cambiarla)</label>
                                    <div class="controls">
                                        <?php echo form_input($old_password, '', 'class="span12"');?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo lang('edit_user_password_label', 'password', 'class="control-label"');?>
                                    <div class="controls">
                                        <?php echo form_input($password, '', 'class="span12"');?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo lang('edit_user_password_confirm_label', 'password_confirm', 'class="control-label"');?>
                                    <div class="controls">
                                        <?php echo form_input($password_confirm, '', 'class="span12"');?>
                                    </div>
                                </div>            
                            </div>
                            <div class="form-actions span12">
                                <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                                <a class="btn btn-danger" href="<?php echo base_url()?>"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
                            </div>
                        </fieldset>    
                    <?php echo form_close();?>    
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</div>   
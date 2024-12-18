<div style="margin-bottom: 60px"></div>
<div class="container-fluid container-main">     
    <section id="content">
        <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="well well-small">
                    <h2 class="module-title box-header"><?php if(isset($titulo)) { echo $titulo;} ?></h2>
                <div class="row-striped">
                    <?php if ($message!=''): ?>    
                    <div class="block-content"> 
                        <div class="alert alert-error alert-block">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <h4 class="alert-heading"><i class="icon-cancel"></i> ¡Datos incorrectos!</h4>
                            <p>
                                <?php echo $message; ?>
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
                                <?php if ($this->ion_auth->is_admin()): ?>
                                    <h3>Rol:</h3>
                                    <?php foreach ($groups as $group):?>
                                        <label class="radio">
                                        <?php
                                            $gID=$group['id'];
                                            $checked = null;
                                            $item = null;
                                            foreach($currentGroups as $grp) {
                                                if ($gID == $grp->id) {
                                                    $checked= ' checked="checked"';
                                                break;
                                                }
                                            }
                                        ?>
                                        <input type="radio" name="group" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                                        <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                                        </label>
                                    <?php endforeach?>
                                <?php endif ?>
                            </div>
                            <div class="form-actions span12">
                                <button type="submit" class="btn btn-success"><i class="icon-floppy"></i> Guardar</button>
                                <a class="btn btn-danger" href="<?php echo base_url()?>auth"><i class="icon-cancel-2 smaller"></i> Cancelar</a>
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
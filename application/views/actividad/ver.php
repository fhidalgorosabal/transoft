<div class="well well-small span12">
    <h3 class="module-title box-header">Ver Actividad</h3>
    <div class="row-striped"> 
        <div class="block-content collapse in">
        <div class="span2"></div>
            <div class="span8">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed ver">
            <thead>
                <tr>
                    <th colspan="4"> &zwnj; </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="9"></td>
                    <td><b>N&uacute;mero:</b></td>
                    <td><span class="label label-info"><?php echo $actividad->id_actividad ?></span></td>
                    <td rowspan="9"></td>
                </tr>
                <tr>
                    <td><b>Nombre de la actividad:</b></td>
                    <td><span class="label label-info"><?php echo $actividad->nombre_act ?></span></td>
                </tr>    
                <tr>
                    <td><b>Tipo de combustible:</b></td>    
                    <td><span class="label label-info"><?php echo $actividad->tipo_combustible ?></span></td>
                </tr>  <tr>
                    <td><b>Estado:</b></td>    
                    <td><span class="label <?php if($actividad->estado=='Activa'){echo 'label-success';}  else {echo 'label-important';}?>"><?php echo $actividad->estado ?></span></td>
                </tr> 
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4"> &zwnj; </th>
                </tr>
            </tfoot>
            </table>
            </div>
        <div class="span2"></div>
        </div> 
        <div style="text-align: center">           
            <a class="btn btn-info" href="<?php echo base_url() ?>actividad">
                <i class="icon-arrow-left"></i> Volver al listado 
            </a>  
        </div>     
    </div>
</div>
<div class="well well-small span12">
    <h3 class="module-title box-header">Ver Carro</h3>
    <div class="row-striped"> 
        <div class="block-content collapse in">
            <div class="span2"></div>
            <div class="span8">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th colspan="4"> &zwnj; </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="10"></td>
                    <td><b>C&oacute;digo:</b></td>
                    <td><span class="label label-info"><?php echo $carro->codigo ?></span></td>
                    <td rowspan="10"></td>
                </tr>
                <tr>
                    <td><b>Chapa:</b></td>
                    <td><span class="label label-info"><?php echo $carro->chapa ?></span></td>
                </tr>    
                <tr>
                    <td><b>Tipo de veh&iacute;culo:</b></td>    
                    <td><span class="label label-info"><?php echo $carro->tipo ?></span></td>
                </tr>    
                <tr>
                    <td><b>Capacidad:</b></td>    
                    <td><span class="label label-info"><?php $this->my_functions->m($this->my_functions->n($carro->capacidad)) ?></span></td>
                </tr>    
                <tr>
                    <td><b>Marca:</b></td>    
                    <td><span class="label label-info"><?php echo $carro->marca ?></span></td>
                </tr>    
                <tr>
                    <td><b>A&ntilde;o de fabricación:</b></td>    
                    <td><span class="label label-info"><?php echo $carro->anno ?></span></td>
                </tr>    
                <tr>
                    <td><b>Estado t&eacute;cnico:</b></td>    
                    <td><span class="label label-info"><?php echo $carro->estado_tecnico ?></span></td>
                </tr>    
                <tr>
                    <td><b>Tipo de combustible:</b></td>    
                    <td><span class="label label-info"><?php echo $carro->tipo_combustible ?></span></td>
                </tr>    
                <tr>
                    <td><b>Norma de consumo:</b></td>    
                    <td><span class="label label-info"><?php $this->my_functions->m($this->my_functions->n($carro->norma_consumo)) ?></span></td>
                </tr>     
                <tr>
                    <td><b>Capacidad del tanque:</b></td>    
                    <td><span class="label label-info"><?php $this->my_functions->m($this->my_functions->n($carro->capacidad_tanque)) ?></span></td>
                </tr>   
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        &nbsp;
                    </th>
                </tr>
            </tfoot>
            </table>
        </div>
        <div class="span2"></div>    
        </div> 
        <div style="text-align: center">           
            <a class="btn" href="<?php echo base_url() ?>carro">
                <i class="icon-arrow-left fg-lightBlue"></i> Regresar al listado
            </a>  
        </div>     
    </div>
</div>
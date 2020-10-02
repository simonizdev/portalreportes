<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script type="text/javascript">
$(function() {

	var tipo_producto = $('#FichaItem_Tipo_Producto').val();

	if(tipo_producto == 1){
		$('#un_gtin').show();
		$('#log_ep').show();
		$('#log_se_cad').show();


	}else{
		$('#un_gtin').hide();
		$('#log_ep').hide();
		$('#log_se_cad').hide();
	}
	   
	//se llenan las opciones seleccionadas del modelo
	$('#FichaItem_Instalaciones').val(<?php echo $instalaciones_activas ?>).trigger('change');
	$('#FichaItem_Bodegas').val(<?php echo $bodegas_activas ?>).trigger('change');

});
</script>

<h4>Solicitud actualización de producto en siesa</h4>

<?php

$estados2 = Yii::app()->params->estados2;

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ficha-item-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Tipo_Producto'); ?>
            <?php echo $form->error($model,'Tipo_Producto', array('class' => 'badge badge-warning float-right')); ?>
            <?php $tipos_p = array(1 => 'TERMINADO', 2 => 'EN PROCESO', 3 => 'POP' , 4 => 'MATERIA PRIMA'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Tipo_Producto]',
                    'id'=>'FichaItem_Tipo_Producto',
                    'data'=>$tipos_p,
                    'value' => $model->Tipo_Producto,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Tiempo_Reposicion'); ?>
		    <?php echo $form->error($model,'Tiempo_Reposicion', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Tiempo_Reposicion', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Cant_Moq'); ?>
		    <?php echo $form->error($model,'Cant_Moq', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Cant_Moq', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Stock_Minimo'); ?>
		    <?php echo $form->error($model,'Stock_Minimo', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Stock_Minimo', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<h5 class="mt-3">Criterios</h5>

<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Origen'); ?>
		    <?php echo $form->error($model,'Crit_Origen', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Origen]',
                    'id'=>'FichaItem_Crit_Origen',
                    'data'=>$lista_origen,
                    'value' => $model->Crit_Origen,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Tipo'); ?>
		    <?php echo $form->error($model,'Crit_Tipo', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Tipo]',
                    'id'=>'FichaItem_Crit_Tipo',
                    'data'=>$lista_tipo,
                    'value' => $model->Crit_Tipo,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Clasificacion'); ?>
		    <?php echo $form->error($model,'Crit_Clasificacion', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Clasificacion]',
                    'id'=>'FichaItem_Crit_Clasificacion',
                    'data'=>$lista_clasif,
                    'value' => $model->Crit_Clasificacion,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Marca'); ?>
		    <?php echo $form->error($model,'Crit_Marca', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Marca]',
                    'id'=>'FichaItem_Crit_Marca',
                    'data'=>$lista_marca,
                    'value' => $model->Crit_Marca,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Submarca'); ?>
		    <?php echo $form->error($model,'Crit_Submarca', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Submarca]',
                    'id'=>'FichaItem_Crit_Submarca',
                    'data'=>$lista_submarca,
                    'value' => $model->Crit_Submarca,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Segmento'); ?>
		    <?php echo $form->error($model,'Crit_Segmento', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Segmento]',
                    'id'=>'FichaItem_Crit_Segmento',
                    'data'=>$lista_segmento,
                    'value' => $model->Crit_Segmento,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Familia'); ?>
		    <?php echo $form->error($model,'Crit_Familia', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Familia]',
                    'id'=>'FichaItem_Crit_Familia',
                    'data'=>$lista_familia,
                    'value' => $model->Crit_Familia,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Subfamilia'); ?>
		    <?php echo $form->error($model,'Crit_Subfamilia', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Subfamilia]',
                    'id'=>'FichaItem_Crit_Subfamilia',
                    'data'=>$lista_subfamilia,
                    'value' => $model->Crit_Subfamilia,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Linea'); ?>
		    <?php echo $form->error($model,'Crit_Linea', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Linea]',
                    'id'=>'FichaItem_Crit_Linea',
                    'data'=>$lista_linea,
                    'value' => $model->Crit_Linea,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Sublinea'); ?>
		    <?php echo $form->error($model,'Crit_Sublinea', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Sublinea]',
                    'id'=>'FichaItem_Crit_Sublinea',
                    'data'=>$lista_sublinea,
                    'value' => $model->Crit_Sublinea,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Grupo'); ?>
		    <?php echo $form->error($model,'Crit_Grupo', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Grupo]',
                    'id'=>'FichaItem_Crit_Grupo',
                    'data'=>$lista_grupo,
                    'value' => $model->Crit_Grupo,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_UN'); ?>
		    <?php echo $form->error($model,'Crit_UN', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_UN]',
                    'id'=>'FichaItem_Crit_UN',
                    'data'=>$lista_un,
                    'value' => $model->Crit_UN,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Fabrica'); ?>
		    <?php echo $form->error($model,'Crit_Fabrica', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Fabrica]',
                    'id'=>'FichaItem_Crit_Fabrica',
                    'data'=>$lista_fabrica,
                    'value' => $model->Crit_Fabrica,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Cat_Oracle'); ?>
		    <?php echo $form->error($model,'Crit_Cat_Oracle', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Cat_Oracle]',
                    'id'=>'FichaItem_Crit_Cat_Oracle',
                    'data'=>$lista_oracle,
                    'value' => $model->Crit_Cat_Oracle,
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-12">
    	<div class="form-group">
          	<?php echo $form->label($model,'Instalaciones'); ?>
		    <?php echo $form->error($model,'Instalaciones', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Instalaciones]',
                    'id'=>'FichaItem_Instalaciones',
                    'data'=>$lista_ins,
                    'value' => $model->Instalaciones,
                    'htmlOptions'=>array(
                        'multiple'=>'multiple',
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,

                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">   
    <div class="col-sm-12">
    	<div class="form-group">
          	<?php echo $form->label($model,'Bodegas'); ?>
		    <?php echo $form->error($model,'Bodegas', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Bodegas]',
                    'id'=>'FichaItem_Bodegas',
                    'data'=>$lista_bodegas,
                    'value' => $model->Bodegas,
                    'htmlOptions'=>array(
                        'multiple'=>'multiple',
                        'readonly'=>true,
                    ),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Estado_Solicitud', array('class' => 'control-label')); ?>
            <p><?php echo $model->DescEstado($model->Estado_Solicitud); ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Solicitud', array('class' => 'control-label')); ?>
            <p><?php echo $model->idusuariosol->Usuario; ?></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Hora_Solicitud', array('class' => 'control-label')); ?>
            <p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Hora_Solicitud); ?></p>
        </div>
    </div>
    <?php if($model->Estado_Solicitud != 1){ ?>

    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Revision', array('class' => 'control-label')); ?>
            <p><?php echo $model->idusuariorev->Usuario; ?></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Hora_Revision', array('class' => 'control-label')); ?>
            <p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Hora_Revision); ?></p>
        </div>
    </div>
<?php } ?>
</div>

<div class="row mb-4">
    <div class="col-sm-6">
    <?php if($opc ==1){ ?>  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <?php }else{ ?> 
    	<button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/rev'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <?php } ?> 
    </div>
</div>
<?php $this->endWidget(); ?>
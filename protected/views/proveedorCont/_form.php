<?php
/* @var $this ProveedorContController */
/* @var $model ProveedorCont */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'proveedor-cont-form',
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
    		<?php echo $form->error($model,'Nit', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'Nit'); ?>
		    <?php echo $form->textField($model,'Nit', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Razon_Social', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'Razon_Social'); ?>
		    <?php echo $form->textField($model,'Razon_Social', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Telefono', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'Telefono'); ?>
		    <?php echo $form->textField($model,'Telefono', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Direccion', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'Direccion'); ?>
		    <?php echo $form->textField($model,'Direccion', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Ciudad', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'Ciudad'); ?>
		    <?php echo $form->textField($model,'Ciudad', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Estado', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ProveedorCont[Estado]',
                    'id'=>'ProveedorCont_Estado',
                    'data'=>$estados,
                    'value' => $model->Estado,
                    'htmlOptions'=>array(),
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

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=proveedorCont/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>

<?php $this->endWidget(); ?>
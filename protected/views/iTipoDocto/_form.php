<?php
/* @var $this ITipoDoctoController */
/* @var $model ITipoDocto */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'itipo-docto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Tipo'); ?>
            <?php echo $form->error($model,'Tipo', array('class' => 'badge badge-warning float-right')); ?>
		    <?php echo $form->textField($model,'Tipo', array('class' => 'form-control form-control-sm', 'maxlength' => '3', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Descripcion'); ?>
            <?php echo $form->error($model,'Descripcion', array('class' => 'badge badge-warning float-right')); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Estado'); ?>
            <?php echo $form->error($model,'Estado', array('class' => 'badge badge-warning float-right')); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ITipoDocto[Estado]',
                    'id'=>'ITipoDocto_Estado',
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
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=ITipoDocto/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>

<?php $this->endWidget(); ?>
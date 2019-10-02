<?php
/* @var $this SuministroController */
/* @var $model Suministro */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'suministro-form',
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
    		<?php echo $form->error($model,'Codigo', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Codigo'); ?>
		    <?php echo $form->textField($model,'Codigo', array('class' => 'form-control', 'maxlength' => '8', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Descripcion', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Descripcion'); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Referencia', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Referencia'); ?>
		    <?php echo $form->textField($model,'Referencia', array('class' => 'form-control', 'maxlength' => '20', 'autocomplete' => 'off')); ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Impresora', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Impresora'); ?>
		    <?php echo $form->textField($model,'Impresora', array('class' => 'form-control', 'maxlength' => '20', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Estado', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Suministro[Estado]',
                    'id'=>'Suministro_Estado',
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

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=suministro/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>

<?php $this->endWidget(); ?>

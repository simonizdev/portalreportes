<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menu-form',
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
    		<?php echo $form->error($model,'Descripcion', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Descripcion'); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control', 'maxlength' => '30', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Padre', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Padre'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Menu[Id_Padre]',
                    'id'=>'Menu_Id_Padre',
                    'data'=>$lista_opciones_p,
                    'value' => $model->Id_Padre,
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
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Link', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Link'); ?>
		    <?php echo $form->textField($model,'Link', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Orden', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Orden'); ?>
		    <?php echo $form->numberField($model,'Orden', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off', 'type' => 'number', 'min' => 1, 'max' => 20)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Font_Icon', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Font_Icon'); ?>
		    <?php echo $form->textField($model,'Font_Icon', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Estado', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Menu[Estado]',
                    'id'=>'Menu_Estado',
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
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=menu/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>
    

<?php $this->endWidget(); ?>

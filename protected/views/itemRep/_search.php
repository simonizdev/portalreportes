<?php
/* @var $this ItemRepController */
/* @var $model ItemRep */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Id_Item_Rep'); ?>
		<?php echo $form->textField($model,'Id_Item_Rep'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Rep'); ?>
		<?php echo $form->textField($model,'Id_Rep'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Item'); ?>
		<?php echo $form->textField($model,'Id_Item'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Orden'); ?>
		<?php echo $form->textField($model,'Orden'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Porcentaje'); ?>
		<?php echo $form->textField($model,'Porcentaje',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Estado'); ?>
		<?php echo $form->textField($model,'Estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Usuario_Creacion'); ?>
		<?php echo $form->textField($model,'Id_Usuario_Creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Usuario_Actualizacion'); ?>
		<?php echo $form->textField($model,'Id_Usuario_Actualizacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fecha_Creacion'); ?>
		<?php echo $form->textField($model,'Fecha_Creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fecha_Actualizacion'); ?>
		<?php echo $form->textField($model,'Fecha_Actualizacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
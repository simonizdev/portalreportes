<?php
/* @var $this IDoctoMovtoController */
/* @var $model IDoctoMovto */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Id'); ?>
		<?php echo $form->textField($model,'Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Docto'); ?>
		<?php echo $form->textField($model,'Id_Docto'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Bodega_Org'); ?>
		<?php echo $form->textField($model,'Id_Bodega_Org'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Bodega_Dst'); ?>
		<?php echo $form->textField($model,'Id_Bodega_Dst'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Id_Item'); ?>
		<?php echo $form->textField($model,'Id_Item'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Cantidad'); ?>
		<?php echo $form->textField($model,'Cantidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Vlr_Total_Item'); ?>
		<?php echo $form->textField($model,'Vlr_Total_Item',array('size'=>19,'maxlength'=>19)); ?>
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
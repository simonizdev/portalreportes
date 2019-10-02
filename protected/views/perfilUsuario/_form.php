<?php
/* @var $this PerfilUsuarioController */
/* @var $model PerfilUsuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'perfil-usuario-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Id_Usuario'); ?>
		<?php echo $form->textField($model,'Id_Usuario'); ?>
		<?php echo $form->error($model,'Id_Usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Id_Usuario_Creacion'); ?>
		<?php echo $form->textField($model,'Id_Usuario_Creacion'); ?>
		<?php echo $form->error($model,'Id_Usuario_Creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Id_Usuario_Actualizacion'); ?>
		<?php echo $form->textField($model,'Id_Usuario_Actualizacion'); ?>
		<?php echo $form->error($model,'Id_Usuario_Actualizacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Id_Perfil'); ?>
		<?php echo $form->textField($model,'Id_Perfil'); ?>
		<?php echo $form->error($model,'Id_Perfil'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Estado'); ?>
		<?php echo $form->checkBox($model,'Estado'); ?>
		<?php echo $form->error($model,'Estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Fecha_Creacion'); ?>
		<?php echo $form->textField($model,'Fecha_Creacion'); ?>
		<?php echo $form->error($model,'Fecha_Creacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Fecha_Actualizacion'); ?>
		<?php echo $form->textField($model,'Fecha_Actualizacion'); ?>
		<?php echo $form->error($model,'Fecha_Actualizacion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

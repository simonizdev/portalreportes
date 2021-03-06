<?php
/* @var $this BodegaUsuarioController */
/* @var $data BodegaUsuario */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_B_Usuario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_B_Usuario), array('view', 'id'=>$data->Id_B_Usuario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Bodega')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Bodega); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estado')); ?>:</b>
	<?php echo CHtml::encode($data->Estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Creacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Actualizacion); ?>
	<br />

	*/ ?>

</div>
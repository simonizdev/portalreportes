<?php
/* @var $this PromocionController */
/* @var $data Promocion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Promocion')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_Promocion), array('view', 'id'=>$data->Id_Promocion)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Item_Padre')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Item_Padre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Item_Hijo')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Item_Hijo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad); ?>
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
<?php
/* @var $this ItemFeeController */
/* @var $data ItemFee */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Fee_Item')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_Fee_Item), array('view', 'id'=>$data->Id_Fee_Item)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Rowid_Item')); ?>:</b>
	<?php echo CHtml::encode($data->Rowid_Item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Porcentaje')); ?>:</b>
	<?php echo CHtml::encode($data->Porcentaje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estado')); ?>:</b>
	<?php echo CHtml::encode($data->Estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Actualizacion); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Actualizacion); ?>
	<br />

	*/ ?>

</div>
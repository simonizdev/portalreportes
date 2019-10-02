<?php
/* @var $this IDoctoMovtoController */
/* @var $data IDoctoMovto */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Docto')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Docto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Bodega_Org')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Bodega_Org); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Bodega_Dst')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Bodega_Dst); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Item')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Vlr_Total_Item')); ?>:</b>
	<?php echo CHtml::encode($data->Vlr_Total_Item); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Actualizacion); ?>
	<br />

	*/ ?>

</div>
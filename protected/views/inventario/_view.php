<?php
/* @var $this InventarioController */
/* @var $data Inventario */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Inventario')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_Inventario), array('view', 'id'=>$data->Id_Inventario)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Suministro')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Suministro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Departamento')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Departamento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Documento')); ?>:</b>
	<?php echo CHtml::encode($data->Documento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Actualizacion); ?>
	<br />

	*/ ?>

</div>
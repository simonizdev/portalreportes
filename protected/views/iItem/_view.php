<?php
/* @var $this IItemController */
/* @var $data IItem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Item')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Referencia')); ?>:</b>
	<?php echo CHtml::encode($data->Referencia); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->Descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UND_Medida')); ?>:</b>
	<?php echo CHtml::encode($data->UND_Medida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Linea')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Linea); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mes_Stock')); ?>:</b>
	<?php echo CHtml::encode($data->Mes_Stock); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Min_Stock')); ?>:</b>
	<?php echo CHtml::encode($data->Min_Stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Max_Stock')); ?>:</b>
	<?php echo CHtml::encode($data->Max_Stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nota')); ?>:</b>
	<?php echo CHtml::encode($data->Nota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estado')); ?>:</b>
	<?php echo CHtml::encode($data->Estado); ?>
	<br />

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
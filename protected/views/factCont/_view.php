<?php
/* @var $this FactPendController */
/* @var $data FactPend */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Fact')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_Fact), array('view', 'id'=>$data->Id_Fact)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Radicado')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Radicado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->Proveedor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Factura')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Factura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Entregada_A')); ?>:</b>
	<?php echo CHtml::encode($data->Entregada_A); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Valor')); ?>:</b>
	<?php echo CHtml::encode($data->Valor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Moneda')); ?>:</b>
	<?php echo CHtml::encode($data->Moneda); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Empresa')); ?>:</b>
	<?php echo CHtml::encode($data->Empresa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Observaciones')); ?>:</b>
	<?php echo CHtml::encode($data->Observaciones); ?>
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
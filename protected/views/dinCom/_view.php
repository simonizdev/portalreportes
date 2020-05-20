<?php
/* @var $this DinComController */
/* @var $data DinCom */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Dic_Com')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_Dic_Com), array('view', 'id'=>$data->Id_Dic_Com)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Inicio')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Fin')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Fin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Plan_Cliente')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Plan_Cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Criterio_Cliente')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Criterio_Cliente); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Plan_item')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Plan_item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Criterio_Item')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Criterio_Item); ?>
	<br />

	<?php /*
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Actualizacion); ?>
	<br />

	*/ ?>

</div>
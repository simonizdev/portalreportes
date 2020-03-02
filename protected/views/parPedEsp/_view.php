<?php
/* @var $this ParPedEspController */
/* @var $data ParPedEsp */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Par_Ped_Esp')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_Par_Ped_Esp), array('view', 'id'=>$data->Id_Par_Ped_Esp)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Consecutivo')); ?>:</b>
	<?php echo CHtml::encode($data->Consecutivo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Nit')); ?>:</b>
	<?php echo CHtml::encode($data->Nit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Razon_Social')); ?>:</b>
	<?php echo CHtml::encode($data->Razon_Social); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Direccion')); ?>:</b>
	<?php echo CHtml::encode($data->Direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sucursal')); ?>:</b>
	<?php echo CHtml::encode($data->Sucursal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Punto_Envio')); ?>:</b>
	<?php echo CHtml::encode($data->Punto_Envio); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Ciudad')); ?>:</b>
	<?php echo CHtml::encode($data->Ciudad); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Estructura')); ?>:</b>
	<?php echo CHtml::encode($data->Estructura); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ruta')); ?>:</b>
	<?php echo CHtml::encode($data->Ruta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Asesor')); ?>:</b>
	<?php echo CHtml::encode($data->Asesor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Coordinador')); ?>:</b>
	<?php echo CHtml::encode($data->Coordinador); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Actualizacion); ?>
	<br />

	*/ ?>

</div>
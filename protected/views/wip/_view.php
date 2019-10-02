<?php
/* @var $this WipController */
/* @var $data Wip */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CONSECUTIVO')); ?>:</b>
	<?php echo CHtml::encode($data->CONSECUTIVO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_ITEM')); ?>:</b>
	<?php echo CHtml::encode($data->ID_ITEM); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DESCRIPCION')); ?>:</b>
	<?php echo CHtml::encode($data->DESCRIPCION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ESTADO_OP')); ?>:</b>
	<?php echo CHtml::encode($data->ESTADO_OP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('INVENTARIO_TOTAL')); ?>:</b>
	<?php echo CHtml::encode($data->INVENTARIO_TOTAL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DE_0_A_30_DIAS')); ?>:</b>
	<?php echo CHtml::encode($data->DE_0_A_30_DIAS); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('DE_31_A_60_DIAS')); ?>:</b>
	<?php echo CHtml::encode($data->DE_31_A_60_DIAS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DE_61_A_90_DIAS')); ?>:</b>
	<?php echo CHtml::encode($data->DE_61_A_90_DIAS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MAS_DE_90_DIAS')); ?>:</b>
	<?php echo CHtml::encode($data->MAS_DE_90_DIAS); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('WIP')); ?>:</b>
	<?php echo CHtml::encode($data->WIP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FECHA_SOLICITUD_WIP')); ?>:</b>
	<?php echo CHtml::encode($data->FECHA_SOLICITUD_WIP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FECHA_ENTREGA_WIP')); ?>:</b>
	<?php echo CHtml::encode($data->FECHA_ENTREGA_WIP); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CANT_A_ARMAR')); ?>:</b>
	<?php echo CHtml::encode($data->CANT_A_ARMAR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CANT_OC_AL_DIA')); ?>:</b>
	<?php echo CHtml::encode($data->CANT_OC_AL_DIA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CANT_PENDIENTE')); ?>:</b>
	<?php echo CHtml::encode($data->CANT_PENDIENTE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CADENA')); ?>:</b>
	<?php echo CHtml::encode($data->CADENA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('RESPONSABLE')); ?>:</b>
	<?php echo CHtml::encode($data->RESPONSABLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DIAS_VENCIMIENTO')); ?>:</b>
	<?php echo CHtml::encode($data->DIAS_VENCIMIENTO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('REDISTRIBUCION')); ?>:</b>
	<?php echo CHtml::encode($data->REDISTRIBUCION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ESTADO_COMERCIAL')); ?>:</b>
	<?php echo CHtml::encode($data->ESTADO_COMERCIAL); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UN')); ?>:</b>
	<?php echo CHtml::encode($data->UN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SUB_MARCA')); ?>:</b>
	<?php echo CHtml::encode($data->SUB_MARCA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FAMILIA')); ?>:</b>
	<?php echo CHtml::encode($data->FAMILIA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SUB_FAMILIA')); ?>:</b>
	<?php echo CHtml::encode($data->SUB_FAMILIA); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GRUPO')); ?>:</b>
	<?php echo CHtml::encode($data->GRUPO); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ORACLE')); ?>:</b>
	<?php echo CHtml::encode($data->ORACLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PTM')); ?>:</b>
	<?php echo CHtml::encode($data->PTM); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_USUARIO_CREACION')); ?>:</b>
	<?php echo CHtml::encode($data->ID_USUARIO_CREACION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID_USUARIO_ACTUALIZACION')); ?>:</b>
	<?php echo CHtml::encode($data->ID_USUARIO_ACTUALIZACION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FECHA_CREACION')); ?>:</b>
	<?php echo CHtml::encode($data->FECHA_CREACION); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FECHA_ACTUALIZACION')); ?>:</b>
	<?php echo CHtml::encode($data->FECHA_ACTUALIZACION); ?>
	<br />

	*/ ?>

</div>
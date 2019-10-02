<?php
/* @var $this MenuPerfilController */
/* @var $data MenuPerfil */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_M_Perfil')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_M_Perfil), array('view', 'id'=>$data->Id_M_Perfil)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Perfil')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Perfil); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Menu')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Menu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Actualizacion); ?>
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
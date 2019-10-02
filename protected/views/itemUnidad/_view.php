<?php
/* @var $this ItemUnidadController */
/* @var $data ItemUnidad */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Item_Unidad')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id_Item_Unidad), array('view', 'id'=>$data->Id_Item_Unidad)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Item')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Item); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id_Usuario_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Id_Usuario_Actualizacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Foto')); ?>:</b>
	<?php echo CHtml::encode($data->Foto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Lead_Time')); ?>:</b>
	<?php echo CHtml::encode($data->Lead_Time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('UN_Venta')); ?>:</b>
	<?php echo CHtml::encode($data->UN_Venta); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('UN_Cadena')); ?>:</b>
	<?php echo CHtml::encode($data->UN_Cadena); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Unidad_1')); ?>:</b>
	<?php echo CHtml::encode($data->Unidad_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Descripcion1')); ?>:</b>
	<?php echo CHtml::encode($data->Descripcion1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad1')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Largo1')); ?>:</b>
	<?php echo CHtml::encode($data->Largo1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Alto1')); ?>:</b>
	<?php echo CHtml::encode($data->Alto1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ancho1')); ?>:</b>
	<?php echo CHtml::encode($data->Ancho1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Volumen_Total1')); ?>:</b>
	<?php echo CHtml::encode($data->Volumen_Total1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Peso_Total1')); ?>:</b>
	<?php echo CHtml::encode($data->Peso_Total1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cod_Barras1')); ?>:</b>
	<?php echo CHtml::encode($data->Cod_Barras1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Unidad_2')); ?>:</b>
	<?php echo CHtml::encode($data->Unidad_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Descripcion2')); ?>:</b>
	<?php echo CHtml::encode($data->Descripcion2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad2')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Largo2')); ?>:</b>
	<?php echo CHtml::encode($data->Largo2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Alto2')); ?>:</b>
	<?php echo CHtml::encode($data->Alto2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ancho2')); ?>:</b>
	<?php echo CHtml::encode($data->Ancho2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Volumen_Total2')); ?>:</b>
	<?php echo CHtml::encode($data->Volumen_Total2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Peso_Total2')); ?>:</b>
	<?php echo CHtml::encode($data->Peso_Total2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cod_Barras2')); ?>:</b>
	<?php echo CHtml::encode($data->Cod_Barras2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Unidad_3')); ?>:</b>
	<?php echo CHtml::encode($data->Unidad_3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Descripcion3')); ?>:</b>
	<?php echo CHtml::encode($data->Descripcion3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad3')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Largo3')); ?>:</b>
	<?php echo CHtml::encode($data->Largo3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Alto3')); ?>:</b>
	<?php echo CHtml::encode($data->Alto3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ancho3')); ?>:</b>
	<?php echo CHtml::encode($data->Ancho3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Volumen_Total3')); ?>:</b>
	<?php echo CHtml::encode($data->Volumen_Total3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Peso_Total3')); ?>:</b>
	<?php echo CHtml::encode($data->Peso_Total3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cod_Barras3')); ?>:</b>
	<?php echo CHtml::encode($data->Cod_Barras3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Unidad_4')); ?>:</b>
	<?php echo CHtml::encode($data->Unidad_4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Descripcion4')); ?>:</b>
	<?php echo CHtml::encode($data->Descripcion4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cantidad4')); ?>:</b>
	<?php echo CHtml::encode($data->Cantidad4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Largo4')); ?>:</b>
	<?php echo CHtml::encode($data->Largo4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Alto4')); ?>:</b>
	<?php echo CHtml::encode($data->Alto4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ancho4')); ?>:</b>
	<?php echo CHtml::encode($data->Ancho4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Volumen_Total4')); ?>:</b>
	<?php echo CHtml::encode($data->Volumen_Total4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Peso_Total4')); ?>:</b>
	<?php echo CHtml::encode($data->Peso_Total4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cod_Barras4')); ?>:</b>
	<?php echo CHtml::encode($data->Cod_Barras4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Creacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Creacion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Fecha_Actualizacion')); ?>:</b>
	<?php echo CHtml::encode($data->Fecha_Actualizacion); ?>
	<br />

	*/ ?>

</div>
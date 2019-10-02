<?php
/* @var $this IDoctoMovtoController */
/* @var $model IDoctoMovto */

//para combos de lineas
$lista_bodegas = CHtml::listData($bodegas, 'Id', 'Descripcion'); 

?>

<h3>Actualización de detalle</h3>

<?php $this->renderPartial('_form2', array('model'=>$model, 'id'=>$id, 'lista_bodegas'=>$lista_bodegas)); ?>
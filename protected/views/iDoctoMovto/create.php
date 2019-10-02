<?php
/* @var $this IDoctoMovtoController */
/* @var $model IDoctoMovto */

//para combos de lineas
$lista_bodegas = CHtml::listData($bodegas, 'Id', 'Descripcion'); 

?>

<h3>Creación de detalle</h3>

<?php $this->renderPartial('_form', array('model'=>$model, 'id'=>$id, 'lista_bodegas'=>$lista_bodegas)); ?>
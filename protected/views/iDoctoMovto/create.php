<?php
/* @var $this IDoctoMovtoController */
/* @var $model IDoctoMovto */

//para combos de lineas
$lista_bodegas = CHtml::listData($bodegas, 'Id', 'Descripcion'); 

?>

<h4>Creación de detalle</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'id'=>$id, 'lista_bodegas'=>$lista_bodegas)); ?>
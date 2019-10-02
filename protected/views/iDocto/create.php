<?php
/* @var $this IDoctoController */
/* @var $model IDocto */

//para combos de tipos
$lista_tipos = CHtml::listData($tipos, 'Id', 'Descripcion'); 

//para combos de lineas
$lista_bodegas = CHtml::listData($bodegas, 'Id', 'Descripcion'); 

?>

<h3>Creación de documento</h3>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_tipos'=>$lista_tipos, 'lista_bodegas'=>$lista_bodegas)); ?>
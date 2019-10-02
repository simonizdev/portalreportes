<?php
/* @var $this ITerceroController */
/* @var $model ITercero */

//para combos de tipos
$lista_tipos = CHtml::listData($tipos, 'Id', 'Descripcion'); 

?>

<h3>Creación de tercero</h3>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_tipos'=>$lista_tipos)); ?>
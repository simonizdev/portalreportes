<?php
/* @var $this MenuController */
/* @var $model Menu */

//para combos de opciones padre
$lista_opciones_p = CHtml::listData($opciones_p, 'Id_Menu', 'Descripcion'); 

?>

<h4>Actualización opción de menu</h4> 
<?php $this->renderPartial('_form', array('model'=>$model, 'lista_opciones_p'=>$lista_opciones_p)); ?>
<?php
/* @var $this MenuController */
/* @var $model Menu */

//para combos de opciones padre
$lista_opciones_p = CHtml::listData($opciones_p, 'Id_Menu', 'Descripcion'); 

?>

<h3>Creación opción de menu</h3>    
<?php $this->renderPartial('_form', array('model'=>$model, 'lista_opciones_p'=>$lista_opciones_p)); ?>  
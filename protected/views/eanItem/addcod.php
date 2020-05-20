<?php
/* @var $this EanItemController */
/* @var $model EanItem */

?>

<h4>Creación código de barras</h4>

<?php $this->renderPartial('_form2', array('modelo_info_item'=>$modelo_info_item, 'model'=>$model, 'array_nu' => $array_nu)); ?>
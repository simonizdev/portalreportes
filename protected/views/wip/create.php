<?php
/* @var $this WipController */
/* @var $model Wip */

?>

<h4>Creación de WIP</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'n_wip'=>$n_wip, 'lista_cadenas'=>$lista_cadenas, 'fecha_min' => $fecha_min)); ?>
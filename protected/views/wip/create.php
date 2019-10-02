<?php
/* @var $this WipController */
/* @var $model Wip */

?>

<h3>Creación de WIP</h3>

<?php $this->renderPartial('_form', array('model'=>$model, 'n_wip'=>$n_wip, 'lista_cadenas'=>$lista_cadenas, 'fecha_min' => $fecha_min)); ?>
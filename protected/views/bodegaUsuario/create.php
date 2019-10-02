<?php
/* @var $this BodegaUsuarioController */
/* @var $model BodegaUsuario */

$this->breadcrumbs=array(
	'Bodega Usuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BodegaUsuario', 'url'=>array('index')),
	array('label'=>'Manage BodegaUsuario', 'url'=>array('admin')),
);
?>

<h1>Create BodegaUsuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
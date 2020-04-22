<?php
/* @var $this AreaUsuarioController */
/* @var $model AreaUsuario */

$this->breadcrumbs=array(
	'Area Usuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AreaUsuario', 'url'=>array('index')),
	array('label'=>'Manage AreaUsuario', 'url'=>array('admin')),
);
?>

<h1>Create AreaUsuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this MenuPerfilController */
/* @var $model MenuPerfil */

$this->breadcrumbs=array(
	'Menu Perfils'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MenuPerfil', 'url'=>array('index')),
	array('label'=>'Manage MenuPerfil', 'url'=>array('admin')),
);
?>

<h1>Create MenuPerfil</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
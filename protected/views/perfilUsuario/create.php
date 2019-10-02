<?php
/* @var $this PerfilUsuarioController */
/* @var $model PerfilUsuario */

$this->breadcrumbs=array(
	'Perfil Usuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PerfilUsuario', 'url'=>array('index')),
	array('label'=>'Manage PerfilUsuario', 'url'=>array('admin')),
);
?>

<h1>Create PerfilUsuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
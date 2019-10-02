<?php
/* @var $this TipoDoctoUsuarioController */
/* @var $model TipoDoctoUsuario */

$this->breadcrumbs=array(
	'Tipo Docto Usuarios'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TipoDoctoUsuario', 'url'=>array('index')),
	array('label'=>'Manage TipoDoctoUsuario', 'url'=>array('admin')),
);
?>

<h1>Create TipoDoctoUsuario</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this PerfilUsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Perfil Usuarios',
);

$this->menu=array(
	array('label'=>'Create PerfilUsuario', 'url'=>array('create')),
	array('label'=>'Manage PerfilUsuario', 'url'=>array('admin')),
);
?>

<h1>Perfil Usuarios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

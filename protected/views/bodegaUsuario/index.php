<?php
/* @var $this BodegaUsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bodega Usuarios',
);

$this->menu=array(
	array('label'=>'Create BodegaUsuario', 'url'=>array('create')),
	array('label'=>'Manage BodegaUsuario', 'url'=>array('admin')),
);
?>

<h1>Bodega Usuarios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

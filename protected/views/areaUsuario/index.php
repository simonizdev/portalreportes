<?php
/* @var $this AreaUsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Area Usuarios',
);

$this->menu=array(
	array('label'=>'Create AreaUsuario', 'url'=>array('create')),
	array('label'=>'Manage AreaUsuario', 'url'=>array('admin')),
);
?>

<h1>Area Usuarios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

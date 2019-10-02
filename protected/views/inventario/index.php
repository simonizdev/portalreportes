<?php
/* @var $this InventarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inventarios',
);

$this->menu=array(
	array('label'=>'Create Inventario', 'url'=>array('create')),
	array('label'=>'Manage Inventario', 'url'=>array('admin')),
);
?>

<h1>Inventarios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

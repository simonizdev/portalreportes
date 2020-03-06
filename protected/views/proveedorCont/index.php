<?php
/* @var $this ProveedorContController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Proveedor Conts',
);

$this->menu=array(
	array('label'=>'Create ProveedorCont', 'url'=>array('create')),
	array('label'=>'Manage ProveedorCont', 'url'=>array('admin')),
);
?>

<h1>Proveedor Conts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

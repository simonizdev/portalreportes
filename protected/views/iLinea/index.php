<?php
/* @var $this ILineaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ilineas',
);

$this->menu=array(
	array('label'=>'Create ILinea', 'url'=>array('create')),
	array('label'=>'Manage ILinea', 'url'=>array('admin')),
);
?>

<h1>Ilineas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

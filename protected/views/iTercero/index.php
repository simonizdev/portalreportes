<?php
/* @var $this ITerceroController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Iterceros',
);

$this->menu=array(
	array('label'=>'Create ITercero', 'url'=>array('create')),
	array('label'=>'Manage ITercero', 'url'=>array('admin')),
);
?>

<h1>Iterceros</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

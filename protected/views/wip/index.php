<?php
/* @var $this WipController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Wips',
);

$this->menu=array(
	array('label'=>'Create Wip', 'url'=>array('create')),
	array('label'=>'Manage Wip', 'url'=>array('admin')),
);
?>

<h1>Wips</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
/* @var $this FactPendController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fact Pends',
);

$this->menu=array(
	array('label'=>'Create FactPend', 'url'=>array('create')),
	array('label'=>'Manage FactPend', 'url'=>array('admin')),
);
?>

<h1>Fact Pends</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
/* @var $this RegImpController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Reg Imps',
);

$this->menu=array(
	array('label'=>'Create RegImp', 'url'=>array('create')),
	array('label'=>'Manage RegImp', 'url'=>array('admin')),
);
?>

<h1>Reg Imps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

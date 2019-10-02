<?php
/* @var $this IItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Iitems',
);

$this->menu=array(
	array('label'=>'Create IItem', 'url'=>array('create')),
	array('label'=>'Manage IItem', 'url'=>array('admin')),
);
?>

<h1>Iitems</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

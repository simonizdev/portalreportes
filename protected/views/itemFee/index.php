<?php
/* @var $this ItemFeeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Item Fees',
);

$this->menu=array(
	array('label'=>'Create ItemFee', 'url'=>array('create')),
	array('label'=>'Manage ItemFee', 'url'=>array('admin')),
);
?>

<h1>Item Fees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

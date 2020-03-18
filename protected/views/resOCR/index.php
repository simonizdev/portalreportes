<?php
/* @var $this ResOCRController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Res Ocrs',
);

$this->menu=array(
	array('label'=>'Create ResOCR', 'url'=>array('create')),
	array('label'=>'Manage ResOCR', 'url'=>array('admin')),
);
?>

<h1>Res Ocrs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

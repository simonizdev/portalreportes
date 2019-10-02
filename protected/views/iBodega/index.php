<?php
/* @var $this IBodegaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ibodegas',
);

$this->menu=array(
	array('label'=>'Create IBodega', 'url'=>array('create')),
	array('label'=>'Manage IBodega', 'url'=>array('admin')),
);
?>

<h1>Ibodegas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

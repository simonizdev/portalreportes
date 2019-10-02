<?php
/* @var $this SuministroController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Suministros',
);

$this->menu=array(
	array('label'=>'Create Suministro', 'url'=>array('create')),
	array('label'=>'Manage Suministro', 'url'=>array('admin')),
);
?>

<h1>Suministros</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

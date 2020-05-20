<?php
/* @var $this DinComController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Din Coms',
);

$this->menu=array(
	array('label'=>'Create DinCom', 'url'=>array('create')),
	array('label'=>'Manage DinCom', 'url'=>array('admin')),
);
?>

<h1>Din Coms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

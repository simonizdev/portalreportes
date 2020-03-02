<?php
/* @var $this ParPedEspController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Par Ped Esps',
);

$this->menu=array(
	array('label'=>'Create ParPedEsp', 'url'=>array('create')),
	array('label'=>'Manage ParPedEsp', 'url'=>array('admin')),
);
?>

<h1>Par Ped Esps</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

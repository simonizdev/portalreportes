<?php
/* @var $this IDoctoMovtoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Idocto Movtos',
);

$this->menu=array(
	array('label'=>'Create IDoctoMovto', 'url'=>array('create')),
	array('label'=>'Manage IDoctoMovto', 'url'=>array('admin')),
);
?>

<h1>Idocto Movtos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

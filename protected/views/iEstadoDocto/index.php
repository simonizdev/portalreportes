<?php
/* @var $this IEstadoDoctoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Iestado Doctos',
);

$this->menu=array(
	array('label'=>'Create IEstadoDocto', 'url'=>array('create')),
	array('label'=>'Manage IEstadoDocto', 'url'=>array('admin')),
);
?>

<h1>Iestado Doctos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

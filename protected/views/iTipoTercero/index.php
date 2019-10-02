<?php
/* @var $this ITipoTerceroController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Itipo Terceros',
);

$this->menu=array(
	array('label'=>'Create ITipoTercero', 'url'=>array('create')),
	array('label'=>'Manage ITipoTercero', 'url'=>array('admin')),
);
?>

<h1>Itipo Terceros</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<?php
/* @var $this ITipoDoctoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Itipo Doctos',
);

$this->menu=array(
	array('label'=>'Create ITipoDocto', 'url'=>array('create')),
	array('label'=>'Manage ITipoDocto', 'url'=>array('admin')),
);
?>

<h1>Itipo Doctos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

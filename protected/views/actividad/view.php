<?php
/* @var $this ActividadController */
/* @var $model Actividad */

$this->breadcrumbs=array(
	'Actividads'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'List Actividad', 'url'=>array('index')),
	array('label'=>'Create Actividad', 'url'=>array('create')),
	array('label'=>'Update Actividad', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Delete Actividad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Actividad', 'url'=>array('admin')),
);
?>

<h1>View Actividad #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Fecha',
		'Hora',
		'Actividad',
		'Estado',
		'Fecha_Cierre',
		'Id_Usuario_Creacion',
		'Fecha_Creacion',
		'Id_Usuario_Actualizacion',
		'Fecha_Actualizacion',
	),
)); ?>

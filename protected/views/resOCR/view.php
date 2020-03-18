<?php
/* @var $this ResOCRController */
/* @var $model ResOCR */

$this->breadcrumbs=array(
	'Res Ocrs'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'List ResOCR', 'url'=>array('index')),
	array('label'=>'Create ResOCR', 'url'=>array('create')),
	array('label'=>'Update ResOCR', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Delete ResOCR', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ResOCR', 'url'=>array('admin')),
);
?>

<h1>View ResOCR #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Tipo',
		'Descripcion',
		'Doc_Soporte',
		'Estado',
		'Id_Usuario_Creacion',
		'Fecha_Creacion',
		'Id_Usuario_Actualizacion',
		'Fecha_Actualizacion',
	),
)); ?>

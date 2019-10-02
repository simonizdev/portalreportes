<?php
/* @var $this BodegaUsuarioController */
/* @var $model BodegaUsuario */

$this->breadcrumbs=array(
	'Bodega Usuarios'=>array('index'),
	$model->Id_B_Usuario,
);

$this->menu=array(
	array('label'=>'List BodegaUsuario', 'url'=>array('index')),
	array('label'=>'Create BodegaUsuario', 'url'=>array('create')),
	array('label'=>'Update BodegaUsuario', 'url'=>array('update', 'id'=>$model->Id_B_Usuario)),
	array('label'=>'Delete BodegaUsuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id_B_Usuario),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BodegaUsuario', 'url'=>array('admin')),
);
?>

<h1>View BodegaUsuario #<?php echo $model->Id_B_Usuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_B_Usuario',
		'Id_Usuario',
		'Id_Usuario_Creacion',
		'Id_Usuario_Actualizacion',
		'Id_Bodega',
		'Estado',
		'Fecha_Creacion',
		'Fecha_Actualizacion',
	),
)); ?>

<?php
/* @var $this TipoDoctoUsuarioController */
/* @var $model TipoDoctoUsuario */

$this->breadcrumbs=array(
	'Tipo Docto Usuarios'=>array('index'),
	$model->Id_Td_Usuario,
);

$this->menu=array(
	array('label'=>'List TipoDoctoUsuario', 'url'=>array('index')),
	array('label'=>'Create TipoDoctoUsuario', 'url'=>array('create')),
	array('label'=>'Update TipoDoctoUsuario', 'url'=>array('update', 'id'=>$model->Id_Td_Usuario)),
	array('label'=>'Delete TipoDoctoUsuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id_Td_Usuario),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TipoDoctoUsuario', 'url'=>array('admin')),
);
?>

<h1>View TipoDoctoUsuario #<?php echo $model->Id_Td_Usuario; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Td_Usuario',
		'Id_Usuario',
		'Id_Usuario_Creacion',
		'Id_Usuario_Actualizacion',
		'Id_Tipo_Docto',
		'Estado',
		'Fecha_Creacion',
		'Fecha_Actualizacion',
	),
)); ?>

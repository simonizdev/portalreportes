<?php
/* @var $this ParPedEspController */
/* @var $model ParPedEsp */

$this->breadcrumbs=array(
	'Par Ped Esps'=>array('index'),
	$model->Id_Par_Ped_Esp,
);

$this->menu=array(
	array('label'=>'List ParPedEsp', 'url'=>array('index')),
	array('label'=>'Create ParPedEsp', 'url'=>array('create')),
	array('label'=>'Update ParPedEsp', 'url'=>array('update', 'id'=>$model->Id_Par_Ped_Esp)),
	array('label'=>'Delete ParPedEsp', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id_Par_Ped_Esp),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ParPedEsp', 'url'=>array('admin')),
);
?>

<h1>View ParPedEsp #<?php echo $model->Id_Par_Ped_Esp; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Par_Ped_Esp',
		'Consecutivo',
		'Nit',
		'Razon_Social',
		'Direccion',
		'Sucursal',
		'Punto_Envio',
		'Ciudad',
		'Fecha',
		'Estructura',
		'Ruta',
		'Asesor',
		'Coordinador',
		'Estado',
		'Id_Usuario_Creacion',
		'Fecha_Creacion',
		'Id_Usuario_Actualizacion',
		'Fecha_Actualizacion',
	),
)); ?>

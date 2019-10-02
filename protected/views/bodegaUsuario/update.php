<?php
/* @var $this BodegaUsuarioController */
/* @var $model BodegaUsuario */

$this->breadcrumbs=array(
	'Bodega Usuarios'=>array('index'),
	$model->Id_B_Usuario=>array('view','id'=>$model->Id_B_Usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List BodegaUsuario', 'url'=>array('index')),
	array('label'=>'Create BodegaUsuario', 'url'=>array('create')),
	array('label'=>'View BodegaUsuario', 'url'=>array('view', 'id'=>$model->Id_B_Usuario)),
	array('label'=>'Manage BodegaUsuario', 'url'=>array('admin')),
);
?>

<h1>Update BodegaUsuario <?php echo $model->Id_B_Usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
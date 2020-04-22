<?php
/* @var $this AreaUsuarioController */
/* @var $model AreaUsuario */

$this->breadcrumbs=array(
	'Area Usuarios'=>array('index'),
	$model->Id_A_Usuario=>array('view','id'=>$model->Id_A_Usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List AreaUsuario', 'url'=>array('index')),
	array('label'=>'Create AreaUsuario', 'url'=>array('create')),
	array('label'=>'View AreaUsuario', 'url'=>array('view', 'id'=>$model->Id_A_Usuario)),
	array('label'=>'Manage AreaUsuario', 'url'=>array('admin')),
);
?>

<h1>Update AreaUsuario <?php echo $model->Id_A_Usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
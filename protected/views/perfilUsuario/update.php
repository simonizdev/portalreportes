<?php
/* @var $this PerfilUsuarioController */
/* @var $model PerfilUsuario */

$this->breadcrumbs=array(
	'Perfil Usuarios'=>array('index'),
	$model->Id_P_Usuario=>array('view','id'=>$model->Id_P_Usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List PerfilUsuario', 'url'=>array('index')),
	array('label'=>'Create PerfilUsuario', 'url'=>array('create')),
	array('label'=>'View PerfilUsuario', 'url'=>array('view', 'id'=>$model->Id_P_Usuario)),
	array('label'=>'Manage PerfilUsuario', 'url'=>array('admin')),
);
?>

<h1>Update PerfilUsuario <?php echo $model->Id_P_Usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
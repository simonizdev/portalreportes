<?php
/* @var $this MenuPerfilController */
/* @var $model MenuPerfil */

$this->breadcrumbs=array(
	'Menu Perfils'=>array('index'),
	$model->Id_M_Perfil=>array('view','id'=>$model->Id_M_Perfil),
	'Update',
);

$this->menu=array(
	array('label'=>'List MenuPerfil', 'url'=>array('index')),
	array('label'=>'Create MenuPerfil', 'url'=>array('create')),
	array('label'=>'View MenuPerfil', 'url'=>array('view', 'id'=>$model->Id_M_Perfil)),
	array('label'=>'Manage MenuPerfil', 'url'=>array('admin')),
);
?>

<h1>Update MenuPerfil <?php echo $model->Id_M_Perfil; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
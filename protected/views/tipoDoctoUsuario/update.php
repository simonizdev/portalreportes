<?php
/* @var $this TipoDoctoUsuarioController */
/* @var $model TipoDoctoUsuario */

$this->breadcrumbs=array(
	'Tipo Docto Usuarios'=>array('index'),
	$model->Id_Td_Usuario=>array('view','id'=>$model->Id_Td_Usuario),
	'Update',
);

$this->menu=array(
	array('label'=>'List TipoDoctoUsuario', 'url'=>array('index')),
	array('label'=>'Create TipoDoctoUsuario', 'url'=>array('create')),
	array('label'=>'View TipoDoctoUsuario', 'url'=>array('view', 'id'=>$model->Id_Td_Usuario)),
	array('label'=>'Manage TipoDoctoUsuario', 'url'=>array('admin')),
);
?>

<h1>Update TipoDoctoUsuario <?php echo $model->Id_Td_Usuario; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
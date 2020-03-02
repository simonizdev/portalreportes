<?php
/* @var $this ParPedEspController */
/* @var $model ParPedEsp */

$this->breadcrumbs=array(
	'Par Ped Esps'=>array('index'),
	$model->Id_Par_Ped_Esp=>array('view','id'=>$model->Id_Par_Ped_Esp),
	'Update',
);

$this->menu=array(
	array('label'=>'List ParPedEsp', 'url'=>array('index')),
	array('label'=>'Create ParPedEsp', 'url'=>array('create')),
	array('label'=>'View ParPedEsp', 'url'=>array('view', 'id'=>$model->Id_Par_Ped_Esp)),
	array('label'=>'Manage ParPedEsp', 'url'=>array('admin')),
);
?>

<h1>Update ParPedEsp <?php echo $model->Id_Par_Ped_Esp; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
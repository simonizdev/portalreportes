<?php
/* @var $this TipoDoctoUsuarioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tipo Docto Usuarios',
);

$this->menu=array(
	array('label'=>'Create TipoDoctoUsuario', 'url'=>array('create')),
	array('label'=>'Manage TipoDoctoUsuario', 'url'=>array('admin')),
);
?>

<h1>Tipo Docto Usuarios</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

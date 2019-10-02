<?php
/* @var $this MenuPerfilController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Menu Perfils',
);

$this->menu=array(
	array('label'=>'Create MenuPerfil', 'url'=>array('create')),
	array('label'=>'Manage MenuPerfil', 'url'=>array('admin')),
);
?>

<h1>Menu Perfils</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

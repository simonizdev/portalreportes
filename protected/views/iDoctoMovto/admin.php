<?php
/* @var $this IDoctoMovtoController */
/* @var $model IDoctoMovto */

$this->breadcrumbs=array(
	'Idocto Movtos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List IDoctoMovto', 'url'=>array('index')),
	array('label'=>'Create IDoctoMovto', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#idocto-movto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Idocto Movtos</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'idocto-movto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Id',
		'Id_Docto',
		'Id_Bodega_Org',
		'Id_Bodega_Dst',
		'Id_Item',
		'Cantidad',
		/*
		'Vlr_Total_Item',
		'Id_Usuario_Creacion',
		'Id_Usuario_Actualizacion',
		'Fecha_Creacion',
		'Fecha_Actualizacion',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

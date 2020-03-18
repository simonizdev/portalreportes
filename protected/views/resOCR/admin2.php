<?php
/* @var $this ResOCRController */
/* @var $model ResOCR */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#res-ocr-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 

?>

<h3>Descarga resumen ordenes de compra / remisiones</h3>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'lista_usuarios' => $lista_usuarios,
)); ?>
</div><!-- search-form -->
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'res-ocr-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		'Id',
		array(
            'name' => 'Tipo',
            'type' => 'raw',
            'value' => '($data->Tipo == "1") ? "ORDENES DE COMPRA" : "REMISIONES"',
        ),
		array(
            'name'=>'Id_Usuario_Creacion',
            'value'=>'$data->idusuariocre->Usuario',
        ),
        array(
            'name'=>'Fecha_Creacion',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Creacion)',
        ),
        array(
            'name'=>'Id_Usuario_Actualizacion',
            'value'=>'$data->idusuarioact->Usuario',
        ),
        array(
            'name'=>'Fecha_Actualizacion',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Actualizacion)',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{download}',
            'buttons'=>array(
                'download'=>array(
                    'label'=>'<i class="fa fa-file-excel-o actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Descargar resumen'),
                    'url'=>'Yii::app()->createUrl("resOCR/download", array("id"=>$data->Id))',
                ),
            )
		),
	),
)); ?>

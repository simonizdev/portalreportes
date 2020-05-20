<?php
/* @var $this ResOCRController */
/* @var $model ResOCR */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
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

<div class="row mb-2">
  <div class="col-sm-8">
    <h4>Descarga resumen ordenes de compra / remisiones</h4>
  </div>
  <div class="col-sm-4 text-right">
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
  </div>
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
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
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
                    'label'=>'<i class="fas fa-file-archive actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Descargar resumen'),
                    'url'=>'Yii::app()->createUrl("resOCR/download", array("id"=>$data->Id))',
                ),
            )
		),
	),
)); ?>

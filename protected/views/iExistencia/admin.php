<?php
/* @var $this IExistenciaController */
/* @var $model IExistencia */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('iexistencia-grid',{ 
        success: function() {
            window.location = '". $this->createUrl('exportexcel')  . "';
            $(\".ajax-loader\").fadeIn('fast');
            setTimeout(function(){ $(\".ajax-loader\").fadeOut('fast'); }, 10000);
        },
        data: $('.search-form form').serialize() + '&export=true'
    });
}
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#iexistencia-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de bodegas
$lista_bodegas = CHtml::listData($bodegas, 'Id', 'Descripcion'); 

//para combos de lineas
$lista_lineas = CHtml::listData($lineas, 'Id', 'Descripcion'); 

?>

<h3>Consulta de existencias x bodega</h3>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
    <button type="button" class="btn btn-success" id="export-excel"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'lista_bodegas'=>$lista_bodegas,
    'lista_lineas'=>$lista_lineas,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'iexistencia-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		array(
            'header' => 'Línea',
            'type' => 'raw',
            'value' => '$data->iditem->idlinea->Descripcion',
        ),
        array(
            'name' => 'Id_Item',
            'type' => 'raw',
            'value' => '$data->DescItem($data->Id_Item)',
        ),
		array(
            'name'=>'Id_Bodega',
            'value' => '($data->Id_Bodega == "") ? "N/A" : $data->idbodega->Descripcion',
        ),
        array(
            'name'=>'Cantidad',
            'value'=>'$data->Cantidad',
            'cssClassExpression' => 'UtilidadesVarias::estadoexiststock($data->Id_Item, $data->Cantidad)',
        ),
		array(
            'name'=>'Fecha_Ult_Ent',
            'value' => '($data->Fecha_Ult_Ent == "") ? "N/A" : UtilidadesVarias::textofecha($data->Fecha_Ult_Ent)',
        ),
        array(
            'name'=>'Fecha_Ult_Sal',
            'value' => '($data->Fecha_Ult_Sal == "") ? "N/A" : UtilidadesVarias::textofecha($data->Fecha_Ult_Sal)',
        ),
		/*
		'Id_Usuario_Actualizacion',
		'Fecha_Actualizacion',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
            )
		),
	),
)); ?>

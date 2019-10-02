<?php
/* @var $this ItemUnidadController */
/* @var $model ItemUnidad */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('item-unidad-grid',{ 
        success: function() {
            window.location = '". $this->createUrl('exportexcel')  . "';
            $(\".ajax-loader\").fadeIn('fast');
            setTimeout(function(){ $(\".ajax-loader\").fadeOut('fast'); }, 20000);
        },
        data: $('.search-form form').serialize() + '&export=true'
    });
}
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#item-unidad-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 

?>

<h3>Administración de unidades por item</h3>

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=itemUnidad/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
    <button type="button" class="btn btn-success" id="export-excel"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-unidad-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'enableSorting' => false, 
	'columns'=>array(
		'Id_Item_Unidad',
		array(
            'name'=>'Id_Item',
            'value'=>'$data->Desc_Item($data->Id_Item)',
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
        /*
		'UN_Venta',
		'UN_Cadena',
		'Unidad_1',
		'Descripcion1',
		'Cantidad1',
		'Largo1',
		'Alto1',
		'Ancho1',
		'Volumen_Total1',
		'Peso_Total1',
		'Cod_Barras1',
		'Unidad_2',
		'Descripcion2',
		'Cantidad2',
		'Largo2',
		'Alto2',
		'Ancho2',
		'Volumen_Total2',
		'Peso_Total2',
		'Cod_Barras2',
		'Unidad_3',
		'Descripcion3',
		'Cantidad3',
		'Largo3',
		'Alto3',
		'Ancho3',
		'Volumen_Total3',
		'Peso_Total3',
		'Cod_Barras3',
		'Unidad_4',
		'Descripcion4',
		'Cantidad4',
		'Largo4',
		'Alto4',
		'Ancho4',
		'Volumen_Total4',
		'Peso_Total4',
		'Cod_Barras4',
		*/
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}{delete}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Actualizar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
                'delete'=>array(
                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Eliminar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
            )
        ),
	),
)); ?>

<?php
/* @var $this BodegaUsuarioController */
/* @var $model BodegaUsuario */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('bodega-usuario-grid',{ 
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
	$('#bodega-usuario-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 
//para combos de bodegas
$lista_bodegas = CHtml::listData($bodegas, 'Descripcion', 'Descripcion'); 

?>

<h3>Consulta de bodegas por usuario</h3>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
    <button type="button" class="btn btn-success" id="export-excel"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
    'lista_bodegas' => $lista_bodegas,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bodega-usuario-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		'Id_B_Usuario',
		array(
            'name'=>'usuario',
            'value'=>'$data->idusuario->Usuario',
        ),
        array(
            'name'=>'bodega',
            'value'=>'$data->idbodega->Descripcion',
        ),
		/*array(
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
        ),*/
        array(
            'name' => 'Estado',
            'type' => 'raw',
            'value' => '($data->Estado == "1") ? "Activo" : "Inactivo"',
        ),
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

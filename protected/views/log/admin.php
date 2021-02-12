<?php
/* @var $this LogController */
/* @var $model Log */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('log-grid',{ 
        success: function() {
            window.location = '". $this->createUrl('exportexcel')  . "';
            $(\".ajax-loader\").fadeIn('fast');
            setTimeout(function(){ $(\".ajax-loader\").fadeOut('fast'); }, 10000);
        },
        data: $('.search-form form').serialize() + '&export=true'
    });
}
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Nombres'); 

$lista_opciones = array();

//para combo de opciones padre
foreach ($opciones as $reg) {
	$opcs = new Log;
	$lista_opciones[$reg['Id_Menu']] = $opcs->DescOpcPadre($reg['Id_Menu']);
}

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Log sesiones y consultas en menú</h4>
  </div>
  <div class="col-sm-6 text-right"> 
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
    <button type="button" class="btn btn-success btn-sm" id="export-excel"><i class="fas fa-file-excel"></i> Exportar a EXCEL</button>
  </div>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
    'lista_opciones' => $lista_opciones,
)); ?>
</div><!-- search-form -->
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'log-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		array(
            'name'=>'Tipo',
            'value'=>'$data->DescTipo($data->Tipo)',
        ),
		array(
            'name'=>'Id_Usuario',
            'value'=>'$data->idusuario->Nombres',
        ),
		array(
            'name' => 'Id_Menu',
            'value' => '($data->Id_Menu == "") ? "-" : $data->DescOpcPadre($data->Id_Menu)',
        ),
		array(
            'name' => 'Accion',
            'value' => '($data->Accion == "") ? "-" : $data->Accion',
        ),
		array(
            'name'=>'Fecha_Hora',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Hora)',
        ),
	),
)); ?>

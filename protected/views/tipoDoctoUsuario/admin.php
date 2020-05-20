<?php
/* @var $this TipoDoctoUsuarioController */
/* @var $model TipoDoctoUsuario */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('tipo-docto-usuario-grid',{ 
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
    $('#tipo-docto-usuario-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 
//para combos de tipos de docto
$lista_tipos_docto = CHtml::listData($tipos_docto, 'Descripcion', 'Descripcion'); 

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Consulta tipos de documento por usuario</h4>
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
    'lista_tipos_docto' => $lista_tipos_docto,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'tipo-docto-usuario-grid',
    'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
    'columns'=>array(
        'Id_Td_Usuario',
        array(
            'name'=>'usuario',
            'value'=>'$data->idusuario->Usuario',
        ),
        array(
            'name'=>'tipo_docto',
            'value'=>'$data->idtipodocto->Descripcion',
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
            'value' => 'UtilidadesVarias::textoestado1($data->Estado)',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
            )
        ),
    ),
)); ?>
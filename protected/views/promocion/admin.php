<?php
/* @var $this PromocionController */
/* @var $model Promocion */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('promocion-grid',{ 
        success: function() {
            window.location = '". $this->createUrl('exportexcel')  . "';
            $(\".ajax-loader\").fadeIn('fast');
            setTimeout(function(){ $(\".ajax-loader\").fadeOut('fast'); }, 20000);
        },
        data: $('.search-form form').serialize() + '&export=true'
    });
}
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#promocion-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración de promociones</h4>
  </div>
  <div class="col-sm-6 text-right"> 
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=promocion/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button> 
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
    <button type="button" class="btn btn-success btn-sm" id="export-excel"><i class="fas fa-file-excel"></i> Exportar a EXCEL</button>
  </div>
</div>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check-circle"></i>Realizado</h5>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<?php if(Yii::app()->user->hasFlash('warning')):?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info-circle"></i>Info</h5>
        <?php echo Yii::app()->user->getFlash('warning'); ?>
    </div>
<?php endif; ?> 

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
)); ?>
</div><!-- search-form -->

<?php 

$this->widget('ext.groupgridview.GroupGridView', array(
    'id' => 'promocion-grid',
    'dataProvider' => $model->search(),
    'mergeColumns' => array('Id_Item_Padre'), 
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
    'columns' => array(
        array(
            'name'=>'Id_Item_Padre',
            'value'=>'$data->Desc_Item($data->Id_Item_Padre)',
        ),
        array(
            'name'=>'Id_Item_Hijo',
            'value'=>'$data->Desc_Item($data->Id_Item_Hijo)',
        ),
        'Cantidad',
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
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}{delete}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
                'update'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Actualizar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
                'delete'=>array(
                    'label'=>'<i class="fa fa-times-circle actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Eliminar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
            )
        ),
    ),

));

?>


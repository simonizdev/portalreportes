<?php
/* @var $this EanItemController */
/* @var $model EanItem */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#ean-item-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración códigos de barras</h4>
  </div>
  <div class="col-sm-6 text-right"> 
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=eanItem/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button> 
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
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
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ean-item-grid',
    'dataProvider' => $model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		array(
            'name'=>'Id_Item',
            'value'=>'$data->DescItem($data->Id_Item)',
        ),
		array(
            'name'=>'Criterio',
            'value'=>'$data->DescCriterio($data->Criterio)',
        ),
        array(
            'name'=>'cod_asoc',
            'value'=>'$data->CodAsoc($data->Id_Item)',
        ),
        /*array(
            'name'=>'Código',
            'value'=>'$data->EanDig($data->Id_Ean_Item)',
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
        ),*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Actualizar'),
                    'url'=>'Yii::app()->createUrl("eanItem/view", array("id"=>$data->Id_Item))',
                ),
            )
		),
	),
)); ?>

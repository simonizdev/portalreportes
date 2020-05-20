<?php
/* @var $this ParPedEspController */
/* @var $model ParPedEsp */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#par-ped-esp-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row mb-2">
  <div class="col-sm-8">
    <h4>Aprob. / rechazo doctos de param. pedidos especiales</h4>
  </div>
  <div class="col-sm-4 text-right">  
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

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'par-ped-esp-grid',
	'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Consecutivo',
		array(
            'name'=>'Fecha',
            'value'=>'UtilidadesVarias::textofecha($data->Fecha)',
        ),
		array(
            'name' => 'Nit',
            'value' => '$data->DescCliente($data->Id_Par_Ped_Esp)',
        ),
		array(
            'name' => 'Estado',
            'value' => '$data->DescEstado($data->Estado)',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{apro}{rech}',
            'buttons'=>array(
                'apro'=>array(
                    'label'=>'<i class="fas fa-check-circle actions text-dark"></i>',
                    'imageUrl'=>false,
                    'url'=>'Yii::app()->createUrl("parPedEsp/aprodoc", array("id"=>$data->Id_Par_Ped_Esp))',
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->Estado == 1)',
                    'options'=>array('title'=>'Aprobar', 'confirm'=>'Esta seguro de aprobar este documento ?'),

                ),
                'rech'=>array(
                    'label'=>'<i class="fas fa-times-circle actions text-dark"></i>',
                    'imageUrl'=>false,
                    'url'=>'Yii::app()->createUrl("parPedEsp/rechdoc", array("id"=>$data->Id_Par_Ped_Esp))',
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->Estado == 1)',
                    'options'=>array('title'=>'Rechazar', 'confirm'=>'Esta seguro de rechazar este documento ?'),

                ),
            )
		),
	),
)); ?>

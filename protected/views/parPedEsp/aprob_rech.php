<?php
/* @var $this ParPedEspController */
/* @var $model ParPedEsp */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
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

<h3>Aprob. / rechazo doctos de param. pedidos especiales</h3>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i>Realizado</h4>
      <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<?php if(Yii::app()->user->hasFlash('warning')):?>
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-info"></i>Info</h4>
      <?php echo Yii::app()->user->getFlash('warning'); ?>
    </div>
<?php endif; ?>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
</div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'par-ped-esp-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
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
                    'label'=>'<i class="fa fa-check actions text-black"></i>',
                    'imageUrl'=>false,
                    'url'=>'Yii::app()->createUrl("parPedEsp/aprodoc", array("id"=>$data->Id_Par_Ped_Esp))',
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->Estado == 1)',
                    'options'=>array('title'=>'Aprobar', 'confirm'=>'Esta seguro de aprobar este documento ?'),

                ),
                'rech'=>array(
                    'label'=>'<i class="fa fa-close actions text-black"></i>',
                    'imageUrl'=>false,
                    'url'=>'Yii::app()->createUrl("parPedEsp/rechdoc", array("id"=>$data->Id_Par_Ped_Esp))',
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->Estado == 1)',
                    'options'=>array('title'=>'Rechazar', 'confirm'=>'Esta seguro de rechazar este documento ?'),

                ),
            )
		),
	),
)); ?>

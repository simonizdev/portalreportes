<?php
/* @var $this PedComController */
/* @var $model PedCom */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#ped-com-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Pedidos comerciales</h4>
  </div>
  <div class="col-sm-6 text-right"> 
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=pedCom/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button> 
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
	/*'lista_tipos'=>$lista_tipos,
	'lista_bodegas'=>$lista_bodegas,
	'lista_estados'=>$lista_estados,
    'lista_usuarios' => $lista_usuarios,*/
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ped-com-grid',
	'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Id_Ped_Com',
		/*array(
          'name' => 'Id_Usuario',
          'value' => '$data->idusuario->Nombres',
      	),*/
      	array(
            'name' => 'Fecha',
            'value' => '($data->Fecha == "") ? "-" : UtilidadesVarias::textofecha($data->Fecha)',
        ),
		    array(
          'name' => 'Cliente',
          'value' => '$data->DescCliente($data->Cliente)',
      	),
      	/*array(
          'name'=>'Fecha_Creacion',
          'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Creacion)',
      	),
      	array(
          'name'=>'Fecha_Actualizacion',
          'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Actualizacion)',
      	),*/
      	array(
          'name' => 'Estado',
          'value' => '$data->DescEstado($data->Estado)',
      	),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array(
                
                'update'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Modificar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
                
            )
		),    
	),
)); ?>
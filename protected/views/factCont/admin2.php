<?php
/* @var $this FactContController */
/* @var $model FactCont */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#fact-cont-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario');

$array_areas_usuario = Yii::app()->user->getState('array_areas');

?>

<?php if(!empty($array_areas_usuario)) { ?>
	
	<div class="row mb-2">
	  <div class="col-sm-6">
		<h4>Actualización estado de facturas</h4>
	  </div>
	  <div class="col-sm-6 text-right"> 
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
        'lista_usuarios' => $lista_usuarios,
        'lista_areas' => $lista_areas,
    )); ?>
    </div><!-- search-form -->

    <?php $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'fact-cont-grid',
    	'dataProvider'=>$model->search2(),
		//'filter'=>$model,
		'pager'=>array(
			'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
		),
		'enableSorting' => false,
    	'columns'=>array(
    		'Id_Fact',
            array(
                'name' => 'Empresa',
                'value' => '$data->DescEmpresa($data->Empresa)',
            ),
            array(
                'name' => 'Area',
                'value' => 'UtilidadesVarias::descarea($data->Area)',
            ),
            'Num_Factura',
            array(
                'name'=>'Fecha_Factura',
                'value'=>'UtilidadesVarias::textofecha($data->Fecha_Factura)',
            ),
            array(
                'name'=>'Fecha_Radicado',
                'value'=>'UtilidadesVarias::textofecha($data->Fecha_Radicado)',
            ),
            array(
                'name' => 'Proveedor',
                'value' => '$data->DescProveedor($data->Proveedor)',
            ),
            array(
                'name'=>'Valor',
                'value'=>function($data){
                    return number_format($data->Valor, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'Moneda',
                'value' => '$data->DescMoneda($data->Moneda)',
            ),
            array(
                'name' => 'Estado',
                'value' => '$data->DescEstado($data->Estado)',
            ),
    		array(
                'class'=>'CButtonColumn',
                'template'=>'{view}{update}',
                'buttons'=>array(
                    'view'=>array(
                        'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                        'imageUrl'=>false,
                        'options'=>array('title'=>'Visualizar'),
                        'url'=>'Yii::app()->createUrl("factCont/view", array("id"=>$data->Id_Fact, "opc"=> 2))',
                    ),
                    'update'=>array(
                        'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                        'imageUrl'=>false,
                        'url'=>'Yii::app()->createUrl("factCont/updateest", array("id"=>$data->Id_Fact, "opc"=> 2))',
                        'options'=>array('title'=>'Actualizar'),
                        'visible'=> '($data->Estado == 1)',
                    ),
                )
            ),
    	),
    )); ?>

<?php }else{ ?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Actualización estado de facturas</h4>
  </div>
  <div class="col-sm-6 text-right">  
  </div>
</div>

<div class="alert alert-warning alert-dismissible">
    <h5><i class="icon fas fa-info-circle"></i>Info</h5>
    Este usuario no tiene áreas asociadas.
</div> 

<?php } ?>

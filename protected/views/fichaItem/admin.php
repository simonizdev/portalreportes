<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ficha-item-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Usuario');

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Solicitudes creación / actualización de productos</h4>
  </div>
  <div class="col-sm-6 text-right"> 
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaItem/create'; ?>';"><i class="fa fa-plus"></i> Solicitud de creación</button>
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaItem/create2'; ?>';"><i class="fa fa-plus"></i> Solicitud de actualización</button> 
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
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ficha-item-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Id',
		array(
            'name' => 'Tipo',
            'value' => '$data->DescTipo($data->Tipo)',
        ),
		array(
            'name' => 'Tipo_Producto',
            'value' => '$data->DescTipoProducto($data->Tipo_Producto)',
        ),
        array(
		    'name'=>'Codigo_Item',
		    'type'=>'raw',
		    'value'=>'($data->Codigo_Item) == "" ? "-" : $data->Codigo_Item	',

		),
		array(
		    'name'=>'Referencia',
		    'type'=>'raw',
		    'value'=>'($data->Referencia) == "" ? "-" : $data->Referencia	',

		),
		array(
		    'name'=>'Descripcion_Corta',
		    'type'=>'raw',
		    'value'=>'($data->Descripcion_Corta) == "" ? "-" : $data->Descripcion_Corta	',

		),
		array(
            'name'=>'Fecha_Hora_Solicitud',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Hora_Solicitud)',
        ),
        array(
            'name'=>'Id_Usuario_Solicitud',
            'value'=>'$data->idusuariosol->Usuario',
        ),
        array(
            'name'=>'Estado_Solicitud',
            'value'=>'$data->DescEstado($data->Estado_Solicitud)',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{vc}{vu}',
            'buttons'=>array(
                'vc'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                    'url'=>'Yii::app()->createUrl("fichaItem/view", array("id"=>$data->Id, "opc"=>1))',
                    'visible'=> '($data->Tipo == 1)',
                ),
                'vu'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                    'url'=>'Yii::app()->createUrl("fichaItem/view2", array("id"=>$data->Id, "opc"=>1))',
                    'visible'=> '($data->Tipo == 2)',
                ),
            )
        ),
	),
)); ?>

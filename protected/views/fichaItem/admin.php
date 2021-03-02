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

$usuarios_desarrollo = UtilidadesVarias::usuariosfichaitem(1);
$usuarios_comercial = UtilidadesVarias::usuariosfichaitem(3);

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Nombres');

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Solicitudes creación / actualización de ítems</h4>
  </div>
  <div class="col-sm-6 text-right"> 
    <?php if(in_array(Yii::app()->user->getState('id_user'), $usuarios_desarrollo)){ ?>
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaItem/create&s=1'; ?>';"><i class="fa fa-plus"></i> Solicitud de creación</button>
    <?php } ?>
    <?php if(in_array(Yii::app()->user->getState('id_user'), $usuarios_comercial)){ ?>
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaItem/create2&s=1'; ?>';"><i class="fa fa-plus"></i> Solicitud de actualización</button> 
    <?php } ?>
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
            'name' => 'Pais',
            'value' => '$data->DescPais($data->Pais)',
        ),
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
		    'name'=>'Descripcion_Corta',
		    'type'=>'raw',
		    'value'=>'($data->Descripcion_Corta) == "" ? "-" : $data->Descripcion_Corta	',

		),
        array(
            'name'=>'Id_Usuario_Solicitud',
            'value'=>'$data->idusuariosol->Nombres',
        ),
        array(
            'name'=>'Fecha_Hora_Solicitud',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Hora_Solicitud)',
        ),
        array(
            'name'=>'Id_Usuario_Actualizacion',
            'value'=>'$data->idusuarioact->Nombres',
        ),
        array(
            'name'=>'Fecha_Hora_Actualizacion',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Hora_Actualizacion)',
        ),
		array(
            'name'=>'Step',
            'value'=>'$data->DescStep($data->Step)',
        ),
        array(
            'name'=>'Estado_Solicitud',
            'value'=>'$data->DescEstado($data->Estado_Solicitud)',
        ),

        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}{update2}',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Revisar'),
                    'url'=>'Yii::app()->createUrl("fichaItem/update", array("id"=>$data->Id, "s"=>$data->Step))',
                    'visible'=> '($data->Tipo == 1)',
                ),
                'update2'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Revisar'),
                    'url'=>'Yii::app()->createUrl("fichaItem/update2", array("id"=>$data->Id, "s"=>$data->Step))',
                    'visible'=> '($data->Tipo == 2)',
                ),
            )
        ),
	),
)); ?>

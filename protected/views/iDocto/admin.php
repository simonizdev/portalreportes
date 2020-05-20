<?php
/* @var $this IDoctoController */
/* @var $model IDocto */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#idocto-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de tipos
$lista_tipos = CHtml::listData($tipos, 'Id', 'Descripcion'); 

//para combos de bodegas
$lista_bodegas = CHtml::listData($bodegas, 'Id', 'Descripcion'); 

//para combos de estados
$lista_estados = CHtml::listData($estados, 'Id', 'Descripcion'); 

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 

?>

<?php if($v == 1) { ?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración de documentos</h4>
  </div>
  <div class="col-sm-6 text-right"> 
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button> 
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
	'lista_tipos'=>$lista_tipos,
	'lista_bodegas'=>$lista_bodegas,
	'lista_estados'=>$lista_estados,
    'lista_usuarios' => $lista_usuarios,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'idocto-grid',
	'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		//'Id',
		array(
            'name' => 'Id_Tipo_Docto',
            'type' => 'raw',
            'value' => '$data->idtipodocto->Descripcion',
        ),
		'Consecutivo',
		array(
            'name'=>'Fecha',
            'value'=>'UtilidadesVarias::textofecha($data->Fecha)',
        ),
		'Referencia',
		array(
            'name' => 'Id_Tercero',
            'type' => 'raw',
            'value' => '$data->DescTercero($data->Id_Tercero)',
        ),
        array(
            'name' => 'Id_Estado',
            'type' => 'raw',
            'value' => '$data->idestado->Descripcion',
        ),
        array(
			'class'=>'CButtonColumn',
            'template'=>'{view}{update}{reppdf}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
                'update'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Modificar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->Id_Estado == Yii::app()->params->elab)',
                ),
                'reppdf'=>array(
                    'label'=>'<i class="fas fa-file-pdf actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Generar reporte en PDF'),
                    'url'=>'Yii::app()->createUrl("iDocto/genrepdoc", array("id"=>$data->Id))',
                ),
            )
		),    
	),
)); ?>

<?php } else { ?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración de documentos</h4>
  </div>
  <div class="col-sm-6 text-right">  
  </div>
</div>

<div class="alert alert-warning alert-dismissible">
    <h5><i class="icon fas fa-info-circle"></i>Info</h5>
    Este usuario no tiene bodegas / tipos de docto asociados.
</div>


<?php } ?>

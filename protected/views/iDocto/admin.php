<?php
/* @var $this IDoctoController */
/* @var $model IDocto */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
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

<h3>Administración de documentos</h3>

<?php if($v == 1) { ?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i>Realizado</h4>
      <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
</div>

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
                    'label'=>'<i class="fa fa-eye actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Modificar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->Id_Estado == Yii::app()->params->elab)',
                ),
                'reppdf'=>array(
                    'label'=>'<i class="fa fa-file-pdf-o actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Generar reporte en PDF'),
                    'url'=>'Yii::app()->createUrl("iDocto/genrepdoc", array("id"=>$data->Id))',
                ),
            )
		),    
	),
)); ?>

<?php } else { ?>

<br>
<br>
<p>Este usuario no tiene bodegas / tipos de docto asociados.</p>

<?php } ?>

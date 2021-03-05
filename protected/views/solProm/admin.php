<?php
/* @var $this SolPromController */
/* @var $model SolProm */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#sol-prom-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$usuarios_registro = UtilidadesVarias::usuariossolprom(1);

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Nombres'); 

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Solicitudes de promociones</h4>
  </div>
  <div class="col-sm-6 text-right">
  		<?php if(in_array(Yii::app()->user->getState('id_user'), $usuarios_registro)){ ?>
      	<button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=SolProm/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
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
    'lista_tipos' => $lista_tipos,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sol-prom-grid',
	'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Num_Sol',
		'Responsable',
		array(
          'name' => 'Tipo',
          'value' => '$data->DescTipo($data->Tipo)',
      	),
		array(
          'name' => 'Cliente',
          'value' => '$data->DescCliente($data->Cliente)',
      	),
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
                    'options'=>array('title'=>'Revisar'),
                    'url'=>'Yii::app()->createUrl("solProm/update", array("id"=>$data->Id_Sol_Prom, "s"=>$data->Estado))',
                ),
            )
		),  
	),
)); ?>

<?php
/* @var $this RepController */
/* @var $model Rep */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#rep-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración de item(s) por reporte</h4>
  </div>
  <div class="col-sm-6 text-right">  
      <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=rep/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
  </div>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
    //'lista_opciones_p' => $lista_opciones_p,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rep-grid',
	'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Id_Rep',
		'Descripcion',
		/*
		'Id_Usuario_Creacion',
		'Id_Usuario_Actualizacion',
		'Fecha_Creacion',
		'Fecha_Actualizacion',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}',
            'buttons'=>array(
                'update'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Actualizar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
            )
		),
	),
)); ?>

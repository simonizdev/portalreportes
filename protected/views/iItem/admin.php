<?php
/* @var $this IItemController */
/* @var $model IItem */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#iitem-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de lineas
$lista_lineas = CHtml::listData($lineas, 'Id', 'Descripcion'); 

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario'); 

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración de items</h4>
  </div>
  <div class="col-sm-6 text-right">  
      <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iItem/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
  </div>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'lista_unidades'=>$lista_unidades,
	'lista_lineas'=>$lista_lineas,
    'lista_usuarios' => $lista_usuarios,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'iitem-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Id',
		'Id_Item',
		'Referencia',
		'Descripcion',
		array(
            'name' => 'UND_Medida',
            'type' => 'raw',
            'value' => '$data->DescUnd($data->UND_Medida)',
        ),
		array(
            'name' => 'Id_Linea',
            'type' => 'raw',
            'value' => '$data->idlinea->Descripcion',
        ),
        /*'Mes_Stock',
		'Min_Stock',
		'Max_Stock',
		'Nota',
		'Id_Usuario_Creacion',
		'Id_Usuario_Actualizacion',
		'Fecha_Creacion',
		'Fecha_Actualizacion',
		*/
		array(
            'name' => 'Estado',
            'value' => 'UtilidadesVarias::textoestado1($data->Estado)',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
                'update'=>array(
                    'label'=>'<i class="fa fa-pen actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Actualizar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
            )
        ),
	),
)); 

?>
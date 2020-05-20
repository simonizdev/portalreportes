<?php
/* @var $this DinComController */
/* @var $model DinCom */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#din-com-grid').yiiGridView('update', {
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
    <h4>Control de dinamica comercial</h4>
  </div>
  <div class="col-sm-6 text-right">  
      <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=dinCom/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
  </div>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'din-com-grid',
	'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Id_Dic_Com',
		array(
            'name'=>'Fecha_Inicio',
            'value'=>'UtilidadesVarias::textofecha($data->Fecha_Inicio)',
        ),
        array(
            'name'=>'Fecha_Fin',
            'value'=>'UtilidadesVarias::textofecha($data->Fecha_Fin)',
        ),
        array(
            'name'=>'Id_Plan_Cliente',
            'value'=>'UtilidadesVarias::descplancliente($data->Id_Plan_Cliente)',
        ),
        array(
            'name'=>'Id_Criterio_Cliente',
            'value'=>'UtilidadesVarias::desccricliente($data->Id_Plan_Cliente, $data->Id_Criterio_Cliente)',
        ),
        array(
            'name'=>'Id_Plan_Item',
            'value'=>'UtilidadesVarias::descplanitem($data->Id_Plan_Item)',
        ),
        array(
            'name'=>'Id_Criterio_Item',
            'value'=>'UtilidadesVarias::desccriitem($data->Id_Plan_Item, $data->Id_Criterio_Item)',
        ),
        array(
            'name'=>'Porc',
            'value'=>function($data){
                return number_format($data->Porc, 2);
            },
            'htmlOptions'=>array('style' => 'text-align: right;'),
        ),
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
)); ?>

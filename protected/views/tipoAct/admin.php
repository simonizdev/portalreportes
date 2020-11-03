<?php
/* @var $this TipoActController */
/* @var $model TipoAct */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
	$('#tipo-act-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Usuario'); 

//para combos de grupos
$lista_grupos = CHtml::listData($grupos, 'Id_Dominio', 'Dominio');

//para combo de opciones padre
$lista_opciones_p = CHtml::listData($opciones_p, 'Id_Tipo', 'Tipo');  

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración tipos de actividad</h4>
  </div>
  <div class="col-sm-6 text-right">  
      <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=tipoact/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
  </div>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
    'lista_grupos' => $lista_grupos,
    'lista_opciones_p' => $lista_opciones_p,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tipo-act-grid',
	'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
	'columns'=>array(
		'Id_Tipo',
        array(
            'name'=>'Grupo',
            'value'=>'$data->idgrupo->Dominio',
        ),
        array(
            'name' => 'Padre',
            'value' => '($data->Padre == "") ? "-" : $data->idpadre->Tipo',
        ),
		'Tipo',
        array(
            'name' => 'Cantidad',
            'value' => '($data->Cantidad == "") ? "-" : $data->Cantidad',
        ),
        array(
            'name' => 'Fecha_Inicio',
            'value' => 'UtilidadesVarias::textofecha($data->Fecha_Inicio)',
        ),
        array(
            'name' => 'Fecha_Fin',
            'value' => 'UtilidadesVarias::textofecha($data->Fecha_Fin)',
        ),
        array(
            'name' => 'Ind_Alto',
            'value' => '($data->Ind_Alto == "") ? "-" : number_format($data->Ind_Alto, 2)',
        ),
        array(
            'name' => 'Ind_Medio',
            'value' => '($data->Ind_Medio == "") ? "-" : number_format($data->Ind_Medio, 2)',
        ),
        array(
            'name' => 'Ind_Bajo',
            'value' => '($data->Ind_Bajo == "") ? "-" : number_format($data->Ind_Bajo, 2)',
        ),
		array(
            'name' => 'Estado',
            'value' => 'UtilidadesVarias::textoestado1($data->Estado)',
        ),
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
)); 

?>
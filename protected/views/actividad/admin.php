<?php
/* @var $this ActividadController */
/* @var $model Actividad */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
	$('#actividad-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

/*$lista_usuarios1 = CHtml::listData($usuarios, 'Id_Usuario', 'Nombres');

//para combos de usuarios
$lista_usuarios2 = CHtml::listData($usuarios, 'Id_Usuario', 'Usuario'); */

//para combos de grupos
$lista_grupos = $grupos;

?>

<?php if($a === 1) { ?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración de Actividades</h4>
  </div>
  <div class="col-sm-6 text-right">  
      <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=actividad/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
  </div>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
    //'lista_usuarios1' => $lista_usuarios1,
    //'lista_usuarios2' => $lista_usuarios2,
    'lista_grupos' => $lista_grupos,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'actividad-grid',
    'dataProvider'=>$model->search(),
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
    'columns'=>array(
        'Id',
        array(
            'name' => 'Fecha',
            'value' => 'UtilidadesVarias::textofecha($data->Fecha)',
        ),
        array(
            'name' => 'Hora',
            'value' => '$data->HoraAmPm($data->Hora)',
        ),
        array(
            'name' => 'Pais',
            'value' => '$data->DescPais($data->Pais)',
        ),
        array(
            'name' => 'Grupo',
            'value' => '$data->idgrupo->Dominio',
        ),
        array(
            'name' => 'Tipo',
            'value' => '$data->idtipo->Tipo',
        ),
        array(
            'name'=>'Id_Usuario',
            'value'=>'$data->idusuario->Nombres',
        ),
        array(
            'name'=>'Id_Usuario_Deleg',
            'value' => '($data->Id_Usuario_Deleg == "") ? "-" : $data->idusuariodeleg->Nombres',
        ),
        'Actividad',
        array(
            'name' => 'Prioridad',
            'value' => '$data->DescPrioridad($data->Prioridad)',
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
                    'options'=>array('title'=>'Actualizar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true)',
                ),
            )
        ),
    ),
)); ?>  

<?php }else{ ?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Administración de Actividades</h4>
  </div>
  <div class="col-sm-6 text-right">  
  </div>
</div>

<div class="alert alert-warning alert-dismissible">
    <h5><i class="icon fas fa-info-circle"></i>Info</h5>
    Este usuario no tiene tipos de actividades asociadas.
</div> 

<?php } ?>






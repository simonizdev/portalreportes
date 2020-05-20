<?php
/* @var $this MenuPerfilController */
/* @var $model MenuPerfil */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#menu-perfil-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Usuario', 'Usuario');

//para combos de perfiles
$lista_perfiles = CHtml::listData($perfiles, 'Descripcion', 'Descripcion'); 

//para combos de menus
$lista_menus = CHtml::listData($menus, 'Descripcion', 'Descripcion');  
?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Consulta opciones de menu por perfil</h4>
  </div>
  <div class="col-sm-6 text-right">
    <button type="button" class="btn btn-success btn-sm search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
  </div>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'lista_usuarios' => $lista_usuarios,
    'lista_perfiles' => $lista_perfiles,
    'lista_menus' => $lista_menus,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'menu-perfil-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
	'enableSorting' => false,
	'columns'=>array(
		'Id_M_Perfil',
		array(
            'name'=>'perfil',
            'value'=>'$data->idperfil->Descripcion',
        ),
        array(
            'name'=>'menu',
            'value'=>'$data->idmenu->Descripcion',
        ),   
        /*array(
            'name'=>'Fecha_Creacion',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Creacion)',
        ),
        array(
            'name'=>'Id_Usuario_Actualizacion',
            'value'=>'$data->idusuarioact->Usuario',
        ),
        array(
            'name'=>'Fecha_Actualizacion',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Actualizacion)',
        ),*/
        array(
            'name' => 'Estado',
            'value' => 'UtilidadesVarias::textoestado1($data->Estado)',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
            )
		),
	),
)); ?>

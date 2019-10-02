<?php
/* @var $this MenuPerfilController */
/* @var $model MenuPerfil */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
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

<h3>Consulta opciones de menu por perfil</h3>


<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
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
            'type' => 'raw',
            'value' => '($data->Estado == "1") ? "Activo" : "Inactivo"',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                ),
            )
		),
	),
)); ?>

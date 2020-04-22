<?php
/* @var $this AreaUsuarioController */
/* @var $model AreaUsuario */

?>

<h3>Visualizando área por usuario</h3>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => false,
	'attributes'=>array(
		'Id_A_Usuario',
		array(
            'name'=>'usuario',
            'value'=>$model->idusuario->Usuario,
        ),
        array(
            'name' => 'Id_Area',
            'value' => UtilidadesVarias::descarea($model->Id_Area),
        ),
		array(
            'name'=>'Id_Usuario_Creacion',
            'value'=>$model->idusuariocre->Usuario,
        ),
        array(
            'name'=>'Fecha_Creacion',
            'value'=>UtilidadesVarias::textofechahora($model->Fecha_Creacion),
        ),
        array(
            'name'=>'Id_Usuario_Actualizacion',
            'value'=>$model->idusuarioact->Usuario,
        ),
        array(
            'name'=>'Fecha_Actualizacion',
            'value'=>UtilidadesVarias::textofechahora($model->Fecha_Actualizacion),
        ),
        array(
            'name' => 'Estado',
            'value' => ($model->Estado == "1") ? "Activo" : "Inactivo",
        ),
	),
)); ?>


</div>

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=areaUsuario/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
</div>

<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

?>

<h4>Visualizando usuario</h4>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Usuario',
		'Usuario',
		'Nombres',
		'Correo',
        array(
            'name' => 'Avatar',
            'value' => UtilidadesVarias::textoavatar($model->Avatar),
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
            'value' => UtilidadesVarias::textoestado1($model->Estado),
        ),
	),
)); ?>

</div>

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=usuario/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
</div>
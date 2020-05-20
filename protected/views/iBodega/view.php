<?php
/* @var $this IBodegaController */
/* @var $model IBodega */

?>

<h4>Visualizando bodega</h4>

<div class="table-responsive">


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Descripcion',
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
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iBodega/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
</div>
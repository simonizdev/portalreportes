<?php
/* @var $this SuministroController */
/* @var $model Suministro */

?>

<h3>Visualizando suministro</h3>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Suministro',
		'Codigo',
		'Descripcion',
		'Referencia',
		'Impresora',
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
            'type' => 'raw',
            'value' => ($model->Estado == 1) ? "Activo" : "Inactivo",
        ),
	),
)); ?>

</div>


<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=suministro/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
</div>



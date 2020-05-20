<?php
/* @var $this MenuController */
/* @var $model Menu */

?>

<h4>Visualizando opción de menú</h4>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Menu',
		array(
            'name'=>'padre',
            'value'=>$model->idpadre->Descripcion,
        ),
		'Descripcion',
		'Orden',
        array(
            'name'=>'Icono',
            'type'=>'html',
            'value'=> '<i class="'.$model->Font_Icon.'"></i>', 
        ),
        array(
            'name' => 'Descarga_Directa',
            'value' => UtilidadesVarias::textoestado2($model->Descarga_Directa),
        ),
        array(
            'name' => 'Descripcion_Larga',
            'value' => ($model->Descripcion_Larga == "") ? "-" : $model->Descripcion_Larga,
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
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=menu/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
</div>
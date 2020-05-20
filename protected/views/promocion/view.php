<?php
/* @var $this PromocionController */
/* @var $model Promocion */

?>

<h2>Visualizando item de promoción</h2>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => false,
	'attributes'=>array(
		'Id_Promocion',
		array(
            'name'=>'Id_Item_Padre',
            'value'=>$model->Desc_Item($model->Id_Item_Padre),
        ),
        array(
            'name'=>'Id_Item_Hijo',
            'value'=>$model->Desc_Item($model->Id_Item_Hijo),
        ),
        array(
            'name'=>'Cantidad',
            'value'=>$model->Cantidad,
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
	),
)); ?>

</div>

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=promocion/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
</div>

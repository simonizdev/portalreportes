<?php
/* @var $this EanItemController */
/* @var $model EanItem */

?>

<h4>Visualizando código de barras x item</h4>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'Id_Ean_Item',
		array(
            'name'=>'Id_Item',
            'value'=>$model->DescItem($model->Id_Item),
        ),
		array(
            'name'=>'Criterio',
            'value'=>$model->DescCriterio($model->Criterio),
        ),
        //'Num_Und',
		array(
            'name'=>'Código',
            'value'=>$model->EanDig($model->Id_Ean_Item),
        ),
        'Und_x_Caja',
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
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=eanItem/view&id='.$model->Id_Item; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
</div>
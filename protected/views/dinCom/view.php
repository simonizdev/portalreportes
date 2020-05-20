<?php
/* @var $this DinComController */
/* @var $model DinCom */

?>

<h4>Visualizando dinamica comercial</h4>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Dic_Com',
		array(
            'name'=>'Fecha_Inicio',
            'value'=>UtilidadesVarias::textofecha($model->Fecha_Inicio),
        ),
        array(
            'name'=>'Fecha_Fin',
            'value'=>UtilidadesVarias::textofecha($model->Fecha_Fin),
        ),
        array(
            'name'=>'Id_Plan_Cliente',
            'value'=>UtilidadesVarias::descplancliente($model->Id_Plan_Cliente),
        ),
        array(
            'name'=>'Id_Criterio_Cliente',
            'value'=>UtilidadesVarias::desccricliente($model->Id_Plan_Cliente, $model->Id_Criterio_Cliente),
        ),
        array(
            'name'=>'Id_Plan_Item',
            'value'=>UtilidadesVarias::descplanitem($model->Id_Plan_Item),
        ),
        array(
            'name'=>'Id_Criterio_Item',
            'value'=>UtilidadesVarias::desccriitem($model->Id_Plan_Item, $model->Id_Criterio_Item),
        ),
        array(
            'name'=>'Porc',
            'value'=>number_format($model->Porc, 2),
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
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=dinCom/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
</div>
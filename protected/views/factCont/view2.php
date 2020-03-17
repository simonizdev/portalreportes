<?php
/* @var $this FactPendController */
/* @var $model FactPend */

?>

<h3>Visualizando factura</h3>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Fact',
		array(
            'name' => 'Empresa',
            'value' => $model->DescEmpresa($model->Empresa),
        ),
        array(
            'name' => 'Area',
            'value' => UtilidadesVarias::descarea($model->Area),
        ),
		'Num_Factura',
		array(
            'name'=>'Fecha_Factura',
            'value'=>UtilidadesVarias::textofecha($model->Fecha_Factura),
        ),
        array(
            'name'=>'Fecha_Radicado',
            'value'=>UtilidadesVarias::textofecha($model->Fecha_Radicado),
        ),
        array(
            'name' => 'Proveedor',
            'value' => $model->DescProveedor($model->Proveedor),
        ),
        array(
            'name' => 'Observaciones',
            'value' => ($model->Observaciones == "") ? "-" : $model->Observaciones,
        ),
        array(
            'name'=>'Valor',
            'value'=>function($model){
                return number_format($model->Valor, 2);
            },
            'htmlOptions'=>array('style' => 'text-align: right;'),
        ),
		array(
            'name' => 'Moneda',
            'value' => $model->DescMoneda($model->Moneda),
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
            'name'=>'Id_Usuario_Revision',
            'value' => ($model->Id_Usuario_Revision == "") ? "-" : $model->idusuariorev->Usuario,
        ),
        array(
            'name'=>'Fecha_Revision',
            'value' => ($model->Fecha_Revision == "") ? "-" : UtilidadesVarias::textofechahora($model->Fecha_Revision),
        ),
        array(
            'name' => 'Estado',
            'value' => $model->DescEstado($model->Estado),
        ),
	),
)); ?>

</div>

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=factCont/admin2'; ?>';"><i class="fa fa-reply"></i> Volver </button>
</div>
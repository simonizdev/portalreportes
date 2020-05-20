<?php
/* @var $this IItemController */
/* @var $model IItem */

?>

<h4>Visualizando item</h4>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Id_Item',
		'Referencia',
		'Descripcion',
		array(
            'name' => 'UND_Medida',
            'type' => 'raw',
            'value' => $model->DescUnd($model->UND_Medida),
        ),
		array(
            'name' => 'Id_Linea',
            'type' => 'raw',
            'value' => $model->idlinea->Descripcion,
        ),
		'Mes_Stock',
		'Min_Stock',
		'Max_Stock',
        'Total_Inventario',
        array(
            'name'=>'Vlr_Costo',
            'value'=>function($model){
                return number_format($model->Vlr_Costo, 2);
            },
        ),
        array(
            'name'=>'costo_unit',
            'value'=>function($model){
                return (number_format($model->Vlr_Costo) != 0 || number_format($model->Total_Inventario) != 0) ? number_format($model->Vlr_Costo / $model->Total_Inventario, 2) : number_format(0, 2) ;
            },
        ),
        array(
            'name'=>'Vlr_Ult_Compra',
            'value'=>function($model){
                return number_format($model->Vlr_Ult_Compra, 2);
            },
        ),
		'Nota',
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
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iItem/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
</div>


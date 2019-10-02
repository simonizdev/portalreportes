<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h3>Visualizando detalle de inventario</h3>

<div class="table-responsive">

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id_Inventario',
		'Documento',
        array(
            'name'=>'Fecha',
            'value'=>UtilidadesVarias::textofecha($model->Fecha),
        ),
		array(
            'name' => 'Tipo',
            'value' => ($model->Tipo == "1") ? "Entrada" : "Salida",
        ),
		'Cantidad',
		array(
            'name'=>'Id_Suministro',
            'value'=>$model->idsuministro->Descripcion,
        ),
		array(
            'name'=>'Id_Departamento',
            'value'=>$model->iddepartamento->Descripcion,
        ),
        array(
            'name'=>'Notas',
            'value'=>$model->Notas,
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

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=inventario/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
</div>


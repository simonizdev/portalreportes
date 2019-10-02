<?php
/* @var $this IDoctoMovtoController */
/* @var $model IDoctoMovto */

?>

<h3>Visualizando detalle de documento</h3>

<div class="table-responsive">

<?php 

if($model->iddocto->Id_Tipo_Docto == Yii::app()->params->ent){
	//entrada
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	            'name'=>'tipo_docto',
	            'value'=>$model->iddocto->idtipodocto->Descripcion,
	        ),
	        array(
	            'name'=>'consecutivo_docto',
	            'value'=>$model->iddocto->Consecutivo,
	        ),
			array(
	            'name' => 'Id_Item',
	            'value' => $model->DescItem($model->Id_Item),
	        ),
			array(
	            'name' => 'Id_Bodega_Dst',
	            'value' => $model->idbodegadst->Descripcion,
	        ),
			'Cantidad',
			array(
	            'name' => 'Vlr_Unit_Item',
	            'value' =>  number_format($model->Vlr_Unit_Item, 2),
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
	)); 
}


if($model->iddocto->Id_Tipo_Docto == Yii::app()->params->sal){
	//salida
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	            'name'=>'tipo_docto',
	            'value'=>$model->iddocto->idtipodocto->Descripcion,
	        ),
	        array(
	            'name'=>'consecutivo_docto',
	            'value'=>$model->iddocto->Consecutivo,
	        ),
			array(
	            'name' => 'Id_Item',
	            'value' => $model->DescItem($model->Id_Item),
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'value' => $model->idbodegaorg->Descripcion,
	        ),
			'Cantidad',
			array(
	            'name' => 'Vlr_Unit_Item',
	            'value' =>  number_format($model->Vlr_Unit_Item, 2),
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
	)); 
}

if($model->iddocto->Id_Tipo_Docto == Yii::app()->params->trb){
	//transferencia
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	            'name'=>'tipo_docto',
	            'value'=>$model->iddocto->idtipodocto->Descripcion,
	        ),
	        array(
	            'name'=>'consecutivo_docto',
	            'value'=>$model->iddocto->Consecutivo,
	        ),
			array(
	            'name' => 'Id_Item',
	            'value' => $model->DescItem($model->Id_Item),
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'value' => $model->idbodegaorg->Descripcion,
	        ),
	        array(
	            'name' => 'Id_Bodega_Dst',
	            'value' => $model->idbodegadst->Descripcion,
	        ),
			'Cantidad',
			array(
	            'name' => 'Vlr_Unit_Item',
	            'value' =>  number_format($model->Vlr_Unit_Item, 2),
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
	)); 
}

if($model->iddocto->Id_Tipo_Docto == Yii::app()->params->aje){
	//ajuste por entrada
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	            'name'=>'tipo_docto',
	            'value'=>$model->iddocto->idtipodocto->Descripcion,
	        ),
	        array(
	            'name'=>'consecutivo_docto',
	            'value'=>$model->iddocto->Consecutivo,
	        ),
			array(
	            'name' => 'Id_Item',
	            'value' => $model->DescItem($model->Id_Item),
	        ),
			array(
	            'name' => 'Id_Bodega_Dst',
	            'value' => $model->idbodegadst->Descripcion,
	        ),
			'Cantidad',
			array(
	            'name' => 'Vlr_Unit_Item',
	            'value' =>  number_format($model->Vlr_Unit_Item, 2),
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
	)); 
}

if($model->iddocto->Id_Tipo_Docto == Yii::app()->params->ajs){
	//ajuste por salida
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	            'name'=>'tipo_docto',
	            'value'=>$model->iddocto->idtipodocto->Descripcion,
	        ),
	        array(
	            'name'=>'consecutivo_docto',
	            'value'=>$model->iddocto->Consecutivo,
	        ),
			array(
	            'name' => 'Id_Item',
	            'value' => $model->DescItem($model->Id_Item),
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'value' => $model->idbodegaorg->Descripcion,
	        ),
			'Cantidad',
			array(
	            'name' => 'Vlr_Unit_Item',
	            'value' =>  number_format($model->Vlr_Unit_Item, 2),
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
	)); 
}

if($model->iddocto->Id_Tipo_Docto == Yii::app()->params->sad){
	//salida de dotación
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	            'name'=>'tipo_docto',
	            'value'=>$model->iddocto->idtipodocto->Descripcion,
	        ),
	        array(
	            'name'=>'consecutivo_docto',
	            'value'=>$model->iddocto->Consecutivo,
	        ),
			array(
	            'name' => 'Id_Item',
	            'value' => $model->DescItem($model->Id_Item),
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'value' => $model->idbodegaorg->Descripcion,
	        ),
			'Cantidad',
			array(
	            'name' => 'Vlr_Unit_Item',
	            'value' =>  number_format($model->Vlr_Unit_Item, 2),
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
	)); 
}

if($model->iddocto->Id_Tipo_Docto == Yii::app()->params->dev){
	//devolución
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
	            'name'=>'tipo_docto',
	            'value'=>$model->iddocto->idtipodocto->Descripcion,
	        ),
	        array(
	            'name'=>'consecutivo_docto',
	            'value'=>$model->iddocto->Consecutivo,
	        ),
			array(
	            'name' => 'Id_Item',
	            'value' => $model->DescItem($model->Id_Item),
	        ),
			array(
	            'name' => 'Id_Bodega_Dst',
	            'value' => $model->idbodegadst->Descripcion,
	        ),
			'Cantidad',
			array(
	            'name' => 'Vlr_Unit_Item',
	            'value' =>  number_format($model->Vlr_Unit_Item, 2),
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
	)); 
}

?>

</div>

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/view&id='.$model->Id_Docto; ?>';"><i class="fa fa-reply"></i> Volver </button>
</div>


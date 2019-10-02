<?php
/* @var $this IDoctoController */
/* @var $model IDocto */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'idocto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<div class="btn-group" id="btn_save" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
   <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-floppy-o"></i> Guardar</button>
</div>

<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Tipo</label>
          	<p><?php echo $model->idtipodocto->Descripcion; ?></p>            	
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Consecutivo</label>
          	<p><?php echo $model->Consecutivo; ?></p>			   
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->error($model,'Fecha', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Fecha'); ?>
            <?php echo $form->textField($model,'Fecha', array('class' => 'form-control datepicker', 'readonly' => true)); ?>				    
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->error($model,'Referencia', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Referencia'); ?>
            <?php echo $form->textField($model,'Referencia', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>     
        </div>
    </div>
    <div class="col-sm-8">
    	<div class="form-group">
          	<?php echo $form->error($model,'Id_Tercero', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Tercero'); ?>
            <?php echo $form->textField($model,'Id_Tercero'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#IDocto_Id_Tercero',
                    'options'  => array(
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('iTercero/SearchTercero'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                   
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("IDocto_Id_Tercero"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'IDocto_Id_Tercero\')\">Limpiar campo</button>"; }',
                        'initSelection'=>'js:function(element,callback) {
		                   	var id=$(element).val(); // read #selector value
		                   	if ( id !== "" ) {
		                     	$.ajax("'.Yii::app()->createUrl('iTercero/SearchTerceroById').'", {
		                       		data: { id: id },
		                       		dataType: "json"
		                     	}).done(function(data,textStatus, jqXHR) { callback(data[0]); });
		                   }
		                }',
                    ),
                ));
            ?>		   
        </div>
    </div> 
</div>

<?php if($model->Id_Tipo_Docto == Yii::app()->params->sad){ ?>

<div class="row">
    <div class="col-sm-8">
    	<div class="form-group">
          	<?php echo $form->error($model,'Id_Emp', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Emp'); ?>
            <?php echo $form->textField($model,'Id_Emp'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#IDocto_Id_Emp',
                    'options'  => array(
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('iDocto/SearchEmpleado'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                   
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("IDocto_Id_Emp"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'IDocto_Id_Emp\')\">Limpiar campo</button>"; }',
                        'initSelection'=>'js:function(element,callback) {
		                   	var id=$(element).val(); // read #selector value
		                   	if ( id !== "" ) {
		                     	$.ajax("'.Yii::app()->createUrl('iDocto/SearchEmpleadoById').'", {
		                       		data: { id: id },
		                       		dataType: "json"
		                     	}).done(function(data,textStatus, jqXHR) { callback(data[0]); });
		                   }
		                }',
                    ),
                ));
            ?>		   
        </div>
    </div> 
</div>

<?php } ?>

<?php if($model->Id_Tipo_Docto == Yii::app()->params->aje || $model->Id_Tipo_Docto == Yii::app()->params->ajs){ ?>

<div class="row">
	<div class="col-sm-8">
	    <div class="form-group">
	        <?php echo $form->error($model,'Notas', array('class' => 'pull-right badge bg-red')); ?>
	        <?php echo $form->label($model,'Notas'); ?>
	        <?php echo $form->textArea($model,'Notas',array('class' => 'form-control', 'rows'=>3, 'cols'=>50, 'onkeyup' => 'convert_may(this)', 'maxlength' => '200')); ?>
	    </div>
    </div>	
</div>

<?php } ?>

<div class="row">
	 <div class="col-sm-4">
    	<div class="form-group">
          	<label>Vlr. total</label>
          	<p><?php echo number_format($model->Vlr_Total, 2); ?></p> 				    
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Estado</label>
          	<p><?php echo $model->idestado->Descripcion; ?></p> 	           	
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Usuario que creo</label>	
          	<p><?php echo $model->idusuariocre->Usuario; ?></p> 			   
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-4">
    	<div class="form-group">
          	<label>Fecha de creación</label>
          	<p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Creacion); ?></p> 				    
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Usuario que actualizó</label>
          	<p><?php echo $model->idusuarioact->Usuario; ?></p> 	            	
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Fecha de actualización</label>
          	<p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Actualizacion); ?></p> 				   
        </div>
    </div>
    <div class="col-sm-4">
    	
    </div>
</div>

<?php $this->endWidget(); ?>

<div class="btn-group" id="btn_add" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDoctoMovto/create&id='.$model->Id; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
</div>

<script type="text/javascript">
	
$(function() {
	$("#valida_form").click(function() {
		var form = $("#idocto-form");
		var empleado = $('#IDocto_Id_Emp').val();
		var notas = $('#IDocto_Notas').val();

		var tipo = <?php echo $model->Id_Tipo_Docto; ?>;
		var aje = <?php echo Yii::app()->params->aje; ?>;
		var ajs = <?php echo Yii::app()->params->ajs; ?>;
		var sad = <?php echo Yii::app()->params->sad; ?>;

		var settings = form.data('settings') ;
		settings.submitting = true ;
		 $.fn.yiiactiveform.validate(form, function(messages) {
			if($.isEmptyObject(messages)) {
			  	$.each(settings.attributes, function () {
		     		$.fn.yiiactiveform.updateInput(this,messages,form); 
			  	});
				
				if(tipo == aje || tipo == ajs || tipo == sad){
					if(tipo == aje || tipo == ajs){
						//ajuste entrada / salida
						if(notas == ""){
							$('#IDocto_Notas_em_').html('Notas no puede ser nulo.');
	            			$('#IDocto_Notas_em_').show();
	            			settings.submitting = false ;
						}else{
							$('#IDocto_Notas_em_').html('');
	            			$('#IDocto_Notas_em_').hide();
	            			//se envia el form
						    $('#btn_save').hide();
						    $('#btn_add').hide();
			                form.submit();	
						}	
					}

					if(tipo == sad){
						//salida de dotación
						if(empleado == ""){
							$('#IDocto_Id_Emp_em_').html('Empleado no puede ser nulo.');
	            			$('#IDocto_Id_Emp_em_').show();
	            			settings.submitting = false ;
						}else{
							$('#IDocto_Id_Emp_em_').html('');
	            			$('#IDocto_Id_Emp_em_').hide();
	            			//se envia el form
						    $('#btn_save').hide();
						    $('#btn_add').hide();
			                form.submit();
						}
					}


				}else{
					//se envia el form
				    $('#btn_save').hide();
				    $('#btn_add').hide();
	                form.submit();	
				}

			} else {
			  settings = form.data('settings'),
			  $.each(settings.attributes, function () {
			     $.fn.yiiactiveform.updateInput(this,messages,form); 
			  });
			  settings.submitting = false ;
			}
		});
	});
});

</script>


<h3>Detalle</h3>

<?php 

//detalle

if($model->Id_Tipo_Docto == Yii::app()->params->ent){
	//entrada
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'idocto-movto-grid',
		'dataProvider'=>$detalle->search(),
		//'filter'=>$model,
    	'enableSorting' => false,
		'columns'=>array(
			array(
	            'name' => 'Id_Item',
	            'type' => 'raw',
	            'value' => '$data->DescItem($data->Id_Item)',
	        ),
			array(
	            'name' => 'Id_Bodega_Dst',
	            'type' => 'raw',
	            'value' => '$data->idbodegadst->Descripcion',
	        ),
			'Cantidad',
			array(
                'name'=>'Vlr_Unit_Item',
                'value'=>function($data){
                    return number_format($data->Vlr_Unit_Item, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}{delete}',
	            'afterDelete'=>'function(link,success,data){
				         window.location.reload(); 
				}',
	            'buttons'=>array(
	                'update'=>array(
	                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Modificar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/update", array("id"=>$data->Id))',
	                ),
	                'delete'=>array(
	                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Eliminar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/delete", array("id"=>$data->Id))',
	                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Docto) > 1)',
	                ),
	            )
			),
		),
	));
}

if($model->Id_Tipo_Docto == Yii::app()->params->sal){
	//salida
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'idocto-movto-grid',
		'dataProvider'=>$detalle->search(),
		//'filter'=>$model,
    	'enableSorting' => false,
		'columns'=>array(
			array(
	            'name' => 'Id_Item',
	            'type' => 'raw',
	            'value' => '$data->DescItem($data->Id_Item)',
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'type' => 'raw',
	            'value' => '$data->idbodegaorg->Descripcion',
	        ),
			'Cantidad',
			array(
                'name'=>'Vlr_Unit_Item',
                'value'=>function($data){
                    return number_format($data->Vlr_Unit_Item, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}{delete}',
	            'afterDelete'=>'function(link,success,data){
				         window.location.reload(); 
				}',
	            'buttons'=>array(
	                'update'=>array(
	                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Modificar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/update", array("id"=>$data->Id))',
	                ),
	                'delete'=>array(
	                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Eliminar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/delete", array("id"=>$data->Id))',
	                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Docto) > 1)',
	                ),
	            )
			),
		),
	));
}

if($model->Id_Tipo_Docto == Yii::app()->params->trb){
	//transferencia
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'idocto-movto-grid',
		'dataProvider'=>$detalle->search(),
		//'filter'=>$model,
    	'enableSorting' => false,
		'columns'=>array(
			array(
	            'name' => 'Id_Item',
	            'type' => 'raw',
	            'value' => '$data->DescItem($data->Id_Item)',
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'type' => 'raw',
	            'value' => '$data->idbodegaorg->Descripcion',
	        ),array(
	            'name' => 'Id_Bodega_Dst',
	            'type' => 'raw',
	            'value' => '$data->idbodegadst->Descripcion',
	        ),
			'Cantidad',
			array(
                'name'=>'Vlr_Unit_Item',
                'value'=>function($data){
                    return number_format($data->Vlr_Unit_Item, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}{delete}',
	            'afterDelete'=>'function(link,success,data){
				         window.location.reload(); 
				}',
	            'buttons'=>array(
	                'update'=>array(
	                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Modificar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/update", array("id"=>$data->Id))',
	                ),
	                'delete'=>array(
	                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Eliminar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/delete", array("id"=>$data->Id))',
	                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Docto) > 1)',
	                ),
	            )
			),
		),
	));
}

if($model->Id_Tipo_Docto == Yii::app()->params->aje){
	//ajuste por entrada
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'idocto-movto-grid',
		'dataProvider'=>$detalle->search(),
		//'filter'=>$model,
    	'enableSorting' => false,
		'columns'=>array(
			array(
	            'name' => 'Id_Item',
	            'type' => 'raw',
	            'value' => '$data->DescItem($data->Id_Item)',
	        ),
			array(
	            'name' => 'Id_Bodega_Dst',
	            'type' => 'raw',
	            'value' => '$data->idbodegadst->Descripcion',
	        ),
			'Cantidad',
			array(
                'name'=>'Vlr_Unit_Item',
                'value'=>function($data){
                    return number_format($data->Vlr_Unit_Item, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}{delete}',
	            'afterDelete'=>'function(link,success,data){
				         window.location.reload(); 
				}',
	            'buttons'=>array(
	                'update'=>array(
	                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Modificar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/update", array("id"=>$data->Id))',
	                ),
	                'delete'=>array(
	                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Eliminar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/delete", array("id"=>$data->Id))',
	                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Docto) > 1)',
	                ),
	            )
			),
		),
	));
}

if($model->Id_Tipo_Docto == Yii::app()->params->ajs){
	//ajuste por salida
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'idocto-movto-grid',
		'dataProvider'=>$detalle->search(),
		//'filter'=>$model,
    	'enableSorting' => false,
		'columns'=>array(
			array(
	            'name' => 'Id_Item',
	            'type' => 'raw',
	            'value' => '$data->DescItem($data->Id_Item)',
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'type' => 'raw',
	            'value' => '$data->idbodegaorg->Descripcion',
	        ),
			'Cantidad',
			array(
                'name'=>'Vlr_Unit_Item',
                'value'=>function($data){
                    return number_format($data->Vlr_Unit_Item, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}{delete}',
	            'afterDelete'=>'function(link,success,data){
				         window.location.reload(); 
				}',
	            'buttons'=>array(
	                'update'=>array(
	                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Modificar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/update", array("id"=>$data->Id))',
	                ),
	                'delete'=>array(
	                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Eliminar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/delete", array("id"=>$data->Id))',
	                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Docto) > 1)',
	                ),
	            )
			),
		),
	));
}

if($model->Id_Tipo_Docto == Yii::app()->params->sad){
	//salida de dotación
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'idocto-movto-grid',
		'dataProvider'=>$detalle->search(),
		//'filter'=>$model,
    	'enableSorting' => false,
		'columns'=>array(
			array(
	            'name' => 'Id_Item',
	            'type' => 'raw',
	            'value' => '$data->DescItem($data->Id_Item)',
	        ),
			array(
	            'name' => 'Id_Bodega_Org',
	            'type' => 'raw',
	            'value' => '$data->idbodegaorg->Descripcion',
	        ),
			'Cantidad',
			array(
                'name'=>'Vlr_Unit_Item',
                'value'=>function($data){
                    return number_format($data->Vlr_Unit_Item, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}{delete}',
	            'afterDelete'=>'function(link,success,data){
				         window.location.reload(); 
				}',
	            'buttons'=>array(
	                'update'=>array(
	                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Modificar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/update", array("id"=>$data->Id))',
	                ),
	                'delete'=>array(
	                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Eliminar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/delete", array("id"=>$data->Id))',
	                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Docto) > 1)',
	                ),
	            )
			),
		),
	));
}

if($model->Id_Tipo_Docto == Yii::app()->params->dev){
	//devolución
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'idocto-movto-grid',
		'dataProvider'=>$detalle->search(),
		//'filter'=>$model,
    	'enableSorting' => false,
		'columns'=>array(
			array(
	            'name' => 'Id_Item',
	            'type' => 'raw',
	            'value' => '$data->DescItem($data->Id_Item)',
	        ),
			array(
	            'name' => 'Id_Bodega_Dst',
	            'type' => 'raw',
	            'value' => '$data->idbodegadst->Descripcion',
	        ),
			'Cantidad',
			array(
                'name'=>'Vlr_Unit_Item',
                'value'=>function($data){
                    return number_format($data->Vlr_Unit_Item, 2);
                },
                'htmlOptions'=>array('style' => 'text-align: right;'),
            ),
			array(
				'class'=>'CButtonColumn',
	            'template'=>'{update}{delete}',
	            'afterDelete'=>'function(link,success,data){
				         window.location.reload(); 
				}',
	            'buttons'=>array(
	                'update'=>array(
	                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Modificar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/update", array("id"=>$data->Id))',
	                ),
	                'delete'=>array(
	                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
	                    'imageUrl'=>false,
	                    'options'=>array('title'=>'Eliminar'),
	                    'url'=>'Yii::app()->createUrl("iDoctoMovto/delete", array("id"=>$data->Id))',
	                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Docto) > 1)',
	                ),
	            )
			),
		),
	));
}

?>

<script type="text/javascript">

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html(""); 
}

</script>



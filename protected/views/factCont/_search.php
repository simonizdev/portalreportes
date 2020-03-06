<?php
/* @var $this FactPendController */
/* @var $model FactPend */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<p>Utilice los filtros para optimizar la busqueda:</p>

	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Id_Fact'); ?>
			    <?php echo $form->numberField($model,'Id_Fact', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Empresa'); ?>
	          	<?php $lista_empresas = array(1 => "COMSTAR", 2 => "PANSELL", 3 => "SIMONIZ", 4 => "TITAN") ?>
			    <?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'FactCont[Empresa]',
						'id'=>'FactCont_Empresa',
						'data'=>$lista_empresas,
						'htmlOptions'=>array(),
					  	'options'=>array(
    						'placeholder'=>'Seleccione...',
    						'width'=> '100%',
    						'allowClear'=>true,
						),
					));

				?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Num_Factura'); ?>
			    <?php echo $form->textField($model,'Num_Factura', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha_Factura'); ?>
			    <?php echo $form->textField($model,'Fecha_Factura', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-6">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Proveedor'); ?>
			    <?php echo $form->textField($model,'Proveedor'); ?>
			    <?php
			    $this->widget('ext.select2.ESelect2', array(
			        'selector' => '#FactCont_Proveedor',

			        'options'  => array(
			        	'allowClear' => true,
			        	'minimumInputLength' => 5,
		               	'width' => '100%',
		               	'language' => 'es',
		                'ajax' => array(
	                        'url' => Yii::app()->createUrl('proveedorCont/SearchProveedor'),
			               	'dataType'=>'json',
	                    	'data'=>'js:function(term){return{q: term};}',
	                    	'results'=>'js:function(data){ return {results:data};}'
					                       
			            ),
		            	'formatNoMatches'=> 'js:function(){ clear_select2_ajax("FactCont_Proveedor"); return "No se encontraron resultados"; }',
		            	'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'FactCont_Proveedor\')\">Limpiar campo</button>"; }',
		        	),

		      	));
			    ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha_Radicado'); ?>
			    <?php echo $form->textField($model,'Fecha_Radicado', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Entregada_A'); ?>
			    <?php echo $form->textField($model,'Entregada_A', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_creacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'FactCont[usuario_creacion]',
						'id'=>'FactCont_usuario_creacion',
						'data'=>$lista_usuarios,
						'htmlOptions'=>array(),
					  	'options'=>array(
    						'placeholder'=>'Seleccione...',
    						'width'=> '100%',
    						'allowClear'=>true,
						),
					));

				?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha_Creacion'); ?>
			    <?php echo $form->textField($model,'Fecha_Creacion', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_actualizacion'); ?>
			    <?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'FactCont[usuario_actualizacion]',
						'id'=>'FactCont_usuario_actualizacion',
						'data'=>$lista_usuarios,
						'htmlOptions'=>array(),
					  	'options'=>array(
    						'placeholder'=>'Seleccione...',
    						'width'=> '100%',
    						'allowClear'=>true,
						),
					));

				?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha_Actualizacion'); ?>
			    <?php echo $form->textField($model,'Fecha_Actualizacion', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Estado'); ?>
			    <?php $estados = Yii::app()->params->estados; ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'FactCont[Estado]',
						'id'=>'FactCont_Estado',
						'data'=>$estados,
						'htmlOptions'=>array(),
					  	'options'=>array(
    						'placeholder'=>'Seleccione...',
    						'width'=> '100%',
    						'allowClear'=>true,
						),
					));
				?>	
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'orderby'); ?>
			    <?php 
                	$array_orden = array(1 => 'ID ASC', 2 => 'ID DESC', 3 => 'Empresa ASC', 4 => 'Empresa DESC', 5 => '# de factura ASC', 6 => '# de factura DESC', 7 => 'Fecha de factura ASC', 8 => 'Fecha de factura DESC', 9 => 'Proveedor ASC', 10 => 'Proveedor DESC', 11 => 'Fecha de radicado ASC', 12 => 'Fecha de radicado DESC', 13 => 'Entregada a ASC', 14 => 'Entregada a DESC', 15 => 'Usuario que creo ASC', 16 => 'Usuario que creo DESC', 17 => 'Fecha de creación ASC', 18 => 'Fecha de creación DESC', 19 => 'Usuario que actualizó ASC', 20 => 'Usuario que actualizó DESC', 21 => 'Fecha de actualización ASC', 22 => 'Fecha de actualización DESC', 23 => 'Estado ASC', 24 => 'Estado DESC'
					);
            	?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'FactCont[orderby]',
						'id'=>'FactCont_orderby',
						'data'=>$array_orden,
						'htmlOptions'=>array(),
					  	'options'=>array(
    						'placeholder'=>'Seleccione...',
    						'width'=> '100%',
    						'allowClear'=>true,
						),
					));
				?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php 
					$this->widget('application.extensions.PageSize.PageSize', array(
				        'mGridId' => 'fact-cont-grid', //Gridview id
				        'mPageSize' => @$_GET['pageSize'],
				        'mDefPageSize' => Yii::app()->params['defaultPageSize'],
				        'mPageSizeOptions'=>Yii::app()->params['pageSizeOptions'],// Optional, you can use with the widget default
					)); 
				?>	
	        </div>
	    </div>
	</div>
	<div class="btn-group" style="padding-bottom: 2%">
		<button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
		<button type="submit" class="btn btn-success" id="yt0"><i class="fa fa-search"></i> Buscar</button>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

function clear_select2_ajax(id){
	$('#'+id+'').val('').trigger('change');
	$('#s2id_'+id+' span').html("");
}

function resetfields(){
	$('#Promocion_Id_Item_Padre').val('').trigger('change');
	$('#s2id_Promocion_Id_Item_Padre span').html("");
	$('#Promocion_Id_Item_Hijo').val('').trigger('change');
	$('#s2id_Promocion_Id_Item_Hijo span').html("");
	$('#Promocion_Cantidad').val('');
	$('#Promocion_usuario_creacion').val('').trigger('change');
	$('#Promocion_Fecha_Creacion').val('');
	$('#Promocion_usuario_actualizacion').val('').trigger('change');
	$('#Promocion_Fecha_Actualizacion').val('');
	$('#Promocion_Estado').val('').trigger('change');
	$('#Promocion_orderby').val('').trigger('change');
	$('#yt0').click();
}

</script>

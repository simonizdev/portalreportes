<?php
/* @var $this InventarioController */
/* @var $model Inventario */
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
	          	<?php echo $form->label($model,'Id_Inventario'); ?>
			    <?php echo $form->numberField($model,'Id_Inventario', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Documento'); ?>
			    <?php echo $form->numberField($model,'Documento', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha'); ?>
			    <?php echo $form->textField($model,'Fecha', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Tipo'); ?>
			    <?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Inventario[Tipo]',
						'id'=>'Inventario_Tipo',
						'data'=> array(1 => 'Entrada', 2 => 'Salida'),
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
	</div>
	<div class="row">
		 <div class="col-sm-2">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cantidad'); ?>
			    <?php echo $form->numberField($model,'Cantidad', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
		<div class="col-sm-5">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Id_Suministro'); ?>
			    <?php echo $form->textField($model,'Id_Suministro'); ?>
			    <?php
			    $this->widget('ext.select2.ESelect2', array(
			        'selector' => '#Inventario_Id_Suministro',

			        'options'  => array(
			        	'allowClear' => true,
			        	'minimumInputLength' => 3,
		               	'width' => '100%',
		               	'language' => 'es',
		                'ajax' => array(
	                        'url' => Yii::app()->createUrl('suministro/SearchSuministro'),
			               	'dataType'=>'json',
	                    	'data'=>'js:function(term){return{q: term};}',
	                    	'results'=>'js:function(data){ return {results:data};}'
					                       
			            ),
		            	'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Inventario_Id_Suministro"); return "No se encontraron resultados"; }',
		            	'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Inventario_Id_Suministro\')\">Limpiar campo</button>"; }',
		        	),

		      	));
			    ?>
	        </div>
	    </div>
	   	<div class="col-sm-5">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Id_Departamento'); ?>
			    <?php echo $form->textField($model,'Id_Departamento', array('autocomplete' => 'off')); ?>
			    <?php
			    $this->widget('ext.select2.ESelect2', array(
			        'selector' => '#Inventario_Id_Departamento',
			        'options'  => array(
			        	'minimumInputLength' => 3,
		               	'width' => '100%',
		               	'language' => 'es',
		                'ajax' => array(
	                        'url' => Yii::app()->createUrl('departamento/SearchDepartamento'),
			               	'dataType'=>'json',
	                    	'data'=>'js:function(term){return{q: term};}',
	                    	'results'=>'js:function(data){ return {results:data};}'
					                       
			            ),
			            'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Inventario_Id_Departamento"); return "No se encontraron resultados"; }',
			            'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Inventario_Id_Departamento\')\">Limpiar campo</button>"; }',
		        	),

		      	));
			    ?>
	        </div>
	    </div>	
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_creacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Inventario[usuario_creacion]',
						'id'=>'Inventario_usuario_creacion',
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
						'name'=>'Inventario[usuario_actualizacion]',
						'id'=>'Inventario_usuario_actualizacion',
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
	          	<?php echo $form->label($model,'orderby'); ?>
			    <?php 
                	$array_orden = array(1 => 'ID ASC', 2 => 'ID DESC', 3 => 'Documento ASC', 4 => 'Documento DESC', 5 => 'Fecha ASC', 6 => 'Fecha DESC' , 7 => 'Tipo ASC', 8 => 'Tipo DESC', 9 => 'Cantidad ASC', 10 => 'Cantidad DESC', 11 => 'Suministro ASC', 12 => 'Suministro DESC', 13 => 'Departamento ASC', 14 => 'Departamento DESC', 15 => 'Usuario que creo ASC', 16 => 'Usuario que creo DESC', 17 => 'Fecha de creación ASC', 18 => 'Fecha de creación DESC', 19 => 'Usuario que actualizó ASC', 20 => 'Usuario que actualizó DESC', 21 => 'Fecha de actualización ASC', 22 => 'Fecha de actualización DESC',
					);
            	?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Inventario[orderby]',
						'id'=>'Inventario_orderby',
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
				        'mGridId' => 'inventario-grid', //Gridview id
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


<script type="text/javascript">

	function resetfields(){
		$('#Inventario_Id_Inventario').val('');
		$('#Inventario_Documento').val('');
		$('#Inventario_Fecha').val('');
		$('#Inventario_Tipo').val('').trigger('change');
		$('#Inventario_Cantidad').val('');
		$('#Inventario_Id_Suministro').val('').trigger('change');
		$('#s2id_Inventario_Id_Suministro span').html("");
		$('#Inventario_Id_Departamento').val('').trigger('change');
		$('#s2id_Inventario_Id_Departamento span').html("");
		$('#Inventario_usuario_creacion').val('').trigger('change');
		$('#Inventario_Fecha_Creacion').val('');
		$('#Inventario_usuario_actualizacion').val('').trigger('change');
		$('#Inventario_Fecha_Actualizacion').val('');
		$('#Inventario_orderby').val('').trigger('change');
		$('#yt0').click();
	}

	function clear_select2_ajax(id){
		$('#'+id+'').val('').trigger('change');
		$('#s2id_'+id+' span').html("");
	}
	
</script>

<?php $this->endWidget(); ?>


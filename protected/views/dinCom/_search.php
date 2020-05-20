<?php
/* @var $this DinComController */
/* @var $model DinCom */
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
	          	<?php echo $form->label($model,'Id_Dic_Com'); ?>
			    <?php echo $form->numberField($model,'Id_Dic_Com', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha_Inicio'); ?>
			    <?php echo $form->textField($model,'Fecha_Inicio', array('class' => 'form-control form-control-sm datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha_Fin'); ?>
			    <?php echo $form->textField($model,'Fecha_Fin', array('class' => 'form-control form-control-sm datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	        <div class="form-group">
	            <?php echo $form->label($model,'Porc'); ?>
	            <?php echo $form->numberField($model,'Porc', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off' , 'step' => '0.01')); ?>
	        </div>
	    </div>		   
	</div>
	<div class="row">		
		<div class="col-sm-3">
	      	<div class="form-group">
				<?php echo $form->label($model,'Id_Plan_Cliente'); ?>
				<?php
				  $this->widget('ext.select2.ESelect2',array(
				      'name'=>'DinCom[Id_Plan_Cliente]',
				      'id'=>'DinCom_Id_Plan_Cliente',
				      'data'=>UtilidadesVarias::listaplanescliente(),
				      'options'=>array(
				          'placeholder'=>'Seleccione...',
				          'width'=> '100%',
				          'allowClear'=>true,
				      ),
				  ));
				?>
	      	</div>
	  	</div>
	  	<div class="col-sm-9" id="div_cri_cli" style="display: none;">
	      	<div class="form-group">
				<?php echo $form->label($model,'Id_Criterio_Cliente'); ?>
				<?php
				  $this->widget('ext.select2.ESelect2',array(
				      'name'=>'DinCom[Id_Criterio_Cliente]',
				      'id'=>'DinCom_Id_Criterio_Cliente',
				      'htmlOptions'=>array(
				        'multiple'=>'multiple',
				      ),
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
		<div class="col-sm-3">
	      	<div class="form-group">
				<?php echo $form->label($model,'Id_Plan_Item'); ?>
				<?php
				  $this->widget('ext.select2.ESelect2',array(
				      'name'=>'DinCom[Id_Plan_Item]',
				      'id'=>'DinCom_Id_Plan_Item',
				      'data'=>UtilidadesVarias::listaplanesitem(),
				      'options'=>array(
				          'placeholder'=>'Seleccione...',
				          'width'=> '100%',
				          'allowClear'=>true,
				      ),
				  ));
				?>
	      	</div>
	  	</div>
	  	<div class="col-sm-9">
	      	<div class="form-group" id="div_cri_item" style="display: none;">
				<?php echo $form->label($model,'Id_Criterio_Item'); ?>
				<?php
				  $this->widget('ext.select2.ESelect2',array(
				      'name'=>'DinCom[Id_Criterio_Item]',
				      'id'=>'DinCom_Id_Criterio_Item',
				      'htmlOptions'=>array(
				        'multiple'=>'multiple',
				      ),
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
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_creacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'DinCom[usuario_creacion]',
						'id'=>'DinCom_usuario_creacion',
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
			    <?php echo $form->textField($model,'Fecha_Creacion', array('class' => 'form-control form-control-sm datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_actualizacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'DinCom[usuario_actualizacion]',
						'id'=>'DinCom_usuario_actualizacion',
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
			    <?php echo $form->textField($model,'Fecha_Actualizacion', array('class' => 'form-control form-control-sm datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
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
						'name'=>'DinCom[Estado]',
						'id'=>'DinCom_Estado',
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
	          	<?php 
					$this->widget('application.extensions.PageSize.PageSize', array(
					        'mGridId' => 'din-com-grid', //Gridview id
					        'mPageSize' => @$_GET['pageSize'],
					        'mDefPageSize' => Yii::app()->params['defaultPageSize'],
					        'mPageSizeOptions'=>Yii::app()->params['pageSizeOptions'],// Optional, you can use with the widget default
					)); 
				?>	
	        </div>
	    </div>
	</div>
	<div class="row mb-2">
	  	<div class="col-sm-6">  
     		<button type="button" class="btn btn-success btn-sm" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
			<button type="submit" class="btn btn-success btn-sm" id="yt0"><i class="fa fa-search"></i> Buscar</button>
	  	</div>
	</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

    $("#DinCom_Id_Plan_Cliente").change(function() {
  		var plan = $(this).val();
	  	if(plan != ""){
  			var data = {plan: plan}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('DinCom/GetCriteriosPlanCliente'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){
					$('#DinCom_Id_Criterio_Cliente').val('').trigger('change');
				   	$("#DinCom_Id_Criterio_Cliente").html('');
				  	$.each(data, function(i,item){
			      		$("#DinCom_Id_Criterio_Cliente").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
				  	});
				  	$("#div_cri_cli").show();
				}
			});
	 	}else{
      		$('#DinCom_Id_Criterio_Cliente').val('').trigger('change');
      		$("#div_cri_cli").hide();    
	 	}

	});

	$("#DinCom_Id_Plan_Item").change(function() {
  		var plan = $(this).val();
	  	if(plan != ""){
  			var data = {plan: plan}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('DinCom/GetCriteriosPlanItem'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){
					$('#DinCom_Id_Criterio_Item').val('').trigger('change');
				   	$("#DinCom_Id_Criterio_Item").html('');
				  	$.each(data, function(i,item){
			      		$("#DinCom_Id_Criterio_Item").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
				  	});
				  	$("#div_cri_item").show();
				}
			});
	 	}else{
      		$('#DinCom_Id_Criterio_Item').val('').trigger('change');
      		$("#div_cri_item").hide();    
	 	}

	});

});

function resetfields(){
	$('#DinCom_Id_Dic_Com').val('');
	$('#DinCom_Fecha_Inicio').val('');
	$('#DinCom_Fecha_Fin').val('');
	$('#DinCom_Porc').val('');
	$('#DinCom_Id_Plan_Cliente').val('').trigger('change');
	$('#DinCom_Id_Plan_Item').val('').trigger('change');
	$('#DinCom_usuario_creacion').val('').trigger('change');
	$('#DinCom_Fecha_Creacion').val('');
	$('#DinCom_usuario_actualizacion').val('').trigger('change');
	$('#DinCom_Fecha_Actualizacion').val('');
	$('#DinCom_Estado').val('').trigger('change');
	$('#yt0').click();
}
	
</script>

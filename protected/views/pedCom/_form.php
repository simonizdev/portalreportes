<?php
/* @var $this PedComController */
/* @var $model PedCom */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ped-com-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Usuario', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Id_Usuario'); ?>
         	<?php echo $form->hiddenField($model,'Id_Usuario', array('class' => 'form-control form-control-sm datepicker', 'readonly' => true, 'value'=> Yii::app()->user->getState('id_user'))); ?>
         	<p><?php echo Yii::app()->user->getState('name_user'); ?></p>
        </div>
    </div>
    <div class="col-sm-6">
    	<div class="form-group">
	      <?php echo $form->error($model,'Cliente', array('class' => 'badge badge-warning float-right')); ?>
	      <?php echo $form->label($model,'Cliente'); ?>
	      <?php echo $form->textField($model,'Cliente'); ?>
	      <?php
	      $this->widget('ext.select2.ESelect2', array(
	          'selector' => '#PedCom_Cliente',

	          'options'  => array(
	            'allowClear' => true,
	            'minimumInputLength' => 3,
	                'width' => '100%',
	                'language' => 'es',
	                'ajax' => array(
	                      'url' => Yii::app()->createUrl('PedCom/SearchCliente'),
	                  'dataType'=>'json',
	                    'data'=>'js:function(term){return{q: term};}',
	                    'results'=>'js:function(data){ return {results:data};}'
	                             
	              ),
	              'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ParPedEsp_Nit"); return "No se encontraron resultados"; }',
	              'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'PedCom_Cliente\')\">Limpiar campo</button>"; }',
	          ),
	        ));
	      ?>
    	</div>
  	</div>
</div>
<div class="row">
  	<div class="col-sm-4" id="div_suc" style="display: none;">
	    <div class="form-group">
			<?php echo $form->error($model,'Sucursal', array('class' => 'badge badge-warning float-right')); ?>
			<?php echo $form->label($model,'Sucursal', array('class' => 'control-label')); ?>
			<?php
			  $this->widget('ext.select2.ESelect2',array(
			    'name'=>'PedCom[Sucursal]',
			    'id'=>'PedCom_Sucursal',
			    //'data'=>$lista_tipos,
			    'value' => $model->Sucursal,
			    'options'=>array(
			        'placeholder'=>'Seleccione...',
			        'width'=> '100%',
			        'allowClear'=>true,
			    ),
			  ));
			?>
	    </div>
	</div>
	<div class="col-sm-4" id="div_pe" style="display: none;">
	    <div class="form-group">
	    	<?php echo $form->error($model,'Punto_Envio', array('class' => 'badge badge-warning float-right')); ?>
			<?php echo $form->label($model,'Punto_Envio', array('class' => 'control-label')); ?>
			
			<?php
			  $this->widget('ext.select2.ESelect2',array(
			    'name'=>'PedCom[Punto_Envio]',
			    'id'=>'PedCom_Punto_Envio',
			    //'data'=>$lista_tipos,
			    'value' => $model->Punto_Envio,
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

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=pedCom/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Continuar</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

  	$("#valida_form").click(function() {
    	var form = $("#ped-com-form");
    	var settings = form.data('settings') ;

      	settings.submitting = true ;
      	$.fn.yiiactiveform.validate(form, function(messages) {
          	if($.isEmptyObject(messages)) {
              	$.each(settings.attributes, function () {
                 	$.fn.yiiactiveform.updateInput(this,messages,form); 
             	});
                 
				form.submit();
				loadershow();
      
          	} else {
              	settings = form.data('settings'),
              	$.each(settings.attributes, function () {
                 	$.fn.yiiactiveform.updateInput(this,messages,form); 
              	});
              	settings.submitting = false ;
          	}
      	});
    });

    $("#PedCom_Cliente").change(function() {

  		var nit = $(this).val();

	  	if(nit != ""){
  			var data = {nit: nit}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('PedCom/GetSucCliente'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){
					$('#PedCom_Sucursal').val('').trigger('change');
				   	$("#PedCom_Sucursal").html('');
				  	$("#PedCom_Sucursal").append('<option value=""></option>');
				  	$.each(data, function(i,item){
			      		$("#PedCom_Sucursal").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
				  	});
				  	$("#div_suc").show();
				}
			});
	 	}else{
	 		$('#contenido').html('');
        	$('#btn_save').hide();
        	$('#PedCom_Sucursal').val('').trigger('change');
        	$('#PedCom_Punto_Envio').val('').trigger('change'); 
      		$("#div_suc").hide();    

	 	}

	});

	$("#PedCom_Sucursal").change(function() {

  		var nit = $("#PedCom_Cliente").val();
  		var suc = $(this).val();

	  	if(suc != ""){
  			var data = {nit: nit, suc: suc}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('PedCom/GetPuntEnvSucCliente'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){ 
					$('#PedCom_Punto_Envio').val('').trigger('change');
					$("#PedCom_Punto_Envio").html('');
				  	$("#PedCom_Punto_Envio").append('<option value=""></option>');
				  	$.each(data, function(i,item){
			      		$("#PedCom_Punto_Envio").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
				  	});
				  	$("#div_pe").show();
				}
			});
	 	}else{
 			$('#contenido').html('');
        	$('#btn_save').hide(); 
      		$('#PedCom_Punto_Envio').val('').trigger('change'); 
      		$("#div_pe").hide();    
	 	}

	});

});

</script>
<?php
/* @var $this EanItemController */
/* @var $model EanItem */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ean-item-form',
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
	<div class="col-sm-6">
		<?php echo $form->error($model,'Id_Item', array('class' => 'badge badge-warning float-right')); ?>
	    <?php echo $form->label($model,'Id_Item'); ?>
	    <?php echo $form->hiddenField($model,'Id_Item', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly' => true, 'value' => $modelo_info_item->Id_Item)); ?>	
   		<p><?php echo $modelo_info_item->DescItem($modelo_info_item->Id_Item); ?></p>
  	</div>
  	<div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->error($model,'Criterio', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Criterio'); ?>
            <?php echo $form->hiddenField($model,'Criterio', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly' => true, 'value' => $modelo_info_item->Criterio)); ?>	
            <p><?php echo $modelo_info_item->DescCriterio($modelo_info_item->Criterio); ?></p>
        </div>
	</div>
	<div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->error($model,'Num_Und', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Num_Und'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'EanItem[Num_Und]',
                    'id'=>'EanItem_Num_Und',
                    'data'=> $array_nu,
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
	<div class="col-sm-3" id="ean" style="display: none;">
		<?php echo $form->error($model,'Ean', array('class' => 'badge badge-warning float-right')); ?>
		<?php echo $form->label($model,'Ean'); ?>
		<?php echo $form->hiddenField($model,'Ean', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly' => true)); ?>
		<?php echo $form->hiddenField($model,'Dig_Ver', array('class' => 'form-control form-control-sm', 'maxlength' => '2', 'autocomplete' => 'off', 'readonly' => true)); ?>
		<p id="desc_ean"></p>
	</div>
	<div class="col-sm-3" id="uxc" style="display: none;">
		<?php echo $form->error($model,'Und_x_Caja', array('class' => 'badge badge-warning float-right')); ?>
		<?php echo $form->label($model,'Und_x_Caja'); ?>
		<?php echo $form->numberField($model,'Und_x_Caja', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'type' => 'number')); ?>
	</div>
</div>

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=eanItem/view&id='.$modelo_info_item->Id_Item; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">

$(function() {

	$('#EanItem_Num_Und').on("change", function() { 
   		
		var item = $('#EanItem_Id_Item').val();
		var val = $(this).val();

		if(val != ""){
			
			$(".ajax-loader").fadeIn('fast');

			var data = {item: item, num_und: val}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('EanItem/generarean14'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){

                    var dig_ver = parseInt(data.dig_ver);
                    var ean = parseInt(data.ean);
					
				  	$(".ajax-loader").fadeOut('fast');

					$('#ean').show();
					$('#EanItem_Ean').val(ean);
					$('#desc_ean').text(ean+''+dig_ver);
					$('#EanItem_Dig_Ver').val(dig_ver);
					$('#uxc').show();

				}
			});	
		}else{
			$('#ean').hide();
			$('#EanItem_Ean').val('');
			$('#desc_ean').text('');
			$('#EanItem_Dig_Ver').val('');
			$('#uxc').hide();
			$('#EanItem_Und_x_Caja').val('');
			
		}

	});

	$("#valida_form").click(function() {
		
		$('#EanItem_Und_x_Caja_em_').html('');
		$('#EanItem_Und_x_Caja_em_').hide();
		
    	var form = $("#ean-item-form");
		var settings = form.data('settings') ;
		 
		settings.submitting = true ;
		$.fn.yiiactiveform.validate(form, function(messages) {
		  if($.isEmptyObject(messages)) {
	      	$.each(settings.attributes, function () {
	         	$.fn.yiiactiveform.updateInput(this,messages,form); 
	      	});

      		var item = $('#EanItem_Id_Item').val();
			var und_x_caja = $('#EanItem_Und_x_Caja').val();

	      	var data = {item: item, und_x_caja: und_x_caja}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('EanItem/validaundxcajaitem'); ?>",
				data: data,
				dataType: 'json',
				success: function(response){
					if(response == 1){
						//se envia el form
        				form.submit();
        				loadershow();
					}else{
						$('#EanItem_Und_x_Caja_em_').html('Esta cant. ya ha sido asignada.');
						$('#EanItem_Und_x_Caja_em_').show();

					}
				}
			});
		    
		      
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




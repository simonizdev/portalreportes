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
		<div class="form-group">
			<?php echo $form->error($model,'Id_Item', array('class' => 'badge badge-warning float-right')); ?>
		    <?php echo $form->label($model,'Id_Item'); ?>	
		    <?php echo $form->textField($model,'Id_Item'); ?>
		    <?php
		        $this->widget('ext.select2.ESelect2', array(
		            'selector' => '#EanItem_Id_Item',
		            'options'  => array(
		                'allowClear' => true,
		                'minimumInputLength' => 3,
		                'width' => '100%',
		                'language' => 'es',
		                'ajax' => array(
		                    'url' => Yii::app()->createUrl('EanItem/SearchItem'),
		                    'dataType'=>'json',
		                    'data'=>'js:function(term){return{q: term};}',
		                    'results'=>'js:function(data){ return {results:data};}'                   
		                ),
		                'formatNoMatches'=> 'js:function(){ clear_select2_ajax("EanItem_Id_Item"); return "No se encontraron resultados"; }',
		                'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'EanItem_Id_Item\')\">Limpiar campo</button>"; }',
		            ),
		        ));
		    ?>
		</div>
  	</div>
  	<div class="col-sm-3" id="criterio" style="display: none;">
        <div class="form-group">
            <?php echo $form->error($model,'Criterio', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Criterio'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'EanItem[Criterio]',
                    'id'=>'EanItem_Criterio',
                    'data'=> array(1 => 'FAB. SIMONIZ', 2 => 'FAB. TITAN', 3 => 'IMPORT.'),
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
	<div class="col-sm-3" id="ean" style="display: none;">
		<div class="form-group">
			<?php echo $form->error($model,'Ean', array('class' => 'badge badge-warning float-right')); ?>
			<?php echo $form->label($model,'Ean'); ?>
			<?php echo $form->hiddenField($model,'Ean', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'readonly' => true)); ?>
			<?php echo $form->hiddenField($model,'Dig_Ver', array('class' => 'form-control', 'maxlength' => '2', 'autocomplete' => 'off', 'readonly' => true)); ?>
			<p id="desc_ean"></p>
		</div>
	</div>
</div>


<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=eanItem/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">

$(function() {

	$('#EanItem_Id_Item').on("change", function() { 
   		
		var val = $(this).val();

		if(val != ""){
			
			$(".ajax-loader").fadeIn('fast');

			var data = {item: val, criterio: 0}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('EanItem/generarean13'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){

                    var criterio = parseInt(data.criterio); 
                    var dig_ver = parseInt(data.dig_ver);
                    var ean = parseInt(data.ean);
					
				  	$(".ajax-loader").fadeOut('fast');

				  	if(criterio == 4){
				  		$('#criterio').show();
						$('#EanItem_Criterio').val('').trigger('change');
						$('#ean').hide();
						$('#EanItem_Ean').val('');
						$('#EanItem_Dig_Ver').val('');
						$('#desc_ean').text('');
				  	}else{
				  		$('#criterio').show();
						$('#EanItem_Criterio').val(criterio).trigger('change');
						$('#ean').show();
						$('#EanItem_Ean').val(ean);
						$('#EanItem_Dig_Ver').val(dig_ver);
						$('#desc_ean').text(ean+''+dig_ver);	
				  	}

				}
			});	
		}else{
			$('#criterio').hide();
			$('#EanItem_Criterio').val('');
			$('#ean').hide();
			$('#EanItem_Ean').val('');
			$('#EanItem_Dig_Ver').val('');
			$('#desc_ean').text('');
		}

	});

	$('#EanItem_Criterio').on("change", function() { 
   		
		var item = $('#EanItem_Id_Item').val();
		var val = $(this).val();

		if(val != ""){
			
			$(".ajax-loader").fadeIn('fast');

			var data = {item: item, criterio: val}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('EanItem/generarean13'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){

                    var dig_ver = parseInt(data.dig_ver);
                    var ean = parseInt(data.ean);
					
				  	$(".ajax-loader").fadeOut('fast');

					$('#ean').show();
					$('#EanItem_Ean').val(ean);
					$('#EanItem_Dig_Ver').val(dig_ver);
					$('#desc_ean').text(ean+''+dig_ver);

				}
			});	
		}else{
			$('#ean').hide();
			$('#EanItem_Ean').val('');
			$('#EanItem_Dig_Ver').val('');
			$('#desc_ean').text('');
		}

	});

});

</script>
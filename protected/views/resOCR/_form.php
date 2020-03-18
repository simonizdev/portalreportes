<?php
/* @var $this ResOCRController */
/* @var $model ResOCR */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'res-ocr-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data'
	),
)); ?>


<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Tipo', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Tipo'); ?>
            <?php $tipos = array(1 => 'ORDENES DE COMPRA', 2 => 'REMISIONES');  ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ResOCR[Tipo]',
                    'id'=>'ResOCR_Tipo',
                    'data'=>$tipos,
                    'value' => $model->Tipo,
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
	<div class="col-sm-6">
	  	<div class="form-group">
			<?php echo $form->error($model,'Descripcion', array('class' => 'pull-right badge bg-red')); ?>
	 		<?php echo $form->label($model,'Descripcion'); ?>
 			<?php echo $form->textArea($model,'Descripcion',array('class' => 'form-control', 'rows'=>3, 'cols'=>50, 'onkeyup' => 'convert_may(this)')); ?>
	  	</div>
  	</div>	
</div>
<div class="row">
	<div class="col-sm-8">
		<div class="form-group">
			<?php echo $form->error($model,'sop', array('class' => 'pull-right badge bg-red')); ?>
  			<div class="pull-right badge bg-red" id="error_sop" style="display: none;"></div>
  			<input type="hidden" id="valid_doc" value="0">
  			<?php echo $form->label($model,'sop'); ?>
	    	<?php echo $form->fileField($model, 'sop'); ?>
	    	<?php echo $form->hiddenField($model, 'ext_sop'); ?>
    	</div>
  	</div>
  	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Estado', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ResOCR[Estado]',
                    'id'=>'ResOCR_Estado',
                    'data'=>$estados,
                    'value' => $model->Estado,
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

<div class="btn-group" id="buttons">
    <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=resOCR/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">


$(function() {

	var extensionesValidas = ".xlsx, .xls";
	var pesoPermitido = 30720;

	$("#valida_form").click(function() {
      var form = $("#res-ocr-form");
      var settings = form.data('settings') ;

      var soporte = $('#ResOCR_sop').val();

      if(soporte == ''){
      	$('#error_sop').html('Soporte no puede ser nulo');
      	$('#error_sop').show();
      }

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              	
              //se valida si el archivo cargado es valido (1)
              valid_doc = $('#valid_doc').val();

              if(valid_doc == 1){
              	//se envia el form
              	$('#buttons').hide();
              	form.submit();
              }else{

              	settings.submitting = false ;	
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

  	$("#ResOCR_sop").change(function () {

  		$('#error_sop').html('');
    	$('#error_sop').hide();

  		if(validarExtension(this)) {

  	    	if(validarPeso(this)) {

  	    		$('#valid_doc').val(1);

  	    	}
  		}  
    });


	// Validacion de extensiones permitidas
	function validarExtension(datos) {

		var ruta = datos.value;
		var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
		var extensionValida = extensionesValidas.indexOf(extension);

		if(extensionValida < 0) {

		 	$('#error_sop').html('La extensión no es válida (.'+ extension+'), Solo se admite (.xlsx, .xls)');
		 	$('#error_sop').show();
		 	$('#valid_doc').val(0);
		 	$('#ResOCR_ext_sop').val('');
		 	return false;

		} else {
			$('#ResOCR_ext_sop').val(extension);
			return true;

		}
	}

	// Validacion de peso del fichero en kbs

	function validarPeso(datos) {

		if (datos.files && datos.files[0]) {

	        var pesoFichero = datos.files[0].size/1024;

	        if(pesoFichero > pesoPermitido) {

	            $('#error_sop').html('El peso maximo permitido del fichero es: ' + pesoPermitido / 1024 + ' MB, Su fichero tiene: '+ (pesoFichero /1024).toFixed(2) +' MB.');
	            $('#error_sop').show();
	            $('#valid_doc').val(0);
	            return false;

	        } else {

	            return true;

	        }

	    }

	}

});

	
</script>
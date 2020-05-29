<?php
/* @var $this RegImpController */
/* @var $model RegImp */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reg-imp-form',
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
      		<?php echo $form->error($model,'Numero', array('class' => 'badge badge-warning float-right')); ?>
      		<?php echo $form->label($model,'Numero'); ?>
      		<?php echo $form->textField($model,'Numero', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
      	</div>
  	</div>
    <div class="col-sm-4">
        <div class="form-group">
        	<?php echo $form->error($model,'Fecha', array('class' => 'badge badge-warning float-right')); ?>
        	<?php echo $form->label($model,'Fecha'); ?>
		      <?php echo $form->textField($model,'Fecha', array('class' => 'form-control form-control-sm datepicker', 'readonly' => true)); ?>
        </div>
    </div>
  </div>
  <div class="row">
	 <div class="col-sm-8">
		  <div class="form-group">
        <?php echo $form->error($model,'Items', array('class' => 'badge badge-warning float-right')); ?>
			  <?php echo $form->label($model,'Items'); ?>
			  <?php echo $form->textArea($model,'Items',array('class' => 'form-control form-control-sm', 'rows'=>3, 'cols'=>50, 'onkeyup' => 'convert_may(this)')); ?>
		  </div>
	 </div>
</div>
<div class="row">
	<div class="col-sm-8">
  		<div class="form-group">
  			<?php echo $form->error($model,'sop', array('class' => 'badge badge-warning float-right')); ?>
    		<div class="badge badge-warning float-right" id="error_file" style="display: none;"></div>
    		<input type="hidden" id="valid_file" value="0">
    		<?php echo $form->label($model,'sop'); ?>
        <br>
		    <?php echo $form->fileField($model, 'sop'); ?>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=regImp/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Crear</button>
    </div>
</div>


<?php $this->endWidget(); ?>

<script type="text/javascript">


$(function() {

	var extensionesValidas = ".pdf, .PDF";
  var textExtensionesValidas = "(.pdf)";
	var pesoPermitido = 5120;
  var idInput = "valid_file";
  var idMsg = "error_file";

	$("#valida_form").click(function() {
      var form = $("#reg-imp-form");
      var settings = form.data('settings') ;

      var soporte = $('#RegImp_sop').val();

      if(soporte == ''){  
      	$('#error_file').html('Soporte es requerido.');
      	$('#error_file').show();
      }

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              	
              //se valida si el archivo cargado es valido (1)
              valid_file = $('#valid_file').val();

              if(valid_file == 1){
              	//se envia el form
              	form.submit();
                loadershow();
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

  	$("#RegImp_sop").change(function () {

  		$('#error_file').html('');
    	$('#error_file').hide();

  		if(validarExtension(this, extensionesValidas, textExtensionesValidas, idInput, idMsg)) {

          if(validarPeso(this, pesoPermitido, idInput, idMsg)) {

            $('#valid_file').val(1);

          }
      }   
    });

});

	
</script>
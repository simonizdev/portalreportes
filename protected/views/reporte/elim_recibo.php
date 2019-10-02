<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Eliminación de recibos</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reporte-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i>Realizado</h4>
      <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<br>
<?php echo $form->hiddenField($model,'opc', array('class' => 'form-control', 'readonly' => true, 'value' => 1)); ?>

<div class="btn-group">
  <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-bar-chart"></i> Ejecutar proceso</button>    
</div>

<?php $this->endWidget(); ?>


<script>

$(function() {

  	$("#valida_form").click(function() {

		var form = $("#reporte-form");

      	if(confirm("Esta seguro de ejecutar el proceso ?")){
			//se envia el form
			form.submit();
			$(".ajax-loader").fadeIn('fast');
      	}else{
      		return false;
      	}
  	});

});

</script>
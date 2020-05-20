<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

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

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Eliminación de pedidos</h4>
  </div>
  <div class="col-sm-6 text-right">
  	<?php echo $form->hiddenField($model,'opc', array('class' => 'form-control', 'readonly' => true, 'value' => 1)); ?>
    <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-cogs"></i> Ejecutar proceso</button>
  </div>
</div>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check-circle"></i>Realizado</h5>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<?php $this->endWidget(); ?>

<script>

$(function() {

  	$("#valida_form").click(function() {

		var form = $("#reporte-form");

      	if(confirm("Esta seguro de ejecutar el proceso ?")){
			//se envia el form
			form.submit();
			loadershow();
      	}else{
      		return false;
      	}
  	});

});

</script>
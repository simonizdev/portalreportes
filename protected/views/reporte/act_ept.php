<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Actualización de EPT</h4>
  </div>
  <div class="col-sm-6 text-right">
    <button type="button" class="btn btn-success btn-sm" onclick="location.reload();"><i class="fa fa-sync"></i> Refrescar resultados</button>  
    <button type="button" class="btn btn-success btn-sm" id="valida_form" style="display: none;"><i class="fas fa-arrow-circle-right"></i> Actualizar Documentos</button>
  </div>
</div>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check-circle"></i>Realizado</h5>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

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

<div class="row">
    <?php echo $form->hiddenField($model,'consecutivo', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
    <div class="col-lg-12 table-responsive" id="resultados">
    <!-- contenido via ajax -->
    </div>
</div>  

<?php $this->endWidget(); ?>

<script>

$(function() {   
  
  reporte_pantalla();

  $("#valida_form").click(function() {


    var form = $("#reporte-form");

    var selected = '';    
    $('input:checkbox.checks').each(function(){
        if (this.checked) {
            selected += $(this).val()+',';
        }
    });

    var cadena = selected.slice(0,-1);
    $('#Reporte_consecutivo').val(cadena);

    form.submit();
    loadershow(); 
               
          
  });

});

function reporte_pantalla(){

  var data = {}
  $(".ajax-loader").fadeIn('fast');
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('reporte/acteptpant'); ?>",
    data: data,
    success: function(data){ 
      $(".ajax-loader").fadeOut('fast');
      $("#resultados").html(data); 
    }
  });

}

function evaldocs(){

  i = $(".checks:checked").length; 

  if(i == 0){
    $("#valida_form").fadeOut('fast');  
  }else{
    $("#valida_form").fadeIn('fast');
  }

}

</script>
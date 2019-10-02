<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Notas aplic. a factura</h3>

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
    <div class="col-sm-4">
      <div class="form-group">
          <?php echo $form->error($model,'cons_inicial', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'cons_inicial'); ?>
          <?php echo $form->numberField($model,'cons_inicial', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
          <?php echo $form->error($model,'cons_final', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'cons_final'); ?>
          <?php echo $form->numberField($model,'cons_final', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
      </div>
    </div>
</div>
    
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-file-excel-o"></i> Generar</button>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

  $("#valida_form").click(function() {

      var form = $("#reporte-form");
      var settings = form.data('settings') ;
      settings.submitting = true ;

      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              //se envia el form
              form.submit();
              $(".ajax-loader").fadeIn('fast');
              setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 5000);
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

function resetfields(){
  $('#Reporte_cons_inicial').val('');
  $('#Reporte_cons_final').val('');
}

</script>

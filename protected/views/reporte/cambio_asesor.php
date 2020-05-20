<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h4>Cambio de asesor</h4>

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
    <div class="col-sm-6">
      <div class="form-group">
          <?php echo $form->error($model,'ruta', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'ruta'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[ruta]',
                  'id'=>'Reporte_ruta',
                  'data'=> $lista_rutas,
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
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'fecha_ret', array('class' => 'badge badge-warning float-right')); ?>
        <?php echo $form->label($model,'fecha_ret'); ?>
        <?php echo $form->textField($model,'fecha_ret', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <?php echo $form->error($model,'asesor_ant', array('class' => 'badge badge-warning float-right')); ?>
      <?php echo $form->label($model,'asesor_ant'); ?>
      <?php echo $form->textField($model,'asesor_ant', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <?php echo $form->error($model,'asesor_nue', array('class' => 'badge badge-warning float-right')); ?>
      <?php echo $form->label($model,'asesor_nue'); ?>
      <?php echo $form->textField($model,'asesor_nue', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
      <?php echo $form->error($model,'firma', array('class' => 'badge badge-warning float-right')); ?>
      <?php echo $form->label($model,'firma'); ?>
      <?php echo $form->textField($model,'firma', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
    </div>
  </div>
</div>
    
<div class="row mb-2">
    <div class="col-sm-6">  
      <button type="button" class="btn btn-success btn-sm" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
      <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-file-pdf"></i> Generar</button>
    </div>
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

  //variables para el lenguaje del datepicker
  $.fn.datepicker.dates['es'] = {
      days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
      daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
      daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
      months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
      today: "Hoy",
      clear: "Limpiar",
      format: "yyyy-mm-dd",
      titleFormat: "MM yyyy",
      weekStart: 1
  };

  $("#Reporte_fecha_ret").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom"
  });
  
});

function resetfields(){
  $('#Reporte_ruta').val('').trigger('change');
  $('#Reporte_fecha_ret').val('');
  $('#Reporte_asesor_ant').val('');
  $('#Reporte_asesor_nue').val('');
  $('#Reporte_firma').val('');
}

</script>

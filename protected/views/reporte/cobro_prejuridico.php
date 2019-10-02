<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Cobro prejurídico</h3>

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
          <?php echo $form->error($model,'ruta_inicial', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'ruta_inicial'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[ruta_inicial]',
                  'id'=>'Reporte_ruta_inicial',
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
    <div class="col-sm-6">
      <div class="form-group">
          <?php echo $form->error($model,'ruta_final', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'ruta_final'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[ruta_final]',
                  'id'=>'Reporte_ruta_final',
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
</div>
<div class="row">
    <div class="col-sm-4">
      <div class="form-group">
          <?php echo $form->error($model,'estado', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'estado'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[estado]',
                  'id'=>'Reporte_estado',
                  'data'=> $lista_estados,
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
        <?php echo $form->error($model,'valor', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'valor'); ?>  
        <?php echo $form->numberField($model,'valor', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
        </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'dias', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'dias'); ?>  
        <?php echo $form->numberField($model,'dias', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-sm-4">
    <div class="form-group">
      <?php echo $form->error($model,'firma', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'firma'); ?>
      <?php echo $form->textField($model,'firma', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
    </div>
  </div>
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-bar-chart"></i> Generar</button>
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
              setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 10000);
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
  $('#Reporte_ruta_inicial').val('').trigger('change');
  $('#Reporte_ruta_final').val('').trigger('change');
  $('#Reporte_estado').val('').trigger('change');
  $('#Reporte_valor').val('');
  $('#Reporte_dias').val('');
  $('#Reporte_firma').val('');
}

</script>

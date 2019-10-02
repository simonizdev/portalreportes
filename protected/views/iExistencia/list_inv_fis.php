<?php
/* @var $this IExistenciaController */
/* @var $model IExistencia */

//para combos de lineas
$lista_lineas = CHtml::listData($lineas, 'Id', 'Descripcion'); 

?>

<h3>Listado de items para inv. físico</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'iexistencia-form',
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
  <div class="col-sm-8">
    <div class="form-group">
          <?php echo $form->hiddenField($model,'orderby', array('class' => 'form-control', 'readonly' => true, 'autocomplete' => 'off', 'value' => 1)); ?>
          <?php echo $form->error($model,'linea', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'linea'); ?>
          <?php
            $this->widget('ext.select2.ESelect2',array(
              'name'=>'IExistencia[linea]',
              'id'=>'IExistencia_linea',
              'data'=>$lista_lineas,
              'htmlOptions'=>array(
                'multiple'=>'multiple',
              ),
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

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-bar-chart"></i> Generar</button>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {
 // $(".ajax-loader").show();
  $("#valida_form").click(function() {

      var form = $("#iexistencia-form");
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
  $('#s2id_IExistencia_linea span').html("");
  $('#IExistencia_linea').val('').trigger('change');
}

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html("");
}

</script>


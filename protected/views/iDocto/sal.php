<?php
/* @var $this IDoctoController */
/* @var $model IDocto */

//para combos de lineas
$lista_lineas = CHtml::listData($lineas, 'Id', 'Descripcion'); 

?>

<h3>Salida de items por línea</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
  'id'=>'idocto-form',
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
        <?php echo $form->error($model,'lin', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'lin'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
                'name'=>'IDocto[lin]',
                'id'=>'IDocto_lin',
                'data'=>$lista_lineas,
                'value' => $model->lin,
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
      <?php echo $form->error($model,'opcion_exp', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'opcion_exp'); ?><br>
      <?php 
        echo $form->radioButtonList($model,'opcion_exp',
            array('1'=>'<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF','2'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL'),
            array(
                'template'=>'{input}{label}',
                'separator'=>'',
                'labelOptions'=>array(
                    'style'=> '
                        padding-left:1%;
                        padding-right:5%;
                  '),
                )                              
            );
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

      var form = $("#idocto-form");
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
  $('#IDocto_lin').val('').trigger('change');
}

</script>
<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h4>Eliminación de transferencia en error</h4>

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
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check-circle"></i>Realizado</h5>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<?php if(Yii::app()->user->hasFlash('warning')):?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info-circle"></i>Info</h5>
        <?php echo Yii::app()->user->getFlash('warning'); ?>
    </div>
<?php endif; ?> 

<div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'tipo', array('class' => 'badge badge-warning float-right')); ?>
        <?php echo $form->label($model,'tipo'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
                'name'=>'Reporte[tipo]',
                'id'=>'Reporte_tipo',
                'data'=> array('EPM' => 'EPM', 'EPP' => 'EPP', 'EPT' => 'EPT'),
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
    <div class="col-sm-8">
      <div class="form-group">
          <?php echo $form->error($model,'consecutivo', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'consecutivo'); ?>
          <?php echo $form->textField($model,'consecutivo', array('class' => 'form-control form-control-sm numbers', 'autocomplete' => 'off')); ?>
      </div>
    </div>
</div>
    
<div class="row mb-2">
    <div class="col-sm-6">  
      <button type="button" class="btn btn-success btn-sm" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
      <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-cogs"></i> Generar</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

  $('.numbers').on('input', function () { 
    this.value = this.value.replace(/[^0-9,]/g,'');
  });

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
  
});

function resetfields(){
  $('#Reporte_tipo').val('');
  $('#Reporte_consecutivo').val('');
}

</script>

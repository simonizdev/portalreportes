<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h4>Saldo de cartera por estructura de ventas</h4>

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
          <?php echo $form->error($model,'ev', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'ev'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[ev]',
                  'id'=>'Reporte_ev',
                  'data'=> $lista_evs,
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
  
});

function resetfields(){
  $('#Reporte_ev').val('').trigger('change');
}

</script>

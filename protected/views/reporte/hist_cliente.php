<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h4>Historial de cartera por cliente</h4>

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
    <div class="col-sm-3">
    	<div class="form-group">
    		<?php echo $form->error($model,'fecha_inicial', array('class' => 'badge badge-warning float-right')); ?>
      	<?php echo $form->label($model,'fecha_inicial'); ?>
		    <?php echo $form->textField($model,'fecha_inicial', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-3">
    	<div class="form-group">
    		<?php echo $form->error($model,'fecha_final', array('class' => 'badge badge-warning float-right')); ?>
      	<?php echo $form->label($model,'fecha_final'); ?>
		    <?php echo $form->textField($model,'fecha_final', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
          <?php echo $form->error($model,'cliente', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'cliente'); ?>
          <?php echo $form->textField($model,'cliente'); ?>
          <?php
          $this->widget('ext.select2.ESelect2', array(
              'selector' => '#Reporte_cliente',

              'options'  => array(
                'allowClear' => true,
                'minimumInputLength' => 3,
                    'width' => '100%',
                    'language' => 'es',
                    'ajax' => array(
                          'url' => Yii::app()->createUrl('reporte/SearchClienteCartNit'),
                      'dataType'=>'json',
                        'data'=>'js:function(term){return{q: term};}',
                        'results'=>'js:function(data){ return {results:data};}'
                                 
                  ),
                  'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Reporte_cliente"); return "No se encontraron resultados"; }',
                  'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'Reporte_cliente\')\">Limpiar campo</button>"; }',
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

  $("#Reporte_fecha_inicial").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  }).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#Reporte_fecha_final').datepicker('setStartDate', minDate);
  });

  $("#Reporte_fecha_final").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  }).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#Reporte_fecha_inicial').datepicker('setEndDate', maxDate);
  });
  
});

function resetfields(){
  $('#Reporte_fecha_inicial').val('');
  $('#Reporte_fecha_final').val('');
  $('#Reporte_cliente').val('').trigger('change');
  $('#s2id_Reporte_cliente span').html("");
}

</script>
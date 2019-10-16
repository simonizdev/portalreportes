<?php
/* @var $this ReporteController */
/* @var $model Reporte */
?>

<h3>Análisis de ventas</h3>

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

  <input type="hidden" id="periodo_min" value="<?php echo date('Y'); ?>-01">
  <input type="hidden" id="periodo_max" value="<?php echo date('Y-m'); ?>">

  <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <?php echo $form->error($model,'periodo_inicial', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'periodo_inicial'); ?>
          <?php echo $form->textField($model,'periodo_inicial', array('class' => 'form-control', 'readonly' => true)); ?>
        </div>
      </div> 
      <div class="col-sm-4">
        <div class="form-group">
          <?php echo $form->error($model,'periodo_final', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'periodo_final'); ?>
          <?php echo $form->textField($model,'periodo_final', array('class' => 'form-control', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'opcion', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'opcion'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[opcion]',
            'id'=>'Reporte_opcion',
            'data'=>array(1=> 'LINEA', 2 => 'MARCA', 3 => 'DESC. ORACLE'),
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
    <div class="col-sm-4" id="linea" style="display: none;">
      <div class="form-group">
        <div class="pull-right badge bg-red" id="error_linea" style="display: none;"></div>
        <?php echo $form->label($model,'linea'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[linea]',
            'id'=>'Reporte_linea',
            'data'=>$lista_lineas,
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
    <div class="col-sm-4" id="marca" style="display: none;">
      <div class="form-group">
        <div class="pull-right badge bg-red" id="error_marca" style="display: none;"></div>
        <?php echo $form->label($model,'marca'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[marca]',
            'id'=>'Reporte_marca',
            'data'=>$lista_marcas,
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
    <div class="col-sm-4" id="oracle" style="display: none;">
      <div class="form-group">
        <div class="pull-right badge bg-red" id="error_oracle" style="display: none;"></div>
        <?php echo $form->label($model,'des_ora'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[des_ora]',
            'id'=>'Reporte_des_ora',
            'data'=>$lista_oracle,
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
    
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-file-excel-o"></i> Generar</button>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

  $("#Reporte_opcion").change(function() {

    var linea  = $('#Reporte_linea').val();
    var marca  = $('#Reporte_marca').val();
    var oracle = $('#Reporte_des_ora').val();
      
    if($(this).val() == ""){


      $('#error_marca').hide();
      $('#error_marca').html('');
      $('#Reporte_marca').val('').trigger('change');
      $('#marca').hide();

      $('#error_linea').hide();
      $('#error_linea').html('');
      $('#Reporte_linea').val('').trigger('change');
      $('#linea').hide();

      $('#error_oracle').hide();
      $('#error_oracle').html('');
      $('#Reporte_des_ora').val('').trigger('change');
      $('#oracle').hide();

    }else{

      if($(this).val() == 1){
        /*LINEA*/

        $('#error_linea').hide();
        $('#error_linea').html('');
        $('#Reporte_linea').val('').trigger('change');
        $('#linea').show();

        $('#error_marca').hide();
        $('#error_marca').html('');
        $('#Reporte_marca').val('').trigger('change');
        $('#marca').hide();

        $('#error_oracle').hide();
        $('#error_oracle').html('');
        $('#Reporte_des_ora').val('').trigger('change');
        $('#oracle').hide();

      }

      if($(this).val() == 2){
        /*MARCA*/

        $('#error_linea').hide();
        $('#error_linea').html('');
        $('#Reporte_linea').val('').trigger('change');
        $('#linea').hide();

        $('#error_marca').hide();
        $('#error_marca').html('');
        $('#Reporte_marca').val('').trigger('change');
        $('#marca').show();

        $('#error_oracle').hide();
        $('#error_oracle').html('');
        $('#Reporte_des_ora').val('').trigger('change');
        $('#oracle').hide();

      }

      if($(this).val() == 3){
        /*ORACLE*/

        $('#error_linea').hide();
        $('#error_linea').html('');
        $('#Reporte_linea').val('').trigger('change');
        $('#linea').hide();

        $('#error_marca').hide();
        $('#error_marca').html('');
        $('#Reporte_marca').val('').trigger('change');
        $('#marca').hide();

        $('#error_oracle').hide();
        $('#error_oracle').html('');
        $('#Reporte_des_ora').val('').trigger('change');
        $('#oracle').show();

      }

    }
  });
  

  $("#valida_form").click(function() {
      var form = $("#reporte-form");
      var settings = form.data('settings');
      var opcion = $('#Reporte_opcion').val();
      var linea  = $('#Reporte_linea').val();
      var marca  = $('#Reporte_marca').val();
      var oracle = $('#Reporte_des_ora').val();

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });

              if(opcion == 1){
                /*LINEA*/

                if(linea == ""){

                  $('#error_linea').show();
                  $('#error_linea').html('Línea no puede ser nulo.');
                                    
                }else{
                  
                  $('#error_linea').hide();
                  $('#error_linea').html('');

                  //se envia el form
                  form.submit();
                  $(".ajax-loader").fadeIn('fast'); 
                  setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 20000);

                }

              }

              if(opcion == 2){
                /*MARCA*/

                if(marca == ""){

                  $('#error_marca').show();
                  $('#error_marca').html('Marca no puede ser nulo.');
                                    
                }else{
                  
                  $('#error_marca').hide();
                  $('#error_marca').html('');

                  //se envia el form
                  form.submit();
                  $(".ajax-loader").fadeIn('fast');
                  setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 10000);

                }

              }

              if(opcion == 3){
                /*ORACLE*/

                if(oracle == ""){

                  $('#error_oracle').show();
                  $('#error_oracle').html('Desc. oracle no puede ser nulo.');
                                    
                }else{
                  
                  $('#error_oracle').hide();
                  $('#error_oracle').html('');

                  //se envia el form
                  form.submit();
                  $(".ajax-loader").fadeIn('fast');
                  setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 30000);

                }

              }

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
      format : 'yyyy-mm',
      titleFormat: "MM yyyy",
  };

  $("#Reporte_periodo_inicial").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
      format: "yyyy-mm",
      startView: "year", 
      minViewMode: "months",
      startDate: $("#periodo_min").val(),
      endDate: $("#periodo_max").val(),
  }).on('changeDate', function (selected) {

    if($("#Reporte_periodo_inicial").val() > $("#Reporte_periodo_final").val()){
        $("#Reporte_periodo_final").val('');
    }

    var minDate = new Date(selected.date.valueOf());
    $('#Reporte_periodo_final').datepicker('setStartDate', minDate);
  });

  $("#Reporte_periodo_final").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
      format: "yyyy-mm",
      startView: "year", 
      minViewMode: "months",
      startDate: $("#periodo_min").val(),
      endDate: $("#periodo_max").val(),
  }).on('changeDate', function (selected) {

    if($("#Reporte_periodo_final").val() < $("#Reporte_periodo_inicial").val()){
        $("#Reporte_periodo_inicial").val('');
    }

    var maxDate = new Date(selected.date.valueOf());
    $('#Reporte_periodo_inicial').datepicker('setEndDate', maxDate);
  });

});

function resetfields(){
  $('#Reporte_periodo_inicial').val('');
  $('#Reporte_periodo_final').val('');
  $('#Reporte_opcion').val('').trigger('change');
}

</script>

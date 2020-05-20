<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//para combos de clases
//$lista_clases = CHtml::listData($clases, 'Id_Clase', 'Descripcion');

?>

<h4>Reporte rentabilidad por cliente</h4>

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
    		<?php echo $form->error($model,'fecha_inicial', array('class' => 'badge badge-warning float-right')); ?>
      	<?php echo $form->label($model,'fecha_inicial'); ?>
		    <?php echo $form->textField($model,'fecha_inicial', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'fecha_final', array('class' => 'badge badge-warning float-right')); ?>
      	<?php echo $form->label($model,'fecha_final'); ?>
		    <?php echo $form->textField($model,'fecha_final', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
          <?php echo $form->error($model,'clase', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'clase'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[clase]',
                  'id'=>'Reporte_clase',
                  'data'=> $lista_clases,
                  'htmlOptions'=>array(),
                  'options'=>array(
                      'placeholder'=>'TODOS',
                      'width'=> '100%',
                      'allowClear'=>true,
                  ),
              ));
          ?>
      </div>
    </div>
    <div class="col-sm-6" id="div_canal" style="display: none;">
      <div class="form-group">
          <?php echo $form->error($model,'canal', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'canal'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[canal]',
                  'id'=>'Reporte_canal',
                  'data'=> $lista_canales,
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
    <div class="col-sm-6">
      <div class="form-group" id="div_ev" style="display: none;">
          <?php echo $form->error($model,'ev', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'ev'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[ev]',
                  'id'=>'Reporte_ev',
                  'data'=> $lista_evs,
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
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <?php echo $form->error($model,'cliente_inicial', array('class' => 'badge badge-warning float-right')); ?>
      <?php echo $form->label($model,'cliente_inicial'); ?>
      <?php echo $form->textField($model,'cliente_inicial'); ?>
      <?php
      $this->widget('ext.select2.ESelect2', array(
          'selector' => '#Reporte_cliente_inicial',

          'options'  => array(
            'allowClear' => true,
            'minimumInputLength' => 3,
                'width' => '100%',
                'language' => 'es',
                'ajax' => array(
                      'url' => Yii::app()->createUrl('reporte/SearchCliente'),
                  'dataType'=>'json',
                    'data'=>'js:function(term){return{q: term};}',
                    'results'=>'js:function(data){ return {results:data};}'
                             
              ),
              'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Reporte_cliente_inicial"); return "No se encontraron resultados"; }',
              'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'Reporte_cliente_inicial\')\">Limpiar campo</button>"; }',
          ),

        ));
      ?>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="form-group">
      <?php echo $form->error($model,'cliente_final', array('class' => 'badge badge-warning float-right')); ?>
      <?php echo $form->label($model,'cliente_final'); ?>
      <?php echo $form->textField($model,'cliente_final'); ?>
      <?php
      $this->widget('ext.select2.ESelect2', array(
          'selector' => '#Reporte_cliente_final',

          'options'  => array(
            'allowClear' => true,
            'minimumInputLength' => 3,
                'width' => '100%',
                'language' => 'es',
                'ajax' => array(
                      'url' => Yii::app()->createUrl('reporte/SearchCliente'),
                  'dataType'=>'json',
                    'data'=>'js:function(term){return{q: term};}',
                    'results'=>'js:function(data){ return {results:data};}'
                             
              ),
              'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Reporte_cliente_final"); return "No se encontraron resultados"; }',
              'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'Reporte_cliente_final\')\">Limpiar campo</button>"; }',
          ),

        ));
      ?>
    </div>
  </div>
</div>
<div class="row">    
	<div class="col-sm-4">
    	<div class="form-group">
			<?php echo $form->error($model,'opcion_exp', array('class' => 'badge badge-warning float-right')); ?>
    	<?php echo $form->label($model,'opcion_exp'); ?><br>
			<?php 
				echo $form->radioButtonList($model,'opcion_exp',
			    	array('1'=>'<i class="far fa-file-pdf" aria-hidden="true"></i> PDF','2'=>'<i class="far fa-file-excel" aria-hidden="true"></i> EXCEL'),
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
    
<div class="row mb-2">
    <div class="col-sm-6">  
      <button type="button" class="btn btn-success btn-sm" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
      <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fa fa-cogs"></i> Generar</button>
    </div>
</div>
<!-- /.row -->

<?php $this->endWidget(); ?>

<script>

$(function() {

  $("#valida_form").click(function() {

      var form = $("#reporte-form");
      var settings = form.data('settings') ;
      settings.submitting = true ;

      var valid = 1;

      var clase = $("#Reporte_clase").val();

      if (clase != "") {
        
        var canales = $("#Reporte_canal").val();
        var evs = $("#Reporte_ev").val();
        
        if (canales == "" || evs == "") {
          valid = 0;  
        }
        
      }

      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages) && valid == 1) {
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

              var canales = $("#Reporte_canal").val();
              var evs = $("#Reporte_ev").val();
        
              if (canales == "") {
                $('#Reporte_canal_em_').html('Canal es requerido.');
                $('#Reporte_canal_em_').show(); 
              }

              if (evs == "") {
                $('#Reporte_ev_em_').html('Estructura de ventas es requerido.');
                $('#Reporte_ev_em_').show();  
              }

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

  $("#Reporte_clase").change(function () {
    var clase = $("#Reporte_clase").val();
    $("#Reporte_canal").val('').trigger('change');
    $("#Reporte_ev").val('').trigger('change');
    if(clase != ""){   
      $("#div_canal").show();
      $("#div_ev").show();
    }else{
      $("#div_canal").hide();
      $("#Reporte_canal").val('').trigger('change');
      $("#div_ev").hide();
      $("#Reporte_ev").val('').trigger('change');
    }
  });

  
});

function resetfields(){
  $('#Reporte_fecha_inicial').val('');
  $('#Reporte_fecha_final').val('');
  $('#Reporte_clase').val('').trigger('change');
  $('#Reporte_canal').val('').trigger('change');
  $('#Reporte_ev').val('').trigger('change');
  $('#Reporte_cliente_inicial').val('').trigger('change');
  $('#s2id_Reporte_cliente_inicial span').html("");
  $('#Reporte_cliente_final').val('').trigger('change');
  $('#s2id_Reporte_cliente_final span').html("");
}

</script>

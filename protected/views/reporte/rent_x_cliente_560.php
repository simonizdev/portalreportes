<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//para combos de clases
//$lista_clases = CHtml::listData($clases, 'Id_Clase', 'Descripcion');

?>

<h3>Rentabilidad por cliente 560</h3>

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
    		<?php echo $form->error($model,'fecha_inicial', array('class' => 'pull-right badge bg-red')); ?>
      	<?php echo $form->label($model,'fecha_inicial'); ?>
		    <?php echo $form->textField($model,'fecha_inicial', array('class' => 'form-control', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'fecha_final', array('class' => 'pull-right badge bg-red')); ?>
      	<?php echo $form->label($model,'fecha_final'); ?>
		    <?php echo $form->textField($model,'fecha_final', array('class' => 'form-control', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'cliente', array('class' => 'pull-right badge bg-red')); ?>
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
                        'url' => Yii::app()->createUrl('reporte/SearchCliente'),
                    'dataType'=>'json',
                      'data'=>'js:function(term){return{q: term};}',
                      'results'=>'js:function(data){ return {results:data};}'
                               
                ),
                'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Reporte_cliente"); return "No se encontraron resultados"; }',
                'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Reporte_cliente\')\">Limpiar campo</button>"; }',
            ),

          ));
        ?>
      </div>
    </div>
</div> 
<div class="row">   
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
              setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 20000);
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

function clear_select2_ajax(id){
  $('#'+id+'').val('').trigger('change');
  $('#s2id_'+id+' span').html("");
}

function resetfields(){
  $('#Reporte_fecha_inicial').val('');
  $('#Reporte_fecha_final').val('');
  $('#Reporte_cliente').val('').trigger('change');
  $('#s2id_Reporte_cliente span').html("");
}

</script>

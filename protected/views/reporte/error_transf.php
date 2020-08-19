<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h4>Log errores de transferencias</h4>

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
      <?php echo $form->error($model,'fecha', array('class' => 'badge badge-warning float-right')); ?>
      <?php echo $form->label($model,'fecha'); ?>
      <?php echo $form->textField($model,'fecha', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
    </div>
  </div> 
	<div class="col-sm-4">
    	<div class="form-group">
  			<?php echo $form->label($model,'opcion_exp'); ?>
        <?php echo $form->error($model,'opcion_exp', array('class' => 'badge badge-warning float-right')); ?>
        <br>
        <?php 
          echo $form->radioButtonList($model,'opcion_exp',
              array('3'=>'<i class="fa fa-desktop" aria-hidden="true"></i> Pantalla','2'=>'<i class="far fa-file-excel" aria-hidden="true"></i> EXCEL'),
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

<div class="row">
    <div class="col-lg-12 table-responsive" id="resultados">
    <!-- contenido via ajax -->
    </div>
</div>  


<?php $this->endWidget(); ?>

<script>

$(function() {
 // $(".ajax-loader").show();
  $("#valida_form").click(function() {

      var form = $("#reporte-form");
      var settings = form.data('settings') ;
      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              $("#resultados").html(''); 
              //se envia el form
              if($("input:radio:checked").val() == 3){
                reporte_pantalla();
              }else{
                form.submit();
                loadershow(); 
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
      format: "yyyy-mm-dd",
      titleFormat: "MM yyyy",
      weekStart: 1
  };

  $("#Reporte_fecha").datepicker({
      language: 'es',
      autoclose: true,
      orientation: "right bottom",
  });

});

function reporte_pantalla(){

  var fecha = $("#Reporte_fecha").val();

  var data = {fecha: fecha}
  $(".ajax-loader").fadeIn('fast');
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('reporte/errortransfpant'); ?>",
    data: data,
    success: function(data){ 
      $(".ajax-loader").fadeOut('fast');
      $("#resultados").html(data); 
    }
  });

}

function resetfields(){
  $('#Reporte_fecha').val('');
  $("#resultados").html(''); 
}

</script>
<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h4>Comprometidos con inconsistencias</h4>

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
)); 

?>
<div class="row">
    <div class="col-sm-4">
      <div class="form-group">
          <?php echo $form->error($model,'tipo', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'tipo'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[tipo]',
                  'id'=>'Reporte_tipo',
                  'data'=> array('PEC' => 'PEC', 'PED' => 'PED', 'PEV' => 'PEV', 'PEM' => 'PEM'),
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
          <?php echo $form->error($model,'cons_inicial', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'cons_inicial'); ?>
          <?php echo $form->numberField($model,'cons_inicial', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'type' => 'number')); ?>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
          <?php echo $form->error($model,'cons_final', array('class' => 'badge badge-warning float-right')); ?>
          <?php echo $form->label($model,'cons_final'); ?>
          <?php echo $form->numberField($model,'cons_final', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'type' => 'number')); ?>
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

  $("#valida_form").click(function() {
    var form = $("#reporte-form");
    var settings = form.data('settings') ;

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                $.fn.yiiactiveform.updateInput(this,messages,form); 
            });
            
            var tipo = $('#Reporte_tipo').val();
            var cons_inicial = $('#Reporte_cons_inicial').val(); 
            var cons_final = $('#Reporte_cons_final').val();  

            $(".ajax-loader").fadeIn('fast');

            $("#resultados").html(''); 
            
            var data = {tipo: tipo, cons_inicial: cons_inicial, cons_final: cons_final}

            $.ajax({ 
              type: "POST",
              data: data, 
              url: "<?php echo Yii::app()->createUrl('reporte/compincpant'); ?>",
              success: function(data){ 
                $("#resultados").html(data);
                $(".ajax-loader").fadeOut('fast'); 
              }
            }); 
            
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
  $("#resultados").html(''); 
  $('#Reporte_tipo').val('').trigger('change');
  $('#Reporte_cons_inicial').val('');
  $('#Reporte_cons_final').val('');
}

</script>

<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Auditoría de pedidos</h3>

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
          <?php echo $form->error($model,'opcion', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'opcion'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[opcion]',
                  'id'=>'Reporte_opcion',
                  'data'=> array(1 => 'TODO', 2 => 'FILTRADO'),
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
    
<div class="row" id="filtro" style="display: none;">
    <div class="col-sm-4">
      <div class="form-group">
          <?php echo $form->error($model,'c_o', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'c_o'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[c_o]',
                  'id'=>'Reporte_c_o',
                  'data'=> $lista_co,
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
          <?php echo $form->error($model,'tipo', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'tipo'); ?>
          <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Reporte[tipo]',
                  'id'=>'Reporte_tipo',
                  'data'=> $lista_tipos,
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
          <?php echo $form->error($model,'consecutivo', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'consecutivo'); ?>
          <?php echo $form->numberField($model,'consecutivo', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
      </div>
    </div>
</div>
    
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-bar-chart"></i> Generar</button>
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

      var opcion = $('#Reporte_opcion').val();
      var co = $('#Reporte_c_o').val();
      var tipo = $('#Reporte_tipo').val();
      var consecutivo = $('#Reporte_consecutivo').val();

      if(opcion != ""){
        if(opcion == 1){

          //TODO
          form.submit();
          $(".ajax-loader").fadeIn('fast');
          setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 10000);

        }else{

          //FILTRADO
          if(co != "" && tipo != "" && consecutivo != ""){

            $(".ajax-loader").fadeIn('fast');
            
            var data = {co: co, tipo: tipo, consecutivo: consecutivo}

            $.ajax({ 
              type: "POST",
              data: data, 
              url: "<?php echo Yii::app()->createUrl('reporte/auditoriapedidospant'); ?>",
              success: function(data){ 
                $(".ajax-loader").fadeOut('fast');
                $("#resultados").html(data); 
              }
            });

          }else{
            if(co == ""){
              $('#Reporte_c_o_em_').html('CO no puede ser nulo.');
              $('#Reporte_c_o_em_').show();
            }

            if(tipo == ""){
              $('#Reporte_tipo_em_').html('Tipo no puede ser nulo.');
              $('#Reporte_tipo_em_').show();
            }
            
            if(consecutivo == ""){
              $('#Reporte_consecutivo_em_').html('Consecutivo no puede ser nulo.');
              $('#Reporte_consecutivo_em_').show();   
            }

          }

        }
      }else{
        $('#Reporte_opcion_em_').html('Opción no puede ser nulo.');
        $('#Reporte_opcion_em_').show();
      }

  });

  $("#Reporte_opcion").change(function() {

    $("#resultados").html(''); 
    var valor = $('#Reporte_opcion').val();

    if(valor != '' ){
      if(valor == 1){
        $('#filtro').hide();
        $('#Reporte_c_o').val('').trigger('change');
        $('#Reporte_c_o_em_').html('');
        $('#Reporte_c_o_em_').hide();
        $('#Reporte_tipo').val('').trigger('change');
        $('#Reporte_tipo_em_').html('');
        $('#Reporte_tipo_em_').hide();
        $('#Reporte_consecutivo').val('');
        $('#Reporte_consecutivo_em_').html('');
        $('#Reporte_consecutivo_em_').hide();
      }else{
        $('#filtro').show();
      }
      
    }else{
      $('#Reporte_opcion_em_').html('Opción no puede ser nulo.');
      $('#Reporte_opcion_em_').show();
      $('#filtro').hide();
    }

  });
  
});

function resetfields(){
  $('#Reporte_opcion').val('').trigger('change');
  $('#filtro').hide();
  $('#Reporte_c_o').val('').trigger('change');
  $('#Reporte_tipo').val('').trigger('change');
  $('#Reporte_consecutivo').val('');
}

</script>

<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Clientes potenciales</h3>

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
      <?php echo $form->error($model,'dias', array('class' => 'pull-right badge bg-red')); ?>
  		<?php echo $form->label($model,'dias'); ?>
      <?php echo $form->numberField($model,'dias', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'min' => 1)); ?>
    </div>
  </div>
  <div class="col-sm-4" style="display: none;">
    <div class="form-group">
        <?php echo $form->error($model,'plan', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'plan'); ?>
        <?php echo $form->HiddenField($model,'opc', array('class' => 'form-control', 'autocomplete' => 'off', 'readonly' => true)); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
                'name'=>'Reporte[plan]',
                'id'=>'Reporte_plan',
                'data'=> $lista_planes,
                
                'options'=>array(
                    'placeholder'=>'Seleccione...',
                    'width'=> '100%',
                    'allowClear'=>true,
                ),
            ));
        ?>
    </div>
  </div>
  <div class="col-sm-4" id="div_criterios" style="display: none;">
    <div class="form-group">
        <?php echo $form->error($model,'criterio', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'criterio'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
                'name'=>'Reporte[criterio]',
                'id'=>'Reporte_criterio',                  
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

<script type="text/javascript">
  
  $(function() {
    $('#Reporte_plan').change(function(){

        plan = this.value;
        
        if(plan != ""){

          var data = {plan: plan}
          
          //ajax para cargar los criterios por plan
          $.ajax({ 
            type: "POST", 
            url: "<?php echo Yii::app()->createUrl('reporte/loadcriterios'); ?>",
            data: data,
            dataType: 'json',
            success: function(data){ 
              var criterios = data;
              $("#Reporte_criterio").html('');
              $("#Reporte_criterio").append('<option value=""></option>');
              $.each(criterios, function(i,item){
                  $("#Reporte_criterio").append('<option value="'+criterios[i].id+'">'+criterios[i].text+'</option>');
              });

              $("#div_criterios").show('fast');
              $("#Reporte_criterio").val('').trigger('change');
            }  
          });

          //ajax para traer opcón de acuerdo a plan elegido
          $.ajax({ 
            type: "POST", 
            url: "<?php echo Yii::app()->createUrl('reporte/getopcionplan'); ?>",
            data: data,
            success: function(data){ 
              var opc = data;
              $("#Reporte_opc").val(opc);
            }  
          });

        }else{
          $("#div_criterios").hide('fast');
          $("#Reporte_criterio").html('');
          $("#Reporte_criterio").append('<option value=""></option>'); 
          $("#Reporte_opc").val('');  
        }

       
      });

      $('#Reporte_criterio').change(function(){
        criterio = this.value;
        
        if(criterio != ""){
          $('#Reporte_criterio_em_').html('');
          $('#Reporte_criterio_em_').hide();
        }else{
          $('#Reporte_criterio_em_').html('Criterio no puede ser nulo.');
          $('#Reporte_criterio_em_').show();
        }
      });

      $("#valida_form").click(function() {
          
          $('#Reporte_criterio_em_').html('');
          $('#Reporte_criterio_em_').hide();

          var form = $("#reporte-form");
          var settings = form.data('settings') ;
          settings.submitting = true ;

          $.fn.yiiactiveform.validate(form, function(messages) {
              if($.isEmptyObject(messages)) {
                  $.each(settings.attributes, function () {
                     $.fn.yiiactiveform.updateInput(this,messages,form); 
                  });

                  var valid = 1;
                  var plan = $('#Reporte_plan').val();
                  var criterio = $('#Reporte_criterio').val();

                  if(plan != ""){
                    if(criterio == ""){
                        $('#Reporte_criterio_em_').html('Criterio no puede ser nulo.');
                        $('#Reporte_criterio_em_').show();
                        valid = 0;
                    }
                  }

                  if(valid == 1){
                    //se envia el form
                    form.submit();
                    $(".ajax-loader").fadeIn('fast');
                    setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 20000);
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

  });

  
function resetfields(){
  $('#Reporte_dias').val('');
  $('#Reporte_plan').val('').trigger('change');
}

</script>

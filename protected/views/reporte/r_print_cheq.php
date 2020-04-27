<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Reimpresión de cheque</h3>

<div id="div_mensaje" style="display: none;"></div>

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
      <?php echo $form->error($model,'cia', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'cia'); ?>
      <?php
          $this->widget('ext.select2.ESelect2',array(
              'name'=>'Reporte[cia]',
              'id'=>'Reporte_cia',
              'data'=> array(2 => '2 - SIMONIZ', 3 => '3 - TITAN', 4 => '4 - COMSTAR', 5 => '5 - PANSELL'),
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
</div>
<div class="row">
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
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-search"></i> Consultar</button>
    <button type="button" class="btn btn-success" id="print" style="display: none;"><i class="fa fa-print"></i> Imprimir</button>
</div>

<div class="row">
    <iframe src="" id="viewer" class="col-sm-12 text-center" style="display: none;">
      
    </iframe>   
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

  $("#Reporte_cia").change(function() {
    $('#valida_form').show();
    $('#print').hide();
    limp_div_msg();
  });

  $("#Reporte_c_o").change(function() {
    $('#valida_form').show();
    $('#print').hide();
    limp_div_msg();
  });

  $("#Reporte_tipo").change(function() {
    $('#valida_form').show();
    $('#print').hide();
    limp_div_msg();
  });

  $("#Reporte_consecutivo").change(function() {
    $('#valida_form').show();
    $('#print').hide();
    limp_div_msg();
  });

  $("#valida_form").click(function() {

      var form = $("#reporte-form");
      var settings = form.data('settings') ;
      settings.submitting = true ;
      limp_div_msg();

      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });

              var cia = $('#Reporte_cia').val();
              var co = $('#Reporte_c_o').val();
              var tipo = $('#Reporte_tipo').val();
              var consecutivo = $('#Reporte_consecutivo').val();

              var data = {
                cia: cia,
                co: co, 
                tipo: tipo,
                consecutivo: consecutivo
              }

              $.ajax({ 
                  type: "POST", 
                  url: "<?php echo Yii::app()->createUrl('reporte/verifcheq'); ?>",
                  data: data,
                  beforeSend: function(){
                      $(".ajax-loader").fadeIn('fast'); 
                  },
                  success: function(resp){

                      if(resp == 0){
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h4><i class="icon fa fa-info-circle"></i>Cuidado</h4><p>No se ha impreso ningún cheque con los criterios de busqueda utilizados.</p>');
                      }

                      if(resp == 1){
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h4><i class="icon fa fa-info-circle"></i>Cuidado</h4><p>Este cheque ya fue impreso el n° de veces permitidas (3).</p>');
                      }

                      if(resp == 2){
                        $("#div_mensaje").addClass("alert alert-success alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h4><i class="icon fa fa-info-circle"></i>Realizado</h4><p>Por favor oprima el botón imprimir.</p>');

                        
                        var name_file = cia+"_"+co+"_"+tipo+"_"+consecutivo+".pdf";
                        var iframe = $("#viewer");

                        var url = "<?php echo Yii::app()->getBaseUrl(true).'/images/cheq/'; ?>"+name_file;
                        iframe.attr('src',url);
                        $('#print').show();
                        $('#valida_form').hide();
                      }

                      $("#div_mensaje").fadeIn('fast');
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

  $("#print").click(function() {
    var cia = $('#Reporte_cia').val();
    var co = $('#Reporte_c_o').val();
    var tipo = $('#Reporte_tipo').val();
    var consecutivo = $('#Reporte_consecutivo').val();

    var data = {
      cia: cia,
      co: co, 
      tipo: tipo,
      consecutivo: consecutivo
    }

    $.ajax({ 
        type: "POST", 
        url: "<?php echo Yii::app()->createUrl('reporte/regrimpcheq'); ?>",
        data: data,
        beforeSend: function(){
            $(".ajax-loader").fadeIn('fast'); 
        },
        success: function(resp){

            if(resp == 0){

              $('#Reporte_cia').val('').trigger('change');
              $('#Reporte_c_o').val('').trigger('change');
              $('#Reporte_tipo').val('').trigger('change');
              $('#Reporte_consecutivo').val('');
              $('#print').hide();
              $('#valida_form').show();

              $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
              $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h4><i class="icon fa fa-info-circle"></i>Cuidado</h4><p>No se registro la reimpresión del cheque '+cia+'-'+co+'-'+tipo+'-'+consecutivo+' en el sistema.</p>');

              $("#div_mensaje").fadeIn('fast');
              $(".ajax-loader").fadeOut('fast');

              var iframe = $("#viewer");
              var url = "#";
              iframe.attr('src',url);
            }

            if(resp == 1){

              $('#Reporte_cia').val('').trigger('change');
              $('#Reporte_c_o').val('').trigger('change');
              $('#Reporte_tipo').val('').trigger('change');
              $('#Reporte_consecutivo').val('');
              $('#print').hide();
              $('#valida_form').show();

              $("#div_mensaje").addClass("alert alert-success alert-dismissible");
              $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h4><i class="icon fa fa-info-circle"></i>Realizado</h4><p>Se registro la reimpresión del cheque '+cia+'-'+co+'-'+tipo+'-'+consecutivo+' en el sistema.</p>');

              $("#div_mensaje").fadeIn('fast');
              $(".ajax-loader").fadeOut('fast');

              var objFra = document.getElementById('viewer');
              objFra.contentWindow.focus();
              objFra.contentWindow.print();

            }
          
        }
    });

  });
  
});

function resetfields(){
  $('#Reporte_cia').val('').trigger('change');
  $('#Reporte_c_o').val('').trigger('change');
  $('#Reporte_tipo').val('').trigger('change');
  $('#Reporte_consecutivo').val('');
  $('#print').hide();
  $('#valida_form').show();
  var iframe = $("#viewer");
  var url = "#";
  iframe.attr('src',url);
  limp_div_msg();
}

//función para limpiar el mensaje retornado por el ajax
function limp_div_msg(){
    $("#div_mensaje").hide();  
    classact = $('#div_mensaje').attr('class');
    $("#div_mensaje").removeClass(classact);
    $("#mensaje").html('');
}


</script>

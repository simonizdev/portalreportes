<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h4>Cambio de estado item(s)</h4>

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
  'htmlOptions' => array(
    'enctype' => 'multipart/form-data'
  ),
)); ?>

<div id="mensaje"></div>

<div class="row">
    <div class="col-sm-8">
      <div class="form-group">
        <div class="badge badge-warning float-right" id="error_file" style="display: none;"></div>
        <input type="hidden" id="valid_file" value="0">
        <?php echo $form->label($model,'archivo'); ?><br>
        <?php echo $form->fileField($model, 'archivo'); ?>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-6">  
      <button type="button" class="btn btn-success btn-sm" id="download"><i class="fas fa-download"></i> Descargar plantilla</button>
      <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-upload"></i> Subir archivo</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

  $("#download").click(function() {
    var clase_act = $('#mensaje').attr('class');
    $('#mensaje').removeClass(clase_act);
    $("#mensaje").html('');
    window.location =  "<?php echo Yii::app()->getBaseUrl(true).'/images/guias/plantilla_cambio_estado_items.xlsx'; ?>";
  });

  var extensionesValidas = ".xlsx";
  var textExtensionesValidas = "(.xlsx)";
  var pesoPermitido = 1024;
  var idInput = "valid_file";
  var idMsg = "error_file";

  $("#valida_form").click(function() {

      var clase_act = $('#mensaje').attr('class');
      $('#mensaje').removeClass(clase_act);
      $("#mensaje").html('');

      var form = $("#reporte-form");
      var settings = form.data('settings') ;

      var archivo = $('#Reporte_archivo').val();

      if(archivo == ''){
        $('#error_file').html('debe cargar un archivo.');
        $('#error_file').show();
      }
          
      //se valida si el archivo cargado es valido (1)
      valid_file = $('#valid_file').val();

      if(valid_file == 1){

        //información del formulario
        var formData = new FormData($("#reporte-form")[0]);
        var message = ""; 
        //hacemos la petición ajax  
        $.ajax({
            url: "<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=reporte/uploadestadoitems'; ?>",  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                $(".ajax-loader").fadeIn('fast');      
            },
            //una vez finalizado correctamente
            success: function(data){
                $(".ajax-loader").fadeOut('fast');
                var data = jQuery.parseJSON(data);
                var opc = data.opc; 
                var mensaje = data.msj; 

                if(opc == 0){
                  //el archivo esta vacio
                  $("#mensaje").addClass("alert alert-warning alert-dismissible");
                  $("#mensaje").html(mensaje);
                }

                if(opc == 1){
                  //el archivo tiene errores
                  $("#mensaje").addClass("alert alert-warning alert-dismissible");
                  $("#mensaje").html(mensaje);
                }

                //se resetea el campo FILE
                $("#reporte-form")[0].reset();
                $('#valid_file').val(0);
            },
        });

      }
             
  });

  $("#Reporte_archivo").change(function () {

      $('#error_file').html('');
      $('#error_file').hide();

      if(validarExtension(this, extensionesValidas, textExtensionesValidas, idInput, idMsg)) {

          if(validarPeso(this, pesoPermitido, idInput, idMsg)) {

            $('#valid_file').val(1);

          }
      }  
  });

  $("#Reporte_archivo").click(function () {

    var clase_act = $('#mensaje').attr('class');
    $('#mensaje').removeClass(clase_act);
    $("#mensaje").html('');

  });

});

</script>


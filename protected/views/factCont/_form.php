<?php
/* @var $this FactPendController */
/* @var $model FactPend */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fact-pend-form',
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

<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Empresa', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Empresa'); ?>
            <?php $lista_empresas = array(1 => "COMSTAR", 2 => "PANSELL", 3 => "SIMONIZ", 4 => "TITAN") ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FactCont[Empresa]',
                    'id'=>'FactCont_Empresa',
                    'data'=>$lista_empresas,
                    'value' => $model->Empresa,
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
            <?php echo $form->error($model,'Area', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Area'); ?>
            <?php
              $this->widget('ext.select2.ESelect2',array(
                'name'=>'FactCont[Area]',
                'id'=>'FactCont_Area',
                'data'=>UtilidadesVarias::listaareas(),
                'value' => $model->Area,
                'options'=>array(
                    'placeholder'=>'Seleccione...',
                    'width'=> '100%',
                    'allowClear'=>true,
                ),
              ));
            ?>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <?php echo $form->error($model,'Num_Factura', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Num_Factura'); ?>
            <?php echo $form->textField($model,'Num_Factura', array('class' => 'form-control', 'maxlength' => '20', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Fecha_Factura', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Fecha_Factura'); ?>
		    <?php echo $form->textField($model,'Fecha_Factura', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha_Radicado', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Fecha_Radicado'); ?>
            <?php echo $form->textField($model,'Fecha_Radicado', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-6">
    	<div class="form-group">
    		<?php echo $form->error($model,'Proveedor', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Proveedor'); ?>
		    <?php echo $form->textField($model,'Proveedor'); ?>
		    <?php
		    $this->widget('ext.select2.ESelect2', array(
		        'selector' => '#FactCont_Proveedor',

		        'options'  => array(
		        	'allowClear' => true,
		        	'minimumInputLength' => 5,
	               	'width' => '100%',
	               	'language' => 'es',
	               	'ajax' => array(
                        'url' => Yii::app()->createUrl('proveedorCont/SearchProveedor'),
		               	'dataType'=>'json',
                    	'data'=>'js:function(term){return{q: term};}',
                    	'results'=>'js:function(data){ return {results:data};}'                   
		            ),
	            	'formatNoMatches'=> 'js:function(){ clear_select2_ajax("FactCont_Proveedor"); return "No se encontraron resultados"; }',
	            	'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'FactCont_Proveedor\')\">Limpiar campo</button>"; }',
	            	'initSelection'=>'js:function(element,callback) {
	                   	var id=$(element).val(); // read #selector value
	                   	if ( id !== "" ) {
	                     	$.ajax("'.Yii::app()->createUrl('proveedorCont/SearchProveedorById').'", {
	                       		data: { id: id },
	                       		dataType: "json"
	                     	}).done(function(data,textStatus, jqXHR) { callback(data[0]); });
	                   }
	                }',
	        	),
	      	));
		    ?>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->error($model,'Valor', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Valor'); ?>
            <?php echo $form->numberField($model,'Valor', array('class' => 'form-control', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.01')); ?>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->error($model,'Moneda', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Moneda'); ?>
            <?php $lista_monedas = array(1 => "COP", 2 => "USD") ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FactCont[Moneda]',
                    'id'=>'FactCont_Moneda',
                    'data'=>$lista_monedas,
                    'value' => $model->Moneda,
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
	<div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'Observaciones', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Observaciones'); ?>
            <?php echo $form->textArea($model,'Observaciones',array('class' => 'form-control', 'rows'=>2, 'cols'=>50, 'onkeyup' => 'convert_may(this)', 'maxlength' => '200')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'sop', array('class' => 'pull-right badge bg-red')); ?>
            <div class="pull-right badge bg-red" id="error_sop" style="display: none;"></div>
            <input type="hidden" id="valid_doc" value="0">
            <?php echo $form->label($model,'sop'); ?>
            <?php echo $form->fileField($model, 'sop'); ?>
        </div>
    </div>
</div>

<div class="btn-group" id="buttons">
    <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=factCont/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">


$(function() {

    var extensionesValidas = ".pdf";
    var pesoPermitido = 2048;

    $("#valida_form").click(function() {
      var form = $("#fact-pend-form");
      var settings = form.data('settings') ;

      var soporte = $('#FactCont_sop').val();

      if(soporte == ''){
        $('#error_sop').html('Soporte no puede ser nulo');
        $('#error_sop').show();
      }

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
                
              //se valida si el archivo cargado es valido (1)
              valid_doc = $('#valid_doc').val();

              if(valid_doc == 1){
                //se envia el form
                $(".ajax-loader").fadeIn('fast');
                $('#buttons').hide();
                form.submit();
              }else{

                settings.submitting = false ;   
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

    $("#FactCont_sop").change(function () {

        $('#error_sop').html('');
        $('#error_sop').hide();

        if(validarExtension(this)) {

            if(validarPeso(this)) {

                $('#valid_doc').val(1);

            }
        }  
    });


    // Validacion de extensiones permitidas
    function validarExtension(datos) {

        var ruta = datos.value;
        var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
        var extensionValida = extensionesValidas.indexOf(extension);

        if(extensionValida < 0) {

            $('#error_sop').html('La extensión no es válida (.'+ extension+'), Solo se admite (.pdf)');
            $('#error_sop').show();
            $('#valid_doc').val(0);
            return false;

        } else {

            return true;

        }
    }

    // Validacion de peso del fichero en kbs

    function validarPeso(datos) {

        if (datos.files && datos.files[0]) {

            var pesoFichero = datos.files[0].size/1024;

            if(pesoFichero > pesoPermitido) {

                $('#error_sop').html('El peso maximo permitido del fichero es: ' + pesoPermitido / 1024 + ' MB, Su fichero tiene: '+ (pesoFichero /1024).toFixed(2) +' MB.');
                $('#error_sop').show();
                $('#valid_doc').val(0);
                return false;

            } else {

                return true;

            }

        }

    }

    function clear_select2_ajax(id){
        $('#'+id+'').val('').trigger('change');
        $('#s2id_'+id+' span').html("");
    }

});

    
</script>
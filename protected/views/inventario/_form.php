<?php
/* @var $this InventarioController */
/* @var $model Inventario */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inventario-form',
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
            <?php echo $form->error($model,'Documento', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Documento'); ?>
            <?php echo $form->numberField($model,'Documento', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Fecha'); ?>
            <?php echo $form->textField($model,'Fecha', array('class' => 'form-control datepicker', 'readonly' => true)); ?>
        </div>
    </div>  
	<div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Id_Departamento', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Id_Departamento'); ?>

		    <?php echo $form->textField($model,'Id_Departamento'); ?>
			<?php
			    $this->widget('ext.select2.ESelect2', array(
			        'selector' => '#Inventario_Id_Departamento',
			        'options'  => array(
			        	'allowClear' => true,
			        	'minimumInputLength' => 3,
		               	'width' => '100%',
		               	'language' => 'es',
		                'ajax' => array(
	                        'url' => Yii::app()->createUrl('departamento/SearchDepartamento'),
			               	'dataType'=>'json',
	                    	'data'=>'js:function(term){return{q: term};}',
	                    	'results'=>'js:function(data){ return {results:data};}'                   
			            ),
		            	'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Inventario_Id_Departamento"); return "No se encontraron resultados"; }',
		            	'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Inventario_Id_Departamento\')\">Limpiar campo</button>"; }',
		            	'initSelection'=>'js:function(element,callback) {
		                   	var id=$(element).val(); // read #selector value
		                   	if ( id !== "" ) {
		                     	$.ajax("'.Yii::app()->createUrl('departamento/SearchDepartamentoById').'", {
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
</div>
<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Tipo', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Tipo'); ?>
            <?php $array = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Inventario[Tipo]',
                    'id'=>'Inventario_Tipo',
                    'data'=> array(1 => 'Entrada', 2 => 'Salida'),
                    'value' => $model->Tipo,
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
            <?php echo $form->error($model,'Id_Suministro', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Suministro'); ?>
			<?php echo $form->textField($model,'Id_Suministro'); ?>
			<?php
			    $this->widget('ext.select2.ESelect2', array(
			        'selector' => '#Inventario_Id_Suministro',
			        'options'  => array(
			        	'minimumInputLength' => 5,
		               	'width' => '100%',
		               	'language' => 'es',
		                'ajax' => array(
	                        'url' => Yii::app()->createUrl('suministro/SearchSuministro'),
			               	'dataType'=>'json',
	                    	'data'=>'js:function(term){return{q: term};}',
	                    	'results'=>'js:function(data){ return {results:data};}'                
			            ),
			            'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Inventario_Id_Suministro"); return "No se encontraron resultados"; }',
			            'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Inventario_Id_Suministro\')\">Limpiar campo</button>"; }',
			            'initSelection'=>'js:function(element,callback) {
		                   	var id=$(element).val(); // read #selector value
		                   	if ( id !== "" ) {
		                     	$.ajax("'.Yii::app()->createUrl('suministro/SearchSuministroById').'", {
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

    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Cantidad', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Cantidad'); ?>
		    <?php echo $form->textField($model,'Cantidad', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    
</div>

<div class="row">   
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Notas', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Notas'); ?>
            <?php echo $form->textField($model,'Notas', array('class' => 'form-control', 'autocomplete' => 'off','maxlength' => '30')); ?>
        </div>
    </div>        
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=inventario/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

$(function() {

	$("#valida_form").click(function() {
		
		var form = $("#inventario-form");
		var settings = form.data('settings') ;

	    var tipo = $('#Inventario_Tipo').val();
	    var id_sum = $('#Inventario_Id_Suministro').val();
	    var cant = $('#Inventario_Cantidad').val();

		settings.submitting = true ;
		$.fn.yiiactiveform.validate(form, function(messages) {
		  if($.isEmptyObject(messages)) {
		      $.each(settings.attributes, function () {
		         $.fn.yiiactiveform.updateInput(this,messages,form); 
		      });
		      	
		     if(tipo == 1){
		     	form.submit();
		     }else{
		     	var data = {id_sum: id_sum, cant: cant, id: <?php echo $model->Id_Inventario ?>}
	            $.ajax({ 
	                type: "POST", 
	                url: "<?php echo Yii::app()->createUrl('inventario/verificardisponibilidad'); ?>",
	                data: data,
	                success: function(data){
	                    
	                    var data = jQuery.parseJSON(data);
	                    var opc = data.opc; 
	                    var mensaje = data.msj;

	                    if(opc == 0){
	                        //no esta disponible la cantidad solicitada
	                        $('#Inventario_Cantidad_em_').html(mensaje);
	                        $('#Inventario_Cantidad_em_').show();
	                        $('#Inventario_Cantidad').val('');
	                    }

	                    if(opc == 1){
	                        //si esta disponible la cantidad solicitada
	                        form.submit();
	                    }

	                }
	            });
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



function clear_select2_ajax(id){
	$('#'+id+'').val('').trigger('change');
	$('#s2id_'+id+' span').html("");
}

</script>

	
	


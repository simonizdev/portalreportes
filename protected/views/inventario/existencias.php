<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h3>Existencias de suministros</h3>

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
  <div class="col-sm-6">
    <div class="form-group">
      <?php echo $form->error($model,'sum', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'sum'); ?>
      <?php echo $form->textField($model,'sum'); ?>
      <?php
          $this->widget('ext.select2.ESelect2', array(
              'selector' => '#Inventario_sum',
              'options'  => array(
                'minimumInputLength' => 3,
                    'width' => '100%',
                    'language' => 'es',
                    'ajax' => array(
                          'url' => Yii::app()->createUrl('suministro/SearchSuministro'),
                      'dataType'=>'json',
                        'data'=>'js:function(term){return{q: term};}',
                        'results'=>'js:function(data){ return {results:data};}'                
                  ),
                  'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Inventario_sum"); return "No se encontraron resultados"; }',
                  'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Inventario_sum\')\">Limpiar campo</button>"; }',
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
	<div class="col-sm-6">
    	<div class="form-group">
			<?php echo $form->error($model,'opcion_exp', array('class' => 'pull-right badge bg-red')); ?>
    	<?php echo $form->label($model,'opcion_exp'); ?><br>
			<?php 
				echo $form->radioButtonList($model,'opcion_exp',
			    	array('3'=>'<i class="fa fa-desktop" aria-hidden="true"></i> Pantalla','1'=>'<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF','2'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL'),
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

      var form = $("#inventario-form");
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
                $(".ajax-loader").fadeIn('fast');
                setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 5000); 
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

function reporte_pantalla(){

  var id_suministro = $("#Inventario_sum").val();

  var data = {id_suministro: id_suministro}
  $(".ajax-loader").fadeIn('fast');
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('inventario/existenciaspant'); ?>",
    data: data,
    success: function(data){ 
      $(".ajax-loader").fadeOut('fast');
      $("#resultados").html(data); 
    }
  });

}

function resetfields(){
  $("#resultados").html(''); 
  $('#Inventario_sum').val('').trigger('change');
  $('#s2id_Inventario_sum span').html("");
}

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html("");
}

</script>
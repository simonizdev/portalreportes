<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Saldo de cartera por cliente</h3>

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
    <div class="col-sm-6">
      <div class="form-group">
          <?php echo $form->error($model,'cliente_inicial', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'cliente_inicial'); ?>
          <?php echo $form->textField($model,'cliente_inicial'); ?>
          <?php
          $this->widget('ext.select2.ESelect2', array(
              'selector' => '#Reporte_cliente_inicial',

              'options'  => array(
                'allowClear' => true,
                'minimumInputLength' => 3,
                    'width' => '100%',
                    'language' => 'es',
                    'ajax' => array(
                          'url' => Yii::app()->createUrl('reporte/SearchClienteCart'),
                      'dataType'=>'json',
                        'data'=>'js:function(term){return{q: term};}',
                        'results'=>'js:function(data){ return {results:data};}'
                                 
                  ),
                  'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Reporte_cliente_inicial"); return "No se encontraron resultados"; }',
                  'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Reporte_cliente_inicial\')\">Limpiar campo</button>"; }',
              ),

            ));
          ?>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="form-group">
          <?php echo $form->error($model,'cliente_final', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'cliente_final'); ?>
          <?php echo $form->textField($model,'cliente_final'); ?>
          <?php
          $this->widget('ext.select2.ESelect2', array(
              'selector' => '#Reporte_cliente_final',

              'options'  => array(
                'allowClear' => true,
                'minimumInputLength' => 3,
                    'width' => '100%',
                    'language' => 'es',
                    'ajax' => array(
                          'url' => Yii::app()->createUrl('reporte/SearchClienteCart'),
                      'dataType'=>'json',
                        'data'=>'js:function(term){return{q: term};}',
                        'results'=>'js:function(data){ return {results:data};}'
                                 
                  ),
                  'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Reporte_cliente_final"); return "No se encontraron resultados"; }',
                  'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Reporte_cliente_final\')\">Limpiar campo</button>"; }',
              ),

            ));
          ?>
      </div>
    </div> 
</div>
    
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-file-pdf-o"></i> Generar</button>
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
              setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 10000);
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

function resetfields(){
  $('#Reporte_cliente_inicial').val('').trigger('change');
  $('#s2id_Reporte_cliente_inicial span').html("");
  $('#Reporte_cliente_final').val('').trigger('change');
  $('#s2id_Reporte_cliente_final span').html("");
}

</script>

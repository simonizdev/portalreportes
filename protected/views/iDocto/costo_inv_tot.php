<?php
/* @var $this IDoctoController */
/* @var $model IDocto */

?>

<h4>Costo de inventario total</h4>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'idocto-form',
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
      <?php echo $form->label($model,'opcion_exp'); ?>
      <?php echo $form->error($model,'opcion_exp', array('class' => 'badge badge-warning float-right')); ?>
      <br>
      <?php 
        echo $form->radioButtonList($model,'opcion_exp',
            array('3'=>'<i class="fa fa-desktop" aria-hidden="true"></i> Pantalla','1'=>'<i class="far fa-file-pdf" aria-hidden="true"></i> PDF'),
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

      var form = $("#idocto-form");
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

});

function reporte_pantalla(){

  $(".ajax-loader").fadeIn('fast');
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('iDocto/cosinvtotpant'); ?>",
    success: function(data){ 
      $(".ajax-loader").fadeOut('fast');
      $("#resultados").html(data); 
    }
  });

}

</script>
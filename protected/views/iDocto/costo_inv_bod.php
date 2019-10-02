<?php
/* @var $this IDoctoController */
/* @var $model IDocto */

//para combos de bodegas
$lista_bodegas = CHtml::listData($bodegas, 'Id', 'Descripcion'); 

?>

<h3>Costo de inventario x bodega</h3>

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
        <?php echo $form->error($model,'bodega', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'bodega'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
                'name'=>'IDocto[bodega]',
                'id'=>'IDocto_bodega',
                'data'=>$lista_bodegas,
                'value' => $model->bodega,
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
      <?php echo $form->error($model,'opcion_exp', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'opcion_exp'); ?><br>
      <?php 
        echo $form->radioButtonList($model,'opcion_exp',
            array('3'=>'<i class="fa fa-desktop" aria-hidden="true"></i> Pantalla','1'=>'<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF'),
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
                $(".ajax-loader").fadeIn('fast');
                setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 10000); 
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
  $('#IDocto_bodega').val('').trigger('change');
}


function reporte_pantalla(){

  var bodega = $("#IDocto_bodega").val();

  var data = {bodega: bodega}
  $(".ajax-loader").fadeIn('fast');
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('iDocto/cosinvbodpant'); ?>",
    data: data,
    success: function(data){ 
      $(".ajax-loader").fadeOut('fast');
      $("#resultados").html(data); 
    }
  });

}

</script>
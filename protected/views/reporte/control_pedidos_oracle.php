<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Control de pedidos por desc. oracle</h3>

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
        <?php echo $form->error($model,'des_ora', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'des_ora'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[des_ora]',
            'id'=>'Reporte_des_ora',
            'data'=>$lista_oracle,
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
        <?php echo $form->error($model,'estado', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'estado'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[estado]',
            'id'=>'Reporte_estado',
            'data'=>$lista_estados,
            'htmlOptions'=>array(
                'multiple'=>'multiple',
            ),
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
            'data'=>$lista_tipos,
            'htmlOptions'=>array(
                'multiple'=>'multiple',
            ),
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
      <?php echo $form->error($model,'opcion_exp', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'opcion_exp'); ?><br>
      <?php 
        echo $form->radioButtonList($model,'opcion_exp',
            array('1'=>'<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF','2'=>'<i class="fa fa-file-excel-o" aria-hidden="true"></i> EXCEL'),
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

function resetfields(){
  $('#Reporte_des_ora').val('').trigger('change');
  $('#Reporte_estado').val('').trigger('change');
  $('#Reporte_tipo').val('').trigger('change');
}

</script>

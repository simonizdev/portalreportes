<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Pedidos pendientes por despacho / línea</h3>

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
    		<?php echo $form->error($model,'fecha_inicial', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'fecha_inicial'); ?>
		    <?php echo $form->textField($model,'fecha_inicial', array('class' => 'form-control datepicker', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'fecha_final', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'fecha_final'); ?>
		    <?php echo $form->textField($model,'fecha_final', array('class' => 'form-control datepicker', 'readonly' => true)); ?>
        </div>
    </div>
	<div class="col-sm-4">
    	
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'linea_inicial', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'linea_inicial'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[linea_inicial]',
            'id'=>'Reporte_linea_inicial',
            'data'=>$lista_lineas,
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
        <?php echo $form->error($model,'linea_final', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'linea_final'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
            'name'=>'Reporte[linea_final]',
            'id'=>'Reporte_linea_final',
            'data'=>$lista_lineas,
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
    
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
        <button type="button" class="btn btn-success" onclick="resetfields();">Limpiar filtros</button>
        <?php echo CHtml::Button('Generar', array('class' => 'btn btn-success', 'id' => 'valida_form')); ?>
        </div>
    </div>
</div>
<!-- /.row -->

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
              $(".ajax-loader").show();
              setTimeout(function(){ $(".ajax-loader").hide(); }, 20000);
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
  $('#Reporte_fecha_inicial').val('');
  $('#Reporte_fecha_final').val('');
  $('#Reporte_marca_inicial').val('').trigger('change');
  $('#Reporte_marca_final').val('').trigger('change');
}

</script>

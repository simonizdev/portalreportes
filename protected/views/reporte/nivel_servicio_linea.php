<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h4>Pedidos pendientes por despacho / línea</h4>

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
    		<?php echo $form->error($model,'fecha_inicial', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'fecha_inicial'); ?>
		    <?php echo $form->textField($model,'fecha_inicial', array('class' => 'form-control form-control-sm datepicker', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'fecha_final', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'fecha_final'); ?>
		    <?php echo $form->textField($model,'fecha_final', array('class' => 'form-control form-control-sm datepicker', 'readonly' => true)); ?>
        </div>
    </div>
	<div class="col-sm-4">
    	
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <?php echo $form->error($model,'linea_inicial', array('class' => 'badge badge-warning float-right')); ?>
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
        <?php echo $form->error($model,'linea_final', array('class' => 'badge badge-warning float-right')); ?>
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
      <?php echo $form->error($model,'opcion_exp', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'opcion_exp'); ?><br>
      <?php 
        echo $form->radioButtonList($model,'opcion_exp',
            array('1'=>'<i class="far fa-file-pdf" aria-hidden="true"></i> PDF','2'=>'<i class="far fa-file-excel" aria-hidden="true"></i> EXCEL'),
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
      <button type="button" class="btn btn-success btn-sm" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
      <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fa fa-cogs"></i> Generar</button>
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
              loadershow();
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

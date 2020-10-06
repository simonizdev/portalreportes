<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */
/* @var $form CActiveForm */

?>

<script>

$(function() {

    $("#valida_form").click(function() {
      var form = $("#ficha-item-form");
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

</script>

<h4>Rechazo de solicitud</h4>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ficha-item-form',
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
	<div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'Observaciones', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Observaciones', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textArea($model,'Observaciones',array('class' => 'form-control form-control-sm', 'rows'=>2, 'cols'=>50, 'maxlength'=>400, 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-sm-6"> 
        <?php if($model->Tipo == 1){ ?>
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/update&id='.$model->Id; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <?php }else{ ?>
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/update2&id='.$model->Id; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <?php } ?>
        <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>
<?php $this->endWidget(); ?>
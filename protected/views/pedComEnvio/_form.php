<?php
/* @var $this PedComEnvioController */
/* @var $model PedComEnvio */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ped-com-envio-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div id="div_mensaje" style="display: none;"></div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Id_Usuario', array('class' => 'badge badge-warning float-right')); ?>
        	<?php
        		$this->widget('ext.select2.ESelect2',array(
					'name'=>'PedComEnvio[Id_Usuario]',
					'id'=>'PedComEnvio_Id_Usuario',
					'data'=>$lista_usuarios,
					'value'=>$model->Id_Usuario,
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
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'Emails', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Emails', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textArea($model,'Emails',array('class' => 'form-control', 'rows'=>3, 'cols'=>50, 'onkeyup' => 'convert_min(this)')); ?>
        </div>
    </div> 
</div>

<div class="row mb-4">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=PedComEnvio/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fa fa-paper-plane" ></i> Enviar</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>

$(function() {

    $("#valida_form").click(function() {

        $('#PedComEnvio_Emails_em_').html('');
        $('#PedComEnvio_Emails_em_').hide('');      

        var form = $("#ped-com-envio-form");
        var settings = form.data('settings') ;
        settings.submitting = true ;
        $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
            $.each(settings.attributes, function () {
                $.fn.yiiactiveform.updateInput(this,messages,form); 
            });

            var cad_emails_adic = $('#PedComEnvio_Emails').val();

            var data = {
              cad_emails_adic: cad_emails_adic
            }

            //se validan los email adic.
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('PedComEnvio/validemailsadic'); ?>",
                data: data,
                success: function(resp){
                    var valid = resp;
                    if(valid == 0){
                        $('#PedComEnvio_Emails_em_').html('Hay E-mails no validos.');
                        $('#PedComEnvio_Emails_em_').show('');
                    }else{
                        
                        form.submit();
						loadershow();
                    }      
                }
            });   
            

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
<?php
/* @var $this DinComController */
/* @var $model DinCom */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'din-com-form',
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
	        <?php echo $form->error($model,'Fecha_Inicio', array('class' => 'badge badge-warning float-right')); ?>
	        <?php echo $form->label($model,'Fecha_Inicio'); ?>
	        <?php echo $form->textField($model,'Fecha_Inicio', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'readonly' => true)); ?>
	  	</div>
	</div>
	<div class="col-sm-4">
	  	<div class="form-group">
	        <?php echo $form->error($model,'Fecha_Fin', array('class' => 'badge badge-warning float-right')); ?>
	        <?php echo $form->label($model,'Fecha_Fin'); ?>
	        <?php echo $form->textField($model,'Fecha_Fin', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'readonly' => true)); ?>
	  	</div>
	</div>
</div>
<div class="row">		
	<div class="col-sm-4">
      	<div class="form-group">
  			<?php echo $form->error($model,'Id_Plan_Cliente', array('class' => 'badge badge-warning float-right')); ?>
			<?php echo $form->label($model,'Id_Plan_Cliente'); ?>
			<?php
			  $this->widget('ext.select2.ESelect2',array(
			      'name'=>'DinCom[Id_Plan_Cliente]',
			      'id'=>'DinCom_Id_Plan_Cliente',
			      'data'=>UtilidadesVarias::listaplanescliente(),
			      'options'=>array(
			          'placeholder'=>'Seleccione...',
			          'width'=> '100%',
			          'allowClear'=>true,
			      ),
			  ));
			?>
      	</div>
  	</div>
  	<div class="col-sm-8" id="div_cri_cli" style="display: none;">
      	<div class="form-group">
  			<?php echo $form->error($model,'Id_Criterio_Cliente', array('class' => 'badge badge-warning float-right')); ?>
			<?php echo $form->label($model,'Id_Criterio_Cliente'); ?>
			<?php
			  $this->widget('ext.select2.ESelect2',array(
			      'name'=>'DinCom[Id_Criterio_Cliente]',
			      'id'=>'DinCom_Id_Criterio_Cliente',
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
  			<?php echo $form->error($model,'Id_Plan_Item', array('class' => 'badge badge-warning float-right')); ?>
			<?php echo $form->label($model,'Id_Plan_Item'); ?>
			<?php
			  $this->widget('ext.select2.ESelect2',array(
			      'name'=>'DinCom[Id_Plan_Item]',
			      'id'=>'DinCom_Id_Plan_Item',
			      'data'=>UtilidadesVarias::listaplanesitem(),
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
      	<div class="form-group" id="div_cri_item" style="display: none;">
  			<?php echo $form->error($model,'Id_Criterio_Item', array('class' => 'badge badge-warning float-right')); ?>
			<?php echo $form->label($model,'Id_Criterio_Item'); ?>
			<?php
			  $this->widget('ext.select2.ESelect2',array(
			      'name'=>'DinCom[Id_Criterio_Item]',
			      'id'=>'DinCom_Id_Criterio_Item',
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
        	<?php echo $form->error($model,'Porc', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Porc'); ?>
            <?php echo $form->numberField($model,'Porc', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off' , 'step' => '0.01')); ?>
        </div>
    </div>
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Estado', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'DinCom[Estado]',
                    'id'=>'DinCom_Estado',
                    'data'=>$estados,
                    'value'=>$model->Estado,
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

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=dinCom/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>

<?php $this->endWidget(); ?>

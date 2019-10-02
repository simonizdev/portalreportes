<?php
/* @var $this IItemController */
/* @var $model IItem */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'iitem-form',
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
    		<?php echo $form->error($model,'Id_Item', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Id_Item'); ?>
		    <?php echo $form->numberField($model,'Id_Item', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true, 'value' => $id_asignar)); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Referencia', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Referencia'); ?>
		    <?php echo $form->textField($model,'Referencia', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Descripcion', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Descripcion'); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'UND_Medida', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'UND_Medida'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IItem[UND_Medida]',
                    'id'=>'IItem_UND_Medida',
                    'data'=>$lista_unidades,
                    'value' => $model->UND_Medida,
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
            <?php echo $form->error($model,'Id_Linea', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Linea'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IItem[Id_Linea]',
                    'id'=>'IItem_Id_Linea',
                    'data'=>$lista_lineas,
                    'value' => $model->Id_Linea,
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
    		<?php echo $form->error($model,'Mes_Stock', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Mes_Stock'); ?>
		    <?php echo $form->numberField($model,'Mes_Stock', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div> 
</div>
<div class="row">
	<div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Min_Stock', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Min_Stock'); ?>
		    <?php echo $form->numberField($model,'Min_Stock', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Max_Stock', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Max_Stock'); ?>
		    <?php echo $form->numberField($model,'Max_Stock', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Nota', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Nota'); ?>
		    <?php echo $form->textField($model,'Nota', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Estado', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IItem[Estado]',
                    'id'=>'IItem_Estado',
                    'data'=>$estados,
                    'value' => $model->Estado,
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
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iItem/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>


<?php $this->endWidget(); ?>


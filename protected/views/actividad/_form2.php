
<?php
/* @var $this ActividadController */
/* @var $model Actividad */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'actividad-form',
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

<?php if($model->Estado == 2){ ?>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Fecha'); ?>
            <p><?php echo UtilidadesVarias::textofecha($model->Fecha); ?></p>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Hora', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Hora', array('class' => 'badge badge-warning float-right')); ?>
            <p><?php echo $model->HoraAmPm($model->Hora); ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'Actividad', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Actividad', array('class' => 'badge badge-warning float-right')); ?>
            <p><?php echo $model->Actividad; ?></p>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Estado', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Estado', array('class' => 'badge badge-warning float-right')); ?>
            <p><?php echo $model->DescEstado($model->Estado); ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha_Cierre', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Fecha_Cierre'); ?>
            <p><?php echo UtilidadesVarias::textofecha($model->Fecha_Cierre); ?></p>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Hora_Cierre', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Hora_Cierre', array('class' => 'badge badge-warning float-right')); ?>
            <p><?php echo $model->HoraAmPm($model->Hora_Cierre); ?></p>
        </div>
    </div>
</div>


<?php }else{ ?>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Fecha'); ?>
            <p><?php echo UtilidadesVarias::textofecha($model->Fecha); ?></p>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Hora', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Hora', array('class' => 'badge badge-warning float-right')); ?>
            <p><?php echo $model->HoraAmPm($model->Hora); ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Id_Usuario', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Actividad[Id_Usuario]',
                    'id'=>'Actividad_Id_Usuario',
                    'data'=>$lista_usuarios,
                    'value' => $model->Id_Usuario,
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
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'Actividad', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Actividad', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textArea($model,'Actividad',array('class' => 'form-control form-control-sm', 'rows'=>2, 'cols'=>50, 'maxlength'=>300, 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Estado', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Estado', array('class' => 'badge badge-warning float-right')); ?>
            <?php $estados = array(1 => 'ABIERTA', 2 => 'CERRADA', 3 => 'EN ESPERA', 4 => 'EN PROCESO'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Actividad[Estado]',
                    'id'=>'Actividad_Estado',
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
<div class="row">
    <div class="col-sm-4" id="fecha_cierre" style="display: none;">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha_Cierre', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Fecha_Cierre'); ?>
            <?php echo $form->textField($model,'Fecha_Cierre', array('class' => 'form-control form-control-sm', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group" id="hora_cierre" style="display: none;">
            <?php echo $form->label($model,'Hora_Cierre', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Hora_Cierre', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Hora_Cierre', array('class' => 'form-control form-control-sm timepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<?php } ?>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Creacion', array('class' => 'control-label')); ?>
            <p><?php echo $model->idusuariocre->Usuario; ?></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Creacion', array('class' => 'control-label')); ?>
            <p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Creacion); ?></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Actualizacion', array('class' => 'control-label')); ?>
            <p><?php echo $model->idusuarioact->Usuario; ?></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Actualizacion', array('class' => 'control-label')); ?>
            <p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Actualizacion); ?></p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=actividad/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <?php if($model->Estado != 2){ ?>
        <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
        <?php } ?>
    </div>
</div>

<?php

$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'hist-actividad-grid',
        'dataProvider'=>$hist->search(),
        //'filter'=>$model,
        'enableSorting' => false,
        'columns'=>array(
            'Texto',
            array(
                'name' => 'Fecha_Registro',
                'value' => 'UtilidadesVarias::textofechahora($data->Fecha_Registro)',
            ),
            array(
                'name'=>'Id_Usuario_Registro',
                'value'=>'$data->idusuarioreg->Nombres',
            ),
        ),
    ));

?>

<?php $this->endWidget(); ?>	
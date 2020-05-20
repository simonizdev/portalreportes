<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
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
            <?php echo $form->label($model,'Nombres', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Nombres', array('class' => 'badge badge-warning float-right')); ?>
		    <?php echo $form->textField($model,'Nombres', array('class' => 'form-control form-control-sm', 'maxlength' => '60', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->label($model,'Correo', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Correo', array('class' => 'badge badge-warning float-right')); ?>
		    <?php echo $form->textField($model,'Correo', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off', 'onkeyup' => 'convert_min(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->label($model,'Usuario', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Usuario', array('class' => 'badge badge-warning float-right')); ?>
		    <?php echo $form->textField($model,'Usuario', array('class' => 'form-control form-control-sm', 'maxlength' => '30', 'autocomplete' => 'off', 'onkeyup' => 'convert_min(this)')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->label($model,'Password', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Password', array('class' => 'badge badge-warning float-right')); ?>
		    <input type="password" name="Usuario[Password]" id="Usuario_Password" class="form-control form-control-sm" autocomplete="off">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Estado', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Estado', array('class' => 'badge badge-warning float-right')); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[Estado]',
                    'id'=>'Usuario_Estado',
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
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Avatar', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Avatar', array('class' => 'badge badge-warning float-right')); ?>
            <?php $avatar = Yii::app()->params->avatar; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[Avatar]',
                    'id'=>'Usuario_Avatar',
                    'data'=>$avatar,
                    'value' => $model->Avatar,
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
            <?php echo $form->label($model,'perfiles', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'perfiles', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[perfiles]',
                    'id'=>'Usuario_perfiles',
                    'data'=>$lista_perfiles,
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
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'bodegas', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'bodegas', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[bodegas]',
                    'id'=>'Usuario_bodegas',
                    'data'=>$lista_bodegas,
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
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'tipos_docto', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'tipos_docto', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[tipos_docto]',
                    'id'=>'Usuario_tipos_docto',
                    'data'=>$lista_tipos_docto,
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
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'areas', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'areas', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Usuario[areas]',
                    'id'=>'Usuario_areas',
                    'data'=>UtilidadesVarias::listaareas(),
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

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=usuario/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>

<?php $this->endWidget(); ?>









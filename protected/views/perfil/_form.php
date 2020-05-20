<?php
/* @var $this PerfilController */
/* @var $model Perfil */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'perfil-form',
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
    		<?php echo $form->label($model,'Descripcion', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Descripcion', array('class' => 'badge badge-warning float-right')); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control form-control-sm', 'maxlength' => '50', 'autocomplete' => 'off')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Modificacion_Reg', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Modificacion_Reg', array('class' => 'badge badge-warning float-right')); ?>
            <?php $opcs = array(0 => "NO", 1 => "SI"); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Perfil[Modificacion_Reg]',
                    'id'=>'Perfil_Modificacion_Reg',
                    'data'=>$opcs,
                    'value' => $model->Modificacion_Reg,
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
            <?php echo $form->label($model,'Estado', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Estado', array('class' => 'badge badge-warning float-right')); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Perfil[Estado]',
                    'id'=>'Perfil_Estado',
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
    <div class="col-sm-12">
        <div class="form-group">
            <?php echo $form->label($model,'opciones_menu', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'opciones_menu', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->hiddenField($model,'opciones_menu', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
            <div id="example-0">
			    <div>
			        <ul id="tree" style="display: none;">
                        <!-- se carga el arbol de opciones por ajax -->
			        </ul>
			    </div>
			</div>            
        </div>
    </div> 
</div>

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=perfil/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="submit" class="btn btn-success btn-sm" onclick="return valida_opciones(event);"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>

<?php $this->endWidget(); ?>
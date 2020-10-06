<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script type="text/javascript">
$(function() {

	$('#FichaItem_Codigo_Item').attr("disabled", true);

});
</script>

<h4>Solicitud actualización de producto en siesa</h4>

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
            <?php echo $form->label($model,'Codigo_Item'); ?>
            <?php echo $form->error($model,'Codigo_Item', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Codigo_Item'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#FichaItem_Codigo_Item',
                    'options'  => array(
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('fichaItem/SearchItem'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                   
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("FichaItem_Codigo_Item"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'FichaItem_Codigo_Item\')\">Limpiar campo</button>"; }',
                        'initSelection'=>'js:function(element,callback) {
                            var id=$(element).val(); // read #selector value
                            if ( id !== "" ) {
                                $.ajax("'.Yii::app()->createUrl('fichaItem/SearchItemById').'", {
                                    data: { id: id },
                                    dataType: "json"
                                }).done(function(data,textStatus, jqXHR) { callback(data[0]); });
                           }
                        }',
                    ),
                ));
            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Tiempo_Reposicion'); ?>
            <?php echo $form->error($model,'Tiempo_Reposicion', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Tiempo_Reposicion', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Cant_Moq'); ?>
            <?php echo $form->error($model,'Cant_Moq', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Cant_Moq', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Stock_Minimo'); ?>
            <?php echo $form->error($model,'Stock_Minimo', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Stock_Minimo', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<h5 class="mt-3">Criterios</h5>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Crit_Origen'); ?>
            <?php echo $form->error($model,'Crit_Origen', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Origen]',
                    'id'=>'FichaItem_Crit_Origen',
                    'data'=>$lista_origen,
                    'value' => $model->Crit_Origen,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Tipo'); ?>
            <?php echo $form->error($model,'Crit_Tipo', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Tipo]',
                    'id'=>'FichaItem_Crit_Tipo',
                    'data'=>$lista_tipo,
                    'value' => $model->Crit_Tipo,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Clasificacion'); ?>
            <?php echo $form->error($model,'Crit_Clasificacion', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Clasificacion]',
                    'id'=>'FichaItem_Crit_Clasificacion',
                    'data'=>$lista_clasif,
                    'value' => $model->Crit_Clasificacion,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Marca'); ?>
            <?php echo $form->error($model,'Crit_Marca', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Marca]',
                    'id'=>'FichaItem_Crit_Marca',
                    'data'=>$lista_marca,
                    'value' => $model->Crit_Marca,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Submarca'); ?>
            <?php echo $form->error($model,'Crit_Submarca', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Submarca]',
                    'id'=>'FichaItem_Crit_Submarca',
                    'data'=>$lista_submarca,
                    'value' => $model->Crit_Submarca,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Segmento'); ?>
            <?php echo $form->error($model,'Crit_Segmento', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Segmento]',
                    'id'=>'FichaItem_Crit_Segmento',
                    'data'=>$lista_segmento,
                    'value' => $model->Crit_Segmento,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Familia'); ?>
            <?php echo $form->error($model,'Crit_Familia', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Familia]',
                    'id'=>'FichaItem_Crit_Familia',
                    'data'=>$lista_familia,
                    'value' => $model->Crit_Familia,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Subfamilia'); ?>
            <?php echo $form->error($model,'Crit_Subfamilia', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Subfamilia]',
                    'id'=>'FichaItem_Crit_Subfamilia',
                    'data'=>$lista_subfamilia,
                    'value' => $model->Crit_Subfamilia,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Linea'); ?>
            <?php echo $form->error($model,'Crit_Linea', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Linea]',
                    'id'=>'FichaItem_Crit_Linea',
                    'data'=>$lista_linea,
                    'value' => $model->Crit_Linea,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Sublinea'); ?>
            <?php echo $form->error($model,'Crit_Sublinea', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Sublinea]',
                    'id'=>'FichaItem_Crit_Sublinea',
                    'data'=>$lista_sublinea,
                    'value' => $model->Crit_Sublinea,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Grupo'); ?>
            <?php echo $form->error($model,'Crit_Grupo', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Grupo]',
                    'id'=>'FichaItem_Crit_Grupo',
                    'data'=>$lista_grupo,
                    'value' => $model->Crit_Grupo,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_UN'); ?>
            <?php echo $form->error($model,'Crit_UN', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_UN]',
                    'id'=>'FichaItem_Crit_UN',
                    'data'=>$lista_un,
                    'value' => $model->Crit_UN,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Fabrica'); ?>
            <?php echo $form->error($model,'Crit_Fabrica', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Fabrica]',
                    'id'=>'FichaItem_Crit_Fabrica',
                    'data'=>$lista_fabrica,
                    'value' => $model->Crit_Fabrica,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
            <?php echo $form->label($model,'Crit_Cat_Oracle'); ?>
            <?php echo $form->error($model,'Crit_Cat_Oracle', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Cat_Oracle]',
                    'id'=>'FichaItem_Crit_Cat_Oracle',
                    'data'=>$lista_oracle,
                    'value' => $model->Crit_Cat_Oracle,
                    'htmlOptions'=>array(
                        'readonly'=>true,
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
    <?php if($model->Estado_Solicitud == 0){ ?>

    <div class="col-sm-9">
        <div class="form-group">
            <?php echo $form->label($model,'Observaciones', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Observaciones', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textArea($model,'Observaciones',array('class' => 'form-control form-control-sm', 'rows'=>2, 'cols'=>50, 'maxlength'=>400, 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>

    <?php } ?>

    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Estado_Solicitud', array('class' => 'control-label')); ?>
            <p><?php echo $model->DescEstado($model->Estado_Solicitud); ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Solicitud', array('class' => 'control-label')); ?>
            <p><?php echo $model->idusuariosol->Usuario; ?></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Hora_Solicitud', array('class' => 'control-label')); ?>
            <p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Hora_Solicitud); ?></p>
        </div>
    </div>
    <?php if($model->Estado_Solicitud != 1){ ?>

    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Revision', array('class' => 'control-label')); ?>
            <p><?php echo $model->idusuariorev->Usuario; ?></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Hora_Revision', array('class' => 'control-label')); ?>
            <p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Hora_Revision); ?></p>
        </div>
    </div>
    <?php } ?>
</div>

<div class="row mb-4">
    <div class="col-sm-6">
    <?php if($opc ==1){ ?>  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <?php }else{ ?> 
    	<button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/rev'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <?php } ?> 
    </div>
</div>
<?php $this->endWidget(); ?>
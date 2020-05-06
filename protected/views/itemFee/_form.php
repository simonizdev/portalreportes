<?php
/* @var $this ItemFeeController */
/* @var $model ItemFee */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-fee-form',
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
    <div class="col-sm-6">
        <div class="form-group">
            <?php echo $form->error($model,'Rowid_Item', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Rowid_Item'); ?>
            <?php echo $form->textField($model,'Rowid_Item'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#ItemFee_Rowid_Item',
                    'options'  => array(
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('reporte/SearchItem'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                   
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ItemFee_Rowid_Item"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ItemFee_Rowid_Item\')\">Limpiar campo</button>"; }',
                        'initSelection'=>'js:function(element,callback) {
		                   	var id=$(element).val(); // read #selector value
		                   	if ( id !== "" ) {
		                     	$.ajax("'.Yii::app()->createUrl('reporte/SearchItemById').'", {
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
    <div class="col-sm-4">
        <div class="form-group">
        	<?php echo $form->error($model,'Porcentaje', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Porcentaje'); ?>
            <?php echo $form->numberField($model,'Porcentaje', array('class' => 'form-control', 'autocomplete' => 'off' , 'step' => '0.01')); ?>
        </div>
    </div>
</div>
<div class="row">
     <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Iva', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Iva'); ?>
            <?php $data = array(0 => 'No', 1 => 'Si'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ItemFee[Iva]',
                    'id'=>'ItemFee_Iva',
                    'data'=>$data,
                    'value' => $model->Iva,
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
            <?php echo $form->error($model,'Estado', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Estado'); ?>
            <?php $estados = Yii::app()->params->estados; ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ItemFee[Estado]',
                    'id'=>'ItemFee_Estado',
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
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=itemFee/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>


<?php $this->endWidget(); ?>

<script type="text/javascript">

    function clear_select2_ajax(id){
        $('#'+id+'').val('').trigger('change');
        $('#s2id_'+id+' span').html(""); 
    }
    
</script>
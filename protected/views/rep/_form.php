<?php
/* @var $this RepController */
/* @var $model Rep */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rep-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<div class="btn-group" id="btn_save" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=rep/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
   <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
</div>


<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Descripcion', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Descripcion'); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Usuario que creo</label>	
          	<p><?php echo $model->idusuariocre->Usuario; ?></p> 			   
        </div>
    </div>
	<div class="col-sm-4">
    	<div class="form-group">
          	<label>Fecha de creación</label>
          	<p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Creacion); ?></p> 				    
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Usuario que actualizó</label>
          	<p><?php echo $model->idusuarioact->Usuario; ?></p> 	            	
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<label>Fecha de actualización</label>
          	<p><?php echo UtilidadesVarias::textofechahora($model->Fecha_Actualizacion); ?></p> 				   
        </div>
    </div>
</div>

<div class="btn-group" id="btn_add" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=itemRep/create&id='.$model->Id_Rep; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
</div>

<h3>Items asociados</h3>

<?php 

//detalle

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-rep-grid',
	'dataProvider'=>$items->search(),
	//'filter'=>$model,
	'enableSorting' => false,
	'columns'=>array(
		array(
            'name' => 'Id_Item',
            'type' => 'raw',
            'value' => '$data->Desc_Item($data->Id_Item)',
        ),
		array(
            'name'=>'Orden',
            'htmlOptions'=>array('style' => 'text-align: right;'),
        ),
		array(
	        'name'=>'Porcentaje',
	        'value'=>function($data){
	            return number_format($data->Porcentaje, 2);
	        },
	        'htmlOptions'=>array('style' => 'text-align: right;'),
	    ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'afterDelete'=>'function(link,success,data){
			    window.location.reload(); 
			}',
            'buttons'=>array(
               	'update'=>array(
                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Modificar'),
                    'url'=>'Yii::app()->createUrl("itemRep/update", array("id"=>$data->Id_Item_Rep))',
                ),
                'delete'=>array(
                    'label'=>'<i class="fa fa-trash actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Eliminar'),
                    'url'=>'Yii::app()->createUrl("itemRep/delete", array("id"=>$data->Id_Item_Rep))',
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->NumDet($data->Id_Rep) > 1)',
                ),
            )
		),
	),
));

?>

<?php $this->endWidget(); ?>

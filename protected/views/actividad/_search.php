<?php
/* @var $this ActividadController */
/* @var $model Actividad */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<p>Utilice los filtros para optimizar la busqueda:</p>

	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Id'); ?>
			    <?php echo $form->numberField($model,'Id', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha'); ?>
			    <?php echo $form->textField($model,'Fecha', array('class' => 'form-control form-control-sm datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	   	<div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Actividad'); ?>
			    <?php echo $form->textField($model,'Actividad', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
		<div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Tipo'); ?>
			    <?php $tipos = array(1 => 'CAPACITACIÓN', 2 => 'PROYECTO', 3 => 'SOLICITUD', 4 => 'SOPORTE'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Actividad[Tipo]',
						'id'=>'Actividad_Tipo',
						'data'=>$tipos,
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
	    <div class="col-sm-9">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Id_Usuario'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Actividad[Id_Usuario]',
						'id'=>'Actividad_Id_Usuario',
						'data'=>$lista_usuarios1,
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
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Id_Usuario_Creacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Actividad[Id_Usuario_Creacion]',
						'id'=>'Actividad_Id_Usuario_Creacion',
						'data'=>$lista_usuarios2,
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
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Estado'); ?>
			    <?php $estados = array(1 => 'ABIERTA', 2 => 'CERRADA', 3 => 'EN ESPERA', 4 => 'EN PROCESO'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Actividad[Estado]',
						'id'=>'Actividad_Estado',
						'data'=>$estados,
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
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'orderby'); ?>
			    <?php 
                	$array_orden = array(1 => 'ID ASC', 2 => 'ID DESC', 3 => 'Fecha ASC', 4 => 'Fecha DESC', 5 => 'Actividad ASC', 6 => 'Actividad DESC', 7 => 'Tipo ASC', 8 => 'Tipo DESC', 9 => 'Responsable ASC', 10 => 'Responsable DESC', 11 => 'Estado ASC', 12 => 'Estado DESC',
					);
            	?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Actividad[orderby]',
						'id'=>'Actividad_orderby',
						'data'=>$array_orden,
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
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php 
					$this->widget('application.extensions.PageSize.PageSize', array(
				        'mGridId' => 'actividad-grid', //Gridview id
				        'mPageSize' => @$_GET['pageSize'],
				        'mDefPageSize' => Yii::app()->params['defaultPageSize'],
				        'mPageSizeOptions'=>Yii::app()->params['pageSizeOptions'],// Optional, you can use with the widget default
					)); 
				?>	
	        </div>
	    </div>
	</div>
	
	<div class="row mb-2">
	  	<div class="col-sm-6">  
     		<button type="button" class="btn btn-success btn-sm" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
			<button type="submit" class="btn btn-success btn-sm" id="yt0"><i class="fa fa-search"></i> Buscar</button>
	  	</div>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

	function resetfields(){
		$('#Actividad_Id').val('');
		$('#Actividad_Fecha').val('');
		$('#Actividad_Actividad').val('');
		$('#Actividad_Tipo').val('').trigger('change');
		$('#Actividad_Id_Usuario').val('').trigger('change');
		$('#Actividad_Id_Usuario_Creacion').val('').trigger('change');
		$('#Actividad_Fecha_Creacion').val('');
		$('#Actividad_Estado').val('').trigger('change');
		$('#Actividad_orderby').val('').trigger('change');
		$('#yt0').click();
	}
	
</script>
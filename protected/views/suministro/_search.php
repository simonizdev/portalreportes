<?php
/* @var $this SuministroController */
/* @var $model Suministro */
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
	          	<?php echo $form->label($model,'Id_Suministro'); ?>
			    <?php echo $form->numberField($model,'Id_Suministro', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Codigo'); ?>
			    <?php echo $form->textField($model,'Codigo', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	   	<div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Descripcion'); ?>
			    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	   	<div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Referencia'); ?>
			    <?php echo $form->textField($model,'Referencia', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Impresora'); ?>
			    <?php echo $form->textField($model,'Impresora', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
	        </div>
	    </div> 
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_creacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Suministro[usuario_creacion]',
						'id'=>'Suministro_usuario_creacion',
						'data'=>$lista_usuarios,
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
	          	<?php echo $form->label($model,'Fecha_Creacion'); ?>
			    <?php echo $form->textField($model,'Fecha_Creacion', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario_actualizacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Suministro[usuario_actualizacion]',
						'id'=>'Suministro_usuario_actualizacion',
						'data'=>$lista_usuarios,
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
	          	<?php echo $form->label($model,'Fecha_Actualizacion'); ?>
			    <?php echo $form->textField($model,'Fecha_Actualizacion', array('class' => 'form-control datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Estado'); ?>
			    <?php $estados = Yii::app()->params->estados; ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Suministro[Estado]',
						'id'=>'Suministro_Estado',
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
                	$array_orden = array(1 => 'ID ASC', 2 => 'ID DESC', 3 => 'Código ASC', 4 => 'Código DESC', 5 => 'Descripción ASC', 6 => 'Descripción DESC', 7 => 'Referencia ASC', 8 => 'Referencia DESC', 9 => 'Impresora ASC', 10 => 'Impresora DESC', 11 => 'Usuario que creo ASC', 12 => 'Usuario que creo DESC', 13 => 'Fecha de creación ASC', 14 => 'Fecha de creación DESC', 15 => 'Usuario que actualizó ASC', 16 => 'Usuario que actualizó DESC', 17 => 'Fecha de actualización ASC', 18 => 'Fecha de actualización DESC', 19 => 'Estado ASC', 20 => 'Estado DESC',
					);
            	?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'Suministro[orderby]',
						'id'=>'Suministro_orderby',
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
				        'mGridId' => 'suministro-grid', //Gridview id
				        'mPageSize' => @$_GET['pageSize'],
				        'mDefPageSize' => Yii::app()->params['defaultPageSize'],
				        'mPageSizeOptions'=>Yii::app()->params['pageSizeOptions'],// Optional, you can use with the widget default
					)); 
				?>	
	        </div>
	    </div>
	</div>
	<div class="btn-group" style="padding-bottom: 2%">
		<button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
		<button type="submit" class="btn btn-success" id="yt0"><i class="fa fa-search"></i> Buscar</button>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

	function resetfields(){
		$('#Suministro_Id_Suministro').val('');
		$('#Suministro_Codigo').val('');
		$('#Suministro_Descripcion').val('');
		$('#Suministro_Referencia').val('');
		$('#Suministro_Impresora').val('');
		$('#Suministro_usuario_creacion').val('').trigger('change');
		$('#Suministro_Fecha_Creacion').val('');
		$('#Suministro_usuario_actualizacion').val('').trigger('change');
		$('#Suministro_Fecha_Actualizacion').val('');
		$('#Suministro_Estado').val('').trigger('change');
		$('#Suministro_orderby').val('').trigger('change');
		$('#yt0').click();
	}
	
</script>
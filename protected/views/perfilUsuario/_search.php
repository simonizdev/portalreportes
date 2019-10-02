<?php
/* @var $this PerfilUsuarioController */
/* @var $model PerfilUsuario */
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
	          	<?php echo $form->label($model,'Id_P_Usuario'); ?>
			    <?php echo $form->numberField($model,'Id_P_Usuario', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'usuario'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'PerfilUsuario[usuario]',
						'id'=>'PerfilUsuario_usuario',
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
	          	<?php echo $form->label($model,'perfil'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'PerfilUsuario[perfil]',
						'id'=>'PerfilUsuario_perfil',
						'data'=>$lista_perfiles,
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
	          	<?php echo $form->label($model,'usuario_creacion'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'PerfilUsuario[usuario_creacion]',
						'id'=>'PerfilUsuario_usuario_creacion',
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
						'name'=>'PerfilUsuario[usuario_actualizacion]',
						'id'=>'PerfilUsuario_usuario_actualizacion',
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
						'name'=>'PerfilUsuario[Estado]',
						'id'=>'PerfilUsuario_Estado',
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
                	$array_orden = array(1 => 'ID ASC', 2 => 'ID DESC', 3 => 'Usuario ASC', 4 => 'Usuario DESC', 5 => 'Perfil ASC', 6 => 'Perfil DESC', 7 => 'Usuario que creo ASC', 8 => 'Usuario que creo DESC', 9 => 'Fecha de creación ASC', 10 => 'Fecha de creación DESC', 11 => 'Usuario que actualizó ASC', 12 => 'Usuario que actualizó DESC', 13 => 'Fecha de actualización ASC', 14 => 'Fecha de actualización DESC', 15 => 'Estado ASC', 16 => 'Estado DESC',
                	);
            	?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'PerfilUsuario[orderby]',
						'id'=>'PerfilUsuario_orderby',
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
					        'mGridId' => 'perfil-usuario-grid', //Gridview id
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
		$('#PerfilUsuario_Id_P_Usuario').val('');
		$('#PerfilUsuario_usuario').val('').trigger('change');
		$('#PerfilUsuario_perfil').val('').trigger('change');
		$('#PerfilUsuario_usuario_creacion').val('').trigger('change');
		$('#PerfilUsuario_Fecha_Creacion').val('');
		$('#PerfilUsuario_usuario_actualizacion').val('').trigger('change');
		$('#PerfilUsuario_Fecha_Actualizacion').val('');
		$('#PerfilUsuario_Estado').val('').trigger('change');
		$('#PerfilUsuario_orderby').val('').trigger('change');
		$('#yt0').click();
	}
	
</script>

<?php
/* @var $this PedComController */
/* @var $model PedCom */
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
	          	<?php echo $form->label($model,'Id_Ped_Com'); ?>
			    <?php echo $form->numberField($model,'Id_Ped_Com', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'type' => 'number')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Fecha'); ?>
			    <?php echo $form->textField($model,'Fecha', array('class' => 'form-control form-control-sm datepicker', 'autocomplete' => 'off', 'readonly' => true)); ?>
	        </div>
	    </div>
	    <div class="col-sm-6">
	    	<div class="form-group">
		      <?php echo $form->error($model,'Cliente', array('class' => 'badge badge-warning float-right')); ?>
		      <?php echo $form->label($model,'Cliente'); ?>
		      <?php echo $form->textField($model,'Cliente'); ?>
		      <?php
		      $this->widget('ext.select2.ESelect2', array(
		          'selector' => '#PedCom_Cliente',

		          'options'  => array(
		            'allowClear' => true,
		            'minimumInputLength' => 3,
		                'width' => '100%',
		                'language' => 'es',
		                'ajax' => array(
		                      'url' => Yii::app()->createUrl('PedCom/SearchCliente'),
		                  'dataType'=>'json',
		                    'data'=>'js:function(term){return{q: term};}',
		                    'results'=>'js:function(data){ return {results:data};}'
		                             
		              ),
		              'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ParPedEsp_Nit"); return "No se encontraron resultados"; }',
		              'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'PedCom_Cliente\')\">Limpiar campo</button>"; }',
		          ),
		        ));
		      ?>
	    	</div>
	  	</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Estado'); ?>
			    <?php $estados = array(0 => 'ANULADO', 1 => 'GUARDADO', 2 => 'ENVIADO', 3 => 'RECHAZADO', 4 => 'CARGADO A SIESA'); ?>
            	<?php
            		$this->widget('ext.select2.ESelect2',array(
						'name'=>'PedCom[Estado]',
						'id'=>'PedCom_Estado',
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
	          	<?php 
					$this->widget('application.extensions.PageSize.PageSize', array(
				        'mGridId' => 'ped-com-grid', //Gridview id
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
		$('#PedCom_Id_Ped_Com').val('');
		$('#PedCom_Fecha').val('');
		$('#PedCom_Cliente').val('').trigger('change');
    	$('#s2id_PedCom_Cliente span').html("");
		$('#PedCom_Estado').val('').trigger('change');
		$('#yt0').click();
	}
	
</script>

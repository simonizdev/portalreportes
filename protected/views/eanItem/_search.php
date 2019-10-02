<?php
/* @var $this EanItemController */
/* @var $model EanItem */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<p>Utilice los filtros para optimizar la busqueda:</p>

	<div class="row">
	    <div class="col-sm-6">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Id_Item'); ?>	
			    <?php echo $form->textField($model,'Id_Item'); ?>
			    <?php
			        $this->widget('ext.select2.ESelect2', array(
			            'selector' => '#EanItem_Id_Item',
			            'options'  => array(
			                'allowClear' => true,
			                'minimumInputLength' => 5,
			                'width' => '100%',
			                'language' => 'es',
			                'ajax' => array(
			                    'url' => Yii::app()->createUrl('EanItem/SearchAllItems'),
			                    'dataType'=>'json',
			                    'data'=>'js:function(term){return{q: term};}',
			                    'results'=>'js:function(data){ return {results:data};}'                   
			                ),
			                'formatNoMatches'=> 'js:function(){ clear_select2_ajax("EanItem_Id_Item"); return "No se encontraron resultados"; }',
			                'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'EanItem_Id_Item\')\">Limpiar campo</button>"; }',
			            ),
			        ));
			    ?>
	        </div>
	    </div>

		
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php 
					$this->widget('application.extensions.PageSize.PageSize', array(
					        'mGridId' => 'ean-item-grid', //Gridview id
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

	function clear_select2_ajax(id){
		$('#'+id+'').val('').trigger('change');
		$('#s2id_'+id+' span').html("");
	}

	function resetfields(){
		$('#EanItem_Id_Item').val('').trigger('change');
		$('#s2id_EanItem_Id_Item span').html("");
		$('#yt0').click();
	}
	
</script>

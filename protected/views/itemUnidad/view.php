<?php
/* @var $this ItemUnidadController */
/* @var $model ItemUnidad */

?>

<h3>Visualizando unidades para item</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-unidad-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data'
	),
)); ?>

<div class="btn-group" style="padding-bottom: 2%">
  <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=itemUnidad/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
</div>

<div class="row" style="padding-bottom: 2%">    		
	<div class="col-sm-8">
		<div class="pull-right badge bg-red" id="error_item" style="display: none;"></div>
        <?php echo $form->label($model,'Id_Item'); ?>
        <p><?php echo $model->Desc_Item($model->Id_Item); ?></p>
        <?php echo $form->hiddenField($model,'Id_Item'); ?>
  	</div>
	<div class="col-sm-4" id="num_und">
    <div class="form-group">
    	<?php echo $form->label($model,'num_und'); ?>
      <p><?php echo $num_und; ?></p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6"  id="und1" style="display: none;">
		<div class="box box-default">
      <div class="box-header">
    		<h3 class="box-title">Unidad 1</h3>
      </div>
      <div class="box-body">
      	<div class="row">
        	<div class="col-xs-8">
          	<?php echo $form->label($model,'Unidad_1'); ?>
            <?php ($model->Unidad_1 == "") ? $un1 = "No asignado" : $un1 = $model->Desc_Unidad($model->Unidad_1) ?>
            <p><?php echo $un1; ?></p>	
      		</div>
      		<div class="col-xs-4">
        		<?php echo $form->label($model,'Cod_Barras1'); ?>
			    	<p><?php echo $model->Cod_Barras1; ?></p>	
      		</div>
    	  </div>
        <div class="row">
        	<div class="col-xs-4">
	      		<?php echo $form->label($model,'Largo1'); ?>
			    	<p><?php echo $model->Largo1; ?></p>
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Ancho1'); ?>
			    	<p><?php echo $model->Ancho1; ?></p>	
        	</div>
        	<div class="col-xs-4">
						<?php echo $form->label($model,'Alto1'); ?>
			    	<p><?php echo $model->Alto1; ?></p>	
        	</div>
      	</div>
      	<div class="row">
        	<div class="col-xs-4">
      			<?php echo $form->label($model,'Volumen_Total1'); ?>
			    	<p><?php echo $model->Volumen_Total1; ?></p>	
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Peso_Total1'); ?>
		   		 	<p><?php echo $model->Peso_Total1; ?></p>	
        	</div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Cantidad1'); ?>
			    	<p><?php echo $model->Cantidad1; ?></p>		
        	</div>
      	</div>
      </div>
    </div>
  </div>

  <div class="col-md-6"  id="und2" style="display: none;">
		<div class="box box-default">
      <div class="box-header">
    		<h3 class="box-title">Unidad 2</h3>
      <div class="box-body">
      	<div class="row">
        	<div class="col-xs-8">
          	<?php echo $form->label($model,'Unidad_2'); ?>
            <?php ($model->Unidad_2 == "") ? $un2 = "No asignado" : $un2 = $model->Desc_Unidad($model->Unidad_2) ?>
            <p><?php echo $un2; ?></p>	
      		</div>
      		<div class="col-xs-4">
        		<?php echo $form->label($model,'Cod_Barras2'); ?>
			    	<p><?php echo $model->Cod_Barras2; ?></p>	
      		</div>
    	  </div>
        <div class="row">
        	<div class="col-xs-4">
	      		<?php echo $form->label($model,'Largo2'); ?>
			    	<p><?php echo $model->Largo2; ?></p>
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Ancho2'); ?>
			    	<p><?php echo $model->Ancho2; ?></p>	
        	</div>
        	<div class="col-xs-4">
						<?php echo $form->label($model,'Alto2'); ?>
			    	<p><?php echo $model->Alto2; ?></p>	
        	</div>
      	</div>
      	<div class="row">
        	<div class="col-xs-4">
      			<?php echo $form->label($model,'Volumen_Total2'); ?>
			    	<p><?php echo $model->Volumen_Total2; ?></p>	
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Peso_Total2'); ?>
		   		 	<p><?php echo $model->Peso_Total2; ?></p>	
        	</div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Cantidad2'); ?>
			    	<p><?php echo $model->Cantidad2; ?></p>		
        	</div>
      	</div>
      </div>
    </div>
  </div>

  <div class="col-md-6"  id="und3" style="display: none;">
		<div class="box box-default">
      <div class="box-header">
    		<h3 class="box-title">Unidad 3</h3>
      </div>
      <div class="box-body">
      	<div class="row">
        	<div class="col-xs-8">
          	<?php echo $form->label($model,'Unidad_3'); ?>
            <?php ($model->Unidad_3 == "") ? $un3 = "No asignado" : $un3 = $model->Desc_Unidad($model->Unidad_3) ?>
            <p><?php echo $un3; ?></p>	
      		</div>
      		<div class="col-xs-4">
        		<?php echo $form->label($model,'Cod_Barras3'); ?>
			    	<p><?php echo $model->Cod_Barras3; ?></p>	
      		</div>
    	  </div>
        <div class="row">
        	<div class="col-xs-4">
	      		<?php echo $form->label($model,'Largo3'); ?>
			    	<p><?php echo $model->Largo3; ?></p>
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Ancho3'); ?>
			    	<p><?php echo $model->Ancho3; ?></p>	
        	</div>
        	<div class="col-xs-4">
						<?php echo $form->label($model,'Alto3'); ?>
			    	<p><?php echo $model->Alto3; ?></p>	
        	</div>
      	</div>
      	<div class="row">
        	<div class="col-xs-4">
      			<?php echo $form->label($model,'Volumen_Total3'); ?>
			    	<p><?php echo $model->Volumen_Total3; ?></p>	
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Peso_Total3'); ?>
		   		 	<p><?php echo $model->Peso_Total3; ?></p>	
        	</div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Cantidad3'); ?>
			    	<p><?php echo $model->Cantidad3; ?></p>		
        	</div>
      	</div>
      </div>
    </div>
  </div>

  <div class="col-md-6"  id="und4" style="display: none;">
		<div class="box box-default">
      <div class="box-header">
    		<h3 class="box-title">Unidad 4</h3>
      </div>
      <div class="box-body">
      	<div class="row">
        	<div class="col-xs-8">
          	<?php echo $form->label($model,'Unidad_4'); ?>
            <?php ($model->Unidad_4 == "") ? $un4 = "No asignado" : $un4 = $model->Desc_Unidad($model->Unidad_4) ?>
            <p><?php echo $un4; ?></p>	
      		</div>
      		<div class="col-xs-4">
        		<?php echo $form->label($model,'Cod_Barras4'); ?>
			    	<p><?php echo $model->Cod_Barras4; ?></p>	
      		</div>
    	  </div>
        <div class="row">
        	<div class="col-xs-4">
	      		<?php echo $form->label($model,'Largo4'); ?>
			    	<p><?php echo $model->Largo4; ?></p>
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Ancho4'); ?>
			    	<p><?php echo $model->Ancho4; ?></p>	
        	</div>
        	<div class="col-xs-4">
						<?php echo $form->label($model,'Alto4'); ?>
			    	<p><?php echo $model->Alto4; ?></p>	
        	</div>
      	</div>
      	<div class="row">
        	<div class="col-xs-4">
      			<?php echo $form->label($model,'Volumen_Total4'); ?>
			    	<p><?php echo $model->Volumen_Total4; ?></p>	
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Peso_Total4'); ?>
		   		 	<p><?php echo $model->Peso_Total4; ?></p>	
        	</div>
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'Cantidad4'); ?>
			    	<p><?php echo $model->Cantidad4; ?></p>		
        	</div>
      	</div>
      </div>
    </div>
  </div>  
</div>

<div class="row">
	<div class="col-md-12" id="config_b">
		<div class="box box-default">
      <div class="box-header">
    		<h3 class="box-title">Otros parametros</h3>
      </div>
      <div class="box-body">
      	<div class="row">
        	<div class="col-xs-4">
        		<?php echo $form->label($model,'UN_Venta'); ?>
            <p><?php echo $model->UN_Venta; ?></p>
      		</div>
      		<div class="col-xs-4">
      			<?php echo $form->label($model,'UN_Cadena'); ?>
            <p><?php echo $model->UN_Cadena; ?></p>
      		</div>
      		<div class="col-xs-4">
      			<?php echo $form->label($model,'Lead_Time'); ?>
			    	<p><?php echo $model->Lead_Time; ?></p>
      		</div>
      	</div>
      	<div class="row">
        
        	<div class="col-xs-12">
        		<label>Foto</label>
		    		<input type="hidden" id="valid_img" value="1">
		    		<img id="img" class="img-responsive"/>
        	</div>
      	</div>
      </div>
    </div>
  </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

$(function() {

	var img = '<?php echo $model->Foto; ?>';
	if(img != ""){
 		img = '<?php echo Yii::app()->baseUrl."/images/items/".$model->Foto; ?>';
		$('#img').attr('src', img);  
	}else{
		img = '<?php echo Yii::app()->baseUrl."/images/items/default.jpg"; ?>';
		$('#img').attr('src', img);   
	}

	var num_und = '<?php echo $num_und; ?>';

  //se muestran los div de las unidades a configurar
  for (t = 1; t <= num_und ; t++) {
 		$('#und'+t).show();
	}

});

</script>




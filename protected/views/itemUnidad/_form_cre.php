<?php
/* @var $this ItemUnidadController */
/* @var $model ItemUnidad */
/* @var $form CActiveForm */
?>

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

<p>seleccione un item y la cantidad de unidades a configurar:</p>

<div class="row" style="padding-bottom: 2%">    		
	<div class="col-sm-8">
		<div class="pull-right badge bg-red" id="error_item" style="display: none;"></div>
    <?php echo $form->label($model,'Id_Item'); ?>	
    <?php echo $form->textField($model,'Id_Item'); ?>
    <?php
        $this->widget('ext.select2.ESelect2', array(
            'selector' => '#ItemUnidad_Id_Item',
            'options'  => array(
                'allowClear' => true,
                'minimumInputLength' => 5,
                'width' => '100%',
                'language' => 'es',
                'ajax' => array(
                    'url' => Yii::app()->createUrl('itemUnidad/SearchItem'),
                    'dataType'=>'json',
                    'data'=>'js:function(term){return{q: term};}',
                    'results'=>'js:function(data){ return {results:data};}'                   
                ),
                'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ItemUnidad_Id_Item"); return "No se encontraron resultados"; }',
                'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ItemUnidad_Id_Item\')\">Limpiar campo</button>"; }',
            ),
        ));
    ?>
  </div>
	<div class="col-sm-4" id="num_und" style="display: none;">
    <div class="form-group">
      <?php echo $form->error($model,'num_und', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'num_und'); ?>
      <?php
          $this->widget('ext.select2.ESelect2',array(
              'name'=>'ItemUnidad[num_und]',
              'id'=>'ItemUnidad_num_und',
              'data'=>array(1 => 1, 2 => 2, 3 => 3, 4 => 4),
              'value' => $model->num_und,
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
  <div class="col-md-6"  id="und1" style="display: none;">
		<div class="box box-default">
      <div class="box-header">
    		<h3 class="box-title">Unidad 1</h3><div class="pull-right badge bg-red" id="error_und_1" style="display: none;"></div>
      </div>
      <div class="box-body">
      	<div class="row">
        	<div class="col-xs-8">
          	<?php echo $form->error($model,'Unidad_1', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Unidad_1'); ?>
            <?php echo $form->textField($model,'Unidad_1'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#ItemUnidad_Unidad_1',
                    'options'  => array(
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('itemUnidad/SearchUnidad'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ItemUnidad_Unidad_1"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ItemUnidad_Unidad_1\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
      		</div>
      		<div class="col-xs-4">
        		<?php echo $form->error($model,'Cod_Barras1', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Cod_Barras1'); ?>
		        <?php echo $form->textField($model,'Cod_Barras1', array('class' => 'form-control', 'maxlength' => '128', 'autocomplete' => 'off')); ?>
      		</div>
    	  </div>
        <div class="row">
        	<div class="col-xs-4">
      			<?php echo $form->error($model,'Largo1', array('class' => 'pull-right badge bg-red')); ?>
						<?php echo $form->label($model,'Largo1'); ?>
				    <?php echo $form->numberField($model,'Largo1', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(1);')); ?>
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->error($model,'Ancho1', array('class' => 'pull-right badge bg-red')); ?>
						<?php echo $form->label($model,'Ancho1'); ?>
				    <?php echo $form->numberField($model,'Ancho1', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(1);')); ?>
        	</div>
        	<div class="col-xs-4">
        		<?php echo $form->error($model,'Alto1', array('class' => 'pull-right badge bg-red')); ?>
						<?php echo $form->label($model,'Alto1'); ?>
				    <?php echo $form->numberField($model,'Alto1', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(1);')); ?>
        	</div>
      	</div>
      	<div class="row">
        	<div class="col-xs-4">
      			<?php echo $form->error($model,'Volumen_Total1', array('class' => 'pull-right badge bg-red')); ?>
						<?php echo $form->label($model,'Volumen_Total1'); ?>
            <?php echo $form->numberField($model,'Volumen_Total1', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'readonly' => true)); ?>
    		  </div>
        	<div class="col-xs-4">
        		<?php echo $form->error($model,'Peso_Total1', array('class' => 'pull-right badge bg-red')); ?>
						<?php echo $form->label($model,'Peso_Total1'); ?>
		    		<?php echo $form->numberField($model,'Peso_Total1', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
        	</div>
        	<div class="col-xs-4">
        		<?php echo $form->error($model,'Cantidad1', array('class' => 'pull-right badge bg-red')); ?>
						<?php echo $form->label($model,'Cantidad1'); ?>
		    		<?php echo $form->numberField($model,'Cantidad1', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
        	</div>
      	</div>
      </div>
    </div>
  </div>

  <div class="col-md-6"  id="und2" style="display: none;">
    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">Unidad 2</h3><div class="pull-right badge bg-red" id="error_und_2" style="display: none;"></div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-xs-8">
            <?php echo $form->error($model,'Unidad_2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Unidad_2'); ?>
            <?php echo $form->textField($model,'Unidad_2'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#ItemUnidad_Unidad_2',
                    'options'  => array(
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('itemUnidad/SearchUnidad'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ItemUnidad_Unidad_2"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ItemUnidad_Unidad_2\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Cod_Barras2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Cod_Barras2'); ?>
            <?php echo $form->textField($model,'Cod_Barras2', array('class' => 'form-control', 'maxlength' => '128', 'autocomplete' => 'off')); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <?php echo $form->error($model,'Largo2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Largo2'); ?>
            <?php echo $form->numberField($model,'Largo2', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(2);')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Ancho2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Ancho2'); ?>
            <?php echo $form->numberField($model,'Ancho2', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(2);')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Alto2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Alto2'); ?>
            <?php echo $form->numberField($model,'Alto2', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(2);')); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <?php echo $form->error($model,'Volumen_Total2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Volumen_Total2'); ?>
            <?php echo $form->numberField($model,'Volumen_Total2', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'readonly' => true)); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Peso_Total2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Peso_Total2'); ?>
            <?php echo $form->numberField($model,'Peso_Total2', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Cantidad2', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Cantidad2'); ?>
            <?php echo $form->numberField($model,'Cantidad2', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6"  id="und3" style="display: none;">
    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">Unidad 3</h3><div class="pull-right badge bg-red" id="error_und_3" style="display: none;"></div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-xs-8">
            <?php echo $form->error($model,'Unidad_3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Unidad_3'); ?>
            <?php echo $form->textField($model,'Unidad_3'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#ItemUnidad_Unidad_3',
                    'options'  => array(
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('itemUnidad/SearchUnidad'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ItemUnidad_Unidad_3"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ItemUnidad_Unidad_3\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Cod_Barras3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Cod_Barras3'); ?>
            <?php echo $form->textField($model,'Cod_Barras3', array('class' => 'form-control', 'maxlength' => '128', 'autocomplete' => 'off')); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <?php echo $form->error($model,'Largo3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Largo3'); ?>
            <?php echo $form->numberField($model,'Largo3', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(3);')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Ancho3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Ancho3'); ?>
            <?php echo $form->numberField($model,'Ancho3', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(3);')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Alto3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Alto3'); ?>
            <?php echo $form->numberField($model,'Alto3', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(3);')); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <?php echo $form->error($model,'Volumen_Total3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Volumen_Total3'); ?>
            <?php echo $form->numberField($model,'Volumen_Total3', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'readonly' => true)); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Peso_Total3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Peso_Total3'); ?>
            <?php echo $form->numberField($model,'Peso_Total3', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Cantidad3', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Cantidad3'); ?>
            <?php echo $form->numberField($model,'Cantidad3', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6"  id="und4" style="display: none;">
    <div class="box box-default">
      <div class="box-header">
        <h3 class="box-title">Unidad 4</h3><div class="pull-right badge bg-red" id="error_und_4" style="display: none;"></div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-xs-8">
            <?php echo $form->error($model,'Unidad_4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Unidad_4'); ?>
            <?php echo $form->textField($model,'Unidad_4'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#ItemUnidad_Unidad_4',
                    'options'  => array(
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('itemUnidad/SearchUnidad'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ItemUnidad_Unidad_4"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ItemUnidad_Unidad_1\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Cod_Barras4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Cod_Barras4'); ?>
            <?php echo $form->textField($model,'Cod_Barras4', array('class' => 'form-control', 'maxlength' => '128', 'autocomplete' => 'off')); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <?php echo $form->error($model,'Largo4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Largo4'); ?>
            <?php echo $form->numberField($model,'Largo4', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(4);')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Ancho4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Ancho4'); ?>
            <?php echo $form->numberField($model,'Ancho4', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(4);')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Alto4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Alto4'); ?>
            <?php echo $form->numberField($model,'Alto4', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'onchange' => 'calculo_volumen(4);')); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <?php echo $form->error($model,'Volumen_Total4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Volumen_Total4'); ?>
            <?php echo $form->numberField($model,'Volumen_Total4', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number', 'readonly' => true)); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Peso_Total4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Peso_Total4'); ?>
            <?php echo $form->numberField($model,'Peso_Total4', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
          </div>
          <div class="col-xs-4">
            <?php echo $form->error($model,'Cantidad4', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Cantidad4'); ?>
            <?php echo $form->numberField($model,'Cantidad4', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12"  id="config_b" style="display: none;">
		<div class="box box-default">
      <div class="box-header">
    		<h3 class="box-title">Otros parametros</h3>
      </div>
      <div class="box-body">
      	<div class="row">
        	<div class="col-xs-4">
        		<?php echo $form->error($model,'UN_Venta', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'UN_Venta'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ItemUnidad[UN_Venta]',
                    'id'=>'ItemUnidad_UN_Venta',
                    'value' => $model->UN_Venta,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
      		</div>
      		<div class="col-xs-4">
      			<?php echo $form->error($model,'UN_Cadena', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'UN_Cadena'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'ItemUnidad[UN_Cadena]',
                    'id'=>'ItemUnidad_UN_Cadena',
                    'value' => $model->UN_Cadena,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
      		</div>
      		<div class="col-xs-4">
      			<?php echo $form->error($model,'Lead_Time', array('class' => 'pull-right badge bg-red')); ?>
		      	<?php echo $form->label($model,'Lead_Time'); ?>
				    <?php echo $form->numberField($model,'Lead_Time', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
      		</div>
      	</div>
      	<div class="row">
        	<div class="col-xs-4">
      		  <?php echo $form->error($model,'Foto', array('class' => 'pull-right badge bg-red')); ?>
		      	<?php echo $form->label($model,'Foto'); ?>
				    <?php echo $form->fileField($model, 'Foto'); ?>
        	</div>
        	<div class="col-xs-8">
        		<label>Vista previa</label>
		    		<div class="pull-right badge bg-red" id="error_sop" style="display: none;"></div>
		    		<input type="hidden" id="valid_img" value="1">
		    		<img id="img" class="img-responsive"/>
        	</div>
      	</div>
      </div>
    </div>
  </div>  
</div>

<div class="btn-group" id="btn_save" style="padding-bottom: 2%;display: none;">
  <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=itemUnidad/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
  <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-floppy-o"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
</div>


<?php $this->endWidget(); ?>

<script type="text/javascript">

$(function() {

	$('#ItemUnidad_Id_Item').on("change", function() { 
   		
		//se limpia el campo de num de unidades
		
    $('#num_und').hide();
		$('#ItemUnidad_num_und').val('').trigger('change');
    	
  	//se limpian los campos de config de UN
  	$('#config_b').hide();
    $("#ItemUnidad_UN_Venta").html('');
    $('#ItemUnidad_UN_Venta').val('').trigger('change');
    $("#ItemUnidad_UN_Cadena").html('');
    $('#ItemUnidad_UN_Cadena').val('').trigger('change');
    $('#ItemUnidad_Lead_Time').val('');

    //se ocultan los div de las unidades
    for (t = 1; t <= 4 ; t++) {
		 	$('#und'+t).hide('fast');
		 	$('#ItemUnidad_Unidad_'+t).val('').trigger('change');
			$('#s2id_ItemUnidad_Unidad_'+t+' span').html("");
		 	$('#ItemUnidad_Cantidad'+t).val('');
		 	$('#ItemUnidad_Largo'+t).val('');
		 	$('#ItemUnidad_Ancho'+t).val('');
		 	$('#ItemUnidad_Alto'+t).val('');
		 	$('#ItemUnidad_Volumen_Total'+t).val('');
		 	$('#ItemUnidad_Peso_Total'+t).val('');
		 	$('#ItemUnidad_Cod_Barras'+t).val('');
	  }
        
    $('#btn_save').hide();

    //se toma el valor del item
 		var item = this.value;	
		
 		if(item != ""){

 			$(".ajax-loader").fadeIn('fast');

      //se consulta si el item tiene unidades de empaque creadas
      var data = {item: item}
      $.ajax({ 
        type: "POST", 
        url: "<?php echo Yii::app()->createUrl('itemUnidad/evaluarexistencia'); ?>",
        data: data,
        dataType: 'json',
        success: function(data){
        	
          $(".ajax-loader").fadeOut('fast');

          if (data == 0) {

          	$('#error_item').html('');
            $('#error_item').hide(); 

            var div_contenido = $('#contenido');

          	$('#num_und').show();    

          }else{
            	
            $('#error_item').html('Este item ya tiene unidades creadas en el sistema.');
            $('#error_item').show(); 

            $('#num_und').hide();
          	$('#ItemUnidad_num_und').val('').trigger('change');   
          } 
        }
      });

    }else{
    	
      $('#error_item').html('Item no puede ser nulo.');
      $('#error_item').show();
	    
    }

	});

	$('#ItemUnidad_num_und').change(function() {
    
    var num_und = $('#ItemUnidad_num_und').val();
	    
    if(num_und == 0 || num_und == ""){

  	  $('#ItemUnidad_num_und_em_').html('# de unidades no puede ser nulo.');
      $('#ItemUnidad_num_und_em_').show();

      //se limpian los campos de config b de UN y demás campos en div config b
      $('#config_b').hide('fast');
      $("#ItemUnidad_UN_Venta").html('');
      $('#ItemUnidad_UN_Venta').val('').trigger('change');
      $("#ItemUnidad_UN_Cadena").html('');
      $('#ItemUnidad_UN_Cadena').val('').trigger('change');
      $('#ItemUnidad_Lead_Time').val('');


      //se ocultan los div de las unidades
      for (t = 1; t <= 4 ; t++) {
			 	$('#und'+t).hide();
			 	$('#ItemUnidad_Unidad_'+t).val('').trigger('change');
				$('#s2id_ItemUnidad_Unidad_'+t+' span').html("");
			 	$('#ItemUnidad_Cantidad'+t).val('');
			 	$('#ItemUnidad_Largo'+t).val('');
			 	$('#ItemUnidad_Ancho'+t).val('');
			 	$('#ItemUnidad_Alto'+t).val('');
			 	$('#ItemUnidad_Volumen_Total'+t).val('');
			 	$('#ItemUnidad_Peso_Total'+t).val('');
			 	$('#ItemUnidad_Cod_Barras'+t).val('');
			}

	    $('#btn_save').hide();
	        
    }else{

    	$('#ItemUnidad_num_und_em_').html('');
      $('#ItemUnidad_num_und_em_').hide();

      //div config_b

      $('#ItemUnidad_UN_Venta').val('').trigger('change');
      $('#ItemUnidad_UN_Cadena').val('').trigger('change');

    	var array = [];

      for (i = 1; i <= num_und ; i++) {
		    nuevo_elemento = array.push(i);
      }

      //se carga el numero de unidades a crear en los combos de UN para venta y UN para cadenas

      $("#ItemUnidad_UN_Venta").html('');
      $("#ItemUnidad_UN_Venta").append('<option value=""></option>');
      $.each(array, function(i, val){
          $("#ItemUnidad_UN_Venta").append('<option value="'+val+'">'+val+'</option>');
      });

      $("#ItemUnidad_UN_Cadena").html('');
      $("#ItemUnidad_UN_Cadena").append('<option value=""></option>');
      $.each(array, function(i, val){
          $("#ItemUnidad_UN_Cadena").append('<option value="'+val+'">'+val+'</option>');
      });

      $('#config_b').show();

      //se muestran los div de las unidades a configurar
      for (t = 1; t <= num_und ; t++) {
        $('#und'+t).show('fast');
      }

		  ult = parseInt(num_und) +1;
			 
      if (ult < 5){
        //se limpian los div de las unidades q no se van a configurar
        for (k = ult ; k <= 4 ; k++) {
					$('#und'+k).hide();
				 	$('#ItemUnidad_Unidad_'+k).val('').trigger('change');
					$('#s2id_ItemUnidad_Unidad_'+k+' span').html("");
				 	$('#ItemUnidad_Cantidad'+k).val('');
				 	$('#ItemUnidad_Largo'+k).val('');
				 	$('#ItemUnidad_Ancho'+k).val('');
				 	$('#ItemUnidad_Alto'+k).val('');
				 	$('#ItemUnidad_Volumen_Total'+k).val('');
				 	$('#ItemUnidad_Peso_Total'+k).val('');
				 	$('#ItemUnidad_Cod_Barras'+k).val('');
			  }
      }

		  $('#btn_save').show();
    }
  
  });



	var extensionesValidas = ".png, .jpeg, .jpg";
	var pesoPermitido = 1024;

	$("#valida_form").click(function() {
		
    var form = $("#item-unidad-form");
		var settings = form.data('settings') ;
		var soporte = $('#ItemUnidad_Foto').val();
		var valid_und = 1;
		var num_und = $('#ItemUnidad_num_und').val(); 

    //se muestran los div de las unidades a configurar
		for (t = 1; t <= num_und ; t++) {
			und    = $('#ItemUnidad_Unidad_'+t).val();
			cant   = $('#ItemUnidad_Cantidad'+t).val();
			largo  = $('#ItemUnidad_Largo'+t).val();
			ancho  = $('#ItemUnidad_Ancho'+t).val();
			alto   = $('#ItemUnidad_Alto'+t).val();
			volumen_tot = $('#ItemUnidad_Volumen_Total'+t).val();
			peso_tot 	= $('#ItemUnidad_Peso_Total'+t).val();
			
			if(und =="" || cant =="" || largo =="" || alto =="" || ancho =="" || volumen_tot =="" || peso_tot ==""){
				valid_und = 0;
				$('#error_und_'+t).html('La configuración para la unidad '+t+' no puede contener campos vacios.');
        $('#error_und_'+t).show();	
			}else{
				$('#error_und_'+t).html('');
        $('#error_und_'+t).hide();
			}
		}

		settings.submitting = true ;
		$.fn.yiiactiveform.validate(form, function(messages) {
		  if($.isEmptyObject(messages)) {
	      $.each(settings.attributes, function () {
	         $.fn.yiiactiveform.updateInput(this,messages,form); 
	      });
		      	
	      //se valida si el archivo cargado es valido (1)
	      valid_img = $('#valid_img').val();

	      if(valid_img == 1 && valid_und == 1){
        	//se envia el form
        	$('#btn_save').hide();
        	form.submit();
	      }else{
	      	settings.submitting = false ;	
	      }
		      
		  } else {
	      settings = form.data('settings'),
	      $.each(settings.attributes, function () {
	         $.fn.yiiactiveform.updateInput(this,messages,form); 
	      });
	      settings.submitting = false ;
		  }
		});
	});

	$("#ItemUnidad_Foto").change(function () {

    $('#error_sop').html('');
    $('#img').attr('src', '');
    $('#error_sop').html('');
    $('#error_sop').hide();

		if(validarExtension(this)) {
    	if(validarPeso(this)) {
    		verImagen(this);
    	}
		}  
	});


	// Validacion de extensiones permitidas
	function validarExtension(datos) {

		var ruta = datos.value;
		var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
		var extensionValida = extensionesValidas.indexOf(extension);

		if(extensionValida < 0) {

		 	$('#error_sop').html('La extensión no es válida (.'+ extension+'), Solo se admite (.png, .jpeg, .jpg)');
		 	$('#error_sop').show();
		 	$('#valid_img').val(0);
		 	return false;

		} else {

			return true;

		}
	}

	// Validacion de peso del fichero en kbs

	function validarPeso(datos) {

		if (datos.files && datos.files[0]) {

      var pesoFichero = datos.files[0].size/1024;

      if(pesoFichero > pesoPermitido) {

        $('#error_sop').html('El peso maximo permitido del fichero es: ' + pesoPermitido / 1024 + ' MB Su fichero tiene: '+ pesoFichero /1024 +' MB');
        $('#error_sop').show();
        $('#valid_img').val(0);
        return false;

      } else {

        return true;

      }
    }
	}

	// Vista preliminar de la imagen.

	function verImagen(datos) {

    if (datos.files && datos.files[0]) {

      var reader = new FileReader();

      reader.onload = function (e) {

        $('#img').attr('src', e.target.result);
        $('#valid_img').val(1);
      };

      reader.readAsDataURL(datos.files[0]);

    }
	}

  function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html("");
  }

  function calculo_volumen(unidad){

    var largo = $('#ItemUnidad_Largo'+unidad).val();
    var ancho = $('#ItemUnidad_Ancho'+unidad).val();
    var alto  = $('#ItemUnidad_Alto'+unidad).val();

    if(largo != "" && ancho != "" && alto != ""){
      var volumen = largo * ancho * alto;
      $('#ItemUnidad_Volumen_Total'+unidad).val(volumen);
    }else{
      $('#ItemUnidad_Volumen_Total'+unidad).val('');
    }
  }

});

</script>



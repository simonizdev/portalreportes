<?php
/* @var $this IDoctoController */
/* @var $model IDocto */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'idocto-form',
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
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Tipo_Docto', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Tipo_Docto'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IDocto[Id_Tipo_Docto]',
                    'id'=>'IDocto_Id_Tipo_Docto',
                    'data'=>$lista_tipos,
                    'value' => $model->Id_Tipo_Docto,
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
            <?php echo $form->error($model,'Fecha', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Fecha'); ?>
            <?php echo $form->textField($model,'Fecha', array('class' => 'form-control datepicker', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Referencia', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Referencia'); ?>
            <?php echo $form->textField($model,'Referencia', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div> 
</div>
<div class="row">
	<div class="col-sm-8">
        <div class="form-group">
        	<?php echo $form->hiddenField($model,'cad_item'); ?>
            <?php echo $form->hiddenField($model,'cad_bodega_origen'); ?>
            <?php echo $form->hiddenField($model,'cad_bodega_destino'); ?>
            <?php echo $form->hiddenField($model,'cad_cant'); ?>
            <?php echo $form->hiddenField($model,'cad_vlr'); ?>

            <?php echo $form->error($model,'Id_Tercero', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Tercero'); ?>
            <?php echo $form->textField($model,'Id_Tercero'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#IDocto_Id_Tercero',
                    'options'  => array(
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('iTercero/SearchTercero'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                   
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("IDocto_Id_Tercero"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'IDocto_Id_Tercero\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
        </div>
    </div>	
</div>
<div class="row" id="empleado" style="display: none;">
	<div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Emp', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Emp'); ?>
            <?php echo $form->textField($model,'Id_Emp'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#IDocto_Id_Emp',
                    'options'  => array(
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('iDocto/SearchEmpleado'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                   
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("IDocto_Id_Emp"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'IDocto_Id_Emp\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
        </div>
    </div>	
</div>
<div class="row" id="notas" style="display: none;">
	<div class="col-sm-8">
	    <div class="form-group">
	        <?php echo $form->error($model,'Notas', array('class' => 'pull-right badge bg-red')); ?>
	        <?php echo $form->label($model,'Notas'); ?>
	        <?php echo $form->textArea($model,'Notas',array('class' => 'form-control', 'rows'=>3, 'cols'=>50, 'onkeyup' => 'convert_may(this)', 'maxlength' => '200')); ?>
	    </div>
    </div>	
</div>

<div class="btn-group" style="padding-bottom: 2%" id="btn_volver">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
</div>

<div id="det_add" style="display: none;">
	<h3>Detalle de documento</h3>
	<div class="row">
	    <div class="col-sm-8">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_item', array('class' => 'pull-right badge bg-red')); ?>
	            <?php echo $form->label($model,'det_item'); ?>
	            <?php echo $form->textField($model,'det_item'); ?>
	            <?php
	                $this->widget('ext.select2.ESelect2', array(
	                    'selector' => '#IDocto_det_item',
	                    'options'  => array(
	                        'minimumInputLength' => 3,
	                        'width' => '100%',
	                        'language' => 'es',
	                        'ajax' => array(
	                            'url' => Yii::app()->createUrl('iItem/SearchItem'),
	                            'dataType'=>'json',
	                            'data'=>'js:function(term){return{q: term};}',
	                            'results'=>'js:function(data){ return {results:data};}'                
	                        ),
	                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("IDocto_det_item"); return "No se encontraron resultados"; }',
	                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'IDocto_det_item\')\">Limpiar campo</button>"; }',
	                    ),
	                ));
	                ?>
	        </div>
	    </div>
	    <div class="col-sm-4" id="bodega_origen">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_bodega_origen', array('class' => 'pull-right badge bg-red')); ?>
	            <?php echo $form->label($model,'det_bodega_origen'); ?>
	            <?php
	                $this->widget('ext.select2.ESelect2',array(
	                    'name'=>'IDocto[det_bodega_origen]',
	                    'id'=>'IDocto_det_bodega_origen',
	                    'data'=>$lista_bodegas,
	                    'value' => $model->det_bodega_origen,
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
	    <div class="col-sm-4" id="bodega_destino">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_bodega_destino', array('class' => 'pull-right badge bg-red')); ?>
	            <?php echo $form->label($model,'det_bodega_destino'); ?>
	            <?php
	                $this->widget('ext.select2.ESelect2',array(
	                    'name'=>'IDocto[det_bodega_destino]',
	                    'id'=>'IDocto_det_bodega_destino',
	                    'data'=>$lista_bodegas,
	                    'value' => $model->det_bodega_destino,
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
	    <div class="col-sm-4" id="bodega_origen_tr">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_bodega_tr_origen', array('class' => 'pull-right badge bg-red')); ?>
	            <?php echo $form->label($model,'det_bodega_tr_origen'); ?>
	            <?php
	                $this->widget('ext.select2.ESelect2',array(
	                    'name'=>'IDocto[det_bodega_tr_origen]',
	                    'id'=>'IDocto_det_bodega_tr_origen',
	                    'data'=>$lista_bodegas,
	                    'value' => $model->det_bodega_tr_origen,
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
	    <div class="col-sm-4" id="bodega_destino_tr">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_bodega_tr_destino', array('class' => 'pull-right badge bg-red')); ?>
	            <?php echo $form->label($model,'det_bodega_tr_destino'); ?>
	            <?php
	                $this->widget('ext.select2.ESelect2',array(
	                    'name'=>'IDocto[det_bodega_tr_destino]',
	                    'id'=>'IDocto_det_bodega_tr_destino',
	                    'value' => $model->det_bodega_tr_destino,
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
	            <?php echo $form->error($model,'det_cant', array('class' => 'pull-right badge bg-red')); ?>
	            <?php echo $form->label($model,'det_cant'); ?>
	            <?php echo $form->numberField($model,'det_cant', array('class' => 'form-control', 'autocomplete' => 'off','maxlength' => '250', 'min' => 1)); ?>
	        </div>
	    </div>
	    <div class="col-sm-4" id="valor">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_vlr', array('class' => 'pull-right badge bg-red')); ?>
	            <?php echo $form->label($model,'det_vlr'); ?>
	            <?php echo $form->numberField($model,'det_vlr', array('class' => 'form-control', 'autocomplete' => 'off','maxlength' => '250', 'min' => 1)); ?>
	        </div>
	    </div> 
	</div>
	<div class="pull-right badge bg-red" id="error_det" style="display: none;"></div>
	<div style="padding-bottom: 2%">
    	<button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    	<button type="button" class="btn btn-success" onclick="add_item();"><i class="fa fa-plus" ></i> Agregar registro</button>
	</div>
</div>

<div id="contenido">
    
</div>

<div class="btn-group" id="btn_save" style="padding-bottom: 2%;display: none;">
    <button type="submit" class="btn btn-success" onclick="return valida_opciones(event);"><i class="fa fa-floppy-o"></i> Guardar</button>
</div>


<?php $this->endWidget(); ?>

<script type="text/javascript">

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html(""); 
}

$('#IDocto_Id_Tipo_Docto').change(function() {

	var value = $(this).val();

	$('#IDocto_Id_Emp').val('').trigger('change');
    $('#s2id_IDocto_Id_Emp span').html("");

    $('#IDocto_Notas').val('');

	$('#IDocto_det_item').val('').trigger('change');
    $('#s2id_IDocto_det_item span').html("");

	$('#IDocto_det_bodega_origen').val('').trigger('change');
	$('#IDocto_det_bodega_destino').val('').trigger('change');

	$('#IDocto_det_bodega_tr_origen').val('').trigger('change');

	$('#IDocto_det_bodega_tr_destino').find('option').remove();
	$('#IDocto_det_bodega_tr_destino').val('').trigger('change');
	$("#IDocto_det_bodega_tr_destino").append('<option value=""></option>');
	$('#IDocto_det_bodega_tr_destino').val('').trigger('change');

	$('#IDocto_det_cant').val('');
	$('#IDocto_det_vlr').val('');

	if(value == ""){
		
		$('#btn_volver').show();
		$('#det_add').hide();
		$('#contenido').html('');
    	$('#btn_save').hide();
    	$('#error_det').html('');
		$('#error_det').hide();

	}else{
		
		$('#contenido').html('');
    	$('#btn_save').hide();
    	$('#error_det').html('');
		$('#error_det').hide();
		$('#btn_volver').hide();
		$('#det_add').show();

		if(value == <?php echo Yii::app()->params->ent; ?>){
			//entrada
			$('#empleado').hide();
			$('#notas').hide();
			$('#bodega_origen').hide();
			$('#bodega_destino').show();
			$('#bodega_origen_tr').hide();
			$('#bodega_destino_tr').hide();
			$('#valor').show();
		}

		if(value == <?php echo Yii::app()->params->sal; ?>){
			//salida
			$('#empleado').hide();
			$('#notas').hide();
			$('#bodega_origen').show();
			$('#bodega_destino').hide();
			$('#bodega_origen_tr').hide();
			$('#bodega_destino_tr').hide();
			$('#valor').hide();
		}

		if(value == <?php echo Yii::app()->params->trb; ?>){
			//transferencia
			$('#empleado').hide();
			$('#notas').hide();
			$('#bodega_origen').hide();
			$('#bodega_destino').hide();
			$('#bodega_origen_tr').show();
			$('#bodega_destino_tr').show();
			$('#valor').hide();
		}

		if(value == <?php echo Yii::app()->params->aje; ?>){
			//ajuste entrada
			$('#empleado').hide();
			$('#notas').show();
			$('#bodega_origen').hide();
			$('#bodega_destino').show();
			$('#bodega_origen_tr').hide();
			$('#bodega_destino_tr').hide();
			$('#valor').hide();
		}

		if(value == <?php echo Yii::app()->params->ajs; ?>){
			//ajuste salida
			$('#empleado').hide();
			$('#notas').show();
			$('#bodega_origen').show();
			$('#bodega_destino').hide();
			$('#bodega_origen_tr').hide();
			$('#bodega_destino_tr').hide();
			$('#valor').hide();
		}

		if(value == <?php echo Yii::app()->params->sad; ?>){
			//salida de dotación
			$('#empleado').show();
			$('#notas').hide();
			$('#bodega_origen').show();
			$('#bodega_destino').hide();
			$('#bodega_origen_tr').hide();
			$('#bodega_destino_tr').hide();
			$('#valor').hide();
		}

		if(value == <?php echo Yii::app()->params->dev; ?>){
			//devolución
			$('#empleado').hide();
			$('#notas').hide();
			$('#bodega_origen').hide();
			$('#bodega_destino').show();
			$('#bodega_origen_tr').hide();
			$('#bodega_destino_tr').hide();
			$('#valor').hide();
		}
	}
   
});

function add_item(){

	//cabecera
	var tipo = $('#IDocto_Id_Tipo_Docto').val();
	var fecha = $('#IDocto_Fecha').val();
	var ref = $('#IDocto_Referencia').val();
	var tercero = $('#IDocto_Id_Tercero').val();
	var empleado = $('#IDocto_Id_Emp').val();
	var notas = $('#IDocto_Notas').val();

	//detalle
	var item = $('#IDocto_det_item').val();
	var item_desc =$('#s2id_IDocto_det_item span').html();
	
	var bodega_origen = $('#IDocto_det_bodega_origen').val();
	var bodega_origen_desc =$('#s2id_IDocto_det_bodega_origen span').html();

	var bodega_destino = $('#IDocto_det_bodega_destino').val();
	var bodega_destino_desc =$('#s2id_IDocto_det_bodega_destino span').html();
	
	var bodega_origen_tr = $('#IDocto_det_bodega_tr_origen').val();
	var bodega_origen_tr_desc =$('#s2id_IDocto_det_bodega_tr_origen span').html();

	var bodega_destino_tr = $('#IDocto_det_bodega_tr_destino').val();
	var bodega_destino_tr_desc =$('#s2id_IDocto_det_bodega_tr_destino span').html();
	
	var cant = $('#IDocto_det_cant').val();
	var vlr = $('#IDocto_det_vlr').val();

	if(tipo == <?php echo Yii::app()->params->ent; ?>){
		//entrada
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_destino != "" && cant != "" && vlr != ""){

			var cont = $(".det_item").length;

			var div_contenido = $('#contenido');

			var id_div = item+'_'+bodega_destino;

			//se verifica si existe un detalle identico
			if ($("#"+id_div).length) {

				$('#error_det').html('Ya existe un detalle con la misma combinación (Item - Bodega destino)');
				$('#error_det').show();

	        }else{

	        	$('#error_det').html('');
				$('#error_det').hide();

	        	num_f = cont + 1;

	            $('#btn_save').show();  
	            div_contenido.append('<div class="row det_item" style="padding-bottom:10px;" id="'+item+'_'+bodega_destino+'"><label class="col-sm-1 control-label">Item</label><div class="col-sm-2"><input type="hidden" class="item" value="'+num_f+'"><input type="hidden" id="item_'+num_f+'" value="'+item+'"><input class="form-control input-sm" name="item[]" value="'+item_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. destino</label><div class="col-sm-2"><input type="hidden" id="bodega_destino_'+num_f+'" value="'+bodega_destino+'"><input class="form-control input-sm" name="bodega_destino[]" value="'+bodega_destino_desc+'" readonly></div><label class="col-sm-1 control-label">Cantidad</label><div class="col-sm-1"><input class="form-control input-sm" id="cant_'+num_f+'" value="'+cant+'" readonly></div><label class="col-sm-1 control-label">Vlr. unit.</label><div class="col-sm-2"><input class="form-control input-sm" id="vlr_'+num_f+'" value="'+vlr+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	            
	            //se resetean los campos para seguir recibiendo detalles
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $('#IDocto_det_vlr').val('');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item no puede ser nulo.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDocto_det_bodega_destino_em_').html('Bodega destino no puede ser nulo.');
	            $('#IDocto_det_bodega_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad no puede ser nulo.');
	            $('#IDocto_det_cant_em_').show();    
	        }
	        if(vlr == ""){
	            $('#IDocto_det_vlr_em_').html('Vlr. unitario no puede ser nulo.');
	            $('#IDocto_det_vlr_em_').show();    
	        }  
		}

	}

	if(tipo == <?php echo Yii::app()->params->sal; ?>){
		//salida
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_origen != "" && cant != ""){
			
			var cont = $(".det_item").length;

			var div_contenido = $('#contenido');

			var id_div = item+'_'+bodega_origen;

			//se verifica si existe un detalle identico
			if ($("#"+id_div).length) {

				$('#error_det').html('Ya existe un detalle con la misma combinación (Item - Bodega origen)');
				$('#error_det').show();

	        }else{

	        	$('#error_det').html('');
				$('#error_det').hide();

	        	num_f = cont + 1;

	            $('#btn_save').show();  
	            div_contenido.append('<div class="row det_item" style="padding-bottom:10px;" id="'+item+'_'+bodega_origen+'"><label class="col-sm-1 control-label">Item</label><div class="col-sm-3"><input type="hidden" class="item" value="'+num_f+'"><input type="hidden" id="item_'+num_f+'" value="'+item+'"><input class="form-control input-sm" name="item[]" value="'+item_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. origen</label><div class="col-sm-3"><input type="hidden" id="bodega_origen_'+num_f+'" value="'+bodega_origen+'"><input class="form-control input-sm" name="bodega_origen[]" value="'+bodega_origen_desc+'" readonly></div><label class="col-sm-1 control-label">Cantidad</label><div class="col-sm-1"><input class="form-control input-sm" id="cant_'+num_f+'" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	            
	            //se resetean los campos para seguir recibiendo detalles
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_origen').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item no puede ser nulo.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDocto_det_bodega_origen_em_').html('Bodega origen no puede ser nulo.');
	            $('#IDocto_det_bodega_origen_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad no puede ser nulo.');
	            $('#IDocto_det_cant_em_').show();    
	        }
		}

	}

	if(tipo == <?php echo Yii::app()->params->trb; ?>){
		//transferencia
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_origen_tr != "" && bodega_destino_tr != "" && cant != ""){
			
			var cont = $(".det_item").length;

			var div_contenido = $('#contenido');

			var id_div = item+'_'+bodega_origen_tr+'_'+bodega_destino_tr;

			//se verifica si existe un detalle identico
			if ($("#"+id_div).length) {

				$('#error_det').html('Ya existe un detalle con la misma combinación (Item - Bodega origen - Bodega destino)');
				$('#error_det').show();

	        }else{

	        	$('#error_det').html('');
				$('#error_det').hide();

	        	num_f = cont + 1;

	            $('#btn_save').show();  
	            div_contenido.append('<div class="row det_item" style="padding-bottom:10px;" id="'+item+'_'+bodega_origen_tr+'_'+bodega_destino_tr+'"><label class="col-sm-1 control-label">Item</label><div class="col-sm-2"><input type="hidden" class="item" value="'+num_f+'"><input type="hidden" id="item_'+num_f+'" value="'+item+'"><input class="form-control input-sm" name="item[]" value="'+item_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. origen</label><div class="col-sm-2"><input type="hidden" id="bodega_origen_tr_'+num_f+'" value="'+bodega_origen_tr+'"><input class="form-control input-sm" name="bodega_origen_tr[]" value="'+bodega_origen_tr_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. destino</label><div class="col-sm-2"><input type="hidden" id="bodega_destino_tr_'+num_f+'" value="'+bodega_destino_tr+'"><input class="form-control input-sm" name="bodega_destino_tr[]" value="'+bodega_destino_tr_desc+'" readonly></div><label class="col-sm-1 control-label">Cantidad</label><div class="col-sm-1"><input class="form-control input-sm" id="cant_'+num_f+'" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	            
	            //se resetean los campos para seguir recibiendo detalles
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_tr_origen').val('').trigger('change');
	            $('#IDocto_det_bodega_tr_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item no puede ser nulo.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen_tr == ""){
	            $('#IDocto_det_bodega_tr_origen_em_').html('Bodega origen no puede ser nulo.');
	            $('#IDocto_det_bodega_tr_origen_em_').show();    
	        }
	        if(bodega_destino_tr == ""){
	            $('#IDocto_det_bodega_tr_destino_em_').html('Bodega destino no puede ser nulo.');
	            $('#IDocto_det_bodega_tr_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad no puede ser nulo.');
	            $('#IDocto_det_cant_em_').show();    
	        }
		}

	}

	if(tipo == <?php echo Yii::app()->params->aje; ?>){
		//ajuste entrada
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_destino != "" && cant != "" && notas != ""){

			var cont = $(".det_item").length;

			var div_contenido = $('#contenido');

			var id_div = item+'_'+bodega_destino;

			//se verifica si existe un detalle identico
			if ($("#"+id_div).length) {

				$('#error_det').html('Ya existe un detalle con la misma combinación (Item - Bodega destino)');
				$('#error_det').show();

	        }else{

	        	$('#error_det').html('');
				$('#error_det').hide();

	        	num_f = cont + 1;

	            $('#btn_save').show();  
	            div_contenido.append('<div class="row det_item" style="padding-bottom:10px;" id="'+item+'_'+bodega_destino+'"><label class="col-sm-1 control-label">Item</label><div class="col-sm-3"><input type="hidden" class="item" value="'+num_f+'"><input type="hidden" id="item_'+num_f+'" value="'+item+'"><input class="form-control input-sm" name="item[]" value="'+item_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. destino</label><div class="col-sm-3"><input type="hidden" id="bodega_destino_'+num_f+'" value="'+bodega_destino+'"><input class="form-control input-sm" name="bodega_destino[]" value="'+bodega_destino_desc+'" readonly></div><label class="col-sm-1 control-label">Cantidad</label><div class="col-sm-1"><input class="form-control input-sm" id="cant_'+num_f+'" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	            
	            //se resetean los campos para seguir recibiendo detalles
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $('#IDocto_det_vlr').val('');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item no puede ser nulo.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDocto_det_bodega_destino_em_').html('Bodega destino no puede ser nulo.');
	            $('#IDocto_det_bodega_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad no puede ser nulo.');
	            $('#IDocto_det_cant_em_').show();    
	        } 
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas no puede ser nulo.');
	            $('#IDocto_Notas_em_').show();    
	        } 

		}

	}

	if(tipo == <?php echo Yii::app()->params->ajs; ?>){
		//ajuste salida
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_origen != "" && cant != ""  && notas != ""){
			
			var cont = $(".det_item").length;

			var div_contenido = $('#contenido');

			var id_div = item+'_'+bodega_origen;

			//se verifica si existe un detalle identico
			if ($("#"+id_div).length) {

				$('#error_det').html('Ya existe un detalle con la misma combinación (Item - Bodega origen)');
				$('#error_det').show();

	        }else{

	        	$('#error_det').html('');
				$('#error_det').hide();

	        	num_f = cont + 1;

	            $('#btn_save').show();  
	            div_contenido.append('<div class="row det_item" style="padding-bottom:10px;" id="'+item+'_'+bodega_origen+'"><label class="col-sm-1 control-label">Item</label><div class="col-sm-3"><input type="hidden" class="item" value="'+num_f+'"><input type="hidden" id="item_'+num_f+'" value="'+item+'"><input class="form-control input-sm" name="item[]" value="'+item_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. origen</label><div class="col-sm-3"><input type="hidden" id="bodega_origen_'+num_f+'" value="'+bodega_origen+'"><input class="form-control input-sm" name="bodega_origen[]" value="'+bodega_origen_desc+'" readonly></div><label class="col-sm-1 control-label">Cantidad</label><div class="col-sm-1"><input class="form-control input-sm" id="cant_'+num_f+'" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	            
	            //se resetean los campos para seguir recibiendo detalles
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_origen').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item no puede ser nulo.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDocto_det_bodega_origen_em_').html('Bodega origen no puede ser nulo.');
	            $('#IDocto_det_bodega_origen_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad no puede ser nulo.');
	            $('#IDocto_det_cant_em_').show();    
	        }
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas no puede ser nulo.');
	            $('#IDocto_Notas_em_').show();    
	        }
		}
	}

	if(tipo == <?php echo Yii::app()->params->sad; ?>){
		//salida de dotación 
		if( tipo != "" && fecha != "" && ref != "" && tercero != ""  && empleado != "" && item != "" && bodega_origen != "" && cant != ""){
			
			var cont = $(".det_item").length;

			var div_contenido = $('#contenido');

			var id_div = item+'_'+bodega_origen;

			//se verifica si existe un detalle identico
			if ($("#"+id_div).length) {

				$('#error_det').html('Ya existe un detalle con la misma combinación (Item - Bodega origen)');
				$('#error_det').show();

	        }else{

	        	$('#error_det').html('');
				$('#error_det').hide();

	        	num_f = cont + 1;

	            $('#btn_save').show();  
	            div_contenido.append('<div class="row det_item" style="padding-bottom:10px;" id="'+item+'_'+bodega_origen+'"><label class="col-sm-1 control-label">Item</label><div class="col-sm-3"><input type="hidden" class="item" value="'+num_f+'"><input type="hidden" id="item_'+num_f+'" value="'+item+'"><input class="form-control input-sm" name="item[]" value="'+item_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. origen</label><div class="col-sm-3"><input type="hidden" id="bodega_origen_'+num_f+'" value="'+bodega_origen+'"><input class="form-control input-sm" name="bodega_origen[]" value="'+bodega_origen_desc+'" readonly></div><label class="col-sm-1 control-label">Cantidad</label><div class="col-sm-1"><input class="form-control input-sm" id="cant_'+num_f+'" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	            
	            //se resetean los campos para seguir recibiendo detalles
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_origen').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(empleado == ""){
	            $('#IDocto_Id_Emp_em_').html('Empleado no puede ser nulo.');
	            $('#IDocto_Id_Emp_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item no puede ser nulo.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDocto_det_bodega_origen_em_').html('Bodega origen no puede ser nulo.');
	            $('#IDocto_det_bodega_origen_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad no puede ser nulo.');
	            $('#IDocto_det_cant_em_').show();    
	        }
		}

	}

	if(tipo == <?php echo Yii::app()->params->dev; ?>){
		//devolución
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_destino != "" && cant != ""){

			var cont = $(".det_item").length;

			var div_contenido = $('#contenido');

			var id_div = item+'_'+bodega_destino;

			//se verifica si existe un detalle identico
			if ($("#"+id_div).length) {

				$('#error_det').html('Ya existe un detalle con la misma combinación (Item - Bodega destino)');
				$('#error_det').show();

	        }else{

	        	$('#error_det').html('');
				$('#error_det').hide();

	        	num_f = cont + 1;

	            $('#btn_save').show();  
	            div_contenido.append('<div class="row det_item" style="padding-bottom:10px;" id="'+item+'_'+bodega_destino+'"><label class="col-sm-1 control-label">Item</label><div class="col-sm-3"><input type="hidden" class="item" value="'+num_f+'"><input type="hidden" id="item_'+num_f+'" value="'+item+'"><input class="form-control input-sm" name="item[]" value="'+item_desc+'" readonly></div><label class="col-sm-1 control-label">Bod. destino</label><div class="col-sm-3"><input type="hidden" id="bodega_destino_'+num_f+'" value="'+bodega_destino+'"><input class="form-control input-sm" name="bodega_destino[]" value="'+bodega_destino_desc+'" readonly></div><label class="col-sm-1 control-label">Cantidad</label><div class="col-sm-1"><input class="form-control input-sm" id="cant_'+num_f+'" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	            
	            //se resetean los campos para seguir recibiendo detalles
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $('#IDocto_det_vlr').val('');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item no puede ser nulo.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDocto_det_bodega_destino_em_').html('Bodega destino no puede ser nulo.');
	            $('#IDocto_det_bodega_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad no puede ser nulo.');
	            $('#IDocto_det_cant_em_').show();    
	        } 
		}

	}

}

$("#IDocto_det_bodega_tr_origen").change( function (){

	bod = $(this).val();
	
	$('#IDocto_det_bodega_tr_destino').find('option').remove();
	$('#IDocto_det_bodega_tr_destino').val('').trigger('change');
	$("#IDocto_det_bodega_tr_destino").append('<option value=""></option>');
	$('#IDocto_det_bodega_tr_destino').val('').trigger('change');

	if(bod != ""){

	 	$("#IDocto_det_bodega_tr_origen option").each(function(name, val) { 
	 	
	 		opt_val = val.value;
			opt_text = val.text;

			if(bod != opt_val && opt_val !=  ""){
				$("#IDocto_det_bodega_tr_destino").append('<option value='+opt_val+'>'+opt_text+'</option>');
			}

 	 	});

	}
   
});

$("body").on("click", ".delete", function (e) {
    $(this).parent().parent("div").remove();
    var cant = $(".det_item").length;
    if(cant == 0){
        $('#btn_save').hide();  
    }else{
        $('#btn_save').show();  
    }
});

function valida_opciones(){

	//cabecera
	var tipo = $('#IDocto_Id_Tipo_Docto').val();
	var fecha = $('#IDocto_Fecha').val();
	var ref = $('#IDocto_Referencia').val();
	var tercero = $('#IDocto_Id_Tercero').val();
	var empleado = $('#IDocto_Id_Emp').val();
	var notas = $('#IDocto_Notas').val();

    $('#IDocto_cad_item').val('');
    $('#IDocto_cad_bodega_origen').val('');
    $('#IDocto_cad_bodega_destino').val('');
    $('#IDocto_cad_cant').val('');
    $('#IDocto_cad_vlr').val('');

    var item_selected = '';
    var bodega_origen_selected = ''; 
    var bodega_destino_selected = ''; 
    var cant_selected = ''; 
    var vlr_selected = '';

    if(tipo == <?php echo Yii::app()->params->ent; ?>){
    	//entrada
    	
    	if(tipo == "" && fecha == "" || ref == "" || tercero == ""){

    		if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$(".ajax-loader").fadeIn('fast');
			$('#btn_save').hide();
			$('#error_det').html('');
			$('#error_det').hide();

	    	$("input.item[type=hidden]").each(function() {

		            f = $(this).val();
		            
		            item = $('#item_'+f).val();
		            bodega = $('#bodega_destino_'+f).val();
		            cant = $('#cant_'+f).val();
		            vlr = $('#vlr_'+f).val();
		            
		            item_selected += item+",";
		            bodega_destino_selected += bodega+",";
		            cant_selected += cant+","; 
		            vlr_selected += vlr+",";         

		    });

		    var cadena_item = item_selected.slice(0,-1);
		    var cadena_bodega_destino = bodega_destino_selected.slice(0,-1);
		    var cadena_cant = cant_selected.slice(0,-1);
		    var cadena_vlr = vlr_selected.slice(0,-1);

		    $('#IDocto_cad_item').val(cadena_item);
		    $('#IDocto_cad_bodega_destino').val(cadena_bodega_destino);
		    $('#IDocto_cad_cant').val(cadena_cant);
		    $('#IDocto_cad_vlr').val(cadena_vlr);

		    return true;
		}

    }

    if(tipo == <?php echo Yii::app()->params->sal; ?>){
    	//salida

    	if(tipo == "" && fecha == "" || ref == "" || tercero == ""){

    		if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$(".ajax-loader").fadeIn('fast');
			$('#btn_save').hide();
			$('#error_det').html('');
			$('#error_det').hide();

	    	$("input.item[type=hidden]").each(function() {

		            f = $(this).val();
		            
		            item = $('#item_'+f).val();
		            bodega = $('#bodega_origen_'+f).val();
		            cant = $('#cant_'+f).val();
		            
		            item_selected += item+",";
		            bodega_origen_selected += bodega+",";
		            cant_selected += cant+","; 

		    });

		    var cadena_item = item_selected.slice(0,-1);
		    var cadena_bodega_origen = bodega_origen_selected.slice(0,-1);
		    var cadena_cant = cant_selected.slice(0,-1);

		    $('#IDocto_cad_item').val(cadena_item);
		    $('#IDocto_cad_bodega_origen').val(cadena_bodega_origen);
		    $('#IDocto_cad_cant').val(cadena_cant);

		    return true;
		}

    }

    if(tipo == <?php echo Yii::app()->params->trb; ?>){
    	//transferencia

    	if(tipo == "" && fecha == "" || ref == "" || tercero == ""){

    		if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$(".ajax-loader").fadeIn('fast');
			$('#btn_save').hide();
			$('#error_det').html('');
			$('#error_det').hide();

	    	$("input.item[type=hidden]").each(function() {

		            f = $(this).val();
		            
		            item = $('#item_'+f).val();
		            bodega_origen_tr = $('#bodega_origen_tr_'+f).val();
		            bodega_destino_tr = $('#bodega_destino_tr_'+f).val();
		            cant = $('#cant_'+f).val();
		            
		            item_selected += item+",";
		            bodega_origen_selected += bodega_origen_tr+",";
		            bodega_destino_selected += bodega_destino_tr+",";
		            cant_selected += cant+","; 

		    });

		    var cadena_item = item_selected.slice(0,-1);
		    var cadena_bodega_origen = bodega_origen_selected.slice(0,-1);
		    var cadena_bodega_destino = bodega_destino_selected.slice(0,-1);
		    var cadena_cant = cant_selected.slice(0,-1);

		    $('#IDocto_cad_item').val(cadena_item);
		    $('#IDocto_cad_bodega_origen').val(cadena_bodega_origen);
		    $('#IDocto_cad_bodega_destino').val(cadena_bodega_destino);
		    $('#IDocto_cad_cant').val(cadena_cant);

		    return true;
		}

    }

    if(tipo == <?php echo Yii::app()->params->aje; ?>){
    	//ajuste entrada

    	if(tipo == "" && fecha == "" || ref == "" || tercero == "" || notas == ""){

    		if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas no puede ser nulo.');
	            $('#IDocto_Notas_em_').show();    
	        }
	      
	    	return false;

		}else{

			$(".ajax-loader").fadeIn('fast');
			$('#btn_save').hide();
			$('#error_det').html('');
			$('#error_det').hide();

	    	$("input.item[type=hidden]").each(function() {

		            f = $(this).val();
		            
		            item = $('#item_'+f).val();
		            bodega = $('#bodega_destino_'+f).val();
		            cant = $('#cant_'+f).val();
		            
		            item_selected += item+",";
		            bodega_destino_selected += bodega+",";
		            cant_selected += cant+","; 

		    });

		    var cadena_item = item_selected.slice(0,-1);
		    var cadena_bodega_destino = bodega_destino_selected.slice(0,-1);
		    var cadena_cant = cant_selected.slice(0,-1);

		    $('#IDocto_cad_item').val(cadena_item);
		    $('#IDocto_cad_bodega_destino').val(cadena_bodega_destino);
		    $('#IDocto_cad_cant').val(cadena_cant);

		    return true;
		}

    }

    if(tipo == <?php echo Yii::app()->params->ajs; ?>){
    	//ajuste salida

    	if(tipo == "" && fecha == "" || ref == "" || tercero == "" || notas == ""){

    		if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas no puede ser nulo.');
	            $('#IDocto_Notas_em_').show();    
	        }
	      
	    	return false;

		}else{

			$(".ajax-loader").fadeIn('fast');
			$('#btn_save').hide();
			$('#error_det').html('');
			$('#error_det').hide();

	    	$("input.item[type=hidden]").each(function() {

		            f = $(this).val();
		            
		            item = $('#item_'+f).val();
		            bodega = $('#bodega_origen_'+f).val();
		            cant = $('#cant_'+f).val();
		            
		            item_selected += item+",";
		            bodega_origen_selected += bodega+",";
		            cant_selected += cant+","; 

		    });

		    var cadena_item = item_selected.slice(0,-1);
		    var cadena_bodega_origen = bodega_origen_selected.slice(0,-1);
		    var cadena_cant = cant_selected.slice(0,-1);

		    $('#IDocto_cad_item').val(cadena_item);
		    $('#IDocto_cad_bodega_origen').val(cadena_bodega_origen);
		    $('#IDocto_cad_cant').val(cadena_cant);

		    return true;

		}

    }


    if(tipo == <?php echo Yii::app()->params->sad; ?>){
    	//salida de dotación

    	if(tipo == "" || fecha == "" || ref == "" || tercero == "" || empleado == ""){

    		if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(empleado == ""){
	            $('#IDocto_Id_Emp_em_').html('Empleado no puede ser nulo.');
	            $('#IDocto_Id_Emp_em_').show(); 
	        }

	        return false;

    	}else{

    		$(".ajax-loader").fadeIn('fast');
			$('#btn_save').hide();
			$('#error_det').html('');
			$('#error_det').hide();

    		$("input.item[type=hidden]").each(function() {

	            f = $(this).val();
	            
	            item = $('#item_'+f).val();
	            bodega = $('#bodega_origen_'+f).val();
	            cant = $('#cant_'+f).val();
	            
	            item_selected += item+",";
	            bodega_origen_selected += bodega+",";
	            cant_selected += cant+","; 

		    });

		    var cadena_item = item_selected.slice(0,-1);
		    var cadena_bodega_origen = bodega_origen_selected.slice(0,-1);
		    var cadena_cant = cant_selected.slice(0,-1);

		    $('#IDocto_cad_item').val(cadena_item);
		    $('#IDocto_cad_bodega_origen').val(cadena_bodega_origen);
		    $('#IDocto_cad_cant').val(cadena_cant);

		    return true;

    	}

    }

    if(tipo == <?php echo Yii::app()->params->dev; ?>){
    	//devolución

    	if(tipo == "" && fecha == "" || ref == "" || tercero == ""){

    		if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo no puede ser nulo.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha no puede ser nulo.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia no puede ser nulo.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero no puede ser nulo.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$(".ajax-loader").fadeIn('fast');
			$('#btn_save').hide();
			$('#error_det').html('');
			$('#error_det').hide();

	    	$("input.item[type=hidden]").each(function() {

		            f = $(this).val();
		            
		            item = $('#item_'+f).val();
		            bodega = $('#bodega_destino_'+f).val();
		            cant = $('#cant_'+f).val();
		            
		            item_selected += item+",";
		            bodega_destino_selected += bodega+",";
		            cant_selected += cant+","; 

		    });

		    var cadena_item = item_selected.slice(0,-1);
		    var cadena_bodega_destino = bodega_destino_selected.slice(0,-1);
		    var cadena_cant = cant_selected.slice(0,-1);

		    $('#IDocto_cad_item').val(cadena_item);
		    $('#IDocto_cad_bodega_destino').val(cadena_bodega_destino);
		    $('#IDocto_cad_cant').val(cadena_cant);

		    return true;
		}

    }
       
}

</script>

<style type="text/css">
    
    .item{
        padding-bottom: 10px;
    }

</style>

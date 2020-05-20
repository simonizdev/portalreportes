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

<div id="div_mensaje" style="display: none;">
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Tipo_Docto', array('class' => 'badge badge-warning float-right')); ?>
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
            <?php echo $form->error($model,'Fecha', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Fecha'); ?>
            <?php echo $form->textField($model,'Fecha', array('class' => 'form-control form-control-sm datepicker', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Referencia', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Referencia'); ?>
            <?php echo $form->textField($model,'Referencia', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
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

            <?php echo $form->error($model,'Id_Tercero', array('class' => 'badge badge-warning float-right')); ?>
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
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'IDocto_Id_Tercero\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
        </div>
    </div>	
</div>
<div class="row" id="empleado" style="display: none;">
	<div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Emp', array('class' => 'badge badge-warning float-right')); ?>
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
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'IDocto_Id_Emp\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
        </div>
    </div>	
</div>
<div class="row" id="notas" style="display: none;">
	<div class="col-sm-8">
	    <div class="form-group">
	        <?php echo $form->error($model,'Notas', array('class' => 'badge badge-warning float-right')); ?>
	        <?php echo $form->label($model,'Notas'); ?>
	        <?php echo $form->textArea($model,'Notas',array('class' => 'form-control form-control-sm', 'rows'=>3, 'cols'=>50, 'onkeyup' => 'convert_may(this)', 'maxlength' => '200')); ?>
	    </div>
    </div>	
</div>

<div class="row mb-2" id="btn_volver">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    </div>
</div>

<div id="det_add" style="display: none;">
	<h5>Detalle</h5>
	<div class="row">
	    <div class="col-sm-8">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_item', array('class' => 'badge badge-warning float-right')); ?>
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
	                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'IDocto_det_item\')\">Limpiar campo</button>"; }',
	                    ),
	                ));
	                ?>
	        </div>
	    </div>
	    <div class="col-sm-4" id="bodega_origen">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_bodega_origen', array('class' => 'badge badge-warning float-right')); ?>
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
	            <?php echo $form->error($model,'det_bodega_destino', array('class' => 'badge badge-warning float-right')); ?>
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
	            <?php echo $form->error($model,'det_bodega_tr_origen', array('class' => 'badge badge-warning float-right')); ?>
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
	            <?php echo $form->error($model,'det_bodega_tr_destino', array('class' => 'badge badge-warning float-right')); ?>
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
	            <?php echo $form->error($model,'det_cant', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->label($model,'det_cant'); ?>
	            <?php echo $form->numberField($model,'det_cant', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off','maxlength' => '250', 'min' => 1)); ?>
	        </div>
	    </div>
	    <div class="col-sm-4" id="valor">
	        <div class="form-group">
	            <?php echo $form->error($model,'det_vlr', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->label($model,'det_vlr'); ?>
	            <?php echo $form->numberField($model,'det_vlr', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off','maxlength' => '250', 'min' => 1)); ?>
	        </div>
	    </div> 
	</div>
	
	<div class="row mb-4">
	    <div class="col-sm-6">  
	        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
	        <button type="button" class="btn btn-success btn-sm" onclick="add_item();"><i class="fa fa-plus" ></i> Agregar registro</button>
	    </div>
	</div>

</div>

<div id="contenido"></div>

<div class="row mb-2" id="btn_save" style="display: none;">
    <div class="col-sm-6">  
        <button type="submit" class="btn btn-success btn-sm" onclick="return valida_opciones(event);"><i class="fas fa-save"></i> Guardar</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

$(function() {

	$('form').keypress(function(e){   
	  if(e == 13){
	      return false;
	  }
	});

	$('input').keypress(function(e){
	  if(e.which == 13){
	      return false;
	  }
	});


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

});

function add_item(){

	limp_div_msg();

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

			$(".ajax-loader").fadeIn('fast');

	        var div_contenido = $('#contenido');

	        var i = item+'_'+bodega_destino;
	        var tr = $("#tr_"+i).length;

	        if(!tr){
			
				var cant_f = $(".tr_items").length;

	            if(cant_f == 0){
	                div_contenido.append('<table class="table table-sm table-hover" id="table_items"><thead><tr><th>Item</th><th>Bodega destino</th><th>Cantidad</th><th>Vlr. unitario</th><th></th></tr></thead><tbody></tbody></table>');
	            }

	            var tabla = $('#table_items');

				tabla.append('<tr class="tr_items" id="tr_'+i+'"><td><input type="hidden" class="items" value="'+i+'"><input type="hidden" id="item_'+i+'" value="'+item+'"><p>'+item_desc+'</p></td><td><input type="hidden" id="bodega_destino_'+i+'" value="'+bodega_destino+'"><p>'+bodega_destino_desc+'</p></td><td align="right"><input type="hidden" id="cant_'+i+'" value="'+cant+'"><p>'+cant+'</p></td><td align="right"><input type="hidden" id="vlr_'+i+'" value="'+vlr+'"><p>'+formatNumber(vlr)+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

	            //se resetean los campos para seguir recibiendo detalles
	            $('#btn_save').show(); 
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $('#IDocto_det_vlr').val('');
	            $(".ajax-loader").fadeOut('fast');

	        }else{
	        	$('html, body').animate({scrollTop:0}, 'fast');
	            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
	            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega destino).');	
	            $("#div_mensaje").fadeIn('fast');
	            $(".ajax-loader").fadeOut('fast');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item es requerido.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDocto_det_bodega_destino_em_').html('Bodega destino es requerido.');
	            $('#IDocto_det_bodega_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad es requerido.');
	            $('#IDocto_det_cant_em_').show();    
	        }
	        if(vlr == ""){
	            $('#IDocto_det_vlr_em_').html('Vlr. unitario es requerido.');
	            $('#IDocto_det_vlr_em_').show();    
	        }  
		}

	}

	if(tipo == <?php echo Yii::app()->params->sal; ?>){
		//salida
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_origen != "" && cant != ""){

			$(".ajax-loader").fadeIn('fast');

	        var div_contenido = $('#contenido');

	        var i = item+'_'+bodega_origen;
	        var tr = $("#tr_"+i).length;

	        if(!tr){
			
				var cant_f = $(".tr_items").length;

	            if(cant_f == 0){
	                div_contenido.append('<table class="table table-sm table-hover" id="table_items"><thead><tr><th>Item</th><th>Bodega origen</th><th>Cantidad</th><th></th></tr></thead><tbody></tbody></table>');
	            }

	            var tabla = $('#table_items');

				tabla.append('<tr class="tr_items" id="tr_'+i+'"><td><input type="hidden" class="items" value="'+i+'"><input type="hidden" id="item_'+i+'" value="'+item+'"><p>'+item_desc+'</p></td><td><input type="hidden" id="bodega_origen_'+i+'" value="'+bodega_origen+'"><p>'+bodega_origen_desc+'</p></td><td align="right"><input type="hidden" id="cant_'+i+'" value="'+cant+'"><p>'+cant+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

	            //se resetean los campos para seguir recibiendo detalles
	            $('#btn_save').show(); 
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_origen').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $(".ajax-loader").fadeOut('fast');

	        }else{
	        	

	            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
	            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen).');	
	            $("#div_mensaje").fadeIn('fast');
	            $(".ajax-loader").fadeOut('fast');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item es requerido.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDocto_det_bodega_origen_em_').html('Bodega origen es requerido.');
	            $('#IDocto_det_bodega_origen_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad es requerido.');
	            $('#IDocto_det_cant_em_').show();    
	        }
		}

	}

	if(tipo == <?php echo Yii::app()->params->trb; ?>){
		//transferencia
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_origen_tr != "" && bodega_destino_tr != "" && cant != ""){
			
			$(".ajax-loader").fadeIn('fast');

	        var div_contenido = $('#contenido');

	        var i = item+'_'+bodega_origen_tr+'_'+bodega_destino_tr;
	        var tr = $("#tr_"+i).length;

	        if(!tr){
			
				var cant_f = $(".tr_items").length;

	            if(cant_f == 0){
	                div_contenido.append('<table class="table table-sm table-hover" id="table_items"><thead><tr><th>Item</th><th>Bodega origen</th><th>Bodega destino</th><th>Cantidad</th><th></th></tr></thead><tbody></tbody></table>');
	            }

	            var tabla = $('#table_items');

				tabla.append('<tr class="tr_items" id="tr_'+i+'"><td><input type="hidden" class="items" value="'+i+'"><input type="hidden" id="item_'+i+'" value="'+item+'"><p>'+item_desc+'</p></td><td><input type="hidden" id="bodega_origen_tr_'+i+'" value="'+bodega_origen_tr+'"><p>'+bodega_origen_tr_desc+'</p></td><td><input type="hidden" id="bodega_destino_tr_'+i+'" value="'+bodega_destino_tr+'"><p>'+bodega_destino_tr_desc+'</p></td><td align="right"><input type="hidden" id="cant_'+i+'" value="'+cant+'"><p>'+cant+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

	            //se resetean los campos para seguir recibiendo detalles
	            $('#btn_save').show(); 
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_tr_origen').val('').trigger('change');
	            $('#IDocto_det_bodega_tr_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $(".ajax-loader").fadeOut('fast');

	        }else{
	        	$('html, body').animate({scrollTop:0}, 'fast');
	            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
	            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen - Bodega destino).');	
	            $("#div_mensaje").fadeIn('fast');
	            $(".ajax-loader").fadeOut('fast');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item es requerido.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen_tr == ""){
	            $('#IDocto_det_bodega_tr_origen_em_').html('Bodega origen es requerido.');
	            $('#IDocto_det_bodega_tr_origen_em_').show();    
	        }
	        if(bodega_destino_tr == ""){
	            $('#IDocto_det_bodega_tr_destino_em_').html('Bodega destino es requerido.');
	            $('#IDocto_det_bodega_tr_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad es requerido.');
	            $('#IDocto_det_cant_em_').show();    
	        }
		}

	}

	if(tipo == <?php echo Yii::app()->params->aje; ?>){
		//ajuste entrada
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_destino != "" && cant != "" && notas != ""){

			$(".ajax-loader").fadeIn('fast');

	        var div_contenido = $('#contenido');

	        var i = item+'_'+bodega_destino;
	        var tr = $("#tr_"+i).length;

	        if(!tr){
			
				var cant_f = $(".tr_items").length;

	            if(cant_f == 0){
	                div_contenido.append('<table class="table table-sm table-hover" id="table_items"><thead><tr><th>Item</th><th>Bodega destino</th><th>Cantidad</th><th></th></tr></thead><tbody></tbody></table>');
	            }

	            var tabla = $('#table_items');

				tabla.append('<tr class="tr_items" id="tr_'+i+'"><td><input type="hidden" class="items" value="'+i+'"><input type="hidden" id="item_'+i+'" value="'+item+'"><p>'+item_desc+'</p></td><td><input type="hidden" id="bodega_destino_'+i+'" value="'+bodega_destino+'"><p>'+bodega_destino_desc+'</p></td><td align="right"><input type="hidden" id="cant_'+i+'" value="'+cant+'"><p>'+cant+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

	            //se resetean los campos para seguir recibiendo detalles
	            $('#btn_save').show(); 
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $(".ajax-loader").fadeOut('fast');

	        }else{
	        	$('html, body').animate({scrollTop:0}, 'fast');
	            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
	            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega destino).');	
	            $("#div_mensaje").fadeIn('fast');
	            $(".ajax-loader").fadeOut('fast');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item es requerido.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDocto_det_bodega_destino_em_').html('Bodega destino es requerido.');
	            $('#IDocto_det_bodega_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad es requerido.');
	            $('#IDocto_det_cant_em_').show();    
	        } 
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas es requerido.');
	            $('#IDocto_Notas_em_').show();    
	        } 

		}

	}

	if(tipo == <?php echo Yii::app()->params->ajs; ?>){
		//ajuste salida
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_origen != "" && cant != ""  && notas != ""){
			
			$(".ajax-loader").fadeIn('fast');

	        var div_contenido = $('#contenido');

	        var i = item+'_'+bodega_origen;
	        var tr = $("#tr_"+i).length;

	        if(!tr){
			
				var cant_f = $(".tr_items").length;

	            if(cant_f == 0){
	                div_contenido.append('<table class="table table-sm table-hover" id="table_items"><thead><tr><th>Item</th><th>Bodega origen</th><th>Cantidad</th><th></th></tr></thead><tbody></tbody></table>');
	            }

	            var tabla = $('#table_items');

				tabla.append('<tr class="tr_items" id="tr_'+i+'"><td><input type="hidden" class="items" value="'+i+'"><input type="hidden" id="item_'+i+'" value="'+item+'"><p>'+item_desc+'</p></td><td><input type="hidden" id="bodega_origen_'+i+'" value="'+bodega_origen+'"><p>'+bodega_origen_desc+'</p></td><td align="right"><input type="hidden" id="cant_'+i+'" value="'+cant+'"><p>'+cant+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

	            //se resetean los campos para seguir recibiendo detalles
	            $('#btn_save').show(); 
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_origen').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $(".ajax-loader").fadeOut('fast');

	        }else{
	        	$('html, body').animate({scrollTop:0}, 'fast');
	            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
	            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen).');	
	            $("#div_mensaje").fadeIn('fast');
	            $(".ajax-loader").fadeOut('fast');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item es requerido.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDocto_det_bodega_origen_em_').html('Bodega origen es requerido.');
	            $('#IDocto_det_bodega_origen_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad es requerido.');
	            $('#IDocto_det_cant_em_').show();    
	        }
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas es requerido.');
	            $('#IDocto_Notas_em_').show();    
	        }
		}
	}

	if(tipo == <?php echo Yii::app()->params->sad; ?>){
		//salida de dotación 
		if( tipo != "" && fecha != "" && ref != "" && tercero != ""  && empleado != "" && item != "" && bodega_origen != "" && cant != ""){

	        $(".ajax-loader").fadeIn('fast');

	        var div_contenido = $('#contenido');

	        var i = item+'_'+bodega_origen;
	        var tr = $("#tr_"+i).length;

	        if(!tr){
			
				var cant_f = $(".tr_items").length;

	            if(cant_f == 0){
	                div_contenido.append('<table class="table table-sm table-hover" id="table_items"><thead><tr><th>Item</th><th>Bodega origen</th><th>Cantidad</th><th></th></tr></thead><tbody></tbody></table>');
	            }

	            var tabla = $('#table_items');

				tabla.append('<tr class="tr_items" id="tr_'+i+'"><td><input type="hidden" class="items" value="'+i+'"><input type="hidden" id="item_'+i+'" value="'+item+'"><p>'+item_desc+'</p></td><td><input type="hidden" id="bodega_origen_'+i+'" value="'+bodega_origen+'"><p>'+bodega_origen_desc+'</p></td><td align="right"><input type="hidden" id="cant_'+i+'" value="'+cant+'"><p>'+cant+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

	            //se resetean los campos para seguir recibiendo detalles
	            $('#btn_save').show(); 
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_origen').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $(".ajax-loader").fadeOut('fast');

	        }else{
	        	$('html, body').animate({scrollTop:0}, 'fast');
	            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
	            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen).');	
	            $("#div_mensaje").fadeIn('fast');
	            $(".ajax-loader").fadeOut('fast');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(empleado == ""){
	            $('#IDocto_Id_Emp_em_').html('Empleado es requerido.');
	            $('#IDocto_Id_Emp_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item es requerido.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDocto_det_bodega_origen_em_').html('Bodega origen es requerido.');
	            $('#IDocto_det_bodega_origen_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad es requerido.');
	            $('#IDocto_det_cant_em_').show();    
	        }
		}

	}

	if(tipo == <?php echo Yii::app()->params->dev; ?>){
		//devolución
		if( tipo != "" && fecha != "" && ref != "" && tercero != "" && item != "" && bodega_destino != "" && cant != ""){

	        $(".ajax-loader").fadeIn('fast');

	        var div_contenido = $('#contenido');

	        var i = item+'_'+bodega_destino;
	        var tr = $("#tr_"+i).length;

	        if(!tr){
			
				var cant_f = $(".tr_items").length;

	            if(cant_f == 0){
	                div_contenido.append('<table class="table table-sm table-hover" id="table_items"><thead><tr><th>Item</th><th>Bodega destino</th><th>Cantidad</th><th></th></tr></thead><tbody></tbody></table>');
	            }

	            var tabla = $('#table_items');

				tabla.append('<tr class="tr_items" id="tr_'+i+'"><td><input type="hidden" class="items" value="'+i+'"><input type="hidden" id="item_'+i+'" value="'+item+'"><p>'+item_desc+'</p></td><td><input type="hidden" id="bodega_destino_'+i+'" value="'+bodega_destino+'"><p>'+bodega_destino_desc+'</p></td><td align="right"><input type="hidden" id="cant_'+i+'" value="'+cant+'"><p>'+cant+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

	            //se resetean los campos para seguir recibiendo detalles
	            $('#btn_save').show(); 
	            $('#IDocto_det_item').val('').trigger('change');
	            $('#s2id_IDocto_det_item span').html("");
	            $('#IDocto_det_bodega_destino').val('').trigger('change');
	            $('#IDocto_det_cant').val('');
	            $(".ajax-loader").fadeOut('fast');

	        }else{
	        	$('html, body').animate({scrollTop:0}, 'fast');
	            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
	            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega destino).');	
	            $("#div_mensaje").fadeIn('fast');
	            $(".ajax-loader").fadeOut('fast');
	        }

		}else{
			if(tipo == ""){
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(item == ""){
	            $('#IDocto_det_item_em_').html('Item es requerido.');
	            $('#IDocto_det_item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDocto_det_bodega_destino_em_').html('Bodega destino es requerido.');
	            $('#IDocto_det_bodega_destino_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDocto_det_cant_em_').html('Cantidad es requerido.');
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
    $(this).parent().parent("tr").remove();
    var cant = $(".tr_items").length;
    
    if(cant == 0){
        $('#contenido').html('');
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
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$('#btn_save').hide();
	    	limp_div_msg();
	    	$(".ajax-loader").fadeIn('fast');

	    	$("input.items").each(function() {

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
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$('#btn_save').hide();
	    	limp_div_msg();
	    	$(".ajax-loader").fadeIn('fast');

	    	$("input.items").each(function() {

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
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$('#btn_save').hide();
	    	limp_div_msg();
	    	$(".ajax-loader").fadeIn('fast');

	    	$("input.items").each(function() {

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
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas es requerido.');
	            $('#IDocto_Notas_em_').show();    
	        }
	      
	    	return false;

		}else{

			$('#btn_save').hide();
	    	limp_div_msg();
	    	$(".ajax-loader").fadeIn('fast');

	    	$("input.items").each(function() {

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
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(notas == ""){
	            $('#IDocto_Notas_em_').html('Notas es requerido.');
	            $('#IDocto_Notas_em_').show();    
	        }
	      
	    	return false;

		}else{

			$('#btn_save').hide();
	    	limp_div_msg();
	    	$(".ajax-loader").fadeIn('fast');

	    	$("input.items").each(function() {

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
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	        if(empleado == ""){
	            $('#IDocto_Id_Emp_em_').html('Empleado es requerido.');
	            $('#IDocto_Id_Emp_em_').show(); 
	        }

	        return false;

    	}else{

    		$('#btn_save').hide();
	    	limp_div_msg();
	    	$(".ajax-loader").fadeIn('fast');

	    	$("input.items").each(function() {

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
	            $('#IDocto_Id_Tipo_Docto_em_').html('Tipo es requerido.');
	            $('#IDocto_Id_Tipo_Docto_em_').show(); 
	        }
	        if(fecha == ""){
	            $('#IDocto_Fecha_em_').html('Fecha es requerido.');
	            $('#IDocto_Fecha_em_').show(); 
	        }
	        if(ref == ""){
	            $('#IDocto_Referencia_em_').html('Referencia es requerido.');
	            $('#IDocto_Referencia_em_').show(); 
	        }
	        if(tercero == ""){
	            $('#IDocto_Id_Tercero_em_').html('Tercero es requerido.');
	            $('#IDocto_Id_Tercero_em_').show(); 
	        }
	      
	    	return false;

		}else{

			$('#btn_save').hide();
	    	limp_div_msg();
	    	$(".ajax-loader").fadeIn('fast');

	    	$("input.items").each(function() {

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
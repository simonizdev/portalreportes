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


<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->hiddenField($model,'cad_items'); ?>
    		<?php echo $form->hiddenField($model,'cad_orden'); ?>
    		<?php echo $form->hiddenField($model,'cad_porc'); ?>
    		<?php echo $form->error($model,'Descripcion', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Descripcion'); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'item', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'item'); ?>
            <?php echo $form->textField($model,'item'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#Rep_item',
                    'options'  => array(
                        'minimumInputLength' => 5,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('Rep/SearchItem'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Promocion_comp"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Promocion_comp\')\">Limpiar campo</button>"; }',
                    ),
                ));
                ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'orden', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'orden'); ?>
            <?php echo $form->numberField($model,'orden', array('class' => 'form-control', 'autocomplete' => 'off',  'step' => '1', 'min' => '0')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'porc', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'porc'); ?>
		    <?php echo $form->numberField($model,'porc', array('class' => 'form-control', 'autocomplete' => 'off', 'step' => '0.01', 'min' => '0')); ?>
        </div>
    </div>
</div>

<div class="pull-right badge bg-red" id="error_item" style="display: none;"></div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=rep/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" onclick="add_item();"><i class="fa fa-plus"></i> Agregar item</button>
</div>


<div id="contenido">
    
</div>


<div class="btn-group" id="btn_save" style="display: none;padding-bottom: 2%">
    <button type="submit" class="btn btn-success" onclick="return valida_opciones(event);"><i class="fa fa-floppy-o"></i> Guardar</button>
</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html("");

    if(id == 'Promocion_Id_Item_Padre'){
        $('#contenido').html('');
        $('#btn_save').hide();  
       
    }
}

function add_item(){  

	var desc = $('#Rep_Descripcion').val();
	var item = $('#Rep_item').val();
	var orden = $('#Rep_orden').val();
	var porc = $('#Rep_porc').val();
	
    
    if(desc != "" && item != "" && orden != "" && porc != ""){
        
    	var div_contenido = $('#contenido');

		//se verifica si existe un detalle identico
		if ($("#"+item).length) {
			
			$('#error_item').html('Este item ya esta registrado para este reporte.');
    		$('#error_item').show();  
		
		}else{
			
			$('#error_item').html('');
    		$('#error_item').hide();

    		var desc_item = $('#s2id_Rep_item span').html();

			var div_contenido = $('#contenido');
			$('#btn_save').show();  
			div_contenido.append('<div class="row item" id="'+item+'"><label class="col-sm-1 control-label" style="margin-bottom: 10px">Item</label><div class="col-sm-4"><input type="hidden" class="items" value="'+item+'"><input class="form-control input-sm" name="item[]" style="margin-bottom: 10px" value="'+desc_item+'" readonly></div><label class="col-sm-1 control-label">Orden</label><div class="col-sm-1"><input class="form-control input-sm" id="orden_'+item+'" value="'+orden+'" readonly></div><label class="col-sm-1 control-label">Porcentaje</label><div class="col-sm-1"><input class="form-control input-sm" id="porc_'+item+'" value="'+porc+'" readonly></div><div class="col-sm-2"><button type="button" class="btn btn-danger btn-sm delete" style="margin-bottom: 10px"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button></div></div>');
			
			$('#Rep_item').val('').trigger('change');
			$('#s2id_Rep_item span').html(""); 
			$('#Rep_orden').val('');
			$('#Rep_porc').val('');

		}

    }else{
        if(desc == ""){
            $('#Rep_Descripcion_em_').html('Descripción no puede ser nulo.');
            $('#Rep_Descripcion_em_').show(); 
        }else{
        	$('#Rep_Descripcion_em_').html('');
            $('#Rep_Descripcion_em_').hide();
        }

        if(item == ""){
            $('#Rep_item_em_').html('Item no puede ser nulo.');
            $('#Rep_item_em_').show(); 
        }else{
        	$('#Rep_item_em_').html('');
            $('#Rep_item_em_').hide();
        }

        if(orden == ""){
            $('#Rep_orden_em_').html('Orden no puede ser nulo.');
            $('#Rep_orden_em_').show(); 
        }else{
        	$('#Rep_orden_em_').html('');
            $('#Rep_orden_em_').hide();
        }

        if(porc == ""){
            $('#Rep_porc_em_').html('Porcentaje no puede ser nulo.');
            $('#Rep_porc_em_').show(); 
        }else{
        	$('#Rep_porc_em_').html('');
            $('#Rep_porc_em_').hide();
        }

    }
}


$("body").on("click", ".delete", function (e) {
    $(this).parent().parent("div").remove();
    var cant = $(".item").length;
    if(cant == 0){
        $('#btn_save').hide();  
    }else{
        $('#btn_save').show();  
    }
});

function valida_opciones(){
    //debugger;

    var desc = $('#Rep_Descripcion').val();
    var items_selected = '';
    var orden_selected = '';
    var porc_selected = '';
    
    $("input.items[type=hidden]").each(function() {

        item = $(this).val();
        items_selected += item+',';
        orden = $('#orden_'+item).val();
	    porc = $('#porc_'+item).val();
	    orden_selected += orden+',';
	    porc_selected += porc+',';

    });

    var cadena_items = items_selected.slice(0,-1);
    var cadena_orden = orden_selected.slice(0,-1);
    var cadena_porc = porc_selected.slice(0,-1);
    
    $('#Rep_cad_items').val(cadena_items);
    $('#Rep_cad_orden').val(cadena_orden);
    $('#Rep_cad_porc').val(cadena_porc);

    if(desc == ""){
        $('#Rep_Descripcion_em_').html('Descripción no puede ser nulo.');
        $('#Rep_Descripcion_em_').show();
        return false;
    }else{
    	$('#Rep_Descripcion_em_').html('');
        $('#Rep_Descripcion_em_').hide();
        return true; 
    }
      
}

</script>


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

<div id="div_mensaje" style="display: none;"></div>

<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->hiddenField($model,'cad_items'); ?>
    		<?php echo $form->hiddenField($model,'cad_orden'); ?>
    		<?php echo $form->hiddenField($model,'cad_porc'); ?>
    		<?php echo $form->error($model,'Descripcion', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'Descripcion'); ?>
		    <?php echo $form->textField($model,'Descripcion', array('class' => 'form-control form-control-sm', 'maxlength' => '100', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'item', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'item'); ?>
            <?php echo $form->textField($model,'item'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#Rep_item',
                    'options'  => array(
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('Rep/SearchItem'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Promocion_comp"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'Promocion_comp\')\">Limpiar campo</button>"; }',
                    ),
                ));
                ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'orden', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'orden'); ?>
            <?php echo $form->numberField($model,'orden', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off',  'step' => '1', 'min' => '0')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'porc', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'porc'); ?>
		    <?php echo $form->numberField($model,'porc', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'step' => '0.01', 'min' => '0')); ?>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=rep/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" onclick="add_item();"><i class="fa fa-plus" ></i> Agregar registro</button>
    </div>
</div>

<div id="contenido">
</div>

<div class="row mb-2" id="btn_save" style="display: none;">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="return valida_opciones(event);"><i class="fas fa-save"></i> Guardar</button>
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

});

function add_item(){  

	limp_div_msg();

	var desc = $('#Rep_Descripcion').val();
	var item = $('#Rep_item').val();
	var orden = $('#Rep_orden').val();
	var porc = $('#Rep_porc').val();
    
    if(desc != "" && item != "" && orden != "" && porc != ""){
		
		var desc_item = $('#s2id_Rep_item span').html();
		
		$(".ajax-loader").fadeIn('fast');

        var div_contenido = $('#contenido');

        var tr = $("#tr_"+item).length;
        
		if(!tr){

            var cant_f = $(".tr_items").length;

            if(cant_f == 0){
                div_contenido.append('<table id="table_items" class="table table-sm table-hover"><thead><tr><th>Item</th><th>Orden</th><th>Porcentaje</th><th></th></tr></thead><tbody></tbody></table>');
            }

			var tabla = $('#table_items');

			tabla.append('<tr class="tr_items" id="tr_'+item+'"><td><input type="hidden" class="items" value="'+item+'"><p id="desc_'+item+'">'+desc_item+'</p></td><td align="right"><input type="hidden" id="orden_'+item+'" value="'+orden+'"><p>'+orden+'</p></td><td align="right"><input type="hidden" id="porc_'+item+'" value="'+porc+'"><p>'+porc+'</p></td><td><button type="button" class="btn btn-danger btn-sm btn-rep delete"><i class="fas fa-times-circle"></i> Eliminar</button></td></tr>');

			$(".ajax-loader").fadeOut('fast');
	

            $('#btn_save').show();  

        	$('#Rep_item').val('').trigger('change');
			$('#s2id_Rep_item span').html(""); 
			$('#Rep_orden').val('');
			$('#Rep_porc').val('');
		
		}else{
			
            $('html, body').animate({scrollTop:0}, 'fast');
            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe este item en el registro actual.');
            $("#div_mensaje").fadeIn('fast');
            $(".ajax-loader").fadeOut('fast');

		}

    }else{
        if(desc == ""){
            $('#Rep_Descripcion_em_').html('Descripción es requerido.');
            $('#Rep_Descripcion_em_').show(); 
        }

        if(item == ""){
            $('#Rep_item_em_').html('Item es requerido.');
            $('#Rep_item_em_').show(); 
        }

        if(orden == ""){
            $('#Rep_orden_em_').html('Orden es requerido.');
            $('#Rep_orden_em_').show(); 
        }

        if(porc == ""){
            $('#Rep_porc_em_').html('Porcentaje es requerido.');
            $('#Rep_porc_em_').show(); 
        }

    }
}


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

    var desc = $('#Rep_Descripcion').val();
    var items_selected = '';
    var orden_selected = '';
    var porc_selected = '';

    if(desc != ""){

        $('#Rep_Descripcion_em_').html('');
        $('#Rep_Descripcion_em_').hide();
    
        $("input.items").each(function() {

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

        var form = $("#rep-form");
        form.submit();

    }else{
        $('#Rep_Descripcion_em_').html('Descripción es requerido.');
        $('#Rep_Descripcion_em_').show();
        return false;
    }
      
}

</script>
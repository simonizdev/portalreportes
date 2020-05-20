<?php
/* @var $this IDoctoMovtoController */
/* @var $model IDoctoMovto */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'idocto-movto-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); 

$modelo_docto = IDocto::model()->findByPk($id);

?>

<div id="div_mensaje" style="display: none;">
</div>

<div class="row">
	<div class="col-sm-4">
	    <div class="form-group">
	    	<?php echo $form->hiddenField($model,'Id_Docto', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off','value' => $id)); ?>
	        <?php echo $form->label($model,'tipo_docto'); ?>
	        <?php echo '<p>'.$modelo_docto->idtipodocto->Descripcion.'</p>'; ?>
	    </div>
	</div>
	<div class="col-sm-4">
	    <div class="form-group">
	        <?php echo $form->label($model,'consecutivo_docto'); ?>
	        <?php echo '<p>'.$modelo_docto->Consecutivo.'</p>'; ?>
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Item', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Id_Item'); ?>
            <?php echo $form->textField($model,'Id_Item'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#IDoctoMovto_Id_Item',
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
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("IDoctoMovto_Id_Item"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'IDoctoMovto_Id_Item\')\">Limpiar campo</button>"; }',
                    ),
                ));
                ?>
        </div>
    </div>

    <?php if($modelo_docto->Id_Tipo_Docto == Yii::app()->params->sal || $modelo_docto->Id_Tipo_Docto == Yii::app()->params->ajs || $modelo_docto->Id_Tipo_Docto == Yii::app()->params->sad) { ?>

	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Bodega_Org', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Id_Bodega_Org'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IDoctoMovto[Id_Bodega_Org]',
                    'id'=>'IDoctoMovto_Id_Bodega_Org',
                    'data'=>$lista_bodegas,
                    'value' => $model->Id_Bodega_Org,
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

	<?php } ?>

    <?php if($modelo_docto->Id_Tipo_Docto == Yii::app()->params->ent || $modelo_docto->Id_Tipo_Docto == Yii::app()->params->aje || $modelo_docto->Id_Tipo_Docto == Yii::app()->params->dev) { ?>

	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Bodega_Dst', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Id_Bodega_Dst'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IDoctoMovto[Id_Bodega_Dst]',
                    'id'=>'IDoctoMovto_Id_Bodega_Dst',
                    'data'=>$lista_bodegas,
                    'value' => $model->Id_Bodega_Dst,
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

	<?php } ?>

</div>

<div class="row">

	<?php if($modelo_docto->Id_Tipo_Docto == Yii::app()->params->trb) { ?>

    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Bodega_Org', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Id_Bodega_Org'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IDoctoMovto[Id_Bodega_Org]',
                    'id'=>'IDoctoMovto_Id_Bodega_Org',
                    'data'=>$lista_bodegas,
                    'value' => $model->Id_Bodega_Org,
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
            <?php echo $form->error($model,'Id_Bodega_Dst', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Id_Bodega_Dst'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'IDoctoMovto[Id_Bodega_Dst]',
                    'id'=>'IDoctoMovto_Id_Bodega_Dst',
                    'value' => $model->Id_Bodega_Dst,
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

<?php } ?>

	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Cantidad', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Cantidad'); ?>
            <?php echo $form->numberField($model,'Cantidad', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off','maxlength' => '250', 'min' => 1)); ?>
        </div>
    </div>

<?php if($modelo_docto->Id_Tipo_Docto == Yii::app()->params->ent) { ?>

	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Vlr_Unit_Item', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Vlr_Unit_Item'); ?>
            <?php echo $form->numberField($model,'Vlr_Unit_Item', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off','maxlength' => '250', 'min' => 1)); ?>
        </div>
    </div>

<?php
 } ?>

</div>

<div class="row mb-4">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=iDocto/update&id='.$id; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" onclick="add_item();"><i class="fas fa-save" ></i> Guardar</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

function add_item(){

    limp_div_msg();

	var form = $("#idocto-movto-form");

	//cabecera
	var tipo = <?php echo $modelo_docto->Id_Tipo_Docto; ?>;
	var id_docto = <?php echo $modelo_docto->Id; ?>;

	//detalle
	var item = $('#IDoctoMovto_Id_Item').val();
	var bodega_origen = $('#IDoctoMovto_Id_Bodega_Org').val();
	var bodega_destino = $('#IDoctoMovto_Id_Bodega_Dst').val();
	var cant = $('#IDoctoMovto_Cantidad').val();
	var vlr = $('#IDoctoMovto_Vlr_Unit_Item').val();

	if(tipo == <?php echo Yii::app()->params->ent; ?>){
		//entrada
		if( item != "" && bodega_destino != "" && cant != "" && vlr != ""){

			var data = {docto: id_docto, id_reg: null, item: item, bodega_origen: null, bodega_destino: bodega_destino}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('iDoctoMovto/verificarduplicidad'); ?>",
                data: data,
                success: function(response){

                    if(response == 0){
                        //se encontro un registro identico en item / bodega
                        $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega destino).');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                    }

                    if(response == 1){
                        //si esta disponible la cantidad solicitada
                        //se envia el form
                        $(".ajax-loader").fadeIn('fast');
                        form.submit();
                    }

                }
            });

		}else{
	        if(item == ""){
	            $('#IDoctoMovto_Id_Item_em_').html('Item es requerido.');
	            $('#IDoctoMovto_Id_Item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDoctoMovto_Id_Bodega_Dst_em_').html('Bodega destino es requerido.');
	            $('#IDoctoMovto_Id_Bodega_Dst_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDoctoMovto_Cantidad_em_').html('Cantidad es requerido.');
	            $('#IDoctoMovto_Cantidad_em_').show();    
	        }
	        if(vlr == ""){
	            $('#IDoctoMovto_Vlr_Unit_Item_em_').html('Vlr. unitario es requerido.');
	            $('#IDoctoMovto_Vlr_Unit_Item_em_').show();    
	        }  
		}

	}

	if(tipo == <?php echo Yii::app()->params->sal; ?>){
		//salida
		if(item != "" && bodega_origen != "" && cant != ""){
			
			var data = {docto: id_docto, id_reg: null, item: item, bodega_origen: bodega_origen, bodega_destino: null}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('iDoctoMovto/verificarduplicidad'); ?>",
                data: data,
                success: function(response){
                   
                    if(response == 0){
                        //se encontro un registro identico en item / bodega
                        $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen).');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                    }

                    if(response == 1){
                        //si esta disponible la cantidad solicitada
                        //se envia el form
                        $(".ajax-loader").fadeIn('fast');
                        form.submit();
                    }

                }
            });

		}else{
	        if(item == ""){
	            $('#IDoctoMovto_Id_Item_em_').html('Item es requerido.');
	            $('#IDoctoMovto_Id_Item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDoctoMovto_Id_Bodega_Org_em_').html('Bodega origen es requerido.');
	            $('#IDoctoMovto_Id_Bodega_Org_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDoctoMovto_Cantidad_em_').html('Cantidad es requerido.');
	            $('#IDoctoMovto_Cantidad_em_').show();    
	        }
		}

	}

	if(tipo == <?php echo Yii::app()->params->trb; ?>){
		//tranferencia
		if(item != "" && bodega_origen != "" && bodega_destino != "" && cant != ""){
			
			var data = {docto: id_docto, id_reg: null, item: item, bodega_origen: bodega_origen, bodega_destino: bodega_destino}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('iDoctoMovto/verificarduplicidad'); ?>",
                data: data,
                success: function(response){
                   
                    if(response == 0){
                        //se encontro un registro identico en item / bodega
                        $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen - Bodega destino).');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                    }

                    if(response == 1){
                        //si esta disponible la cantidad solicitada
                        //se envia el form
                        $(".ajax-loader").fadeIn('fast');
                        form.submit();
                    }
                }
            });	

		}else{
	        if(item == ""){
	            $('#IDoctoMovto_Id_Item_em_').html('Item es requerido.');
	            $('#IDoctoMovto_Id_Item_em_').show(); 
	        }
	        if(bodega_origen == ""){
	            $('#IDoctoMovto_Id_Bodega_Org_em_').html('Bodega origen es requerido.');
	            $('#IDoctoMovto_Id_Bodega_Org_em_').show();    
	        }
	        if(bodega_destino == ""){
	            $('#IDoctoMovto_Id_Bodega_Dst_em_').html('Bodega destino es requerido.');
	            $('#IDoctoMovto_Id_Bodega_Dst_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDoctoMovto_Cantidad_em_').html('Cantidad es requerido.');
	            $('#IDoctoMovto_Cantidad_em_').show();    
	        }
		}
	}

	if(tipo == <?php echo Yii::app()->params->aje; ?>){
		//ajuste por entrada
		if(item != "" && bodega_destino != "" && cant != ""){
			
			var data = {docto: id_docto, id_reg: null, item: item, bodega_origen: null, bodega_destino: bodega_destino}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('iDoctoMovto/verificarduplicidad'); ?>",
                data: data,
                success: function(response){
                   
                    if(response == 0){
                        //se encontro un registro identico en item / bodega
                        $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega destino).');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                    }

                    if(response == 1){
                        //si esta disponible la cantidad solicitada
                        //se envia el form
                        $(".ajax-loader").fadeIn('fast');
                        form.submit();
                    }

                }
            });

		}else{
	        if(item == ""){
	            $('#IDoctoMovto_Id_Item_em_').html('Item es requerido.');
	            $('#IDoctoMovto_Id_Item_em_').show(); 
	        }
	        if(bodega_destino == ""){
	            $('#IDoctoMovto_Id_Bodega_Dst_em_').html('Bodega destino es requerido.');
	            $('#IDoctoMovto_Id_Bodega_Dst_em_').show();    
	        }
	        if(cant == ""){
	            $('#IDoctoMovto_Cantidad_em_').html('Cantidad es requerido.');
	            $('#IDoctoMovto_Cantidad_em_').show();    
	        }
		}

	}

    if(tipo == <?php echo Yii::app()->params->ajs; ?>){
        //ajuste por salida
        if(item != "" && bodega_origen != "" && cant != ""){
            
            var data = {docto: id_docto, id_reg: null, item: item, bodega_origen: bodega_origen, bodega_destino: null}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('iDoctoMovto/verificarduplicidad'); ?>",
                data: data,
                success: function(response){
                   
                    if(response == 0){
                        //se encontro un registro identico en item / bodega
                        $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen).');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                    }

                    if(response == 1){
                        //si esta disponible la cantidad solicitada
                        //se envia el form
                        $(".ajax-loader").fadeIn('fast');
                        form.submit();
                    }

                }
            });

        }else{
            if(item == ""){
                $('#IDoctoMovto_Id_Item_em_').html('Item es requerido.');
                $('#IDoctoMovto_Id_Item_em_').show(); 
            }
            if(bodega_origen == ""){
                $('#IDoctoMovto_Id_Bodega_Org_em_').html('Bodega origen es requerido.');
                $('#IDoctoMovto_Id_Bodega_Org_em_').show();    
            }
            if(cant == ""){
                $('#IDoctoMovto_Cantidad_em_').html('Cantidad es requerido.');
                $('#IDoctoMovto_Cantidad_em_').show();    
            }
        }

    }

    if(tipo == <?php echo Yii::app()->params->sad; ?>){
        //salida de dotacion
        if(item != "" && bodega_origen != "" && cant != ""){
            
            var data = {docto: id_docto, id_reg: null, item: item, bodega_origen: bodega_origen, bodega_destino: null}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('iDoctoMovto/verificarduplicidad'); ?>",
                data: data,
                success: function(response){
                   
                    if(response == 0){
                        //se encontro un registro identico en item / bodega
                        $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega origen).');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                    }

                    if(response == 1){
                        //si esta disponible la cantidad solicitada
                        //se envia el form
                        $(".ajax-loader").fadeIn('fast');
                        form.submit();
                    }

                }
            });

        }else{
            if(item == ""){
                $('#IDoctoMovto_Id_Item_em_').html('Item es requerido.');
                $('#IDoctoMovto_Id_Item_em_').show(); 
            }
            if(bodega_origen == ""){
                $('#IDoctoMovto_Id_Bodega_Org_em_').html('Bodega origen es requerido.');
                $('#IDoctoMovto_Id_Bodega_Org_em_').show();    
            }
            if(cant == ""){
                $('#IDoctoMovto_Cantidad_em_').html('Cantidad es requerido.');
                $('#IDoctoMovto_Cantidad_em_').show();    
            }
        }

    }

    if(tipo == <?php echo Yii::app()->params->dev; ?>){
        //devolución
        if(item != "" && bodega_destino != "" && cant != ""){
            
            var data = {docto: id_docto, id_reg: null, item: item, bodega_origen: null, bodega_destino: bodega_destino}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('iDoctoMovto/verificarduplicidad'); ?>",
                data: data,
                success: function(response){
                   
                    if(response == 0){
                        //se encontro un registro identico en item / bodega
                        $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Ya existe un detalle con la misma combinación (Item - Bodega destino).');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                    }

                    if(response == 1){
                        //si esta disponible la cantidad solicitada
                        //se envia el form
                        $(".ajax-loader").fadeIn('fast');
                        form.submit();
                    }

                }
            });

        }else{
            if(item == ""){
                $('#IDoctoMovto_Id_Item_em_').html('Item es requerido.');
                $('#IDoctoMovto_Id_Item_em_').show(); 
            }
            if(bodega_destino == ""){
                $('#IDoctoMovto_Id_Bodega_Dst_em_').html('Bodega destino es requerido.');
                $('#IDoctoMovto_Id_Bodega_Dst_em_').show();    
            }
            if(cant == ""){
                $('#IDoctoMovto_Cantidad_em_').html('Cantidad es requerido.');
                $('#IDoctoMovto_Cantidad_em_').show();    
            }
        }

    }

}

$("#IDoctoMovto_Id_Item").change( function (){
	limp_div_msg();
});

$("#IDoctoMovto_Id_Bodega_Dst").change( function (){
	limp_div_msg();
});

$("#IDoctoMovto_Id_Bodega_Org").change( function (){

	var tipo = <?php echo $modelo_docto->Id_Tipo_Docto; ?>;

	limp_div_msg();

	bod = $(this).val();
	
	$('#IDoctoMovto_Id_Bodega_Dst').find('option').remove();
	$('#IDoctoMovto_Id_Bodega_Dst').val('').trigger('change');
	$("#IDoctoMovto_Id_Bodega_Dst").append('<option value=""></option>');
	$('#IDoctoMovto_Id_Bodega_Dst').val('').trigger('change');

	if(bod != ""){

		if(tipo == <?php echo Yii::app()->params->trb; ?>){

			$("#IDoctoMovto_Id_Bodega_Org option").each(function(name, val) { 
	 	
		 		opt_val = val.value;
				opt_text = val.text;

				if(bod != opt_val && opt_val !=  ""){
					$("#IDoctoMovto_Id_Bodega_Dst").append('<option value='+opt_val+'>'+opt_text+'</option>');
				}

	 	 	});

		}
	 	
	}
   
});


</script>
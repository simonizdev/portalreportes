<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script type="text/javascript">
$(function() {

	$(".ajax-loader").show();

	var tipo_producto = $('#FichaItem_Tipo_Producto').val();

	if(tipo_producto == 1){
		$('#con_und_med_prod').show();


	}else{
		$('#con_und_med_prod').hide();
	}

	var step = <?php echo $s; ?>;
	var e = <?php echo $e; ?>;
    div_step(step, e);
   
	//se llenan las opciones seleccionadas del modelo
	$('#FichaItem_Instalaciones').val(<?php echo $instalaciones_activas ?>).trigger('change');
	$('#FichaItem_Bodegas').val(<?php echo $bodegas_activas ?>).trigger('change');

	$("#valida_form").click(function() {

		debugger;

      	var form = $("#ficha-item-form");
		var settings = form.data('settings') ;
		var step = <?php echo $s; ?>;
		var tipo_producto = $("#FichaItem_Tipo_Producto").val();


		var contenido = $("#FichaItem_Contenido").val();
		var und_prod = $("#FichaItem_Unidad_Medida_Prod").val();

		if(step == 2){

			$valid = 0;

			if(tipo_producto == 1){   

				if(contenido != "" && und_prod != ""){
				    $valid = 1;
				}else{
				    $valid = 0;
				}

			}else{
				$valid = 1;
			}

		}else{
			$valid = 1;
		}
		
		settings.submitting = true ;
		$.fn.yiiactiveform.validate(form, function(messages) {
		  if($.isEmptyObject(messages)) {
		    $.each(settings.attributes, function () {
		        $.fn.yiiactiveform.updateInput(this,messages,form); 
		    });

			if($valid == 1){
                //se envia el form
                form.submit();
                loadershow();
            }else{
            	if(tipo_producto == 1){   

					if(contenido != "" && und_prod != ""){
					    $valid = 1;
					}else{
					    if(contenido == ""){
					        $('#FichaItem_Contenido_em_').html('Contenido es requerido.');
					        $('#FichaItem_Contenido_em_').show(); 
					    }

					    if(und_prod == ""){
					        $('#FichaItem_Unidad_Medida_Prod_em_').html('Und. medida producto es requerido.');
					        $('#FichaItem_Unidad_Medida_Prod_em_').show(); 
					    }

					    $valid = 0;

					}

				}	
            }
		    
		  } else {
		      settings = form.data('settings'),
		      $.each(settings.attributes, function () {
		         $.fn.yiiactiveform.updateInput(this,messages,form); 
		      });
		      settings.submitting = false ;

		      if(tipo_producto == 1){
                if(contenido == ""){
                    $('#FichaItem_Contenido_em_').html('Contenido es requerido.');
                    $('#FichaItem_Contenido_em_').show(); 
                }

                if(und_prod == ""){
                    $('#FichaItem_Unidad_Medida_Prod_em_').html('Und. medida producto es requerido.');
                    $('#FichaItem_Unidad_Medida_Prod_em_').show(); 
                }
              }
		  }
		});
	});

	$('#FichaItem_Contenido').change(function() {
        var tipo_producto = $("#FichaItem_Tipo_Producto").val();
        var val = $('#FichaItem_Contenido').val();
        if(tipo_producto == 1){   
            if(val == ""){
                $('#FichaItem_Contenido_em_').html('Contenido es requerido.');
                $('#FichaItem_Contenido_em_').show(); 
            }else{
                $('#FichaItem_Contenido_em_').html('');
                $('#FichaItem_Contenido_em_').hide(); 
            }

        }else{
            $('#FichaItem_Contenido_em_').html('');
            $('#FichaItem_Contenido_em_').hide(); 
        
        }
      
    });

    $('#FichaItem_Unidad_Medida_Prod').change(function() {
        var tipo_producto = $("#FichaItem_Tipo_Producto").val();
        var val = $('#FichaItem_Unidad_Medida_Prod').val();
        if(tipo_producto == 1){   
            if(val == ""){
                $('#FichaItem_Unidad_Medida_Prod_em_').html('Und. medida producto es requerido.');
                $('#FichaItem_Unidad_Medida_Prod_em_').show(); 
            }else{
                $('#FichaItem_Unidad_Medida_Prod_em_').html('');
                $('#FichaItem_Unidad_Medida_Prod_em_').hide(); 
            }

        }else{
            $('#FichaItem_Contenido_em_').html('');
            $('#FichaItem_Contenido_em_').hide(); 
        
        }
        
    });

	$('#FichaItem_Tipo_Producto').change(function() {

		var value = $(this).val();

		$('#Actividad_Fecha_Cierre_em_').html('');
		$('#Actividad_Hora_Cierre_em_').html('');
		$('#Actividad_Fecha_Cierre').val('');
		$('#Actividad_Hora_Cierre').val('');

		if(value == 1){
			$('#con_und_med_prod').show();
		}else{
			$('#con_und_med_prod').hide();
		}
	   
	});

	$("#rechazar_form").click(function() {
		var opcion = confirm("Desea solicitar una revisión de los datos registrados?");
	    if (opcion == true) {
	    	loadershow();
	       	location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/notas&id='.$model->Id; ?>';
	   	} 
	});
});

function desc_corta(){

    var nf = $('#FichaItem_Nombre_Funcional').val();
    var marca = $('#FichaItem_Marca_Producto').val();
    var caract = $('#FichaItem_Caracteristicas').val();

    if(nf != "" && marca != "" && caract != ""){
        var desc_corta = nf+' '+marca+' '+caract;
        $('#FichaItem_Descripcion_Corta').val(desc_corta);  
    }else{
        $('#FichaItem_Descripcion_Corta').val('');  
    }       
}

function calculo_volumen(opc){

	if(opc ==  1){
		var largo = $('#FichaItem_Un_Largo').val();
		var ancho = $('#FichaItem_Un_Ancho').val();
		var alto = $('#FichaItem_Un_Alto').val();

		if(largo != "" && ancho != "" && alto != ""){
			var volumen = largo * ancho * alto;
			$('#FichaItem_Un_Volumen').val(volumen.toFixed(4));	
		}else{
			$('#FichaItem_Un_Volumen').val('');	
		}		
	}

	if(opc ==  2){
		var largo = $('#FichaItem_Ep_Largo').val();
		var ancho = $('#FichaItem_Ep_Ancho').val();
		var alto = $('#FichaItem_Ep_Alto').val();

		if(largo != "" && ancho != "" && alto != ""){
			var volumen = largo * ancho * alto;
			$('#FichaItem_Ep_Volumen').val(volumen.toFixed(4));	
		}else{
			$('#FichaItem_Ep_Volumen').val('');	
		}	
	}

	if(opc ==  3){
		var largo = $('#FichaItem_Cad_Largo').val();
		var ancho = $('#FichaItem_Cad_Ancho').val();
		var alto = $('#FichaItem_Cad_Alto').val();

		if(largo != "" && ancho != "" && alto != ""){
			var volumen = largo * ancho * alto;
			$('#FichaItem_Cad_Volumen').val(volumen.toFixed(4));	
		}else{
			$('#FichaItem_Cad_Volumen').val('');	
		}	
	}
}

function div_step(step, e){

	var tipo_producto = $('#FichaItem_Tipo_Producto').val();

    if(step == 2){

    	if(e == 1){
	    	//campos habilitados
	  		$('#FichaItem_Tipo_Producto').removeAttr('disabled');
	  		$('#FichaItem_Nombre_Funcional').removeAttr('disabled');
	  		$('#FichaItem_Marca_Producto').removeAttr('disabled');
	  		$('#FichaItem_Caracteristicas').removeAttr('disabled');
	  		$('#FichaItem_Contenido').removeAttr('disabled');
	  		$('#FichaItem_Descripcion_Larga').removeAttr('disabled');
	  		$('#FichaItem_Unidad_Medida_Prod').removeAttr('disabled');
	  		$('#FichaItem_Unidad_Medida_Inv').removeAttr('disabled');
	  		$('#FichaItem_Unidad_Medida_Compra').removeAttr('disabled');
	  		$('#FichaItem_Ind_Compra').removeAttr('disabled');
	  		$('#FichaItem_Ind_Manufactura').removeAttr('disabled');
	  		$('#FichaItem_Ind_Venta').removeAttr('disabled');
	  		$('#FichaItem_Maneja_Lote').removeAttr('disabled');
	  		$('#FichaItem_Exento_Impuesto').removeAttr('disabled');
	  		$('#FichaItem_Tiempo_Reposicion').removeAttr('disabled');
	  		$('#FichaItem_Cant_Moq').removeAttr('disabled');
	  		$('#FichaItem_Stock_Minimo').removeAttr('disabled');
	  		$('#FichaItem_Instalaciones').removeAttr('disabled');
	  		$('#FichaItem_Bodegas').removeAttr('disabled');
	  		$("#buttons_1").html('<button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
	  	}

        $("#collapse_2").hide();
        $("#collapse_3").hide();
        $("#collapse_4").hide();
        $("#collapse_5").hide();

        $('#link_collapse_1').addClass('text-warning').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-danger').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 3){
        //finanzas

        if(e == 1){
	    	//campos habilitados
	  		$('#FichaItem_Tipo_Inventario').removeAttr('disabled');
  			$('#FichaItem_Grupo_Impositivo').removeAttr('disabled');
  			$("#buttons_2").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
	  	}

        $("#collapse_3").hide();
        $("#collapse_4").hide();
        $("#collapse_5").hide();

        $('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-warning').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-danger').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 4){
        //verificación finanzas

        if(e == 1){
	    	//campos habilitados
	  		$('#FichaItem_Tipo_Inventario').removeAttr('disabled');
  			$('#FichaItem_Grupo_Impositivo').removeAttr('disabled');
  			$("#buttons_2").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
	  	}

        $("#collapse_3").hide();
        $("#collapse_4").hide();
        $("#collapse_5").hide();

        $('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-warning').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-danger').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 5){
        //comercial

        if(e == 1){
	  		//campos habilitados
	  		$('#FichaItem_Crit_Origen').removeAttr('disabled');
	  		$('#FichaItem_Crit_Tipo').removeAttr('disabled');
	  		$('#FichaItem_Crit_Clasificacion').removeAttr('disabled');
	  		$('#FichaItem_Crit_Clase').removeAttr('disabled');
	  		$('#FichaItem_Crit_Marca').removeAttr('disabled');
	  		$('#FichaItem_Crit_Submarca').removeAttr('disabled');
	  		$('#FichaItem_Crit_Segmento').removeAttr('disabled');
	  		$('#FichaItem_Crit_Familia').removeAttr('disabled');
	  		$('#FichaItem_Crit_Subfamilia').removeAttr('disabled');
	  		$('#FichaItem_Crit_Linea').removeAttr('disabled');
	  		$('#FichaItem_Crit_Sublinea').removeAttr('disabled');
	  		$('#FichaItem_Crit_Grupo').removeAttr('disabled');
	  		$('#FichaItem_Crit_UN').removeAttr('disabled');
	  		$('#FichaItem_Crit_Fabrica').removeAttr('disabled');
	  		$('#FichaItem_Crit_Cat_Oracle').removeAttr('disabled');
	  		$("#buttons_3").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
	  	}

        $("#collapse_4").hide();
        $("#collapse_5").hide();

        $('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-warning').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-danger').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_3').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 6){
        //verificación comercial

        if(e == 1){
	  		//campos habilitados
	  		$('#FichaItem_Crit_Origen').removeAttr('disabled');
	  		$('#FichaItem_Crit_Tipo').removeAttr('disabled');
	  		$('#FichaItem_Crit_Clasificacion').removeAttr('disabled');
	  		$('#FichaItem_Crit_Clase').removeAttr('disabled');
	  		$('#FichaItem_Crit_Marca').removeAttr('disabled');
	  		$('#FichaItem_Crit_Submarca').removeAttr('disabled');
	  		$('#FichaItem_Crit_Segmento').removeAttr('disabled');
	  		$('#FichaItem_Crit_Familia').removeAttr('disabled');
	  		$('#FichaItem_Crit_Subfamilia').removeAttr('disabled');
	  		$('#FichaItem_Crit_Linea').removeAttr('disabled');
	  		$('#FichaItem_Crit_Sublinea').removeAttr('disabled');
	  		$('#FichaItem_Crit_Grupo').removeAttr('disabled');
	  		$('#FichaItem_Crit_UN').removeAttr('disabled');
	  		$('#FichaItem_Crit_Fabrica').removeAttr('disabled');
	  		$('#FichaItem_Crit_Cat_Oracle').removeAttr('disabled');
	  		$("#buttons_3").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
	  	}

        $("#collapse_4").hide();
        $("#collapse_5").hide();

        $('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-warning').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-danger').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-danger').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_3').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 7){
        //ingenieria

        if(tipo_producto == 1){
			$('#log_ep').show();
			$('#log_se_cad').show();
			if(e == 1){
		  		//campos habilitados
		  		$('#FichaItem_Un_Medida').removeAttr('disabled');
		  		$('#FichaItem_Un_Cant').removeAttr('disabled');
		  		$('#FichaItem_Un_Peso').removeAttr('disabled');
		  		$('#FichaItem_Un_Largo').removeAttr('disabled');
		  		$('#FichaItem_Un_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Un_Alto').removeAttr('disabled');
		  		$('#FichaItem_Ep_Medida').removeAttr('disabled');
		  		$('#FichaItem_Ep_Cant').removeAttr('disabled');
		  		$('#FichaItem_Ep_Peso').removeAttr('disabled');
		  		$('#FichaItem_Ep_Largo').removeAttr('disabled');
		  		$('#FichaItem_Ep_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Ep_Alto').removeAttr('disabled');
		  		$('#FichaItem_Cad_Medida').removeAttr('disabled');
		  		$('#FichaItem_Cad_Cant').removeAttr('disabled');
		  		$('#FichaItem_Cad_Peso').removeAttr('disabled');
		  		$('#FichaItem_Cad_Largo').removeAttr('disabled');
		  		$('#FichaItem_Cad_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Cad_Alto').removeAttr('disabled');
		  		$("#buttons_4").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
		  	}
		}else{
			$('#log_ep').hide();
			$('#log_se_cad').hide();
			if(e == 1){
		  		//campos habilitados
		  		$('#FichaItem_Un_Medida').removeAttr('disabled');
		  		$('#FichaItem_Un_Cant').removeAttr('disabled');
		  		$('#FichaItem_Un_Peso').removeAttr('disabled');
		  		$('#FichaItem_Un_Largo').removeAttr('disabled');
		  		$('#FichaItem_Un_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Un_Alto').removeAttr('disabled');
		  		$("#buttons_4").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
		  	}
		}

        $("#collapse_5").hide();

        $('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-warning').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-danger').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_3').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_4').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 8){
        //verificación ingenieria

        if(tipo_producto == 1){
			$('#log_ep').show();
			$('#log_se_cad').show();
			if(e == 1){
		  		//campos habilitados
		  		$('#FichaItem_Un_Medida').removeAttr('disabled');
		  		$('#FichaItem_Un_Cant').removeAttr('disabled');
		  		$('#FichaItem_Un_Peso').removeAttr('disabled');
		  		$('#FichaItem_Un_Largo').removeAttr('disabled');
		  		$('#FichaItem_Un_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Un_Alto').removeAttr('disabled');
		  		$('#FichaItem_Ep_Medida').removeAttr('disabled');
		  		$('#FichaItem_Ep_Cant').removeAttr('disabled');
		  		$('#FichaItem_Ep_Peso').removeAttr('disabled');
		  		$('#FichaItem_Ep_Largo').removeAttr('disabled');
		  		$('#FichaItem_Ep_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Ep_Alto').removeAttr('disabled');
		  		$('#FichaItem_Cad_Medida').removeAttr('disabled');
		  		$('#FichaItem_Cad_Cant').removeAttr('disabled');
		  		$('#FichaItem_Cad_Peso').removeAttr('disabled');
		  		$('#FichaItem_Cad_Largo').removeAttr('disabled');
		  		$('#FichaItem_Cad_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Cad_Alto').removeAttr('disabled');
		  		$("#buttons_4").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
		  	}
		}else{
			$('#log_ep').hide();
			$('#log_se_cad').hide();
			if(e == 1){
		  		//campos habilitados
		  		$('#FichaItem_Un_Medida').removeAttr('disabled');
		  		$('#FichaItem_Un_Cant').removeAttr('disabled');
		  		$('#FichaItem_Un_Peso').removeAttr('disabled');
		  		$('#FichaItem_Un_Largo').removeAttr('disabled');
		  		$('#FichaItem_Un_Ancho').removeAttr('disabled');
		  		$('#FichaItem_Un_Alto').removeAttr('disabled');
		  		$("#buttons_4").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> Guardar</button>');
		  	}
		}

        $("#collapse_5").hide();

       	$('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-warning').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-danger').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_3').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_4').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 9){
        //datos maestros

        if(tipo_producto == 1){
			$('#log_ep').show();
			$('#log_se_cad').show();
			$('#un_gtin').show();
			$('#ep_gtin').show();
			$('#cad_gtin').show();
			if(e == 1){
		  		//campos habilitados
		  		$('#FichaItem_Codigo_Item').removeAttr('disabled');
				$('#FichaItem_Referencia').removeAttr('disabled');
				$('#FichaItem_Un_Gtin').removeAttr('disabled');
				$('#FichaItem_Ep_Gtin').removeAttr('disabled');
				$('#FichaItem_Cad_Gtin').removeAttr('disabled');
				$("#buttons_5").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-check-circle"></i> Aprobar</button>');
		  	}
		}else{
			$('#log_ep').hide();
			$('#log_se_cad').hide();
			$('#un_gtin').hide();
			$('#ep_gtin').hide();
			$('#cad_gtin').hide();
			if(e == 1){
		  		//campos habilitados
		  		$('#FichaItem_Codigo_Item').removeAttr('disabled');
				$('#FichaItem_Referencia').removeAttr('disabled');
				$("#buttons_5").html('<button type="button" class="btn btn-success btn-sm" id="rechazar_form"><i class="fas fa-exclamation-circle"></i> Solicitar revisión</button> <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-check-circle"></i> Aprobar</button>');
		  	}	
		}

        $('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-warning').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_3').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_4').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_5').addClass('fa-circle').removeClass('fa-clock');
    }

    if(step == 10){

    	if(tipo_producto == 1){
			$('#log_ep').show();
			$('#log_se_cad').show();
			$('#un_gtin').show();
			$('#ep_gtin').show();
			$('#cad_gtin').show();
			
		}else{
			$('#log_ep').hide();
			$('#log_se_cad').hide();
			$('#un_gtin').hide();
			$('#ep_gtin').hide();
			$('#cad_gtin').hide();
		}

        //proceso completo
        $("#buttons_1").html('');
        $("#buttons_2").html('');
        $("#buttons_3").html('');
        $("#buttons_4").html('');
        $("#buttons_5").html('');

        $('#link_collapse_1').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_2').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_3').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_4').addClass('text-success').removeClass('text-secondary');
        $('#link_collapse_5').addClass('text-success').removeClass('text-secondary');

        $('#img_info_1').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_2').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_3').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_4').addClass('fa-check-circle').removeClass('fa-clock');
        $('#img_info_5').addClass('fa-check-circle').removeClass('fa-clock');
    }

    $(".ajax-loader").fadeOut('fast');
}

</script>

<div class="row mb-2">
  <div class="col-sm-9">
    <h4>Revisión solicitud creación de producto en siesa</h4>
  </div>
  <div class="col-sm-3 text-right"> 
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
  </div>
</div>

<?php 
$this->renderPartial('_form', array(
	'model'=>$model,
	'lista_unidad'=>$lista_unidad,
	'lista_tipo_inv'=>$lista_tipo_inv,
	'lista_grupo_imp'=>$lista_grupo_imp,
	'lista_origen'=>$lista_origen,
	'lista_tipo'=>$lista_tipo,
	'lista_clasif'=>$lista_clasif,
	'lista_clase'=>$lista_clase,
	'lista_marca'=>$lista_marca,
	'lista_submarca'=>$lista_submarca,
	'lista_segmento'=>$lista_segmento,
	'lista_familia'=>$lista_familia,
	'lista_linea'=>$lista_linea,
	'lista_subfamilia'=>$lista_subfamilia,
	'lista_sublinea'=>$lista_sublinea,
	'lista_grupo'=>$lista_grupo,
	'lista_un'=>$lista_un,
	'lista_fabrica'=>$lista_fabrica,
	'lista_oracle'=>$lista_oracle,
	'lista_ins'=>$lista_ins,
	'lista_bodegas'=>$lista_bodegas,
)); 

	?>
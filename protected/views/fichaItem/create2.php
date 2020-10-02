<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script>

$(function() {

    $("#valida_form").click(function() {
      var form = $("#ficha-item-form");
      var settings = form.data('settings') ;

      var tipo_producto = $("#FichaItem_Tipo_Producto").val();
      
      var ep_und = $("#FichaItem_Ep_Medida").val();
      var ep_cant = $("#FichaItem_Ep_Cant").val();
      var ep_peso = $("#FichaItem_Ep_Peso").val();
      var ep_largo = $("#FichaItem_Ep_Largo").val();
      var ep_ancho = $("#FichaItem_Ep_Ancho").val();
      var ep_alto = $("#FichaItem_Ep_Alto").val();
      var cad_und = $("#FichaItem_Cad_Medida").val();
      var cad_cant = $("#FichaItem_Cad_Cant").val();
      var cad_peso = $("#FichaItem_Cad_Peso").val();
      var cad_largo = $("#FichaItem_Cad_Largo").val();
      var cad_ancho = $("#FichaItem_Cad_Ancho").val();
      var cad_alto = $("#FichaItem_Cad_Alto").val();

      if(tipo_producto == 1){	

    	if(ep_und != "" && ep_cant != "" && ep_peso != "" && ep_largo != "" && ep_ancho != "" && ep_alto != "" && cad_und != "" && cad_cant != "" && cad_peso != "" && cad_largo != "" && cad_ancho != "" && cad_alto != ""){
        	$valid = 1;
    	}else{
    		if(ep_und == ""){
	            $('#FichaItem_Ep_Medida_em_').html('Medida es requerido.');
	            $('#FichaItem_Ep_Medida_em_').show(); 
	        }

	        if(ep_cant == ""){
	            $('#FichaItem_Ep_Cant_em_').html('Cantidad es requerido.');
	            $('#FichaItem_Ep_Cant_em_').show(); 
	        }

	        if(ep_peso == ""){
	            $('#FichaItem_Ep_Peso_em_').html('Peso es requerido.');
	            $('#FichaItem_Ep_Peso_em_').show(); 
	        }

	        if(ep_largo == ""){
	            $('#FichaItem_Ep_Largo_em_').html('Largo es requerido.');
	            $('#FichaItem_Ep_Largo_em_').show(); 
	        }

	        if(ep_ancho == ""){
	            $('#FichaItem_Ep_Ancho_em_').html('Ancho es requerido.');
	            $('#FichaItem_Ep_Ancho_em_').show(); 
	        }

	        if(ep_alto == ""){
	            $('#FichaItem_Ep_Alto_em_').html('Alto es requerido.');
	            $('#FichaItem_Ep_Alto_em_').show(); 
	        }

	        if(cad_und == ""){
	            $('#FichaItem_Cad_Medida_em_').html('Medida es requerido.');
	            $('#FichaItem_Cad_Medida_em_').show(); 
	        }

	        if(cad_cant == ""){
	            $('#FichaItem_Cad_Cant_em_').html('Cantidad es requerido.');
	            $('#FichaItem_Cad_Cant_em_').show(); 
	        }

	        if(cad_peso == ""){
	            $('#FichaItem_Cad_Peso_em_').html('Peso es requerido.');
	            $('#FichaItem_Cad_Peso_em_').show(); 
	        }

	        if(cad_largo == ""){
	            $('#FichaItem_Cad_Largo_em_').html('Largo es requerido.');
	            $('#FichaItem_Cad_Largo_em_').show(); 
	        }

	        if(cad_ancho == ""){
	            $('#FichaItem_Cad_Ancho_em_').html('Ancho es requerido.');
	            $('#FichaItem_Cad_Ancho_em_').show(); 
	        }

	        if(cad_alto == ""){
	            $('#FichaItem_Cad_Alto_em_').html('Alto es requerido.');
	            $('#FichaItem_Cad_Alto_em_').show(); 
	        }


	        $valid = 0;

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
            }
             
          } else {
              settings = form.data('settings'),
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              settings.submitting = false ;

              if(tipo_producto == 1){
	            if(ep_und == ""){
		            $('#FichaItem_Ep_Medida_em_').html('Medida es requerido.');
		            $('#FichaItem_Ep_Medida_em_').show(); 
		        }

		        if(ep_cant == ""){
		            $('#FichaItem_Ep_Cant_em_').html('Cantidad es requerido.');
		            $('#FichaItem_Ep_Cant_em_').show(); 
		        }

		        if(ep_peso == ""){
		            $('#FichaItem_Ep_Peso_em_').html('Peso es requerido.');
		            $('#FichaItem_Ep_Peso_em_').show(); 
		        }

		        if(ep_largo == ""){
		            $('#FichaItem_Ep_Largo_em_').html('Largo es requerido.');
		            $('#FichaItem_Ep_Largo_em_').show(); 
		        }

		        if(ep_ancho == ""){
		            $('#FichaItem_Ep_Ancho_em_').html('Ancho es requerido.');
		            $('#FichaItem_Ep_Ancho_em_').show(); 
		        }

		        if(ep_alto == ""){
		            $('#FichaItem_Ep_Alto_em_').html('Alto es requerido.');
		            $('#FichaItem_Ep_Alto_em_').show(); 
		        }

		        if(cad_und == ""){
		            $('#FichaItem_Cad_Medida_em_').html('Medida es requerido.');
		            $('#FichaItem_Cad_Medida_em_').show(); 
		        }

		        if(cad_cant == ""){
		            $('#FichaItem_Cad_Cant_em_').html('Cantidad es requerido.');
		            $('#FichaItem_Cad_Cant_em_').show(); 
		        }

		        if(cad_peso == ""){
		            $('#FichaItem_Cad_Peso_em_').html('Peso es requerido.');
		            $('#FichaItem_Cad_Peso_em_').show(); 
		        }

		        if(cad_largo == ""){
		            $('#FichaItem_Cad_Largo_em_').html('Largo es requerido.');
		            $('#FichaItem_Cad_Largo_em_').show(); 
		        }

		        if(cad_ancho == ""){
		            $('#FichaItem_Cad_Ancho_em_').html('Ancho es requerido.');
		            $('#FichaItem_Cad_Ancho_em_').show(); 
		        }

		        if(cad_alto == ""){
		            $('#FichaItem_Cad_Alto_em_').html('Alto es requerido.');
		            $('#FichaItem_Cad_Alto_em_').show(); 
		        }
              }
          }
      });
    });

    $('#FichaItem_Tipo_Producto').change(function() {

		var value = $(this).val();

		$('#Actividad_Fecha_Cierre_em_').html('');
		$('#Actividad_Hora_Cierre_em_').html('');
		$('#Actividad_Fecha_Cierre').val('');
		$('#Actividad_Hora_Cierre').val('');

		if(value == 1){
			
			$('#log_ep').show();
			$('#log_se_cad').show();

		}else{
			
			$('#log_ep').hide();
			$('#log_se_cad').hide();
		}
	   
	});

});

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

function desc_corta(){

	var nf = $('#FichaItem_Nombre_Funcional').val();
	var marca = $('#FichaItem_Marca_Producto').val();
	var caract = $('#FichaItem_Caracteristicas').val();
	var cont = $('#FichaItem_Contenido').val();
	var und_prod = $('#FichaItem_Unidad_Medida_Prod').val();

	if(nf != "" && marca != "" && caract != "" && cont != "" && und_prod != ""){
		var desc_corta = nf+' '+marca+' '+caract+' '+cont+' '+und_prod;
		$('#FichaItem_Descripcion_Corta').val(desc_corta);	
	}else{
		$('#FichaItem_Descripcion_Corta').val('');	
	}		
}

</script>

<h4>Solicitud actualización de producto en siesa</h4>

<?php 

$this->renderPartial('_form3', array(
	'model'=>$model,	
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
)); 

?>
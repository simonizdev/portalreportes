<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script type="text/javascript">
$(function() {

	var tipo_producto = $('#FichaItem_Tipo_Producto').val();

	if(tipo_producto == 1){
		$('#un_gtin').show();
		$('#log_ep').show();
		$('#log_se_cad').show();


	}else{
		$('#un_gtin').hide();
		$('#log_ep').hide();
		$('#log_se_cad').hide();
	}
	   
	//se llenan las opciones seleccionadas del modelo
	$('#FichaItem_Instalaciones').val(<?php echo $instalaciones_activas ?>).trigger('change');
	$('#FichaItem_Bodegas').val(<?php echo $bodegas_activas ?>).trigger('change');

	$("#valida_form").click(function() {
		debugger;

      	var form = $("#ficha-item-form");
		var settings = form.data('settings') ;

		var tipo_producto = $("#FichaItem_Tipo_Producto").val();

		var codigo = $("#FichaItem_Codigo_Item").val();
		var referencia = $("#FichaItem_Referencia").val();
		var tipo_inv = $("#FichaItem_Tipo_Inventario").val();
		var grupo_imp = $("#FichaItem_Grupo_Impositivo").val();
		var un_gtin = $("#FichaItem_Un_Gtin").val();
		var ep_gtin = $("#FichaItem_Ep_Gtin").val();
		var cad_gtin = $("#FichaItem_Cad_Gtin").val();

		if(tipo_producto == 1){	

	    	if(un_gtin != "" && ep_gtin != "" && cad_gtin != ""){
	        	$valid = 1;
	    	}else{
	    		if(un_gtin == ""){
			        $('#FichaItem_Un_Gtin_em_').html('Gtin es requerido.');
			        $('#FichaItem_Un_Gtin_em_').show(); 
			    }

			    if(ep_gtin == ""){
			        $('#FichaItem_Ep_Gtin_em_').html('Gtin es requerido.');
			        $('#FichaItem_Ep_Gtin_em_').show(); 
			    }

			    if(cad_gtin == ""){
			        $('#FichaItem_Cad_Gtin_em_').html('Gtin es requerido.');
			        $('#FichaItem_Cad_Gtin_em_').show(); 
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
	            }else{
	            	if(un_gtin == ""){
				        $('#FichaItem_Un_Gtin_em_').html('Gtin es requerido.');
				        $('#FichaItem_Un_Gtin_em_').show(); 
				    }

				    if(ep_gtin == ""){
				        $('#FichaItem_Ep_Gtin_em_').html('Gtin es requerido.');
				        $('#FichaItem_Ep_Gtin_em_').show(); 
				    }

				    if(cad_gtin == ""){
				        $('#FichaItem_Cad_Gtin_em_').html('Gtin es requerido.');
				        $('#FichaItem_Cad_Gtin_em_').show(); 
				    }
	            }
	             
	          } else {
	              settings = form.data('settings'),
	              $.each(settings.attributes, function () {
	                 $.fn.yiiactiveform.updateInput(this,messages,form); 
	              });
	              settings.submitting = false ;

	              if(tipo_producto == 1){	
			    		if(un_gtin == ""){
					        $('#FichaItem_Un_Gtin_em_').html('Gtin es requerido.');
					        $('#FichaItem_Un_Gtin_em_').show(); 
					    }

					    if(ep_gtin == ""){
					        $('#FichaItem_Ep_Gtin_em_').html('Gtin es requerido.');
					        $('#FichaItem_Ep_Gtin_em_').show(); 
					    }

					    if(cad_gtin == ""){
					        $('#FichaItem_Cad_Gtin_em_').html('Gtin es requerido.');
					        $('#FichaItem_Cad_Gtin_em_').show(); 
					    }

				        $valid = 0;
				  }
	          }
	      });
	});

	$("#rechazar_form").click(function() {
		var opcion = confirm("Desea rechazar la solicitud?");
	    if (opcion == true) {
	    	loadershow();
	       	location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/rechazar&id='.$model->Id; ?>';
	   	} 
	});
});
</script>

<h4>Revisión solicitud creación de producto en siesa</h4>

<?php 
$this->renderPartial('_form2', array(
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
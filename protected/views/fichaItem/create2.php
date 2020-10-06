<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script>

$(function() {

    $("#valida_form").click(function() {
      var form = $("#ficha-item-form");
      var settings = form.data('settings') ;

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
            $.each(settings.attributes, function () {
                $.fn.yiiactiveform.updateInput(this,messages,form); 
            });

        	//se envia el form
        	form.submit();
        	loadershow();
             
          } else {
              settings = form.data('settings'),
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              settings.submitting = false ;
          }
      });
    });

	$('#FichaItem_Codigo_Item').change(function() {

		var value = $(this).val();

		if(value != ""){
			var data = {codigo: value}
		 	$.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('fichaItem/getinfoitem'); ?>",
                data: data,
                success: function(response){
             
                    var data = jQuery.parseJSON(response);
                    $('#FichaItem_Tiempo_Reposicion').val(data.tiempo_repocision);
                    $('#FichaItem_Cant_Moq').val(data.cant_moq);
                    $('#FichaItem_Stock_Minimo').val(data.stock_minimo);
                    $('#FichaItem_Crit_Origen').val(data.origen).trigger('change');
                    $('#FichaItem_Crit_Tipo').val(data.tipo).trigger('change');
                    $('#FichaItem_Crit_Clasificacion').val(data.clasif).trigger('change');
                    $('#FichaItem_Crit_Marca').val(data.marca).trigger('change');
                    $('#FichaItem_Crit_Submarca').val(data.submarca).trigger('change');
                    $('#FichaItem_Crit_Segmento').val(data.segmento).trigger('change');
                    $('#FichaItem_Crit_Familia').val(data.familia).trigger('change');
                    $('#FichaItem_Crit_Subfamilia').val(data.subfamilia).trigger('change');
                    $('#FichaItem_Crit_Linea').val(data.linea).trigger('change');
                    $('#FichaItem_Crit_Sublinea').val(data.sublinea).trigger('change');
                    $('#FichaItem_Crit_Grupo').val(data.grupo).trigger('change');
                    $('#FichaItem_Crit_UN').val(data.unidad_negocio).trigger('change');
                    $('#FichaItem_Crit_Fabrica').val(data.fabrica).trigger('change');
                    $('#FichaItem_Crit_Cat_Oracle').val(data.cat_oracle).trigger('change');
                    $('#div_info').show();
                }
            });
        }else{
        	$('#FichaItem_Tiempo_Reposicion').val('');
            $('#FichaItem_Cant_Moq').val('');
            $('#FichaItem_Stock_Minimo').val('');
            $('#FichaItem_Crit_Origen').val('').trigger('change');
            $('#FichaItem_Crit_Tipo').val('').trigger('change');
            $('#FichaItem_Crit_Clasificacion').val('').trigger('change');
            $('#FichaItem_Crit_Marca').val('').trigger('change');
            $('#FichaItem_Crit_Submarca').val('').trigger('change');
            $('#FichaItem_Crit_Segmento').val('').trigger('change');
            $('#FichaItem_Crit_Familia').val('').trigger('change');
            $('#FichaItem_Crit_Subfamilia').val('').trigger('change');
            $('#FichaItem_Crit_Linea').val('').trigger('change');
            $('#FichaItem_Crit_Sublinea').val('').trigger('change');
            $('#FichaItem_Crit_Grupo').val('').trigger('change');
            $('#FichaItem_Crit_UN').val('').trigger('change');
            $('#FichaItem_Crit_Fabrica').val('').trigger('change');
            $('#FichaItem_Crit_Cat_Oracle').val('').trigger('change');
            $('#div_info').hide();
        }
    });


});

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
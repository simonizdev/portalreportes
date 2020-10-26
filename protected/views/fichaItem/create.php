<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script>

$(function() {

    var step = <?php echo $s; ?>;
    var e = <?php echo $e; ?>;
    div_step(step, e);

    $("#valida_form").click(function() {
      var form = $("#ficha-item-form");
      var settings = form.data('settings');

      var tipo_producto = $("#FichaItem_Tipo_Producto").val();
      
      var contenido = $("#FichaItem_Contenido").val();
      var und_prod = $("#FichaItem_Unidad_Medida_Prod").val();

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

function div_step(step, e){

    if(step == 1){
        //inicio

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
        }else{
            $("#buttons_1").html('');
        }

        $('#collapse_1').collapse({
          toggle: true
        });
        $("#collapse_2").hide();
        $("#collapse_3").hide();
        $("#collapse_4").hide();
        $("#collapse_5").hide();

        $('#img_info_1').addClass('fas fa-circle');
        $("#img_info_2").addClass("fas fa-clock");
        $("#img_info_3").addClass("fas fa-clock");
        $("#img_info_4").addClass("fas fa-clock");
        $("#img_info_5").addClass("fas fa-clock");
    }
}

</script>

<h4>Solicitud creación de producto en siesa</h4>

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
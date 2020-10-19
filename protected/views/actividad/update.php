<?php
/* @var $this ActividadController */
/* @var $model Actividad */

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Nombres');

//para combos de grupos
$lista_grupos = CHtml::listData($grupos, 'Id_Dominio', 'Dominio');

$lista_tipos = array();

//para combos de tipos
foreach ($tipos as $t) {
  if($t->Cantidad != ""){
    $lista_tipos[$t->Id_Tipo] = $t->Cantidad." - ".$t->Tipo; 
  }else{
    $lista_tipos[$t->Id_Tipo] = $t->Tipo;
  }
}

?>

<script>

$(function() {

	$('#Actividad_Id_Grupo').val(<?php echo $model->Id_Grupo ?>).trigger('change');

    $("#valida_form").click(function() {

      var form = $("#actividad-form");
      var settings = form.data('settings') ;

      var estado = $("#Actividad_Estado").val();
      var fecha_cierre = $("#Actividad_Fecha_Cierre").val();
      var hora_cierre = $("#Actividad_Hora_Cierre").val();

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
            $.each(settings.attributes, function () {
                $.fn.yiiactiveform.updateInput(this,messages,form); 
            });

            if(estado == 2){	

            	if(fecha_cierre != "" && hora_cierre != ""){
	            	//se envia el form
		        	form.submit();
		        	loadershow();
            	}else{
            		if(fecha_cierre == ""){
			            $('#Actividad_Fecha_Cierre_em_').html('Fecha de cierre es requerido.');
			            $('#Actividad_Fecha_Cierre_em_').show(); 
			        }
			        if(hora_cierre == ""){
			            $('#Actividad_Hora_Cierre_em_').html('Hora de cierre es requerido.');
			            $('#Actividad_Hora_Cierre_em_').show(); 
			        }
            	}

            }else{
            	//se envia el form
            	form.submit();
            	loadershow();	
            }
                
          } else {
              settings = form.data('settings'),
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });

              if(fecha_cierre == ""){
			    $('#Actividad_Fecha_Cierre_em_').html('Fecha de cierre es requerido.');
			    $('#Actividad_Fecha_Cierre_em_').show(); 
			  }
			  
			  if(hora_cierre == ""){
			    $('#Actividad_Hora_Cierre_em_').html('Hora de cierre es requerido.');
			    $('#Actividad_Hora_Cierre_em_').show(); 
			  }

              settings.submitting = false ;
          }
      });
    });

    //variables para el lenguaje del datepicker
  	$.fn.datepicker.dates['es'] = {
	  days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
	  daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
	  daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
	  months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	  monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
	  today: "Hoy",
	  clear: "Limpiar",
	  format: "yyyy-mm-dd",
	  titleFormat: "MM yyyy",
	  weekStart: 1
	};

	$("#Actividad_Fecha_Cierre").datepicker({
	  language: 'es',
	  autoclose: true,
	  orientation: "right bottom",
	  startDate: '<?php echo $model->Fecha ?>',
	});

  $('#Actividad_Estado').change(function() {

		var value = $(this).val();

		$('#Actividad_Fecha_Cierre_em_').html('');
		$('#Actividad_Hora_Cierre_em_').html('');
		$('#Actividad_Fecha_Cierre').val('');
		$('#Actividad_Hora_Cierre').val('');

		if(value == 2){
			
			$('#fecha_cierre').show();
			$('#hora_cierre').show();

		}else{
			
			$('#fecha_cierre').hide();
			$('#hora_cierre').hide();
		}
	   
	});

  	$("#Actividad_Id_Grupo").change(function () {
      vlr = $("#Actividad_Id_Grupo").val();
      if(vlr != ""){
        var data = {grupo: vlr}
        $.ajax({ 
          type: "POST", 
          url: "<?php echo Yii::app()->createUrl('actividad/gettipos'); ?>",
          data: data,
          dataType: 'json',
          success: function(data){ 
            $("#Actividad_Id_Tipo").html('');
            $("#Actividad_Id_Tipo").append('<option value=""></option>');
            $.each(data, function(i,item){
                $("#Actividad_Id_Tipo").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
            });
            $("#Actividad_Id_Tipo").val('').trigger('change');
            $("#div_tipo").show();
          }
        });
      }else{
        $("#Actividad_Id_Tipo").val('').trigger('change');
        $("#div_tipo").hide();
      }
    });

});

</script>


<h4>Resumen de actividad</h4>

<?php $this->renderPartial('_form2', array('model'=>$model, 'hist'=>$hist, 'lista_usuarios'=>$lista_usuarios, 'lista_grupos'=>$lista_grupos, 'lista_tipos'=>$lista_tipos)); ?>
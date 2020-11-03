<?php
/* @var $this TipoActController */
/* @var $model TipoAct */

//para combos de grupos
$lista_grupos = CHtml::listData($grupos, 'Id_Dominio', 'Dominio');

//para combos de opciones p
$lista_opciones_p = CHtml::listData($opciones_p, 'Id_Tipo', 'Tipo');

?>

<script>

$(function() {

	$("#valida_form").click(function() {
    	var form = $("#tipo-act-form");
    	var settings = form.data('settings') ;

      	settings.submitting = true ;
      	$.fn.yiiactiveform.validate(form, function(messages) {
          	if($.isEmptyObject(messages)) {
              	$.each(settings.attributes, function () {
                 	$.fn.yiiactiveform.updateInput(this,messages,form); 
             	});
                 
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

    $("#TipoAct_Fecha_Inicio").datepicker({
        language: 'es',
        autoclose: true,
        orientation: "right bottom",
    }).on('changeDate', function (selected) {
      var minDate = new Date(selected.date.valueOf());
      $('#TipoAct_Fecha_Fin').datepicker('setStartDate', minDate);
    });

    $("#TipoAct_Fecha_Fin").datepicker({
        language: 'es',
        autoclose: true,
        orientation: "right bottom",
    }).on('changeDate', function (selected) {
      var maxDate = new Date(selected.date.valueOf());
      $('#TipoAct_Fecha_Inicio').datepicker('setEndDate', maxDate);
    });

});
   	
</script>

<h4>Actualización tipo de actividad</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_grupos' => $lista_grupos, 'lista_opciones_p' => $lista_opciones_p)); ?>
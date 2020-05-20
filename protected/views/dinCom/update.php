<?php
/* @var $this DinComController */
/* @var $model DinCom */

?>

<script>

$(function() {

	$('#DinCom_Id_Plan_Cliente').val(<?php echo $model->Id_Plan_Cliente; ?>).trigger('change');
	$('#DinCom_Id_Plan_Item').val(<?php echo $model->Id_Plan_Item; ?>).trigger('change');

	var data = {plan: <?php echo $model->Id_Plan_Cliente; ?>}
	$.ajax({
		type: "POST", 
		url: "<?php echo Yii::app()->createUrl('DinCom/GetCriteriosPlanCliente'); ?>",
		data: data,
		dataType: 'json',
		success: function(data){
			$('#DinCom_Id_Criterio_Cliente').val('').trigger('change');
		   	$("#DinCom_Id_Criterio_Cliente").html('');
		  	$.each(data, function(i,item){
	      		$("#DinCom_Id_Criterio_Cliente").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
		  	});
		  	$("#div_cri_cli").show();
		  	$("#DinCom_Id_Criterio_Cliente").val(<?php echo $json_criterio_cliente ?>).trigger('change');
			
		}
	});

	var data = {plan: <?php echo $model->Id_Plan_Item; ?>}
	$.ajax({ 
		type: "POST", 
		url: "<?php echo Yii::app()->createUrl('DinCom/GetCriteriosPlanItem'); ?>",
		data: data,
		dataType: 'json',
		success: function(data){
			$('#DinCom_Id_Criterio_Item').val('').trigger('change');
		   	$("#DinCom_Id_Criterio_Item").html('');
		  	$.each(data, function(i,item){
	      		$("#DinCom_Id_Criterio_Item").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
		  	});
		  	$("#div_cri_item").show();
		  	$("#DinCom_Id_Criterio_Item").val(<?php echo $json_criterio_item ?>).trigger('change');

		}
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

	$("#DinCom_Fecha_Inicio").datepicker({
	  language: 'es',
	  autoclose: true,
	  orientation: "right bottom",
	}).on('changeDate', function (selected) {
	var minDate = new Date(selected.date.valueOf());
	$('#DinCom_Fecha_Fin').datepicker('setStartDate', minDate);
	});

	$("#DinCom_Fecha_Fin").datepicker({
	  language: 'es',
	  autoclose: true,
	  orientation: "right bottom",
	}).on('changeDate', function (selected) {
	var maxDate = new Date(selected.date.valueOf());
	$('#DinCom_Fecha_Inicio').datepicker('setEndDate', maxDate);
	});
	
    $("#DinCom_Id_Plan_Cliente").change(function() {
  		var plan = $(this).val();
	  	if(plan != ""){
  			var data = {plan: plan}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('DinCom/GetCriteriosPlanCliente'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){
					$('#DinCom_Id_Criterio_Cliente').val('').trigger('change');
				   	$("#DinCom_Id_Criterio_Cliente").html('');
				  	$.each(data, function(i,item){
			      		$("#DinCom_Id_Criterio_Cliente").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
				  	});
				  	$("#div_cri_cli").show();	
				}
			});
	 	}else{
      		$('#DinCom_Id_Criterio_Cliente').val('').trigger('change');
      		$("#div_cri_cli").hide();    
	 	}

	});

	$("#DinCom_Id_Plan_Item").change(function() {
  		var plan = $(this).val();
	  	if(plan != ""){
  			var data = {plan: plan}
			$.ajax({ 
				type: "POST", 
				url: "<?php echo Yii::app()->createUrl('DinCom/GetCriteriosPlanItem'); ?>",
				data: data,
				dataType: 'json',
				success: function(data){
					$('#DinCom_Id_Criterio_Item').val('').trigger('change');
				   	$("#DinCom_Id_Criterio_Item").html('');
				  	$.each(data, function(i,item){
			      		$("#DinCom_Id_Criterio_Item").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
				  	});
				  	$("#div_cri_item").show();
				}
			});
	 	}else{
      		$('#DinCom_Id_Criterio_Item').val('').trigger('change');
      		$("#div_cri_item").hide();    
	 	}

	});

	
	
});

</script>

<h4>Actualización de dinamica comercial</h4>

<?php $this->renderPartial('_form2', array('model'=>$model,'json_criterio_cliente'=>$json_criterio_cliente)); ?>
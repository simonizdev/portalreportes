<?php
/* @var $this TipoActController */
/* @var $model TipoAct */

//para combos de grupos
$lista_grupos = CHtml::listData($grupos, 'Id_Dominio', 'Dominio');

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

});
   	
</script>

<h4>Actualización tipo de actividad</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_grupos' => $lista_grupos)); ?>
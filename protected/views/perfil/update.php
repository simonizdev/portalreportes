<?php
/* @var $this PerfilController */
/* @var $model Perfil */

?>

<script>

$(function() {
	//funcion para cargar el tree de opciones de menu
	var data = {id_perfil: <?php echo $model->Id_Perfil; ?>}
	$.ajax({ 
		type: "POST", 
		url: "<?php echo Yii::app()->createUrl('perfil/getmenu'); ?>",
		data: data,
		dataType: 'json',
		success: function(data){
			if (data.length > 0) {
			    $.each(data, function(indice0) {
			    	//nivel 1
		    		id0 = data[indice0]['id'];
		    		text0 = data[indice0]['text'];
		    		children0 = data[indice0]['children'];
		    		check0 = data[indice0]['check'];
		    		if (check0 == 1) { checked0 = 'checked'; } else { checked0 = ''; }
		    		$("#tree").append('<li id="li_'+id0+'"><input type="checkbox" '+checked0+' value="'+id0+'"><span> '+text0+'</span></li>');
		    		if (children0.length > 0) {
		    			//nivel 2
		    			$("#li_"+id0+"").append('<ul id="ul_'+id0+'"></ul>');
		    			$.each(children0, function(indice1) {
		    				id1 = children0[indice1]['id'];
				    		text1 = children0[indice1]['text'];
				    		children1 = children0[indice1]['children'];
				    		check1 = children0[indice1]['check'];
		    				if (check1 == 1) { checked1 = 'checked'; } else { checked1 = ''; }
				    		$("#ul_"+id0+"").append('<li id="li_'+id1+'"><input type="checkbox" '+checked1+' value="'+id1+'"><span> '+text1+'</span></li>');
				    		if (children1.length > 0) {
				    			//nivel 3
				    			$("#li_"+id1+"").append('<ul id="ul_'+id1+'"></ul>');
				    			$.each(children1, function(indice2) {
				    				id2 = children1[indice2]['id'];
						    		text2 = children1[indice2]['text'];
						    		children2 = children1[indice2]['children'];
						    		check2 = children1[indice2]['check'];
		    						if (check2 == 1) { checked2 = 'checked'; } else { checked2 = ''; }
						    		$("#ul_"+id1+"").append('<li id="li_'+id2+'"><input type="checkbox" '+checked2+' value="'+id2+'"><span> '+text2+'</span></li>');	
				    			});	
							}	
		    			});
					}
			    });
			}
			//se inicializa el tree
			$('#example-0 div').tree({
		        collapseUiIcon: 'ui-icon-plus',
		        expandUiIcon: 'ui-icon-minus',
		        leafUiIcon: 'ui-icon-bullet',
		    });
			//se colapsa el tree
			$(".ui-icon-minus").trigger("click");
			//se muestra el tree
			$("#tree").fadeIn();  
		}
	});
});




function valida_opciones(){
	var selected = '';    
    $('input[type=checkbox]').each(function(){
        if (this.checked) {
            selected += $(this).val()+',';
        }
    });
    var cadena = selected.slice(0,-1);
    $('#Perfil_opciones_menu').val(cadena);
    
    return true;  
}
   	
</script>

<h3>Actualización de perfil</h3> 
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
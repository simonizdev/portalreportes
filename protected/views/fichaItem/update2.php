<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */

?>

<script type="text/javascript">
$(function() {

	$('#FichaItem_Codigo_Item').attr("disabled", true);

	$("#rechazar_form").click(function() {
		var opcion = confirm("Desea rechazar la solicitud?");
	    if (opcion == true) {
	    	loadershow();
	       	location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/notas&id='.$model->Id; ?>';
	   	} 
	});

	$("#aprobar_form").click(function() {
    	loadershow();
       	location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/aprobar&id='.$model->Id; ?>';
	});

});
</script>

<h4>Revisión solicitud actualización de producto en siesa</h4>

<?php 
$this->renderPartial('_form4', array(
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
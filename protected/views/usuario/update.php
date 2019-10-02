<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

//para combos de perfiles
$lista_perfiles = CHtml::listData($m_perfiles, 'Id_Perfil', 'Descripcion');

//para combos de bodegas
$lista_bodegas = CHtml::listData($m_bodegas, 'Id', 'Descripcion'); 

//para combos tipos de docto
$lista_tipos_docto = CHtml::listData($m_tipos_docto, 'Id', 'Descripcion'); 

?>

<script type="text/javascript">
$(function() {
	//se llenan las opciones seleccionadas del modelo
	$('#Usuario_perfiles').val(<?php echo $json_perfiles_activos ?>).trigger('change');
	$('#Usuario_bodegas').val(<?php echo $json_bodegas_activas ?>).trigger('change');
	$('#Usuario_tipos_docto').val(<?php echo $json_td_activos ?>).trigger('change');
});
</script>

<h3>Actualización de usuario</h3>    
<?php $this->renderPartial('_form', array('model'=>$model, 'lista_perfiles'=>$lista_perfiles, 'lista_bodegas'=>$lista_bodegas, 'lista_tipos_docto'=>$lista_tipos_docto)); ?> 
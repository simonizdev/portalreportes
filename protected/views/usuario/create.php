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

<h3>Creación de usuario</h3>    
<?php $this->renderPartial('_form', array('model'=>$model, 'lista_perfiles'=>$lista_perfiles, 'lista_bodegas'=>$lista_bodegas, 'lista_tipos_docto'=>$lista_tipos_docto)); ?>  


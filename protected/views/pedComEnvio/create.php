<?php
/* @var $this PedComEnvioController */
/* @var $model PedComEnvio */

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Nombres'); 

?>

<h4>Creación configuración envio por vendedor</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_usuarios'=>$lista_usuarios)); ?>
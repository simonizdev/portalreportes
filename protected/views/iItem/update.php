<?php
/* @var $this IItemController */
/* @var $model IItem */

//para combos de lineas
$lista_lineas = CHtml::listData($lineas, 'Id', 'Descripcion'); 

?>

<script type="text/javascript">

</script>

<h4>Actualización de item</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_unidades'=>$lista_unidades, 'lista_lineas'=>$lista_lineas, 'id_asignar'=>$id_asignar)); ?>
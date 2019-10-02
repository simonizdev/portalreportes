<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h3>Lista de materiales</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reporte-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="row">
  <div class="col-sm-8">
    <div class="form-group">
          <?php echo $form->error($model,'item', array('class' => 'pull-right badge bg-red')); ?>
          <?php echo $form->label($model,'item'); ?>
          <?php echo $form->textField($model,'item'); ?>
          <?php
              $this->widget('ext.select2.ESelect2', array(
                  'selector' => '#Reporte_item',
                  'options'  => array(
                      'allowClear' => true,
                      'minimumInputLength' => 5,
                      'width' => '100%',
                      'language' => 'es',
                      'ajax' => array(
                          'url' => Yii::app()->createUrl('reporte/SearchItem'),
                          'dataType'=>'json',
                          'data'=>'js:function(term){return{q: term};}',
                          'results'=>'js:function(data){ return {results:data};}'                   
                      ),
                      'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Reporte_item"); return "No se encontraron resultados"; }',
                      'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Reporte_item\')\">Limpiar campo</button>"; }',
                  ),
              ));
          ?>
      </div>
  </div>
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="submit" class="btn btn-success" ><i class="fa fa-search"></i> Buscar</button>
</div>

<?php $this->endWidget(); ?>

<script>

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html("");
}

</script>




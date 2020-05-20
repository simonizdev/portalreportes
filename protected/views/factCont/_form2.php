<?php
/* @var $this FactContController */
/* @var $model FactCont */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fact-cont-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Actualización de factura</h4>
  </div>
  <div class="col-sm-6 text-right">  
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=factCont/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    <button type="button" class="btn btn-success btn-sm" id="toogle_button"><i class="fa fa-low-vision"></i> Ver / ocultar doc.</button>
	<button type="submit" class="btn btn-success btn-sm" ><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
  </div>
</div>

<div id="info">
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<?php echo $form->label($model,'Empresa'); ?>
				<?php echo '<p>'.$model->DescEmpresa($model->Empresa).'</p>';?>        
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">  
				<?php echo $form->error($model,'Area', array('class' => 'badge badge-warning float-right')); ?>
				<?php echo $form->label($model,'Area'); ?>
				<?php
				  $this->widget('ext.select2.ESelect2',array(
					'name'=>'FactCont[Area]',
					'id'=>'FactCont_Area',
					'data'=>UtilidadesVarias::listaareas(),
					'value' => $model->Area,
					'options'=>array(
						'placeholder'=>'Seleccione...',
						'width'=> '100%',
						'allowClear'=>true,
					),
				  ));
				?>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<?php echo $form->label($model,'Num_Factura'); ?>
				<?php echo '<p>'.$model->Num_Factura.'</p>';?> 
			</div>
		</div> 
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<?php echo $form->label($model,'Fecha_Factura'); ?>
				<?php echo '<p>'.UtilidadesVarias::textofecha($model->Fecha_Factura).'</p>';?> 
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<?php echo $form->label($model,'Fecha_Radicado'); ?>
				<?php echo '<p>'.UtilidadesVarias::textofecha($model->Fecha_Radicado).'</p>';?> 
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<?php echo $form->label($model,'Proveedor'); ?>
				<?php echo '<p>'.$model->DescProveedor($model->Proveedor).'</p>';?> 
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
				<?php echo $form->label($model,'Valor'); ?>
				<?php echo '<p>'.number_format($model->Valor, 2).'</p>';?> 
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
				<?php echo $form->label($model,'Moneda'); ?>
				<?php echo '<p>'.$model->DescMoneda($model->Moneda).'</p>';?> 
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<?php echo $form->label($model,'Observaciones'); ?>
				<?php if($model->Observaciones == ""){ $Observaciones = "-"; }else{ $Observaciones = $model->Observaciones; } ?> 
				<?php echo '<p>'.$Observaciones.'</p>';?> 
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div id="viewer" class="col-sm-12 text-center" style="display: none;">

    </div>   
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/pdf.js/pdf.js"></script>
<script type="text/javascript">

$(function() {

    renderPDF('<?php echo Yii::app()->getBaseUrl(true).'/images/fact_cont/'.$model->Doc_Soporte; ?>', document.getElementById('viewer'));

    loadershow();

    $('#toogle_button').click(function(){
        $('#info').slideToggle('fast');
        $('#viewer').slideToggle('fast');
        return false;
    });

});

</script>
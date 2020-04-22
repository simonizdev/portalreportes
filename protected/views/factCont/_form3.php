<?php
/* @var $this FactPendController */
/* @var $model FactPend */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fact-pend-form',
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
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Empresa'); ?>
            <?php echo '<p>'.$model->DescEmpresa($model->Empresa).'</p>';?>        
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">  
            <?php echo $form->label($model,'Area'); ?>
            <?php echo '<p>'.UtilidadesVarias::descarea($model->Area).'</p>';?>
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
    <div class="col-sm-3">
        <div class="form-group">
            <?php echo $form->label($model,'Estado'); ?>
            <?php echo '<p>'.$model->DescEstado($model->Estado).'</p>';?> 
            <?php echo $form->hiddenField($model,'Estado', array('class' => 'form-control')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Creacion'); ?>
            <?php echo '<p>'.$model->idusuariocre->Usuario.'</p>';?> 
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Creacion'); ?>
            <?php echo '<p>'.UtilidadesVarias::textofechahora($model->Fecha_Creacion).'</p>';?> 
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Actualizacion'); ?>
            <?php echo '<p>'.$model->idusuarioact->Usuario.'</p>';?> 
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Actualizacion'); ?>
            <?php echo '<p>'.UtilidadesVarias::textofechahora($model->Fecha_Actualizacion).'</p>';?> 
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Id_Usuario_Revision'); ?>
            <?php if($model->Id_Usuario_Revision == ""){ $Usuario_Revision = "-"; }else{ $Usuario_Revision = $model->idusuariorev->Usuario; } ?> 
            <?php echo '<p>'.$Usuario_Revision.'</p>';?> 
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Fecha_Revision'); ?>
            <?php if($model->Fecha_Revision == ""){ $Fecha_Revision = "-"; }else{ $Fecha_Revision = UtilidadesVarias::textofechahora($model->Fecha_Revision); } ?> 
            <?php echo '<p>'.$Fecha_Revision.'</p>';?> 
        </div>
    </div>
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=factCont/admin2'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" id="toogle_button"><i class="fa fa-low-vision"></i> Ver / ocultar soporte </button>
    <?php if($model->Estado == 1){ ?>
    <button type="button" class="btn btn-success" id="recibir"><i class="fa fa-check"></i> Recibir factura</button>
    <button type="button" class="btn btn-success" id="rechazar"><i class="fa fa-close"></i> Rechazar factura </button>    
   <?php } ?>
</div>

<div class="row">
    <div id="viewer" class="col-sm-12 text-center" style="display: none;">
    </div>  
</div>


<?php $this->endWidget(); ?>

<script type="text/javascript">

var archivo =  "<?php echo $model->Doc_Soporte; ?>";
var form = $("#fact-pend-form"); 

renderPDF('<?php echo Yii::app()->getBaseUrl(true).'/images/fact_cont/'.$model->Doc_Soporte; ?>', document.getElementById('viewer'));

function clear_select2_ajax(id){
	$('#'+id+'').val('').trigger('change');
	$('#s2id_'+id+' span').html("");
}


$("#recibir").click(function() {
  var opcion = confirm("Esta seguro de recibir esta factura ?");
    if (opcion == true) {
        $(".ajax-loader").fadeIn('fast');
        $("#FactCont_Estado").val(2);
        form.submit();
    }   
});

$("#rechazar").click(function() {
  var opcion = confirm("Esta seguro de rechazar esta factura ?");
    if (opcion == true) {
        $(".ajax-loader").fadeIn('fast');
        $("#FactCont_Estado").val(0);
        form.submit();
    }   
});

</script>

<?php
/* @var $this FactPendController */
/* @var $model FactPend */
/* @var $form CActiveForm */
?>

<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true).'/components/pdf.js/pdf.js'; ?>"></script>
<script type="text/javascript">

    $(function() {

        $('.ajax-loader').fadeIn('fast');
        setTimeout(function(){ $('.ajax-loader').fadeOut('fast'); }, 3000);

        $('#toogle_button').click(function(){
            
            var archivo =  "<?php echo $model->Doc_Soporte; ?>"; 
            var ext = archivo.split('.').pop();

            if($.trim(ext) == "pdf"){
                $('#viewer').toggle('fast');
            }else{
                $('#viewer_img').toggle('fast');
            }
            
            return false;

        });

    });

    function renderPDF(url, canvasContainer, options) {

        var options = options || { scale: 1.5 };
            
        function renderPage(page) {
            var viewport = page.getViewport(options.scale);
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var renderContext = {
              canvasContext: ctx,
              viewport: viewport
            };
            
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            canvasContainer.appendChild(canvas);
            
            page.render(renderContext);
        }
        
        function renderPages(pdfDoc) {
            for(var num = 1; num <= pdfDoc.numPages; num++)
                pdfDoc.getPage(num).then(renderPage);
        }

        PDFJS.disableWorker = true;
        PDFJS.getDocument(url).then(renderPages);

    }
   
</script> 

<h3>Visualizando facturas</h3>

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
    <?php 
        if($opc == 1){ ?>
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=factCont/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>   
   <?php } 
        if($opc == 2){ ?>
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=factCont/admin2'; ?>';"><i class="fa fa-reply"></i> Volver</button>   
   <?php }
        if($opc == 3){ ?>
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=factCont/admin3'; ?>';"><i class="fa fa-reply"></i> Volver</button>   
   <?php } ?>
   <button type="button" class="btn btn-success" id="toogle_button"><i class="fa fa-low-vision"></i> Ver / ocultar soporte </button>
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

</script>

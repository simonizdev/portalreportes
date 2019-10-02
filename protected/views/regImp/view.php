<?php
/* @var $this RegImpController */
/* @var $model RegImp */
 
?>


<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true).'/components/pdf.js/pdf.js'; ?>"></script>
<script type="text/javascript">

$(function() {

    $('.ajax-loader').fadeIn('fast');
    setTimeout(function(){ $('.ajax-loader').fadeOut('fast'); }, 3000);

    $("#download").click(function() {
    	$('#link')[0].click();
    });

    $('#toogle_button').click(function(){
        $('#viewer').toggle('fast');
        return false;
    });

});

function renderPDF(url, canvasContainer, options) {

    var options = options || { scale: 1 };
        
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

<h3>Visualizando declaración de importación</h3>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Número</label>
            <?php echo '<p>'.$model->Numero.'</p>';?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Fecha</label>
            <?php echo '<p>'.UtilidadesVarias::textofecha($model->Fecha).'</p>';?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Item(s)</label>
            <?php echo '<p>'.$model->Items.'</p>';?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Usuario que creo</label>
            <?php echo '<p>'.$model->idusuariocre->Usuario.'</p>';?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Fecha de creación</label>
            <?php echo '<p>'.UtilidadesVarias::textofechahora($model->Fecha_Creacion).'</p>';?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Usuario que actualizó</label>
            <?php echo '<p>'.$model->idusuarioact->Usuario.'</p>';?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Fecha de actualización</label>
            <?php echo '<p>'.UtilidadesVarias::textofechahora($model->Fecha_Actualizacion).'</p>';?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 ">
        <div class="btn-group" style="padding-bottom: 2%">
           	<button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=regImp/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
           	<button type="button" class="btn btn-success" id="toogle_button"><i class="fa fa-low-vision"></i> Ver / Ocultar Documento</button>
            <button type="button" class="btn btn-success" id="download"><i class="fa fa-download"></i> Descargar documento </button>
            <div style="display: none;">
                <a href="<?php echo Yii::app()->getBaseUrl(true).'/images/reg_imp/'.$model->Documento; ?>" download="<?php echo $model->Documento; ?>" style="display: none;" id="link"></a>
            </div>
        </div>
    </div>

    <div id="viewer" class="col-sm-12 text-center" style="display: none;">

    </div>   
</div>


<script type="text/javascript">
renderPDF('<?php echo Yii::app()->getBaseUrl(true).'/images/reg_imp/'.$model->Documento; ?>', document.getElementById('viewer'));
</script>  


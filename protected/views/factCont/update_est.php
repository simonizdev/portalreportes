<?php
/* @var $this FactPendController */
/* @var $model FactPend */

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

<h3>Visualizando factura</h3>

<?php $this->renderPartial('_form3', array('model'=>$model)); ?>
<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h3>Detalle de materiales</h3>

<div class="row">
  <div class="col-sm-12">
    <div class="form-group">
      <div id="resultados" style="display: none;">
        <div>
            
        </div>
      </div> 
      <p id="mensaje" style="display: none;">Este item no tiene registrada lista de materiales.</p>           
    </div>
  </div> 
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=reporte/listamateriales'; ?>';"><i class="fa fa-reply"></i> Volver</button>
</div>

<script>

$(function() {

  $(".ajax-loader").show();

  var data = {item: <?php echo $item; ?>}
  $(".ajax-loader").show();
  $.ajax({ 
    type: "POST", 
    url: "<?php echo Yii::app()->createUrl('reporte/listamaterialespant'); ?>",
    data: data,
    success: function(data){ 
      $(".ajax-loader").hide();
        
      if(data == ''){
        $("#mensaje").show();
        $("#resultados").hide();
      }else{

        $("#mensaje").hide();
        $("#resultados").show();

        $("#resultados div").html(data);

        //se inicializa el tree
        $('#resultados div').tree({
            //alert('fdgdf');
            collapseUiIcon: 'ui-icon-plus',
            expandUiIcon: 'ui-icon-minus',
            leafUiIcon: 'ui-icon-bullet',
        });

      }
    }
  });
});

</script>


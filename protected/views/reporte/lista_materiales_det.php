<?php
/* @var $this InventarioController */
/* @var $model Inventario */

?>

<h4>Detalle de materiales</h4>

<div class="row">
  <div class="col-sm-12">
    <div class="form-group">
      <div id="resultados" style="display: none;">
        <div>
            
        </div>
      </div> 
      <div class="alert alert-warning alert-dismissible" id="mensaje" style="display: none;">
        <h5><i class="icon fas fa-info-circle"></i>Info</h5>
        Este item no tiene registrada lista de materiales.
      </div>           
    </div>
  </div> 
</div>

<div class="row mb-2">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=reporte/listamateriales'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    </div>
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


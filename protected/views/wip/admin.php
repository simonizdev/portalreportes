<?php
/* @var $this WipController */
/* @var $model Wip */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.yiiGridView.export();
});
$.fn.yiiGridView.export = function() {
    $.fn.yiiGridView.update('wip-grid',{ 
        success: function() {
            window.location = '". $this->createUrl('exportexcel')  . "';
            $(\".ajax-loader\").fadeIn('fast');
            setTimeout(function(){ $(\".ajax-loader\").fadeOut('fast'); }, 10000);
        },
        data: $('.search-form form').serialize() + '&export=true'
    });
}
$('.search-button').click(function(){
	$('.search-form').toggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$('#wip-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Administración de WIP</h3>

<div class="btn-group" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=Wip/create'; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
    <button type="button" class="btn btn-success search-button"><i class="fa fa-filter"></i> Busqueda avanzada</button>
    <button type="button" class="btn btn-success" id="export-excel"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
</div>

<div class="search-form" style="display:none;">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'lista_cadenas'=>$lista_cadenas,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'wip-grid',
	'dataProvider' => $model->search(),
	//'filter'=>$model,
    'enableSorting' => false,
	'columns'=>array(
		//'ID',
		//'CONSECUTIVO',
		array(
            'name'=>'WIP',
            'htmlOptions'=>array('width'=>'70px'),
    	),
    	array(
            'name' => 'CADENA',
            'type' => 'raw',
            'value' => '$data->desccadena($data->ID)',
        ),
		'ID_ITEM',
		array(
            'name' => 'DESCRIPCION',
            'value' => 'substr($data->DESCRIPCION, 0, 35)',
        ),
		'RESPONSABLE',
		'CANT_OC_AL_DIA',
		'CANT_PENDIENTE',
		'CANT_VEND',
		'INVENTARIO_TOTAL',
		/*'ESTADO_OP',
		'DE_0_A_30_DIAS',
		'DE_31_A_60_DIAS',
		'DE_61_A_90_DIAS',
		'MAS_DE_90_DIAS',
		'WIP',
		'FECHA_SOLICITUD_WIP',
		'FECHA_ENTREGA_WIP',
		'CANT_A_ARMAR',
		'DIAS_VENCIMIENTO',
		'REDISTRIBUCION',
		'ESTADO_COMERCIAL',
		'UN',
		'SUB_MARCA',
		'FAMILIA',
		'SUB_FAMILIA',
		'GRUPO',
		'ORACLE',
		'PTM',
		'ID_USUARIO_CREACION',
		'ID_USUARIO_ACTUALIZACION',
		'FECHA_CREACION',
		'FECHA_ACTUALIZACION',
		*/
		array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                    'visible'=> '$data->vbtnview($data->FECHA_CUMPLIDO)',
                    'url'=>'Yii::app()->createUrl("Wip/view", array("id"=>$data->ID))',
                ),
                'update'=>array(
                    'label'=>'<i class="fa fa-pencil actions text-black"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Actualizar'),
                    'visible'=> '(Yii::app()->user->getState("permiso_act") == true && $data->vbtnupdate($data->FECHA_CUMPLIDO) == true)',
                    'url'=>'Yii::app()->createUrl("Wip/update", array("id"=>$data->ID))',
                ),   
            )
        ),
        array(
    		'value'=>'CHTML::button(\'Generar pdf\', array(\'onClick\'=>"firmawip(\'$data->ID\')", \'class\'=>"btn btn-xs btn-success",))',
      		'type'=>'raw',
			'htmlOptions'=>array('data-toggle'=>'modal', 'data-target'=> '#modal-wip'),
   		),       
	),
)); ?>

<div class="modal fade" id="modal-wip">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">WIP</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        	<input class="form-control" autocomplete="off" name="id_wip" id="id_wip" type="hidden">  
		  	<div class="col-sm-6">
		        <div class="form-group">
		        	<div class="pull-right badge bg-red" id="error_firma" style="display: none"></div>
	                <label>Firma</label>
	                <input class="form-control" autocomplete="off" name="firma_wip" id="firma_wip" onkeyup="convert_may(this)" type="text">
	            </div>
		    </div>
		    <div class="col-sm-6">
		        <div class="form-group">
		        	<div class="pull-right badge bg-red" id="error_cargo" style="display: none"></div>
	                <label>Cargo</label>     
	                <input class="form-control" autocomplete="off" name="cargo_wip" id="cargo_wip" onkeyup="convert_may(this)" type="text">        
	            </div>
		    </div>
		    
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" id="close_modal"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success" id="gen_wip"><i class="fa fa-file-pdf-o"></i> Generar PDF</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">

	$(function(){

		$("#close_modal").click(function() {
  			$('#id_wip').val('');
  			$('#firma_wip').val('');
  			$('#cargo_wip').val('');
  			$('#error_firma').html('');
			$('#error_firma').hide();
			$('#error_cargo').html('');
			$('#error_cargo').hide();
		});

		$("#gen_wip").click(function() {
			
			var id = $('#id_wip').val();
			var firma = $('#firma_wip').val();
			var cargo = $('#cargo_wip').val();

			if(firma != "" && cargo != ""){

				$('#error_firma').html('');
				$('#error_firma').hide();
				$('#error_cargo').html('');
				$('#error_cargo').hide();
				$('#modal-wip').modal('hide');
				$('#firma_wip').val('');
  				$('#cargo_wip').val('');
				var url = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=Wip/genrepwip'; ?>';
				var vars = '&id='+id+'&firma='+firma+'&cargo='+cargo;
				comp_url = url+vars;

  				location.href = comp_url;
				$('#wip-grid').yiiGridView.update('wip-grid');

			}else{
				if(firma == ""){
					$('#error_firma').html('Firma no puede ser nulo.');
					$('#error_firma').show();
				}

				if(cargo == ""){
					$('#error_cargo').html('Firma no puede ser nulo.');
					$('#error_cargo').show();
				}
			}

  			//window.location = url;
		});

	});
	
	function firmawip(idwip){
		$('#id_wip').val('');
		$('#firma_wip').val('');
		$('#cargo_wip').val('');
		$('#error_firma').html('');
		$('#error_firma').hide();
		$('#error_cargo').html('');
		$('#error_cargo').hide();
		$('#id_wip').val(idwip);
	}

</script>

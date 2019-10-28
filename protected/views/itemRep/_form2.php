<?php
/* @var $this ItemRepController */
/* @var $model ItemRep */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'item-rep-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); 

$modelo_rep = Rep::model()->findByPk($id);

?>

<div class="row">
	<div class="col-sm-4">
	    <div class="form-group">
	    	<?php echo $form->hiddenField($model,'Id_Rep', array('class' => 'form-control', 'autocomplete' => 'off','value' => $id)); ?>
	        <?php echo $form->label($model,'Id_Rep'); ?>
	        <?php echo '<p>'.$modelo_rep->Descripcion.'</p>'; ?>
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Item', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Item'); ?>
            <?php echo $form->textField($model,'Id_Item'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#ItemRep_Id_Item',
                    'options'  => array(
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('Rep/SearchItem'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("ItemRep_Id_Item"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'ItemRep_Id_Item\')\">Limpiar campo</button>"; }',
                        'initSelection'=>'js:function(element,callback) {
                            var id=$(element).val(); // read #selector value
                            if ( id !== "" ) {
                                $.ajax("'.Yii::app()->createUrl('Rep/SearchItemById').'", {
                                    data: { id: id },
                                    dataType: "json"
                                }).done(function(data,textStatus, jqXHR) { callback(data[0]); });
                           }
                        }',
                    ),
                ));
                ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Orden', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Orden'); ?>
            <?php echo $form->numberField($model,'Orden', array('class' => 'form-control', 'autocomplete' => 'off',  'step' => '1', 'min' => '0')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Porcentaje', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'Porcentaje'); ?>
		    <?php echo $form->numberField($model,'Porcentaje', array('class' => 'form-control', 'autocomplete' => 'off', 'step' => '0.01', 'min' => '0')); ?>
        </div>
    </div>
</div>

<div class="pull-right badge bg-red" id="error_det" style="display: none;"></div>

<div class="btn-group" id="btn_save" style="padding-bottom: 2%">
   <button type="button" class="btn btn-success" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=rep/update&id='.$id; ?>';"><i class="fa fa-reply"></i> Volver </button>
   <button type="button" class="btn btn-success" onclick="add_item();"><i class="fa fa-floppy-o" ></i> Guardar</button>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html(""); 
}

function add_item(){

	var form = $("#item-rep-form");

	//cabecera
	var id_rep = <?php echo $modelo_rep->Id_Rep; ?>;
	var id_reg = <?php echo $model->Id_Item_Rep ?>;

	//detalle
	var item = $('#ItemRep_Id_Item').val();
	var orden = $('#ItemRep_Orden').val();
	var porcentaje = $('#ItemRep_Porcentaje').val();

	if( item != "" && orden != "" && porcentaje != ""){

		var data = {rep: id_rep, id_reg: id_reg, item: item}
        $.ajax({ 
            type: "POST", 
            url: "<?php echo Yii::app()->createUrl('itemRep/verificarduplicidad'); ?>",
            data: data,
            success: function(response){

                if(response == 0){
                    //se encontro un registro identico en item / bodega
                    $('#error_det').html('Este item ya esta asociado con este reporte.');
                    $('#error_det').show();
                }

                if(response == 1){
                    //si esta disponible la cantidad solicitada
                    $('#error_det').html('');
					$('#error_det').hide();
					$('#btn_save').hide();
                    form.submit();
                }

            }
        });

	}else{
        if(item == ""){
            $('#ItemRep_Id_Item_em_').html('Item no puede ser nulo.');
            $('#ItemRep_Id_Item_em_').show(); 
        }
        if(orden == ""){
            $('#ItemRep_Orden_em_').html('Orden no puede ser nulo.');
            $('#ItemRep_Orden_em_').show();    
        }
        if(porcentaje == ""){
            $('#ItemRep_Porcentaje_em_').html('Porcentaje no puede ser nulo.');
            $('#ItemRep_Porcentaje_em_').show();    
        }
	}

}

$("#ItemRep_Id_Item").change( function (){
	$('#error_det').html('');
	$('#error_det').hide();
   
});

</script>
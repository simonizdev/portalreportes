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

<div id="div_mensaje" style="display: none;">
</div>

<div class="row">
	<div class="col-sm-4">
	    <div class="form-group">
	    	<?php echo $form->hiddenField($model,'Id_Rep', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off','value' => $id)); ?>
	        <?php echo $form->label($model,'Id_Rep'); ?>
	        <?php echo '<p>'.$modelo_rep->Descripcion.'</p>'; ?>
	    </div>
	</div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Item', array('class' => 'badge badge-warning float-right')); ?>
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
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs float-right\" onclick=\"clear_select2_ajax(\'ItemRep_Id_Item\')\">Limpiar campo</button>"; }',
                    ),
                ));
                ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Orden', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->label($model,'Orden'); ?>
            <?php echo $form->numberField($model,'Orden', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off',  'step' => '1', 'min' => '0')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
    		<?php echo $form->error($model,'Porcentaje', array('class' => 'badge badge-warning float-right')); ?>
          	<?php echo $form->label($model,'Porcentaje'); ?>
		    <?php echo $form->numberField($model,'Porcentaje', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'step' => '0.01', 'min' => '0')); ?>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=rep/update&id='.$id; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" onclick="add_item();"><i class="fas fa-save" ></i> Guardar</button>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

function add_item(){

    limp_div_msg();

	var form = $("#item-rep-form");

	//cabecera
	var id_rep = <?php echo $modelo_rep->Id_Rep; ?>;

	//detalle
	var item = $('#ItemRep_Id_Item').val();
	var orden = $('#ItemRep_Orden').val();
	var porcentaje = $('#ItemRep_Porcentaje').val();

	if( item != "" && orden != "" && porcentaje != ""){

		var data = {rep: id_rep, id_reg: null, item: item}
        $.ajax({ 
            type: "POST", 
            url: "<?php echo Yii::app()->createUrl('itemRep/verificarduplicidad'); ?>",
            data: data,
            success: function(response){

                if(response == 0){
                    $('html, body').animate({scrollTop:0}, 'fast');
                        $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
                        $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h5><i class="icon fas fa-exclamation-triangle"></i>Info</h5>Este item ya esta asociado con este reporte.');    
                        $("#div_mensaje").fadeIn('fast');
                        $(".ajax-loader").fadeOut('fast');
                }

                if(response == 1){
                    $(".ajax-loader").fadeIn('fast');
                    form.submit();
                }

            }
        });

	}else{
        if(item == ""){
            $('#ItemRep_Id_Item_em_').html('Item es requerido.');
            $('#ItemRep_Id_Item_em_').show(); 
        }
        if(orden == ""){
            $('#ItemRep_Orden_em_').html('Orden es requerido.');
            $('#ItemRep_Orden_em_').show();    
        }
        if(porcentaje == ""){
            $('#ItemRep_Porcentaje_em_').html('Porcentaje es requerido.');
            $('#ItemRep_Porcentaje_em_').show();    
        }
	}

}

</script>
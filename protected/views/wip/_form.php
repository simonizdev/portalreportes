<?php
/* @var $this WipController */
/* @var $model Wip */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wip-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div id="div_mensaje" style="display: none;"></div>

<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
            <input type="hidden" id="fecha_min" value="<?php echo $fecha_min; ?>">
    		<?php echo $form->error($model,'WIP', array('class' => 'pull-right badge bg-red')); ?>
          	<?php echo $form->label($model,'WIP'); ?>
		    <?php echo $form->textField($model,'WIP', array('class' => 'form-control', 'maxlength' => '7', 'readonly' => true, 'value' => $n_wip)); ?>
            <?php echo $form->hiddenField($model,'cad_item'); ?>
            <?php echo $form->hiddenField($model,'cad_cant'); ?>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'CADENA', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'CADENA'); ?>
            <?php
              $this->widget('ext.select2.ESelect2',array(
                  'name'=>'Wip[CADENA]',
                  'id'=>'Wip_CADENA',
                  'data'=> $lista_cadenas,
                  'htmlOptions'=>array(
                  ),
                  'options'=>array(
                      'placeholder'=>'Seleccione...',
                      'width'=> '100%',
                      'allowClear'=>true,
                  ),
              ));
            ?>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-sm-4">
	    <div class="form-group">
			<?php echo $form->error($model,'FECHA_SOLICITUD_WIP', array('class' => 'pull-right badge bg-red')); ?>
			<?php echo $form->label($model,'FECHA_SOLICITUD_WIP'); ?>
			<?php echo $form->textField($model,'FECHA_SOLICITUD_WIP', array('class' => 'form-control datepicker', 'readonly' => true)); ?>
	    </div>
  	</div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'FECHA_ENTREGA_WIP', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'FECHA_ENTREGA_WIP'); ?>
            <?php echo $form->textField($model,'FECHA_ENTREGA_WIP', array('class' => 'form-control datepicker', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'RESPONSABLE', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'RESPONSABLE'); ?>
            <?php echo $form->textField($model,'RESPONSABLE', array('class' => 'form-control', 'maxlength' => '200', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->error($model,'OBSERVACIONES', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'OBSERVACIONES'); ?>
            <?php echo $form->textField($model,'OBSERVACIONES', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div id="reg">
    <div class="row">  
        <div class="col-sm-8">
            <div class="form-group">
                <?php echo $form->error($model,'ID_ITEM', array('class' => 'pull-right badge bg-red')); ?>
                <?php echo $form->label($model,'ID_ITEM'); ?>
                <?php echo $form->textField($model,'ID_ITEM'); ?>
                <?php
                    $this->widget('ext.select2.ESelect2', array(
                        'selector' => '#Wip_ID_ITEM',
                        'options'  => array(
                            'allowClear' => true,
                            'minimumInputLength' => 5,
                            'width' => '100%',
                            'language' => 'es',
                            'ajax' => array(
                                'url' => Yii::app()->createUrl('promocion/SearchItem'),
                                'dataType'=>'json',
                                'data'=>'js:function(term){return{q: term};}',
                                'results'=>'js:function(data){ return {results:data};}'                   
                            ),
                            'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Wip_ID_ITEM"); return "No se encontraron resultados"; }',
                            'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Wip_ID_ITEM\')\">Limpiar campo</button>"; }',
                        ),
                    ));
                ?>
            </div>
        </div>
      	<div class="col-sm-4">
            <div class="form-group">
            	<?php echo $form->error($model,'CANT_A_ARMAR', array('class' => 'pull-right badge bg-red')); ?>
                <?php echo $form->label($model,'CANT_A_ARMAR'); ?>
                <?php echo $form->numberField($model,'CANT_A_ARMAR', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            </div>
        </div>
    </div>
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=Wip/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" id="add" onclick="add_item();"><i class="fa fa-plus"></i> Agregar</button>
</div>


<div id="contenido">
    
</div>


<div class="btn-group" id="btn_save" style="display: none;padding-bottom: 2%">
    <button type="submit" class="btn btn-success" onclick="return valida_opciones(event);"><i class="fa fa-floppy-o"></i> Guardar</button>
</div>


<?php $this->endWidget(); ?>

<script>

$(function() {

    $('form').keypress(function(e){   
        if(e == 13){
            return false;
        }
    });

    $('input').keypress(function(e){
        if(e.which == 13){
            return false;
        }
    });


  	//variables para el lenguaje del datepicker
  	$.fn.datepicker.dates['es'] = {
		days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
		daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
		daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
		months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
		monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
		today: "Hoy",
		clear: "Limpiar",
		format: "yyyy-mm-dd",
		titleFormat: "MM yyyy",
		weekStart: 1
  	};

    var fecha = <?php echo date('Y-m-d')?>;

  	$("#Wip_FECHA_SOLICITUD_WIP").datepicker({
  		language: 'es',
  		autoclose: true,
  		orientation: "right bottom",
        startDate: new Date(),
  	}).on('changeDate', function () {
        var date = $(this).datepicker("getDate"); //Get the Date object with actual date
        date.setDate(date.getDate() + 20);
        $("#Wip_FECHA_ENTREGA_WIP").datepicker("setDate", date);
        var minDate = $(this).datepicker("getDate");
        $('#Wip_FECHA_ENTREGA_WIP').datepicker('setStartDate', minDate);
    });

    $("#Wip_FECHA_ENTREGA_WIP").datepicker({
        language: 'es',
        autoclose: true,
        orientation: "right bottom",
    });  

});

function clear_select2_ajax(id){
	$('#'+id+'').val('').trigger('change');
	$('#s2id_'+id+' span').html("");
}

function add_item(){

    limp_div_msg();

    var item = $('#Wip_ID_ITEM').val();
    var desc_item = $('#s2id_Wip_ID_ITEM span').html();
    var fecha_solicitud = $('#Wip_FECHA_SOLICITUD_WIP').val();
    var fecha_entrega = $('#Wip_FECHA_ENTREGA_WIP').val();
    var cantidad = $('#Wip_CANT_A_ARMAR').val();
    var responsable = $('#Wip_RESPONSABLE').val();

    if(item != "" && fecha_solicitud != "" && fecha_entrega != "" && cantidad != "" && responsable != ""){
        
        var div_contenido = $('#contenido');

        var tr = $("#tr_"+item).length;

        if(!tr){

            var cant = $(".tr_wips").length;

            if(cant == 0){
                div_contenido.append('<table class="table" id="table_wip" style="font-size:11px !important;"><thead><tr><th>Item</th><th>Cantidad</th><th></th></tr></thead><tbody></tbody></table>');
            }

            if(cant >= 0 && cant < 19){
                $('#add').show();
                $('#reg').show();
            }

            if(cant == 19){
                $('#add').hide();
                $('#reg').hide();
            }

            var tabla = $('#table_wip');

            $('#btn_save').show();  

            tabla.append('<tr class="tr_wips" id="tr_'+item+'"><td><input type="hidden" class="wips" value="'+item+'">'+desc_item+'</td><td align="right"><p id="cantidad_'+item+'">'+cantidad+'</p></td><td><button type="button" class="btn btn-danger btn-xs delete"><i class="fa fa-trash" aria-hidden="true"></i> </button></td></tr>');

            $('#Wip_ID_ITEM').val('').trigger('change');
            $('#s2id_Wip_ID_ITEM span').html("");
            $('#Wip_CANT_A_ARMAR').val('');
        }else{
            $("#div_mensaje").addClass("alert alert-warning alert-dismissible");
            $("#div_mensaje").html('<button type="button" class="close" aria-hidden="true" onclick="limp_div_msg();">×</button><h4><i class="icon fa fa-info-circle"></i>Cuidado</h4><p>Este item ya esta registrado.</p>');
            $("#div_mensaje").fadeIn('fast');
        }
                
    }else{
        if(item == ""){
            $('#Wip_ID_ITEM_em_').html('Item no puede ser nulo.');
            $('#Wip_ID_ITEM_em_').show(); 
        }

        if(fecha_solicitud == ""){
            $('#Wip_FECHA_SOLICITUD_WIP_em_').html('Fecha de solicitud no puede ser nulo.');
            $('#Wip_FECHA_SOLICITUD_WIP_em_').show(); 
        }

        if(fecha_entrega == ""){
            $('#Wip_FECHA_ENTREGA_WIP_em_').html('Fecha de entrega no puede ser nulo.');
            $('#Wip_FECHA_ENTREGA_WIP_em_').show();    
        }

        if(cantidad == ""){
            $('#Wip_CANT_A_ARMAR_em_').html('Cantidad no puede ser nulo.');
            $('#Wip_CANT_A_ARMAR_em_').show();    
        }

        if(responsable == ""){
            $('#Wip_RESPONSABLE_em_').html('Responsable no puede ser nulo.');
            $('#Wip_RESPONSABLE_em_').show();    
        }

    }
}

$("body").on("click", ".delete", function (e) {
    $(this).parent().parent("tr").remove();
    var cant = $(".tr_wips").length;
    
    if(cant == 0){
        $('#contenido').html('');
        $('#btn_save').hide();  
    }else{
        $('#btn_save').show();  
    }

    if(cant >= 0 && cant <= 19){
        $('#add').show();
        $('#reg').show();
    }


});

function valida_opciones(){

    var responsable = $('#Wip_RESPONSABLE').val();
    var fecha_solicitud = $('#Wip_FECHA_SOLICITUD_WIP').val();
    var fecha_entrega = $('#Wip_FECHA_ENTREGA_WIP').val();

    if(responsable != ""  && fecha_solicitud != "" && fecha_entrega != ""){

        $('#btn_save').hide();
        $(".ajax-loader").fadeIn('fast');

        var item_selected = '';
        var cant_selected = ''; 
        
        $("input.wips[type=hidden]").each(function() {

            item = $(this).val();
            cant = $('#cantidad_'+item).text();

            item_selected += item+',';
            cant_selected += cant+',';  

        });

        var cadena_item = item_selected.slice(0,-1);
        var cadena_cant = cant_selected.slice(0,-1);
        
        $('#Wip_cad_item').val(cadena_item);
        $('#Wip_cad_cant').val(cadena_cant);

        return true;
        
    } else {

        if(responsable == ""){
            $('#Wip_RESPONSABLE_em_').html('Responsable no puede ser nulo.');
            $('#Wip_RESPONSABLE_em_').show();    
        }

        if(fecha_solicitud == ""){
            $('#Wip_FECHA_SOLICITUD_WIP_em_').html('Fecha de solicitud no puede ser nulo.');
            $('#Wip_FECHA_SOLICITUD_WIP_em_').show(); 
        }

        if(fecha_entrega == ""){
            $('#Wip_FECHA_ENTREGA_WIP_em_').html('Fecha de entrega no puede ser nulo.');
            $('#Wip_FECHA_ENTREGA_WIP_em_').show();    
        }
        
        return false;   
    }  
}

function limp_div_msg(){
    $("#div_mensaje").hide();  
    classact = $('#div_mensaje').attr('class');
    $("#div_mensaje").removeClass(classact);
    $("#mensaje").html('');
}

</script>
<?php
/* @var $this PromocionController */
/* @var $model Promocion */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'inventario-form',
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
            <?php echo $form->error($model,'Documento', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Documento'); ?>
            <?php echo $form->numberField($model,'Documento', array('class' => 'form-control', 'autocomplete' => 'off', 'type' => 'number')); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Fecha'); ?>
            <?php echo $form->textField($model,'Fecha', array('class' => 'form-control datepicker', 'readonly' => true)); ?>
        </div>
    </div>     
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Departamento', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Departamento'); ?>
            <?php echo $form->textField($model,'Id_Departamento'); ?>
            <?php echo $form->hiddenField($model,'Id_Suministro'); ?>
            <?php echo $form->hiddenField($model,'Notas'); ?>
            <?php echo $form->hiddenField($model,'Cantidad'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#Inventario_Id_Departamento',
                    'options'  => array(
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('departamento/SearchDepartamento'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                   
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Inventario_Id_Departamento"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Inventario_Id_Departamento\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Tipo', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Tipo'); ?>
            <?php $array = array(1 => 'Entrada', 2 => 'Salida'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'Inventario[Tipo]',
                    'id'=>'Inventario_Tipo',
                    'data'=>$array,
                    'value' => 2,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div> 
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'suminist', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'suminist'); ?>
            <?php echo $form->textField($model,'suminist'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#Inventario_suminist',
                    'options'  => array(
                        'minimumInputLength' => 3,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('suministro/SearchSuministro'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Inventario_suminist"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 3 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Inventario_suminist\')\">Limpiar campo</button>"; }',
                    ),
                ));
                ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'cant', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'cant'); ?>
            <?php echo $form->numberField($model,'cant', array('class' => 'form-control', 'autocomplete' => 'off','maxlength' => '250')); ?>
        </div>
    </div>
</div>
<div class="row">   
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'not', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'not'); ?>
            <?php echo $form->textField($model,'not', array('class' => 'form-control', 'autocomplete' => 'off','maxlength' => '30')); ?>
        </div>
    </div>        
</div>
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=inventario/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" onclick="add_suminist();"><i class="fa fa-plus" ></i> Agregar registro</button>
</div>


<div id="contenido">
    
</div>

<div class="btn-group" id="btn_save" style="padding-bottom: 2%;display: none;">
    <button type="submit" class="btn btn-success" onclick="return valida_opciones(event);"><i class="fa fa-floppy-o"></i> Guardar</button>
</div>
    
<?php $this->endWidget(); ?>

<script type="text/javascript">

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html(""); 
}

$('#Inventario_Documento').change(function() {
    $('#contenido').html('');
    $('#btn_save').hide();  
});

$('#Inventario_Fecha').change(function() {
    $('#contenido').html('');
    $('#btn_save').hide();  
       
});

$('#Inventario_Tipo').change(function() {
    $('#contenido').html('');
    $('#btn_save').hide();  
});

$('#Inventario_Id_Departamento').change(function() {
    $('#contenido').html('');
    $('#btn_save').hide();  
       
});

function add_suminist(){

    var doc = $('#Inventario_Documento').val();
    var fecha = $('#Inventario_Fecha').val();
    var dep = $('#Inventario_Id_Departamento').val();
    var tipo = $('#Inventario_Tipo').val();
    var id_sum = $('#Inventario_suminist').val();
    var sum =$('#s2id_Inventario_suminist span').html();
    var cant = $('#Inventario_cant').val();
    var not = $('#Inventario_not').val();

    if(not == ""){
        nota = 'N/A';
    }else{
        nota = not;
    }
    
    if( doc != "" && fecha != "" && dep != "" && tipo != "" && id_sum != "" && cant != ""){

        if(tipo == 2){
            //se evalua si hay existencias suficientes para realizar la salida

            var data = {id_sum: id_sum, cant: cant, id: 0}
            $.ajax({ 
                type: "POST", 
                url: "<?php echo Yii::app()->createUrl('inventario/verificardisponibilidad'); ?>",
                data: data,
                success: function(data){
                    
                    var data = jQuery.parseJSON(data);
                    var opc = data.opc; 
                    var mensaje = data.msj;

                    if(opc == 0){
                        //no esta disponible la cantidad solicitada
                        $('#Inventario_cant_em_').html(mensaje);
                        $('#Inventario_cant_em_').show();
                        $('#Inventario_cant').val('');
                    }

                    if(opc == 1){
                        //si esta disponible la cantidad solicitada
                        var div_contenido = $('#contenido');
                        $('#btn_save').show();  
                        div_contenido.append('<div class="row item"><label class="col-sm-1 control-label" style="margin-bottom: 10px">Suministro</label><div class="col-sm-4"><input type="hidden" class="sumi" value="'+id_sum+'"><input class="form-control" name="suministro[]" style="margin-bottom: 10px" value="'+sum+'" readonly></div><label class="col-sm-1 control-label" style="margin-bottom: 10px">Nota</label><div class="col-sm-2"><input class="form-control" id="not_sum_'+id_sum+'" style="margin-bottom: 10px" value="'+nota+'" readonly></div><label class="col-sm-1 control-label" style="margin-bottom: 10px">Cantidad</label><div class="col-sm-1"><input class="form-control" id="cant_sum_'+id_sum+'" style="margin-bottom: 10px" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger delete" style="margin-bottom: 10px"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button></div></div>');
                        $('#Inventario_suminist').val('').trigger('change');
                        $('#s2id_Inventario_suminist span').html("");
                        $('#Inventario_cant').val('');
                        $('#Inventario_cant_em_').html('');
                        $('#Inventario_cant_em_').hide();
                        $('#Inventario_not').val('');
                    }

                }
            });
        }else{
            var div_contenido = $('#contenido');
            $('#btn_save').show();  
            div_contenido.append('<div class="row item"><label class="col-sm-1 control-label" style="margin-bottom: 10px">Suministro</label><div class="col-sm-4"><input type="hidden" class="sumi" value="'+id_sum+'"><input class="form-control" name="suministro[]" style="margin-bottom: 10px" value="'+sum+'" readonly></div><label class="col-sm-1 control-label" style="margin-bottom: 10px">Nota</label><div class="col-sm-2"><input class="form-control" id="not_sum_'+id_sum+'" style="margin-bottom: 10px" value="'+nota+'" readonly></div><label class="col-sm-1 control-label" style="margin-bottom: 10px">Cantidad</label><div class="col-sm-1"><input class="form-control" id="cant_sum_'+id_sum+'" style="margin-bottom: 10px" value="'+cant+'" readonly></div><div class="col-sm-1"><button type="button" class="btn btn-danger delete" style="margin-bottom: 10px"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button></div></div>');
            $('#Inventario_suminist').val('').trigger('change');
            $('#s2id_Inventario_suminist span').html("");
            $('#Inventario_cant').val('');
            $('#Inventario_cant_em_').html('');
            $('#Inventario_cant_em_').hide();
            $('#Inventario_not').val('');
        }

    }else{
        if(doc == ""){
            $('#Inventario_Documento_em_').html('Documento no puede ser nulo.');
            $('#Inventario_Documento_em_').show(); 
        }

        if(fecha == ""){
            $('#Inventario_Fecha_em_').html('Fecha no puede ser nulo.');
            $('#Inventario_Fecha_em_').show(); 
        }

        if(dep == ""){
            $('#Inventario_Id_Departamento_em_').html('Departamento no puede ser nulo.');
            $('#Inventario_Id_Departamento_em_').show(); 
        }

        if(tipo == ""){
            $('#Inventario_Tipo_em_').html('Tipo no puede ser nulo.');
            $('#Inventario_Tipo_em_').show(); 
        }

        if(id_sum == ""){
            $('#Inventario_suminist_em_').html('Suministro no puede ser nulo.');
            $('#Inventario_suminist_em_').show(); 
        }

        if(cant == ""){
            $('#Inventario_cant_em_').html('Cantidad no puede ser nulo.');
            $('#Inventario_cant_em_').show();    
        }
    }
}


$("body").on("click", ".delete", function (e) {
    $(this).parent().parent("div").remove();
    var cant = $(".sumi").length;
    if(cant == 0){
        $('#btn_save').hide();  
    }else{
        $('#btn_save').show();  
    }
});

function valida_opciones(){

    var sumi_selected = '';
    var cant_selected = '';
    var not_selected = ''; 
    
    $("input.sumi[type=hidden]").each(function() {

            sum = $(this).val();
            not = $('#not_sum_'+sum).val();
            cant = $('#cant_sum_'+sum).val();
            
            sumi_selected += sum+",";
            not_selected += not+",";
            cant_selected += cant+",";         

    });

    var cadena_sum = sumi_selected.slice(0,-1);
    var cadena_not = not_selected.slice(0,-1);
    var cadena_val = cant_selected.slice(0,-1);
    
    $('#Inventario_Id_Suministro').val(cadena_sum);
    $('#Inventario_Notas').val(cadena_not);
    $('#Inventario_Cantidad').val(cadena_val);


    return true;   
}

</script>

<style type="text/css">
    
    .sumi{
        padding-bottom: 10px;
    }

</style>


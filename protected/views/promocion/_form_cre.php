<?php
/* @var $this PromocionController */
/* @var $model Promocion */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'promocion-form',
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
    <div class="col-sm-6">
        <div class="form-group">
            <?php echo $form->error($model,'Id_Item_Padre', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Id_Item_Padre'); ?>
            <?php echo $form->textField($model,'Id_Item_Padre'); ?>
            <?php echo $form->hiddenField($model,'Id_Item_Hijo'); ?>
            <?php echo $form->hiddenField($model,'Cantidad'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#Promocion_Id_Item_Padre',
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
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Promocion_Id_Item_Padre"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Promocion_Id_Item_Padre\')\">Limpiar campo</button>"; }',
                    ),
                ));
            ?>
        </div>
    </div>
</div>
<div class="row"> 
    <div class="col-sm-6">
        <div class="form-group">
            <?php echo $form->error($model,'comp', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'comp'); ?>
            <?php echo $form->textField($model,'comp'); ?>
            <?php
                $this->widget('ext.select2.ESelect2', array(
                    'selector' => '#Promocion_comp',
                    'options'  => array(
                        'minimumInputLength' => 5,
                        'width' => '100%',
                        'language' => 'es',
                        'ajax' => array(
                            'url' => Yii::app()->createUrl('promocion/SearchItem'),
                            'dataType'=>'json',
                            'data'=>'js:function(term){return{q: term};}',
                            'results'=>'js:function(data){ return {results:data};}'                
                        ),
                        'formatNoMatches'=> 'js:function(){ clear_select2_ajax("Promocion_comp"); return "No se encontraron resultados"; }',
                        'formatInputTooShort' =>  'js:function(){ return "Digite más de 5 caracteres para iniciar busqueda <button type=\"button\" class=\"btn btn-success btn-xs pull-right\" onclick=\"clear_select2_ajax(\'Promocion_comp\')\">Limpiar campo</button>"; }',
                    ),
                ));
                ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'cant', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'cant'); ?>
            <?php echo $form->numberField($model,'cant', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
                

        </div>
    </div>
</div>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success"  onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=promocion/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
    <button type="button" class="btn btn-success" onclick="add_item();"><i class="fa fa-plus"></i> Agregar item</button>
</div>


<div id="contenido">
    
</div>


<div class="btn-group" id="btn_save" style="display: none;padding-bottom: 2%">
    <button type="submit" class="btn btn-success" onclick="return valida_opciones(event);"><i class="fa fa-floppy-o"></i> Guardar</button>
</div>

    
<?php $this->endWidget(); ?>

<script type="text/javascript">

function clear_select2_ajax(id){
    $('#'+id+'').val('').trigger('change');
    $('#s2id_'+id+' span').html("");

    if(id == 'Promocion_Id_Item_Padre'){
        $('#contenido').html('');
        $('#btn_save').hide();  
       
    }
}

function add_item(){

    var promocion = $('#Promocion_Id_Item_Padre').val();
    var id_comp = $('#Promocion_comp').val();
    var comp = $('#s2id_Promocion_comp span').html();
    var cant = $('#Promocion_cant').val();
    
    if(promocion != "" && id_comp != "" && cant != ""){
        
        //se consulta si el item ya esta creado para la promocion
        var data = {promocion: promocion, id_comp: id_comp}
        $.ajax({ 
            type: "POST", 
            url: "<?php echo Yii::app()->createUrl('promocion/evaluarexistencia'); ?>",
            data: data,
            dataType: 'json',
            success: function(data){
                if (data == 0) {
                    var div_contenido = $('#contenido');
                    $('#btn_save').show();  
                    div_contenido.append('<div class="row item"><label class="col-sm-2 control-label" style="margin-bottom: 10px">Componente</label><div class="col-sm-4"><input type="hidden" class="comps" value="'+id_comp+'"><input class="form-control" name="componente[]" style="margin-bottom: 10px" value="'+comp+'" readonly></div><label class="col-sm-1 control-label" style="margin-bottom: 10px">Cantidad</label><div class="col-sm-2"><input class="form-control" id="cant_comp_'+id_comp+'" style="margin-bottom: 10px" value="'+cant+'" readonly></div><div class="col-sm-2"><button type="button" class="btn btn-danger delete" style="margin-bottom: 10px"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button></div></div>');
                    $('#Promocion_comp').val('').trigger('change');
                    $('#s2id_Promocion_comp span').html("");
                    $('#Promocion_cant').val('');     
                }else{
                    $('#Promocion_comp_em_').html('Prom. - componente ya existe en el sistema');
                    $('#Promocion_comp_em_').show();     
                } 
            }
        });

    }else{
        if(promocion == ""){
            $('#Promocion_Id_Item_Padre_em_').html('Promoción no puede ser nulo.');
            $('#Promocion_Id_Item_Padre_em_').show(); 
        }
        if(id_comp == ""){
            $('#Promocion_comp_em_').html('Componente no puede ser nulo.');
            $('#Promocion_comp_em_').show(); 
        }

        if(cant == ""){
            $('#Promocion_cant_em_').html('Cantidad no puede ser nulo.');
            $('#Promocion_cant_em_').show();    
        }
    }
}


$("body").on("click", ".delete", function (e) {
    $(this).parent().parent("div").remove();
    var cant = $(".item").length;
    if(cant == 0){
        $('#btn_save').hide();  
    }else{
        $('#btn_save').show();  
    }
});

function valida_opciones(){
    debugger;
    //elementos
    var comp_selected = '';
    var cant_selected = ''; 
    
    //$('input.comps').each(function(){
    $("input.comps[type=hidden]").each(function() {
     //$(this).val() //do something with
//});

            comp = $(this).val();
            cant = $('#cant_comp_'+comp).val();

            comp_selected += comp+',';
            cant_selected += cant+',';         

    });

    var cadena_comp = comp_selected.slice(0,-1);
    var cadena_val = cant_selected.slice(0,-1);
    
    $('#Promocion_Id_Item_Hijo').val(cadena_comp);
    $('#Promocion_Cantidad').val(cadena_val);

    return true;   
}

</script>

<style type="text/css">
    
    .comp{
        padding-bottom: 10px;
    }

</style>


<?php
/* @var $this ActividadController */
/* @var $model Actividad */

$fecha_act = date("Y-m-d");
$fecha = date("Y-m-d",strtotime($fecha_act."- 1 days")); 

//para combos de grupos
$lista_grupos = CHtml::listData($grupos, 'Id_Dominio', 'Dominio');

//para combos de usuarios
$lista_usuarios = CHtml::listData($usuarios, 'Id_Usuario', 'Nombres');

?>

<script>

$(function() {

    $("#valida_form").click(function() {
      var form = $("#actividad-form");
      var settings = form.data('settings') ;

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
            $.each(settings.attributes, function () {
                $.fn.yiiactiveform.updateInput(this,messages,form); 
            });
                
            //se envia el form
            form.submit();
            loadershow();
             
          } else {
              settings = form.data('settings'),
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              settings.submitting = false ;
          }
      });
    });

    $("#Actividad_Id_Grupo").change(function () {
      vlr = $("#Actividad_Id_Grupo").val();
      if(vlr != ""){
        var data = {grupo: vlr}
        $.ajax({ 
          type: "POST", 
          url: "<?php echo Yii::app()->createUrl('actividad/gettipos'); ?>",
          data: data,
          dataType: 'json',
          success: function(data){ 
            $("#Actividad_Id_Tipo").html('');
            $("#Actividad_Id_Tipo").append('<option value=""></option>');
            $.each(data, function(i,item){
                $("#Actividad_Id_Tipo").append('<option value="'+data[i].id+'">'+data[i].text+'</option>');
            });
            $("#div_tipo").show();
          }
        });
      }else{
        $("#Actividad_Id_Tipo").val('');
        $("#div_tipo").hide();
      }
    });

});

</script>

<h4>Creación de actividad</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_usuarios'=>$lista_usuarios, 'lista_grupos'=>$lista_grupos)); ?>

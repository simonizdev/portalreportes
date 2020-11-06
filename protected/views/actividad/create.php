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

    $('#Actividad_Prioridad').val(3).trigger('change');

    $("#valida_form").click(function() {
      var form = $("#actividad-form");
      var settings = form.data('settings') ;

      var estado = $("#Actividad_Estado").val();
      var usuario_deleg = $("#Actividad_Id_Usuario_Deleg").val();

      $valid = 0;

      if(estado == 3){   

        if(usuario_deleg != ""){
            $valid = 1;
        }else{
            $valid = 0;
        }

      }

      if(estado == 1 || estado == 2 || estado == 4){   
        $valid = 1;
      }

      settings.submitting = true ;
      $.fn.yiiactiveform.validate(form, function(messages) {
          if($.isEmptyObject(messages)) {
            $.each(settings.attributes, function () {
                $.fn.yiiactiveform.updateInput(this,messages,form); 
            });
                
            if($valid == 1){
                //se envia el form
                form.submit();
                loadershow();
            }else{
              if(estado == 3){   

                if(usuario_deleg == ""){
                    $('#Actividad_Id_Usuario_Deleg_em_').html('Cedido a es requerido.');
                    $('#Actividad_Id_Usuario_Deleg_em_').show(); 
                } 
              }
            }
             
          } else {
              settings = form.data('settings'),
              $.each(settings.attributes, function () {
                 $.fn.yiiactiveform.updateInput(this,messages,form); 
              });
              settings.submitting = false ;

              if(estado == 3){   

                if(usuario_deleg == ""){
                    $('#Actividad_Id_Usuario_Deleg_em_').html('Cedido a es requerido.');
                    $('#Actividad_Id_Usuario_Deleg_em_').show(); 
                }
                 
              }
          }
      });
    });

    $('#Actividad_Estado').change(function() {
      
      var value = $(this).val();
        
      if(value != ""){

        $('#Actividad_Id_Usuario_Deleg_em_').html('');
        $('#Actividad_Id_Usuario_Deleg').val('');

        if(value == 3){
          //EN ESPERA
          $('#user_deleg').show();
          $('#fecha_cierre').hide();
          $('#hora_cierre').hide();
        }

        if(value == 1 || value == 4){
          //EN PROCESO, ABIERTA
          $('#user_deleg').hide();
        }

      }else{
        $("#user_deleg").hide();
      }
     
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

    $('#Actividad_Id_Usuario_Deleg').change(function() {
        var estado = $("#Actividad_Estado").val();
        var val = $('#Actividad_Id_Usuario_Deleg').val();
        if(estado == 3){   
            if(val == ""){
                $('#Actividad_Id_Usuario_Deleg_em_').html('Cedido a es requerido.');
                $('#Actividad_Id_Usuario_Deleg_em_').show(); 
            }else{
                $('#Actividad_Id_Usuario_Deleg_em_').html('');
                $('#Actividad_Id_Usuario_Deleg_em_').hide(); 
            }

        }else{
            $('#Actividad_Id_Usuario_Deleg_em_').html('');
            $('#Actividad_Id_Usuario_Deleg_em_').hide(); 
        
        }
      
    });

});

</script>

<h4>Creación de actividad</h4>

<?php $this->renderPartial('_form', array('model'=>$model, 'lista_usuarios'=>$lista_usuarios, 'lista_grupos'=>$lista_grupos)); ?>

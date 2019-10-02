<?php
/* @var $this ReporteController */
/* @var $model Reporte */

?>

<h3>Lista de precios</h3>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reporte-form',
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
        <?php echo $form->error($model,'tipo', array('class' => 'pull-right badge bg-red')); ?>
        <?php echo $form->label($model,'tipo'); ?>
        <?php
            $this->widget('ext.select2.ESelect2',array(
                'name'=>'Reporte[tipo]',
                'id'=>'Reporte_tipo',
                'data'=> array(1 => 'Rango marcas', 2 => 'Rango oracle'),
                'options'=>array(
                    'placeholder'=>'Seleccione...',
                    'width'=> '100%',
                    'allowClear'=>true,
                ),
            ));
        ?>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="form-group">
      <?php echo $form->error($model,'lista', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'lista'); ?>
      <?php
          $this->widget('ext.select2.ESelect2',array(
              'name'=>'Reporte[lista]',
              'id'=>'Reporte_lista',
              'data'=> $lista_pr,
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
   <div class="col-sm-6" id="marca_inicial" style="display: none;">
    <div class="form-group">
      <?php echo $form->error($model,'marca_inicial', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'marca_inicial'); ?>
      <?php
          $this->widget('ext.select2.ESelect2',array(
              'name'=>'Reporte[marca_inicial]',
              'id'=>'Reporte_marca_inicial',
              'data'=> $lista_marcas,
              'options'=>array(
                  'placeholder'=>'Seleccione...',
                  'width'=> '100%',
                  'allowClear'=>true,
              ),
          ));
      ?>
    </div>
  </div>
  <div class="col-sm-6" id="marca_final" style="display: none;">
    <div class="form-group">
      <?php echo $form->error($model,'marca_final', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'marca_final'); ?>
      <?php
          $this->widget('ext.select2.ESelect2',array(
              'name'=>'Reporte[marca_final]',
              'id'=>'Reporte_marca_final',
              'data'=> $lista_marcas,
              'options'=>array(
                  'placeholder'=>'Seleccione...',
                  'width'=> '100%',
                  'allowClear'=>true,
              ),
          ));
      ?>
    </div>
  </div>
  <div class="col-sm-6" id="oracle_inicial" style="display: none;">
    <div class="form-group">
      <?php echo $form->error($model,'des_ora_ini', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'des_ora_ini'); ?>
      <?php
          $this->widget('ext.select2.ESelect2',array(
              'name'=>'Reporte[des_ora_ini]',
              'id'=>'Reporte_des_ora_ini',
              'data'=> $lista_oracle,
              'options'=>array(
                  'placeholder'=>'Seleccione...',
                  'width'=> '100%',
                  'allowClear'=>true,
              ),
          ));
      ?>
    </div>
  </div>
  <div class="col-sm-6" id="oracle_final" style="display: none;">
    <div class="form-group">
      <?php echo $form->error($model,'des_ora_fin', array('class' => 'pull-right badge bg-red')); ?>
      <?php echo $form->label($model,'des_ora_fin'); ?>
      <?php
          $this->widget('ext.select2.ESelect2',array(
              'name'=>'Reporte[des_ora_fin]',
              'id'=>'Reporte_des_ora_fin',
              'data'=> $lista_oracle,
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
    
<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" onclick="resetfields();"><i class="fa fa-eraser"></i> Limpiar filtros</button>
    <button type="button" class="btn btn-success" id="valida_form"><i class="fa fa-file-pdf-o"></i> Generar</button>
</div>


<div class="row">
    <div class="col-lg-12 table-responsive" id="resultados">
    <!-- contenido via ajax -->
    </div>
</div>  

<?php $this->endWidget(); ?>

<script>

$(function() {

  $("#Reporte_tipo").change(function() {

    var val = $(this).val();

    if(val == ""){

      $('#marca_inicial').hide();
      $('#marca_final').hide();
      $('#oracle_inicial').hide();
      $('#oracle_final').hide();

      $('#Reporte_marca_inicial').val('').trigger('change');
      $('#Reporte_marca_final').val('').trigger('change');
      $('#Reporte_des_ora_ini').val('').trigger('change');
      $('#Reporte_des_ora_fin').val('').trigger('change');
      $('#Reporte_marca_inicial_em_').html('');
      $('#Reporte_marca_inicial_em_').hide();  
      $('#Reporte_marca_final_em_').html('');
      $('#Reporte_marca_final_em_').hide();  
      $('#Reporte_des_ora_ini_em_').html('');
      $('#Reporte_des_ora_ini_em_').hide();  
      $('#Reporte_des_ora_fin_em_').html('');
      $('#Reporte_des_ora_fin_em_').hide();  
    }else{
        
      if(val == 1){
        //rango marcas
        $('#marca_inicial').show();
        $('#marca_final').show();
        $('#oracle_inicial').hide();
        $('#oracle_final').hide();
      }

      if(val == 2){
        //rango oracle
        $('#marca_inicial').hide();
        $('#marca_final').hide();
        $('#oracle_inicial').show();
        $('#oracle_final').show();
      }

      $('#Reporte_marca_inicial').val('').trigger('change');
      $('#Reporte_marca_final').val('').trigger('change');
      $('#Reporte_des_ora_ini').val('').trigger('change');
      $('#Reporte_des_ora_fin').val('').trigger('change');
      $('#Reporte_marca_inicial_em_').html('');
      $('#Reporte_marca_inicial_em_').hide();  
      $('#Reporte_marca_final_em_').html('');
      $('#Reporte_marca_final_em_').hide();  
      $('#Reporte_des_ora_ini_em_').html('');
      $('#Reporte_des_ora_ini_em_').hide();  
      $('#Reporte_des_ora_fin_em_').html('');
      $('#Reporte_des_ora_fin_em_').hide(); 

    }    
  });

  $("#valida_form").click(function() {

    var form = $("#reporte-form");
    
    var tipo =  $('#Reporte_tipo').val();
    var lista =  $('#Reporte_lista').val();
    var marca_inicial =  $('#Reporte_marca_inicial').val();
    var marca_final =  $('#Reporte_marca_final').val();
    var oracle_inicial =  $('#Reporte_des_ora_ini').val();
    var oracle_final =  $('#Reporte_des_ora_fin').val();

    if(tipo != ""){
      if(tipo == 1){
        if(lista != "" && marca_inicial != "" && marca_final != ""){
          //se envia el form
          form.submit();
          $(".ajax-loader").fadeIn('fast');
          setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 10000);
        }else{
          if(lista == ""){
            $('#Reporte_lista_em_').html('Lista no puede ser nulo.');
            $('#Reporte_lista_em_').show(); 
          }

          if(marca_inicial == ""){
            $('#Reporte_marca_inicial_em_').html('Línea inicial no puede ser nulo.');
            $('#Reporte_marca_inicial_em_').show();    
          }

          if(marca_final == ""){
            $('#Reporte_marca_final_em_').html('Línea final no puede ser nulo.');
            $('#Reporte_marca_final_em_').show();    
          }
        }
      }else{
        if(lista != "" && oracle_inicial != "" && oracle_final != ""){
          //se envia el form
          form.submit();
          $(".ajax-loader").fadeIn('fast');
          setTimeout(function(){ $(".ajax-loader").fadeOut('fast'); }, 10000);
        }else{
          if(lista == ""){
            $('#Reporte_lista_em_').html('Lista no puede ser nulo.');
            $('#Reporte_lista_em_').show(); 
          }

          if(oracle_inicial == ""){
              $('#Reporte_des_ora_ini_em_').html('Desc. oracle inicial no puede ser nulo.');
              $('#Reporte_des_ora_ini_em_').show();    
          }

          if(oracle_final == ""){
              $('#Reporte_des_ora_fin_em_').html('Desc. oracle final no puede ser nulo.');
              $('#Reporte_des_ora_fin_em_').show();    
          }
        }
      }
    }else{
      $('#Reporte_tipo_em_').html('Tipo no puede ser nulo.');
      $('#Reporte_tipo_em_').show(); 
    }
  });

});


function resetfields(){
  $('#Reporte_tipo').val('').trigger('change');
  $('#Reporte_lista').val('').trigger('change');
}

</script>

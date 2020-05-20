<?php
/* @var $this RegImpController */
/* @var $model RegImp */
 
?>

<div class="row mb-2">
  <div class="col-sm-6">
    <h4>Visualizando declaración de importación</h4>
  </div>
  <div class="col-sm-6 text-right">  
    <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=regImp/admin'; ?>';"><i class="fa fa-reply"></i> Volver </button>
    <button type="button" class="btn btn-success btn-sm" id="toogle_button"><i class="fa fa-low-vision"></i> Ver / ocultar doc.</button>
    <button type="button" class="btn btn-success btn-sm" id="download"><i class="fas fa-file-pdf"></i> Descargar documento </button>
    <div style="display: none;">
        <a href="<?php echo Yii::app()->getBaseUrl(true).'/images/reg_imp/'.$model->Documento; ?>" download="<?php echo $model->Documento; ?>" style="display: none;" id="link"></a>
    </div>
  </div>
</div>

<div id="info">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'reg-imp-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
    )); ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->label($model,'Numero'); ?>
                <?php echo '<p>'.$model->Numero.'</p>'; ?>
            </div>
        </div> 
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->label($model,'Fecha'); ?>
                <?php echo '<p>'.UtilidadesVarias::textofecha($model->Fecha).'</p>'; ?>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="form-group" style="word-wrap: break-word;">
                <?php echo $form->label($model,'Items'); ?>
                <?php echo '<p>'.$model->Items.'</p>'; ?>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->error($model,'Id_Usuario_Creacion', array('class' => 'pull-right badge bg-red')); ?>
                <?php echo $form->label($model,'Id_Usuario_Creacion'); ?>
                <?php echo '<p>'.$model->idusuariocre->Usuario.'</p>'; ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->error($model,'Fecha_Creacion', array('class' => 'pull-right badge bg-red')); ?>
                <?php echo $form->label($model,'Fecha_Creacion'); ?>
                <?php echo '<p>'.UtilidadesVarias::textofechahora($model->Fecha_Creacion).'</p>'; ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $form->error($model,'Id_Usuario_Actualizacion', array('class' => 'pull-right badge bg-red')); ?>
                <?php echo $form->label($model,'Id_Usuario_Actualizacion'); ?>
                <?php echo '<p>'.$model->idusuarioact->Usuario.'</p>'; ?>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->error($model,'Fecha_Actualizacion', array('class' => 'pull-right badge bg-red')); ?>
            <?php echo $form->label($model,'Fecha_Actualizacion'); ?>
            <?php echo '<p>'.UtilidadesVarias::textofechahora($model->Fecha_Actualizacion).'</p>'; ?>
        </div>
      </div>
    </div>

<?php $this->endWidget(); ?>

</div>

<div class="row">
    <div id="viewer" class="col-sm-12 text-center" style="display: none;">

    </div>   
</div>


<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/plugins/pdf.js/pdf.js"></script>
<script type="text/javascript">

$(function() {

    renderPDF('<?php echo Yii::app()->getBaseUrl(true).'/images/reg_imp/'.$model->Documento; ?>', document.getElementById('viewer'));

    loadershow();

    $("#download").click(function() {
        $('#link')[0].click();
    });

    $('#toogle_button').click(function(){
        $('#info').slideToggle('fast');
        $('#viewer').slideToggle('fast');
        return false;
    });

});

</script> 
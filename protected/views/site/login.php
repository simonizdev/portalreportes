<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<div class="login-box">
  <div class="login-logo">
    <img src="<?php echo Yii::app()->baseUrl."/images/logo_simonizco_large.png"; ?>">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <h4 class="text-center"><?php echo Yii::app()->name; ?></h4>
    <p class="login-box-msg">Ingrese sus credenciales para iniciar sesión:</p>

  <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
      'validateOnSubmit'=>true,
    ),
  )); ?>

      <div class="form-group has-feedback">
        <?php echo $form->label($model,'username', array('class' => 'control-label')); ?>
        <?php echo $form->textField($model,'username', array('class' => 'form-control', 'placeholder' => 'Usuario', 'autocomplete' => 'off')); ?>
        <i class="glyphicon glyphicon-user form-control-feedback"></i>
      </div>
      <div>
          <?php echo $form->error($model,'username', array('class' => 'badge bg-red')); ?>
      </div>
      <br>
      <div class="form-group has-feedback">
        <?php echo $form->label($model,'password', array('class' => 'control-label')); ?>
        <?php echo $form->passwordField($model,'password', array('class' => 'form-control', 'placeholder' => 'Password', 'autocomplete' => 'off')); ?>
      <i class="glyphicon glyphicon-lock form-control-feedback"></i>  
      </div>
      <div>
        <?php echo $form->error($model,'password', array('class' => 'badge bg-red')); ?>
      </div>
      <br>
      <button type="submit" class="btn btn-success btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i> Ingresar</button>

    <?php $this->endWidget(); ?>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


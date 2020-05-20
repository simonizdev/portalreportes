<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
  		'validateOnSubmit'=>true,	
	),
)); ?>

<div class="login-box">
  <div class="login-logo">
	<img src="<?php echo Yii::app()->baseUrl."/images/logo_simonizco_large.png"; ?>">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    	<h4 class="text-center"><?php echo Yii::app()->name; ?></h4>
      	<p class="login-box-msg">Ingrese sus credenciales para iniciar sesión:</p>
      
		<div class="form-group">
			<?php echo $form->label($model,'username', array('class' => 'control-label')); ?>
			<?php echo $form->error($model,'username', array('class' => 'badge badge-warning float-right')); ?>
			<div class="input-group mb-3">
		  		<?php echo $form->textField($model,'username', array('class' => 'form-control', 'placeholder' => 'Usuario', 'autocomplete' => 'off')); ?>
		  		<div class="input-group-append">
		    		<div class="input-group-text">
		      			<span class="fas fa-user"></span>
		    		</div>
		  		</div>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->label($model,'password', array('class' => 'control-label')); ?>
			<?php echo $form->error($model,'password', array('class' => 'badge badge-warning float-right')); ?>
			<div class="input-group mb-3">
		  		<?php echo $form->passwordField($model,'password', array('class' => 'form-control', 'placeholder' => 'Password', 'autocomplete' => 'off')); ?>
		  		<div class="input-group-append">
		    		<div class="input-group-text">
		      			<span class="fas fa-lock"></span>
		    		</div>
		  		</div>
			</div>
		</div>
        <div class="row">
        	<div class="col-8"> 
        	</div>
          	<div class="col-4">
            	<button type="submit" class="btn btn-block btn-success btn-sm"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
          	</div>
          	<!-- /.col -->
        </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<?php $this->endWidget(); ?>


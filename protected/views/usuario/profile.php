<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
?>

<!-- Content Header (Page header) -->
<section>
  <h2>
    Bienvenido
  </h2>
</section>

<!-- Main content -->
<section>

  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-default">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="dist/img/user.jpg"" alt="Imagen de usuario">

          <h3 class="profile-username text-center"><?php echo Yii::app()->user->getState('name_user'); ?></h3>

          <p class="text-muted text-center"><b>Usuario:</b> <?php echo Yii::app()->user->getState('username_user'); ?></p>

          <a href="<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=site/logout'; ?>" class="btn btn-danger btn-block"><i class="fa fa-sign-out"></i> Salir</a>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->    
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" style="font-size: 12px !important;">
          <li class="active"><a href="#credenciales" data-toggle="tab">Cambio de credenciales</a></li>
          <li><a href="#perfiles" data-toggle="tab">Perfiles asociados</a></li>          
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="credenciales">
            <?php $form=$this->beginWidget('CActiveForm', array(
              'id'=>'change-password-form',
              'htmlOptions'=>array(
                'class'=>'form-horizontal',
              ),
              // Please note: When you enable ajax validation, make sure the corresponding
              // controller action is handling ajax validation correctly.
              // There is a call to performAjaxValidation() commented in generated controller code.
              // See class documentation of CActiveForm for details on this.
              'enableClientValidation'=>true,
              'clientOptions'=>array(
                'validateOnSubmit'=>true,
              ),
            )); ?>
        
            <?php if(Yii::app()->user->hasFlash('success')):?>
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-check"></i> Realizado</h4>
                  <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>  
            <div class="form-group">
              <?php echo $form->label($model,'old_password',array('class' => 'col-sm-3 control-label')); ?>              
              <div class="col-sm-3">
                <?php echo $form->passwordField($model,'old_password', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
              </div>
              <div class="col-sm-5">
                <?php echo $form->error($model,'old_password', array('class' => 'pull-left badge bg-red')); ?>
              </div>
            </div>

            <div class="form-group">
              <?php echo $form->label($model,'new_password',array('class' => 'col-sm-3 control-label')); ?>              
              <div class="col-sm-3">
                <?php echo $form->passwordField($model,'new_password', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
              </div>
              <div class="col-sm-5">
                <?php echo $form->error($model,'new_password', array('class' => 'pull-left badge bg-red')); ?>
              </div>
            </div>

            <div class="form-group">
              <?php echo $form->label($model,'repeat_password',array('class' => 'col-sm-3 control-label')); ?>              
              <div class="col-sm-3">
                <?php echo $form->passwordField($model,'repeat_password', array('class' => 'form-control', 'autocomplete' => 'off')); ?>
              </div>
              <div class="col-sm-5">
                <?php echo $form->error($model,'repeat_password', array('class' => 'pull-left badge bg-red')); ?>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-10">
                <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> Guardar</button>
              </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <?php $this->endWidget(); ?>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="perfiles">
            <div class="row">
              <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Perfil</th>
                      <th>Usuario que asocio</th>
                      <th>Fecha de asociación</th>
                      <th>Usuario que actualizó</th>
                      <th>Fecha de actualización</th>
                      <th>Estado</th>
                    </tr>
                  </thead><tbody>
                  <?php
                    $i = 1;
                    foreach ($perfiles as $p) {

                      if ($i % 2 == 0){
                        $clase = 'odd'; 
                      }else{
                        $clase = 'even'; 
                      }

                      echo '<tr>';
                      echo '<td>'.$p->idperfil->Descripcion.'</td>';
                      echo '<td>'.$p->idusuariocre->Usuario.'</td>';
                      echo '<td>'.UtilidadesVarias::textofechahora($p->Fecha_Creacion).'</td>';
                      echo '<td>'.$p->idusuarioact->Usuario.'</td>';
                      echo '<td>'.UtilidadesVarias::textofechahora($p->Fecha_Actualizacion).'</td>';
                      if($p->Estado == 1){
                        echo '<td><span class="label label-success">Activo</span></td>';
                      }else{
                        echo '<td><span class="label label-warning">Inactivo</span></td>';
                      }
                      echo '</tr>';

                      $i++;

                    }
                  ?>
                </tbody></table>   
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->



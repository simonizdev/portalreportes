<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
?>
<!-- Main content -->
<section>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link profile active" href="#password" data-toggle="tab"><i class="fas fa-user-lock"></i> Cambio de credenciales</a></li>
            <li class="nav-item"><a class="nav-link profile" href="#perfiles" data-toggle="tab"><i class="fas fa-chalkboard-teacher"></i> Perfiles asociados</a></li>
            <li class="nav-item"><a class="nav-link profile" href="#bodegas" data-toggle="tab"><i class="fas fa-chalkboard-teacher"></i> Bodegas asociadas</a></li>
            <li class="nav-item"><a class="nav-link profile" href="#tipos_docto" data-toggle="tab"><i class="fas fa-chalkboard-teacher"></i> Tipos de docto asociados</a></li>
            <li class="nav-item"><a class="nav-link profile" href="#areas" data-toggle="tab"><i class="fas fa-chalkboard-teacher"></i> Áreas asociadas</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="password">
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
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h5><i class="icon fas fa-check-circle"></i>Realizado</h5>
                      <?php echo Yii::app()->user->getFlash('success'); ?>
                  </div>
              <?php endif; ?> 

              <div class="row">
                <div class="col-4">
                  <?php echo $form->label($model,'old_password',array('class' => 'control-label')); ?>
                  <?php echo $form->passwordField($model,'old_password', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off')); ?>
                </div>
                <div class="col-6">
                  <?php echo $form->error($model,'old_password', array('class' => 'badge badge-warning float-left')); ?>
                </div>
              </div>

              <div class="row">
                <div class="col-4">
                  <?php echo $form->label($model,'new_password',array('class' => 'control-label')); ?>
                  <?php echo $form->passwordField($model,'new_password', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off')); ?>
                </div>
                <div class="col-6">
                  <?php echo $form->error($model,'new_password', array('class' => 'badge badge-warning float-left')); ?>
                </div>
              </div>

              <div class="row">
                <div class="col-4">
                  <?php echo $form->label($model,'repeat_password',array('class' => 'control-label')); ?>
                  <?php echo $form->passwordField($model,'repeat_password', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off')); ?>
                </div>
                <div class="col-6">
                  <?php echo $form->error($model,'repeat_password', array('class' => 'badge badge-warning float-left')); ?>
                </div>
              </div>

              <div class="row" style="padding-top: 1%">
                <div class="col-4">
                  <button type="submit" class="btn btn-success btn-sm" ><i class="fas fa-save"></i> Guardar cambios</button>
                </div>
              </div>

              <!-- /.row -->
              <?php $this->endWidget(); ?> 
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="perfiles">
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>Perfil</th>
                        <th>Usuario que actualizó</th>
                        <th>Fecha de actualización</th>
                        <th>Estado</th>
                      </tr>
                    </thead><tbody>
                    <?php
                      foreach ($perfiles as $p) {
                        echo '<tr>';
                        echo '<td>'.$p->idperfil->Descripcion.'</td>';
                        echo '<td>'.$p->idusuarioact->Usuario.'</td>';
                        echo '<td>'.UtilidadesVarias::textofechahora($p->Fecha_Actualizacion).'</td>';
                        echo '<td>'.UtilidadesVarias::textoestado1($p->Estado).'</td>';
                        echo '</tr>';
                      }
                    ?>
                  </tbody></table>   
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
            <div class="tab-pane" id="bodegas">
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>Bodega</th>
                        <th>Usuario que actualizó</th>
                        <th>Fecha de actualización</th>
                        <th>Estado</th>
                      </tr>
                    </thead><tbody>
                    <?php
                    if(!empty($bodegas)){
                      foreach ($bodegas as $b) {
                        echo '<tr>';
                        echo '<td>'.$b->idbodega->Descripcion.'</td>';
                        echo '<td>'.$b->idusuarioact->Usuario.'</td>';
                        echo '<td>'.UtilidadesVarias::textofechahora($b->Fecha_Actualizacion).'</td>';
                        echo '<td>'.UtilidadesVarias::textoestado1($b->Estado).'</td>';
                        echo '</tr>';
                      }
                    }else{
                      echo '<tr>';
                      echo '<td colspan="4">No se encontraron resultados.</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody></table>   
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
            <div class="tab-pane" id="tipos_docto">
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>Tipo de docto</th>
                        <th>Usuario que actualizó</th>
                        <th>Fecha de actualización</th>
                        <th>Estado</th>
                      </tr>
                    </thead><tbody>
                    <?php
                    if(!empty($tipos_docto)){
                      foreach ($tipos_docto as $td) {
                        echo '<tr>';
                        echo '<td>'.$td->idtipodocto->Descripcion.'</td>';
                        echo '<td>'.$td->idusuarioact->Usuario.'</td>';
                        echo '<td>'.UtilidadesVarias::textofechahora($td->Fecha_Actualizacion).'</td>';
                        echo '<td>'.UtilidadesVarias::textoestado1($td->Estado).'</td>';
                        echo '</tr>';
                      }
                    }else{
                      echo '<tr>';
                      echo '<td colspan="4">No se encontraron resultados.</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody></table>   
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

            <!-- /.tab-pane -->
            <div class="tab-pane" id="areas">
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-sm table-hover">
                    <thead>
                      <tr>
                        <th>Área</th>
                        <th>Usuario que actualizó</th>
                        <th>Fecha de actualización</th>
                        <th>Estado</th>
                      </tr>
                    </thead><tbody>
                    <?php
                    if(!empty($areas)){
                      foreach ($areas as $a) {
                        echo '<tr>';
                        echo '<td>'.UtilidadesVarias::descarea($a->Id_Area).'</td>';
                        echo '<td>'.$a->idusuarioact->Usuario.'</td>';
                        echo '<td>'.UtilidadesVarias::textofechahora($a->Fecha_Actualizacion).'</td>';
                        echo '<td>'.UtilidadesVarias::textoestado1($a->Estado).'</td>';
                        echo '</tr>';
                      }
                    }else{
                      echo '<tr>';
                      echo '<td colspan="4">No se encontraron resultados.</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody></table>   
                </div>
              </div>
            </div>
            <!-- /.tab-pane -->

          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</section>
<!-- /.content -->
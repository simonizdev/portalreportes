<?php
/* @var $this DetPedComController */
/* @var $model DetPedCom */

?>

<h4>Registro de ítem</h4>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check-circle"></i>Realizado</h5>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?> 

<?php if(Yii::app()->user->hasFlash('warning')):?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info-circle"></i>Info</h5>
        <?php echo Yii::app()->user->getFlash('warning'); ?>
    </div>
<?php endif; ?>

<?php $this->renderPartial('_form', array('model'=>$model, 'cab'=>$cab, 'detalle'=>$detalle)); ?>
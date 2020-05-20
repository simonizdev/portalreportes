<?php
/* @var $this EanItemController */
/* @var $model EanItem */

?>

<h4>Actualización códigos de barras x item</h4>

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

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Item</label>
            <?php echo '<p>'.$model->DescItem($model->Id_Item).'</p>';?>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Criterio</label>
            <?php echo '<p>'.$model->DescCriterio($model->Criterio).'</p>';?>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=eanItem/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <?php if($n_u < 5){ ?>
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=eanItem/AddCod&id='.$model->Id_Item; ?>';"><i class="fa fa-plus"></i> Nuevo registro</button>
        <?php } ?>
    </div>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'ean-item-grid',
    'dataProvider' => $model_all,
    //'filter'=>$model,
    'pager'=>array(
        'cssFile'=>Yii::app()->getBaseUrl(true).'/css/pager.css',
    ),
    'enableSorting' => false,
    'columns'=>array(
        //'Num_Und',
        array(
            'name'=>'Código',
            'value'=>'$data->EanDig($data->Id_Ean_Item)',
        ),
        'Und_x_Caja',
        array(
            'name'=>'Id_Usuario_Creacion',
            'value'=>'$data->idusuariocre->Usuario',
        ),
        array(
            'name'=>'Fecha_Creacion',
            'value'=>'UtilidadesVarias::textofechahora($data->Fecha_Creacion)',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}',
            'buttons'=>array(
                'view'=>array(
                    'label'=>'<i class="fa fa-eye actions text-dark"></i>',
                    'imageUrl'=>false,
                    'options'=>array('title'=>'Visualizar'),
                    'url'=>'Yii::app()->createUrl("eanItem/view2", array("id"=>$data->Id_Ean_Item))',
                ),
            )
        ),
    ),
)); ?>
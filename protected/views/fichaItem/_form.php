<?php
/* @var $this FichaItemController */
/* @var $model FichaItem */
/* @var $form CActiveForm */

$estados2 = Yii::app()->params->estados2;

?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ficha-item-form',
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
            <?php echo $form->label($model,'Tipo_Producto'); ?>
            <?php echo $form->error($model,'Tipo_Producto', array('class' => 'badge badge-warning float-right')); ?>
            <?php $tipos_p = array(1 => 'TERMINADO', 2 => 'EN PROCESO', 3 => 'POP' , 4 => 'MATERIA PRIMA'); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Tipo_Producto]',
                    'id'=>'FichaItem_Tipo_Producto',
                    'data'=>$tipos_p,
                    'value' => $model->Tipo_Producto,
                    'htmlOptions'=>array(),
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
	<div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Nombre_Funcional'); ?>
		    <?php echo $form->error($model,'Nombre_Funcional', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Nombre_Funcional', array('class' => 'form-control form-control-sm', 'maxlength' => '10', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'onchange' => 'desc_corta()')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Marca_Producto'); ?>
		    <?php echo $form->error($model,'Marca_Producto', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Marca_Producto', array('class' => 'form-control form-control-sm', 'maxlength' => '9', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'onchange' => 'desc_corta()')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Caracteristicas'); ?>
		    <?php echo $form->error($model,'Caracteristicas', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Caracteristicas', array('class' => 'form-control form-control-sm', 'maxlength' => '9', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'onchange' => 'desc_corta()')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Contenido'); ?>
		    <?php echo $form->error($model,'Contenido', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Contenido', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'onchange' => 'desc_corta()')); ?>
        </div>
    </div>
    <div class="col-sm-8">
    	<div class="form-group">
          	<?php echo $form->label($model,'Descripcion_Corta'); ?>
		    <?php echo $form->error($model,'Descripcion_Corta', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Descripcion_Corta', array('class' => 'form-control form-control-sm', 'maxlength' => '40', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)', 'readonly' => true)); ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-sm-8">
        <div class="form-group">
            <?php echo $form->label($model,'Descripcion_Larga', array('class' => 'control-label')); ?>
            <?php echo $form->error($model,'Descripcion_Larga', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textArea($model,'Descripcion_Larga',array('class' => 'form-control form-control-sm', 'rows'=>2, 'cols'=>50, 'maxlength'=>140, 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Unidad_Medida_Prod'); ?>
		    <?php echo $form->error($model,'Unidad_Medida_Prod', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Unidad_Medida_Prod]',
                    'id'=>'FichaItem_Unidad_Medida_Prod',
                    'data'=>$lista_unidad,
                    'value' => $model->Unidad_Medida_Prod,
                    'htmlOptions'=>array(
                    	'onchange'=>'desc_corta()',
                	),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Unidad_Medida_Inv'); ?>
		    <?php echo $form->error($model,'Unidad_Medida_Inv', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Unidad_Medida_Inv]',
                    'id'=>'FichaItem_Unidad_Medida_Inv',
                    'data'=>$lista_unidad,
                    'value' => $model->Unidad_Medida_Inv,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Unidad_Medida_Compra'); ?>
		    <?php echo $form->error($model,'Unidad_Medida_Compra', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Unidad_Medida_Compra]',
                    'id'=>'FichaItem_Unidad_Medida_Compra',
                    'data'=>$lista_unidad,
                    'value' => $model->Unidad_Medida_Compra,
                    'htmlOptions'=>array(),
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
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Ind_Compra'); ?>
            <?php echo $form->error($model,'Ind_Compra', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Ind_Compra]',
                    'id'=>'FichaItem_Ind_Compra',
                    'data'=>$estados2,
                    'value' => $model->Ind_Compra,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Ind_Manufactura'); ?>
            <?php echo $form->error($model,'Ind_Manufactura', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Ind_Manufactura]',
                    'id'=>'FichaItem_Ind_Manufactura',
                    'data'=>$estados2,
                    'value' => $model->Ind_Manufactura,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Ind_Venta'); ?>
            <?php echo $form->error($model,'Ind_Venta', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Ind_Venta]',
                    'id'=>'FichaItem_Ind_Venta',
                    'data'=>$estados2,
                    'value' => $model->Ind_Venta,
                    'htmlOptions'=>array(),
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
	<div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Maneja_Lote'); ?>
            <?php echo $form->error($model,'Maneja_Lote', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Maneja_Lote]',
                    'id'=>'FichaItem_Maneja_Lote',
                    'data'=>$estados2,
                    'value' => $model->Maneja_Lote,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $form->label($model,'Exento_Impuesto'); ?>
            <?php echo $form->error($model,'Exento_Impuesto', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Exento_Impuesto]',
                    'id'=>'FichaItem_Exento_Impuesto',
                    'data'=>$estados2,
                    'value' => $model->Exento_Impuesto,
                    'htmlOptions'=>array(),
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
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Tiempo_Reposicion'); ?>
		    <?php echo $form->error($model,'Tiempo_Reposicion', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Tiempo_Reposicion', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Cant_Moq'); ?>
		    <?php echo $form->error($model,'Cant_Moq', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Cant_Moq', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Stock_Minimo'); ?>
		    <?php echo $form->error($model,'Stock_Minimo', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Stock_Minimo', array('class' => 'form-control form-control-sm', 'maxlength' => '4', 'onkeypress' => 'return soloNumeros(event);', 'autocomplete' => 'off', 'onkeyup' => 'convert_may(this)')); ?>
        </div>
    </div>
</div>

<h5 class="mt-3">Logistica unidad</h5>

<p>Peso (KG) / Largo, Ancho Y Alto (CM)</p>

<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Un_Medida'); ?>
		    <?php echo $form->error($model,'Un_Medida', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Un_Medida]',
                    'id'=>'FichaItem_Un_Medida',
                    'data'=>$lista_unidad,
                    'value' => $model->Un_Medida,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-3">
    	<div class="form-group">
          	<?php echo $form->label($model,'Un_Cant'); ?>
		    <?php echo $form->error($model,'Un_Cant', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->numberField($model,'Un_Cant', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '1')); ?>
        </div>
    </div>
    <div class="col-sm-3">
    	<div class="form-group">
          	<?php echo $form->label($model,'Un_Peso'); ?>
		    <?php echo $form->error($model,'Un_Peso', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->numberField($model,'Un_Peso', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
    	<div class="form-group">
          	<?php echo $form->label($model,'Un_Largo'); ?>
		    <?php echo $form->error($model,'Un_Largo', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->numberField($model,'Un_Largo', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(1)')); ?>
        </div>
    </div>
    <div class="col-sm-3">
    	<div class="form-group">
          	<?php echo $form->label($model,'Un_Ancho'); ?>
		    <?php echo $form->error($model,'Un_Ancho', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->numberField($model,'Un_Ancho', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(1)')); ?>
        </div>
    </div>
    <div class="col-sm-3">
    	<div class="form-group">
          	<?php echo $form->label($model,'Un_Alto'); ?>
		    <?php echo $form->error($model,'Un_Alto', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->numberField($model,'Un_Alto', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(1)')); ?>
        </div>
    </div>
    <div class="col-sm-3">
    	<div class="form-group">
          	<?php echo $form->label($model,'Un_Volumen'); ?>
		    <?php echo $form->error($model,'Un_Volumen', array('class' => 'badge badge-warning float-right')); ?>
            <?php echo $form->textField($model,'Un_Volumen', array('class' => 'form-control form-control-sm', 'readonly' => 'true')); ?>
        </div>
    </div>
</div>

<div id="log_ep" style="display: none">

	<h5 class="mt-3">Logistica empaque principal</h5>

	<p>Peso (KG) / Largo, Ancho Y Alto (CM)</p>

	<div class="row">
	    <div class="col-sm-4">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Ep_Medida'); ?>
			    <?php echo $form->error($model,'Ep_Medida', array('class' => 'badge badge-warning float-right')); ?>
	            <?php
	                $this->widget('ext.select2.ESelect2',array(
	                    'name'=>'FichaItem[Ep_Medida]',
	                    'id'=>'FichaItem_Ep_Medida',
	                    'data'=>$lista_unidad,
	                    'value' => $model->Ep_Medida,
	                    'htmlOptions'=>array(),
	                    'options'=>array(
	                        'placeholder'=>'Seleccione...',
	                        'width'=> '100%',
	                        'allowClear'=>true,
	                    ),
	                ));
	            ?>
	        </div>
	    </div>
	    <div class="col-sm-4">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Ep_Cant'); ?>
			    <?php echo $form->error($model,'Ep_Cant', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Ep_Cant', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '1')); ?>
	        </div>
	    </div>
	    <div class="col-sm-4">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Ep_Peso'); ?>
			    <?php echo $form->error($model,'Ep_Peso', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Ep_Peso', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001')); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Ep_Largo'); ?>
			    <?php echo $form->error($model,'Ep_Largo', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Ep_Largo', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(2)')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Ep_Ancho'); ?>
			    <?php echo $form->error($model,'Ep_Ancho', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Ep_Ancho', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(2)')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Ep_Alto'); ?>
			    <?php echo $form->error($model,'Ep_Alto', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Ep_Alto', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(2)')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Ep_Volumen'); ?>
			    <?php echo $form->error($model,'Ep_Volumen', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->textField($model,'Ep_Volumen', array('class' => 'form-control form-control-sm', 'readonly' => 'true')); ?>
	        </div>
	    </div>
	</div>
</div>
<div id="log_se_cad" style="display: none">

	<h5 class="mt-3">Logistica subempaque cadena</h5>

	<p>Peso (KG) / Largo, Ancho Y Alto (CM)</p>

	<div class="row">
	    <div class="col-sm-4">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cad_Medida'); ?>
			    <?php echo $form->error($model,'Cad_Medida', array('class' => 'badge badge-warning float-right')); ?>
	            <?php
	                $this->widget('ext.select2.ESelect2',array(
	                    'name'=>'FichaItem[Cad_Medida]',
	                    'id'=>'FichaItem_Cad_Medida',
	                    'data'=>$lista_unidad,
	                    'value' => $model->Cad_Medida,
	                    'htmlOptions'=>array(),
	                    'options'=>array(
	                        'placeholder'=>'Seleccione...',
	                        'width'=> '100%',
	                        'allowClear'=>true,
	                    ),
	                ));
	            ?>
	        </div>
	    </div>
	    <div class="col-sm-4">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cad_Cant'); ?>
			    <?php echo $form->error($model,'Cad_Cant', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Cad_Cant', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '1')); ?>
	        </div>
	    </div>
	    <div class="col-sm-4">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cad_Peso'); ?>
			    <?php echo $form->error($model,'Cad_Peso', array('class' => 'badge badge-warning float-right')); ?>
	           <?php echo $form->numberField($model,'Cad_Peso', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001')); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cad_Largo'); ?>
			    <?php echo $form->error($model,'Cad_Largo', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Cad_Largo', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(3)')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cad_Ancho'); ?>
			    <?php echo $form->error($model,'Cad_Ancho', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Cad_Ancho', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(3)')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cad_Alto'); ?>
			    <?php echo $form->error($model,'Cad_Alto', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->numberField($model,'Cad_Alto', array('class' => 'form-control form-control-sm', 'autocomplete' => 'off', 'min' => '0', 'step' => '0.0001', 'onchange' => 'calculo_volumen(3)')); ?>
	        </div>
	    </div>
	    <div class="col-sm-3">
	    	<div class="form-group">
	          	<?php echo $form->label($model,'Cad_Volumen'); ?>
			    <?php echo $form->error($model,'Cad_Volumen', array('class' => 'badge badge-warning float-right')); ?>
	            <?php echo $form->textField($model,'Cad_Volumen', array('class' => 'form-control form-control-sm', 'readonly' => 'true')); ?>
	        </div>
	    </div>
	</div>
</div>

<h5 class="mt-3">Criterios</h5>

<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Origen'); ?>
		    <?php echo $form->error($model,'Crit_Origen', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Origen]',
                    'id'=>'FichaItem_Crit_Origen',
                    'data'=>$lista_origen,
                    'value' => $model->Crit_Origen,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Tipo'); ?>
		    <?php echo $form->error($model,'Crit_Tipo', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Tipo]',
                    'id'=>'FichaItem_Crit_Tipo',
                    'data'=>$lista_tipo,
                    'value' => $model->Crit_Tipo,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Clasificacion'); ?>
		    <?php echo $form->error($model,'Crit_Clasificacion', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Clasificacion]',
                    'id'=>'FichaItem_Crit_Clasificacion',
                    'data'=>$lista_clasif,
                    'value' => $model->Crit_Clasificacion,
                    'htmlOptions'=>array(),
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
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Marca'); ?>
		    <?php echo $form->error($model,'Crit_Marca', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Marca]',
                    'id'=>'FichaItem_Crit_Marca',
                    'data'=>$lista_marca,
                    'value' => $model->Crit_Marca,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Submarca'); ?>
		    <?php echo $form->error($model,'Crit_Submarca', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Submarca]',
                    'id'=>'FichaItem_Crit_Submarca',
                    'data'=>$lista_submarca,
                    'value' => $model->Crit_Submarca,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Segmento'); ?>
		    <?php echo $form->error($model,'Crit_Segmento', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Segmento]',
                    'id'=>'FichaItem_Crit_Segmento',
                    'data'=>$lista_segmento,
                    'value' => $model->Crit_Segmento,
                    'htmlOptions'=>array(),
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
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Familia'); ?>
		    <?php echo $form->error($model,'Crit_Familia', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Familia]',
                    'id'=>'FichaItem_Crit_Familia',
                    'data'=>$lista_familia,
                    'value' => $model->Crit_Familia,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Subfamilia'); ?>
		    <?php echo $form->error($model,'Crit_Subfamilia', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Subfamilia]',
                    'id'=>'FichaItem_Crit_Subfamilia',
                    'data'=>$lista_subfamilia,
                    'value' => $model->Crit_Subfamilia,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Linea'); ?>
		    <?php echo $form->error($model,'Crit_Linea', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Linea]',
                    'id'=>'FichaItem_Crit_Linea',
                    'data'=>$lista_linea,
                    'value' => $model->Crit_Linea,
                    'htmlOptions'=>array(),
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
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Sublinea'); ?>
		    <?php echo $form->error($model,'Crit_Sublinea', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Sublinea]',
                    'id'=>'FichaItem_Crit_Sublinea',
                    'data'=>$lista_sublinea,
                    'value' => $model->Crit_Sublinea,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Grupo'); ?>
		    <?php echo $form->error($model,'Crit_Grupo', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Grupo]',
                    'id'=>'FichaItem_Crit_Grupo',
                    'data'=>$lista_grupo,
                    'value' => $model->Crit_Grupo,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_UN'); ?>
		    <?php echo $form->error($model,'Crit_UN', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_UN]',
                    'id'=>'FichaItem_Crit_UN',
                    'data'=>$lista_un,
                    'value' => $model->Crit_UN,
                    'htmlOptions'=>array(),
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
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Fabrica'); ?>
		    <?php echo $form->error($model,'Crit_Fabrica', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Fabrica]',
                    'id'=>'FichaItem_Crit_Fabrica',
                    'data'=>$lista_fabrica,
                    'value' => $model->Crit_Fabrica,
                    'htmlOptions'=>array(),
                    'options'=>array(
                        'placeholder'=>'Seleccione...',
                        'width'=> '100%',
                        'allowClear'=>true,
                    ),
                ));
            ?>
        </div>
    </div>
    <div class="col-sm-4">
    	<div class="form-group">
          	<?php echo $form->label($model,'Crit_Cat_Oracle'); ?>
		    <?php echo $form->error($model,'Crit_Cat_Oracle', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Crit_Cat_Oracle]',
                    'id'=>'FichaItem_Crit_Cat_Oracle',
                    'data'=>$lista_oracle,
                    'value' => $model->Crit_Cat_Oracle,
                    'htmlOptions'=>array(),
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
	<div class="col-sm-12">
    	<div class="form-group">
          	<?php echo $form->label($model,'Instalaciones'); ?>
		    <?php echo $form->error($model,'Instalaciones', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Instalaciones]',
                    'id'=>'FichaItem_Instalaciones',
                    'data'=>$lista_ins,
                    'value' => $model->Instalaciones,
                    'htmlOptions'=>array(
                        'multiple'=>'multiple',
                    ),
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
    <div class="col-sm-12">
    	<div class="form-group">
          	<?php echo $form->label($model,'Bodegas'); ?>
		    <?php echo $form->error($model,'Bodegas', array('class' => 'badge badge-warning float-right')); ?>
            <?php
                $this->widget('ext.select2.ESelect2',array(
                    'name'=>'FichaItem[Bodegas]',
                    'id'=>'FichaItem_Bodegas',
                    'data'=>$lista_bodegas,
                    'value' => $model->Bodegas,
                    'htmlOptions'=>array(
                        'multiple'=>'multiple',
                    ),
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


<div class="row mb-4">
    <div class="col-sm-6">  
        <button type="button" class="btn btn-success btn-sm" onclick="location.href = '<?php echo Yii::app()->getBaseUrl(true).'/index.php?r=fichaitem/admin'; ?>';"><i class="fa fa-reply"></i> Volver</button>
        <button type="button" class="btn btn-success btn-sm" id="valida_form"><i class="fas fa-save"></i> <?php if($model->isNewRecord){echo 'Crear';}else{ echo 'Guardar';} ?></button>
    </div>
</div>
<?php $this->endWidget(); ?>
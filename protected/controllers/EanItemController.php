<?php

class EanItemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','view2'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','addcod','searchitem','searchallitems','generarean13','generarean14','validaundxcajaitem'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

		$model = EanItem::model()->findByAttributes(array('Id_Item' => $id, 'Num_Und' => 0));

		$n_u_i = EanItem::model()->findAll(array('condition'=>'Id_Item=:Id_Item', 'params'=>array(':Id_Item'=>$id)));

		$criteria=new CDbCriteria;
		$criteria->condition = "Id_Item = :Id_Item";
		$criteria->order = "Num_Und ASC";
		$criteria->params = array (':Id_Item' => $id);
		$model_all = new CActiveDataProvider('EanItem', array(
		    'criteria'=>$criteria,
		));

		$n_u = count($n_u_i);

		$this->render('view',array(
			'model'=> $model,
			'model_all'=> $model_all,
			'n_u' => $n_u,

		));
	}

	public function actionView2($id)
    {
        $this->render('view2',array(
            'model'=>$this->loadModel($id),
        ));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new EanItem;
		$model->scenario = 'create';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EanItem']))
		{
			$model->attributes=$_POST['EanItem'];
			$model->Num_Und = 0;
			$model->Und_x_Caja = 1;
			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');

			if($model->save())

				//se verifica si el EAN fue tomado de los cons. pend. para inactivarlo
				$model_ean_pend = EanPend::model()->findByAttributes(array('Ean' => $model->Ean));

				if(!empty($model_ean_pend)){
					$model_ean_pend->Estado = 0;
					$model_ean_pend->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$model_ean_pend->Fecha_Actualizacion = date('Y-m-d H:i:s');
					if($model_ean_pend->save()){
						Yii::app()->user->setFlash('success', "El código de barras fue creado correctamente.");
						$this->redirect(array('admin'));
					}
				}else{
					$this->redirect(array('admin'));	
				}
				
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionAddCod($id)
	{
		
		$model=new EanItem;
		$model->scenario = 'add';

		$array_nu = array(1 => 1, 2 => 2, 3 => 3, 4 => 4);
		
		$model_all_cod_x_item = EanItem::model()->findAllByAttributes(array('Id_Item' => $id));

		if(!empty($model_all_cod_x_item)){
			foreach ($model_all_cod_x_item as $reg) {
				unset($array_nu[$reg->Num_Und]);
			}
			
		}

		$modelo_info_item = EanItem::model()->findByAttributes(array('Id_Item' => $id, 'Num_Und' => 0));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EanItem']))
		{
			$model->attributes=$_POST['EanItem'];
			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');

			if($model->save()){
				Yii::app()->user->setFlash('success', "El código de barras fue creado correctamente.");
				$this->redirect(array('eanItem/view','id'=>$id));
			}
				
		}

		$this->render('addcod',array(
			'modelo_info_item' => $modelo_info_item,
			'model'=>$model,
			'array_nu' => $array_nu,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$model=new EanItem('search');

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EanItem']))
			$model->attributes=$_GET['EanItem'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EanItem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EanItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EanItem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ean-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSearchItem(){
		$filtro = $_GET['q'];
        $data = EanItem::model()->searchByItem($filtro);
        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['ID'],
               'text' => $item['DESCR'],
           );
        endforeach;
        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}

 	public function actionSearchAllItems(){
		$filtro = $_GET['q'];
        $data = EanItem::model()->searchByAllItems($filtro);
        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['ID'],
               'text' => $item['DESCR'],
           );
        endforeach;
        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}

 	public function actionGenerarEan13()
	{
		$item = $_POST['item'];
		$criterio = $_POST['criterio'];

		if($criterio == 0){

			$q_crit = Yii::app()->db->createCommand("SELECT CASE WHEN (t1.f125_id_plan='100' AND t1.f125_id_criterio_mayor='0001' AND t2.f125_id_criterio_mayor IN ('0001','0030','0031','1060')) THEN 1 WHEN (t1.f125_id_plan='100' AND t1.f125_id_criterio_mayor='0001' AND t2.f125_id_criterio_mayor='0040') THEN 2 WHEN (t1.f125_id_plan='100' AND t1.f125_id_criterio_mayor='0010') THEN 3 ELSE 4 END AS ID FROM UnoEE1..t125_mc_items_criterios as t1 LEFT JOIN UnoEE1..t125_mc_items_criterios AS t2 ON t1.f125_rowid_item=t2.f125_rowid_item AND t2.f125_id_plan ='500' WHERE t1.f125_rowid_item = ".$item." AND t1.f125_id_plan='100'")->queryRow();

			$crit = $q_crit['ID'];

			$q_ean_pend_asig = Yii::app()->db->createCommand("SELECT TOP 1 Ean, Dig_Ver FROM TH_EAN_PEND WHERE Estado = 1 AND Criterio = ".$crit." ORDER BY Id_Ean_Pend ASC")->queryRow();

			//se encontro un consecutivo sin asignar 
			$ean = $q_ean_pend_asig['Ean'];
			$dig_ver = $q_ean_pend_asig['Dig_Ver'];

			$resp = array('criterio' => $crit, 'ean' => $ean, 'dig_ver' => $dig_ver);

	        echo json_encode($resp);

	    }else{

	    	$q_ean_pend_asig = Yii::app()->db->createCommand("SELECT TOP 1 Ean, Dig_Ver FROM TH_EAN_PEND WHERE Estado = 1 AND Criterio = ".$criterio." ORDER BY Id_Ean_Pend ASC")->queryRow();
			
			//se encontro un consecutivo sin asignar 
			$ean = $q_ean_pend_asig['Ean'];
			$dig_ver = $q_ean_pend_asig['Dig_Ver'];

			$resp = array('ean' => $ean, 'dig_ver' => $dig_ver);

	        echo json_encode($resp);

	    }

	}

	public function actionGenerarEan14()
	{
		$item = $_POST['item'];
		$num_und = $_POST['num_und'];

		$modelo_info_item = EanItem::model()->findByAttributes(array('Id_Item' => $item, 'Num_Und' => 0));

		$ean = $num_und.$modelo_info_item->Ean;

		$dig_ver = UtilidadesVarias::digitocontrolean14($ean);

		$resp = array('ean' => $ean, 'dig_ver' => $dig_ver);

        echo json_encode($resp);

	}

	public function actionValidaUndXCajaItem()
	{
		$item = $_POST['item'];
		$und_x_caja = $_POST['und_x_caja'];

		$modelo_item = EanItem::model()->findByAttributes(array('Id_Item' => $item, 'Und_x_Caja' => $und_x_caja));

		if(empty($modelo_item)){
			$response = 1;
		}else{
			$response = 0;
		}

        echo json_encode($response);

	}

}

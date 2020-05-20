<?php

class DinComController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','getcriteriosplancliente','getcriteriosplanitem'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DinCom;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DinCom']))
		{
			$model->attributes=$_POST['DinCom'];
			$model->Id_Criterio_Cliente = str_replace(' ', '',implode(',',$_POST['DinCom']['Id_Criterio_Cliente']));
			$model->Id_Criterio_Item = str_replace(' ', '',implode(',',$_POST['DinCom']['Id_Criterio_Item']));
			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');
			if($model->save())	
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$json_criterio_cliente = json_encode(explode(",", $model->Id_Criterio_Cliente));
		$json_criterio_item = json_encode(explode(",", $model->Id_Criterio_Item));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DinCom']))
		{
			$model->attributes=$_POST['DinCom'];
			$model->Id_Criterio_Cliente = str_replace(' ', '',implode(',',$_POST['DinCom']['Id_Criterio_Cliente']));
			$model->Id_Criterio_Item = str_replace(' ', '',implode(',',$_POST['DinCom']['Id_Criterio_Item']));
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');
			if($model->save())	
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
			'json_criterio_cliente'=>$json_criterio_cliente,
			'json_criterio_item'=>$json_criterio_item,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DinCom');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DinCom('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DinCom']))
			$model->attributes=$_GET['DinCom'];

		$this->render('admin',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DinCom the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DinCom::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DinCom $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='din-com-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetCriteriosPlanCliente(){
		
 		$plan = $_POST['plan'];

		$resp = Yii::app()->db->createCommand("
			SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".$plan." ORDER BY Id_Criterio
		")->queryAll();

		$i = 0;
		$array_cri = array();
		foreach ($resp as $t) {
    		$array_cri[$i] = array('id' => trim($t['Id_Criterio']),  'text' => trim($t['Criterio_Descripcion']));
    		$i++; 
	    }

	    //se retorna un json con las opciones
		echo json_encode($array_cri);
 	}

 	public function actionGetCriteriosPlanItem(){
		
 		$plan = $_POST['plan'];

		$resp = Yii::app()->db->createCommand("
			SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = ".$plan." ORDER BY Id_Criterio
		")->queryAll();

		$i = 0;
		$array_cri = array();
		foreach ($resp as $t) {
    		$array_cri[$i] = array('id' => trim($t['Id_Criterio']),  'text' => trim($t['Criterio_Descripcion']));
    		$i++; 
	    }

	    //se retorna un json con las opciones
		echo json_encode($array_cri);
 	}
}

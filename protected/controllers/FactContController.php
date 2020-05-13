<?php

class FactContController extends Controller
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
				'actions'=>array('create','update', 'export', 'exportexcel','updateest','updateest2'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','admin2','admin3'),
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
	public function actionView($id,$opc)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'opc'=>$opc,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new FactCont;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FactCont']))
		{
			$rnd = rand(0,99999);  // genera un numero ramdom entre 0-99999
			$model->attributes=$_POST['FactCont'];
			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');
			$model->Estado = 1;

			$documento_subido = CUploadedFile::getInstance($model,'sop');
            $nombre_archivo = "{$rnd}-{$documento_subido}";
            $model->Doc_Soporte = $nombre_archivo;

			if($model->save()){	
				$documento_subido->saveAs(Yii::app()->basePath.'/../images/fact_cont/'.$nombre_archivo);
				Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue cargada correctamente.");
				$this->redirect(array('admin'));
			}
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FactCont']))
		{
			$model->attributes=$_POST['FactCont'];
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');
			if($model->save()){	
				Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue actualizada correctamente.");
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateEst($id, $opc)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FactCont']))
		{
			$model->attributes=$_POST['FactCont'];
			$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
			$model->Fecha_Revision = date('Y-m-d H:i:s');
			
			if($model->save()){

				if($model->Estado == 2){
					//recibir
					Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue recibida correctamente.");
					$this->redirect(array('admin2'));
				}

				if($model->Estado == 0){
					//rechazar
					Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue rechazada correctamente.");
					$this->redirect(array('admin2'));
				}

				if($opc == 2){
					$this->redirect(array('admin2'));
				}else{
					$this->redirect(array('admin3'));	
				}
				
			}else{

				if($model->Estado == 2){
					//recibir
					Yii::app()->user->setFlash('warning', "Error al recibir la factura (".$model->Num_Factura.").");
				}

				if($model->Estado == 0){
					//rechazar
					Yii::app()->user->setFlash('warning', "Error al rechazar la factura (".$model->Num_Factura.").");
				}

				if($opc == 2){
					$this->redirect(array('admin2'));
				}else{
					$this->redirect(array('admin3'));	
				}

					
			}

		}

		$this->render('update_est',array(
			'model'=>$model,
			'opc'=>$opc,
		));
	}

	public function actionUpdateEst2($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FactCont']))
		{
			$model->attributes=$_POST['FactCont'];
			$model->Id_Usuario_Revision = NULL;
			$model->Fecha_Revision = NULL;
			
			if($model->save()){

				Yii::app()->user->setFlash('success', "La estado de la factura (".$model->Num_Factura.") fue revertido correctamente.");
				$this->redirect(array('admin3'));
				
			}else{

				Yii::app()->user->setFlash('warning', "Error al revertir el estado de la factura (".$model->Num_Factura.").");
				$this->redirect(array('admin3'));
				
			}

		}

		$this->render('update_est',array(
			'model'=>$model,
			'opc'=>3,
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
		$dataProvider=new CActiveDataProvider('FactCont');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		if(Yii::app()->request->getParam('export')) {
    		$this->actionExport();
    		Yii::app()->end();
		}

		$model=new FactCont('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));
		$lista_areas = UtilidadesVarias::listaareas();

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FactCont']))
			$model->attributes=$_GET['FactCont'];

		$this->render('admin',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
			'lista_areas'=>$lista_areas,
		));
	}

	public function actionAdmin2()
	{
		$model=new FactCont('search2');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));
		$lista_areas = UtilidadesVarias::listaareasusuario();

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FactCont']))
			$model->attributes=$_GET['FactCont'];

		$this->render('admin2',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
			'lista_areas'=>$lista_areas,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin3()
	{
		$model=new FactCont('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));
		$lista_areas = UtilidadesVarias::listaareas();

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FactCont']))
			$model->attributes=$_GET['FactCont'];

		$this->render('admin3',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
			'lista_areas'=>$lista_areas,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FactCont the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FactCont::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FactCont $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fact-pend-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionExport(){
    	
    	$model=new FactCont('search');
	    $model->unsetAttributes();  // clear any default values
	    
	    if(isset($_GET['FactCont'])) {
	        $model->attributes=$_GET['FactCont'];
	    }

    	$dp = $model->search();
		$dp->setPagination(false);
 
		$data = $dp->getData();

		Yii::app()->user->setState('fact-cont-export',$data);
	}

	public function actionExportExcel()
	{
		$data = Yii::app()->user->getState('fact-cont-export');
		$this->renderPartial('fact_cont_export_excel',array('data' => $data));	
	}

	public function actionReciDoc($id)
	{
		
		$model=$this->loadModel($id);

		$model->Estado = 2;
		$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
		$model->Fecha_Revision = date('Y-m-d H:i:s');

		if($model->save()){
			Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue recibida correctamente.");
			$this->redirect(array('admin2'));
		}else{
			Yii::app()->user->setFlash('warning', "Error al recibir la factura (".$model->Num_Factura.").");
			$this->redirect(array('admin2'));	
		}
		
	}

	public function actionRechDoc($id)
	{
		
		$model=$this->loadModel($id);

		$model->Estado = 0;
		$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
		$model->Fecha_Revision = date('Y-m-d H:i:s');

		if($model->save()){
			Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue rechazada correctamente.");
			$this->redirect(array('admin2'));
		}else{
			Yii::app()->user->setFlash('warning', "Error al rechazar la factura (".$model->Num_Factura.").");
			$this->redirect(array('admin2'));	
		}
		
	}

	public function actionUpdateEstadoFact()
	{
		$id_factura = $_POST['id_factura'];
		$opcion = $_POST['opcion'];

		$model=FactCont::model()->findByPk($id_factura);
		$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
		$model->Fecha_Revision = date('Y-m-d H:i:s');

		if($opcion == 1){
			//recibir
			$model->Estado = 2;
		}

		if($opcion == 0){
			//rechazar
			$model->Estado = 0;
		}

		if($model->save()){

			if($opcion == 1){
				//recibir
				Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue recibida correctamente.");
				$this->redirect(array('admin2'));
			}

			if($opcion == 0){
				//rechazar
				Yii::app()->user->setFlash('success', "La factura (".$model->Num_Factura.") fue rechazada correctamente.");
				$this->redirect(array('admin2'));
			}
			
		}else{

			if($opcion == 1){
				//recibir
				Yii::app()->user->setFlash('warning', "Error al recibir la factura (".$model->Num_Factura.").");
				$this->redirect(array('admin2'));
			}

			if($opcion == 0){
				//rechazar
				Yii::app()->user->setFlash('warning', "Error al rechazar la factura (".$model->Num_Factura.").");
				$this->redirect(array('admin2'));
			}

				
		}

	}

}

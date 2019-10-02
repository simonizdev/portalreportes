<?php

class InventarioController extends Controller
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
				'actions'=>array('create','update','reportepap','exportexcel', 'existencias', 'existenciaspant','verificardisponibilidad'),
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
		$model=new Inventario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventario']))
		{
			//print_r($_POST);die;
			$model->attributes=$_POST['Inventario'];
			$sumi = explode(",", $_POST['Inventario']['Id_Suministro']);
			$not = explode(",", $_POST['Inventario']['Notas']);
			$cant = explode(",", $_POST['Inventario']['Cantidad']);

			foreach ($sumi as $key => $valor) {
				$nuevo_sum = new Inventario;
				$nuevo_sum->Documento = $model->Documento;
				$nuevo_sum->Id_Departamento = $model->Id_Departamento;
				$nuevo_sum->Fecha = $model->Fecha;
				$nuevo_sum->Tipo = $model->Tipo;
				$nuevo_sum->Id_Suministro = $valor;
				$nuevo_sum->Cantidad = $cant[$key];

				$nota = $not[$key];

				if($nota == "N/A"){
					$nuevo_sum->Notas = null;	
				}else{
					$nuevo_sum->Notas = $nota;
				}

				$nuevo_sum->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
				$nuevo_sum->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
				$nuevo_sum->Fecha_Creacion = date('Y-m-d H:i:s');
				$nuevo_sum->Fecha_Actualizacion = date('Y-m-d H:i:s');
				$nuevo_sum->save();
			}

			$this->redirect(array('create'));
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

		if(isset($_POST['Inventario']))
		{
			$model->attributes=$_POST['Inventario'];

			$nota = $_POST['Inventario']['Notas'];

			if($nota == ""){
				$n = null;
			}else{
				$n = $nota;
			}

			$model->Notas = $n;
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');

			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('Inventario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Inventario('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventario']))
			$model->attributes=$_GET['Inventario'];

		$this->render('admin',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Inventario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Inventario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Inventario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionReportePap()
	{
		$this->render('reportepap');
	}

	public function actionExportExcel()
	{
		$this->renderPartial('reporte_export_excel');	
	}

	public function actionExistencias()
	{		
		$model=new Inventario;
		$model->scenario = 'existencias';

		if(isset($_POST['Inventario']))
		{
			$model=$_POST['Inventario'];
			$this->renderPartial('existencias_resp',array('model' => $model));	
		}

		$this->render('existencias',array(
			'model'=>$model,
		));
	}

	public function actionExistenciasPant()
	{		
		if (isset($_POST['id_suministro'])){ $id_suministro = $_POST['id_suministro']; } else { $id_suministro = ""; }

		$resultados = UtilidadesReportes::existenciaspantalla($id_suministro);

		echo $resultados;
	}

	public function actionVerificarDisponibilidad()
	{
		$id_sum = $_POST['id_sum'];
		$cant = $_POST['cant'];
		$id = $_POST['id'];

		$opc = '';
       	$msj = '';

		$cant_sal = 0;

		$modelo_suministro_sal = Inventario::model()->FindAllByAttributes(array('Tipo' => 2, 'Id_Suministro' => $id_sum));

		if(!is_null($modelo_suministro_sal)){
			foreach ($modelo_suministro_sal as $sal) {
				if($id != $sal->Id_Inventario){
					$cant_sal = $cant_sal + $sal->Cantidad;	
				}
			}
		}

		$cant_ent = 0;

		$modelo_suministro_ent = Inventario::model()->FindAllByAttributes(array('Tipo' => 1, 'Id_Suministro' => $id_sum));

		if(!is_null($modelo_suministro_ent)){
			foreach ($modelo_suministro_ent as $ent) {
				$cant_ent = $cant_ent + $ent->Cantidad;	
			}
		}

		$cant_disp = $cant_ent - $cant_sal;

		if($cant_disp <= 0){
			$opc = 0;
			$msj = 'No hay unidades disponibles de este suministro.';
		}else{
			if($cant_disp >= $cant){
				$opc = 1;
				$msj = '';
			}else{
				$opc = 0;
				$msj = 'Solo hay disponible '.$cant_disp.' unidad(es) de este suministro.';
			}	
		}


		$resp = array('opc' => $opc, 'msj' => $msj);

        echo json_encode($resp);

	}

}

<?php

class ActividadController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Actividad;
		$model->scenario = 'create';

		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario', 'condition'=>'Estado=1'));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Actividad']))
		{
			$model->attributes=$_POST['Actividad'];
			$model->Hora = date('H:i:s', strtotime($model->Hora));
			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');
			if($model->save())	
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
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
		$model->scenario = 'update';

		//hist 
		$hist=new HistActividad('search');
		$hist->unsetAttributes();  // clear any default values
		$hist->Id_Actividad = $id;

		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario', 'condition'=>'Estado=1'));

		$id_usuario_actual = $model->Id_Usuario;
		$tipo_actual = $model->Tipo;
		$usuario_actual = $model->idusuario->Nombres;
		$actividad_actual = $model->Actividad;
		$estado_actual = $model->Estado;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Actividad']))
		{
			$tipo_nuevo = $_POST['Actividad']['Tipo'];
			$id_usuario_nuevo = $_POST['Actividad']['Id_Usuario'];
			$usuario_nuevo = Usuario::model()->findByPk($_POST['Actividad']['Id_Usuario'])->Nombres;
			$actividad_nueva = $_POST['Actividad']['Actividad'];
			$estado_nuevo = $_POST['Actividad']['Estado'];
			
			$model->attributes=$_POST['Actividad'];
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');

			if($model->Estado == 2){
				$model->Hora_Cierre = date('H:i:s', strtotime($_POST['Actividad']['Hora_Cierre']));
				$fecha_cierre_nueva = $_POST['Actividad']['Fecha_Cierre'];
				$hora_cierre_nueva = $model->HoraAmPm(date('H:i:s', strtotime($_POST['Actividad']['Hora_Cierre'])));
			}else{
				$model->Fecha_Cierre = null;
				$model->Hora_Cierre = null;
				$fecha_cierre_nueva = null;
				$hora_cierre_nueva = null;
			}

			$texto_novedad = "";
			$flag = 0;

			//tipo
			if($tipo_actual != $tipo_nuevo){
				$flag = 1;
				$texto_novedad .= "Tipo: ".$model->DescTipo($tipo_actual)." / ".$model->DescTipo($tipo_nuevo).", ";
			}

			//usuario
			if($id_usuario_actual != $id_usuario_nuevo){
				$flag = 1;
				$texto_novedad .= "Usuario: ".$usuario_actual." / ".$usuario_nuevo.", ";
			}

			//actividad
			if($actividad_actual != $actividad_nueva){
				$flag = 1;
				$texto_novedad .= "Actividad: ".$actividad_actual." / ".$actividad_nueva.", ";
			}

			//Estado
			if($estado_actual != $estado_nuevo){
				$flag = 1;
				$texto_novedad .= "Estado: ".$model->DescEstado($estado_actual)." / ".$model->DescEstado($estado_nuevo).", ";
			}

			//área
			if($model->Estado == 2){
				$flag = 1;
				$texto_novedad .= "Fecha de cierre: ".$fecha_cierre_nueva.", Hora de cierre: ".$hora_cierre_nueva.", ";
			}

			//alguno de los criterios cambio
			if($flag == 1){
				$texto_novedad = substr ($texto_novedad, 0, -2);
				$nueva_novedad = new HistActividad;
				$nueva_novedad->Id_Actividad = $model->Id;
				$nueva_novedad->Texto = $texto_novedad;
				$nueva_novedad->Id_Usuario_Registro = Yii::app()->user->getState('id_user');
				$nueva_novedad->Fecha_Registro = date('Y-m-d H:i:s');
				$nueva_novedad->save();
			}

			if($model->save())	
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
			'hist'=>$hist,
			'usuarios'=>$usuarios,	
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Actividad('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Actividad']))
			$model->attributes=$_GET['Actividad'];

		$this->render('admin',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Actividad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Actividad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Actividad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='actividad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

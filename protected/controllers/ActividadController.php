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
				'actions'=>array('create','update','gettipos','getusuarios'),
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

		$q_grupos=TipoActUsuario::model()->findAll(array('condition'=>'Estado=:estado AND Id_Usuario ='.Yii::app()->user->getState('id_user'), 'params'=>array(':estado'=>1)));

		$grupos = array();
		foreach ($q_grupos as $g) {
			$grupos[$g->idtipoact->idgrupo->Id_Dominio] = $g->idtipoact->idgrupo->Dominio;	
	    }

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Actividad']))
		{
			$model->attributes=$_POST['Actividad'];
			$model->Pais = implode(",", $_POST['Actividad']['Pais']);
			$model->Hora = date('H:i:s', strtotime($model->Hora));
			if($_POST['Actividad']['Fecha_Finalizacion'] != ""){$model->Fecha_Finalizacion = $_POST['Actividad']['Fecha_Finalizacion']; }else{$model->Fecha_Finalizacion = NULL; }
			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');
			$model->Estado = 1;

			if($model->save())	
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
			'grupos'=>$grupos,
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

		//$usuarios=Usuario::model()->findAll(array('order'=>'Usuario', 'condition'=>'Estado=1'));

		$q_grupos=TipoActUsuario::model()->findAll(array('condition'=>'Estado=:estado AND Id_Usuario ='.Yii::app()->user->getState('id_user'), 'params'=>array(':estado'=>1)));

		$grupos = array();
		foreach ($q_grupos as $g) {
			$grupos[$g->idtipoact->idgrupo->Id_Dominio] = $g->idtipoact->idgrupo->Dominio;	
	    }

		$q_tipos = Yii::app()->db->createCommand("SELECT TA.Id_Tipo, TA.Tipo FROM TH_TIPO_ACT TA 
		LEFT JOIN TH_TIPO_ACT_USUARIO TAU ON TAU.Id_Tipo = TA.Id_Tipo AND TAU.Estado = 1
		WHERE TA.Estado = 1 AND TA.Id_Grupo = ".$model->Id_Grupo." AND TAU.Id_Usuario = ".Yii::app()->user->getState('id_user')." AND (SELECT COUNT (*) FROM TH_TIPO_ACT C WHERE C.Padre = TA.Id_Tipo) = 0 ORDER BY 2")->queryAll();

		$tipos = array();
		foreach ($q_tipos as $t) {
			$tipos[$t['Id_Tipo']] = $t['Tipo'];	
	    }

	    $q_usuarios = Yii::app()->db->createCommand("
		SELECT TAU.Id_Usuario, U.Nombres FROM TH_TIPO_ACT_USUARIO TAU 
		LEFT JOIN TH_USUARIOS U ON TAU.Id_Usuario = U.Id_Usuario AND U.Estado = 1
		WHERE TAU.Estado = 1 AND TAU.Id_Tipo = ".$model->Id_Tipo." AND TAU.Id_Usuario != ".$model->Id_Usuario." ORDER BY 2
		")->queryAll();

		$usuarios = array();
		foreach ($q_usuarios as $u) {
			$usuarios[$u['Id_Usuario']] = $u['Nombres'];	
	    }
	
		$actividad_actual = $model->Actividad;
		$prioridad_actual = $model->Prioridad;
		$estado_actual = $model->Estado;
		if($model->Estado == 3){
			$id_usuario_deleg_actual = $model->Id_Usuario_Deleg;
			$usuario_deleg_actual = $model->idusuariodeleg->Nombres;
		}else{
			$id_usuario_deleg_actual = null;
			$usuario_deleg_actual = '-';	
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Actividad']))
		{
			$actividad_nueva = $_POST['Actividad']['Actividad'];
			$prioridad_nueva = $_POST['Actividad']['Prioridad'];
			$estado_nuevo = $_POST['Actividad']['Estado'];
			
			$model->attributes=$_POST['Actividad'];
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');

			if($model->Estado == 2){
				$model->Hora_Cierre = date('H:i:s', strtotime($_POST['Actividad']['Hora_Cierre']));
				$fecha_cierre_nueva = $_POST['Actividad']['Fecha_Cierre'];
				$hora_cierre_nueva = $model->HoraAmPm(date('H:i:s', strtotime($_POST['Actividad']['Hora_Cierre'])));
				$model->Id_Usuario_Deleg = null;
				$id_usuario_deleg_nuevo = null;
				$usuario_deleg_nuevo = '-';
			}

			if($model->Estado == 3){
				$model->Fecha_Cierre = null;
				$model->Hora_Cierre = null;
				$fecha_cierre_nueva = null;
				$hora_cierre_nueva = null;
				$model->Id_Usuario_Deleg = $_POST['Actividad']['Id_Usuario_Deleg'];
				$id_usuario_deleg_nuevo = $_POST['Actividad']['Id_Usuario_Deleg'];
				$usuario_deleg_nuevo = Usuario::model()->findByPk($_POST['Actividad']['Id_Usuario_Deleg'])->Nombres;
			}

			if($model->Estado == 1 || $model->Estado == 4 ||  $model->Estado == 5 ||  $model->Estado == 6 ||  $model->Estado == 7){
				$model->Fecha_Cierre = null;
				$model->Hora_Cierre = null;
				$fecha_cierre_nueva = null;
				$hora_cierre_nueva = null;
				$model->Id_Usuario_Deleg = null;
				$id_usuario_deleg_nuevo = null;
				$usuario_deleg_nuevo = '-';
			}

			$texto_novedad = "";
			$flag = 0;

			//usuario al que cede
			if($id_usuario_deleg_actual != $id_usuario_deleg_nuevo){
				$flag = 1;
				$texto_novedad .= "Cedido a: ".$usuario_deleg_actual." / ".$usuario_deleg_nuevo.", ";
			}

			//actividad
			if($actividad_actual != $actividad_nueva){
				$flag = 1;
				$texto_novedad .= "Actividad: ".$actividad_actual." / ".$actividad_nueva.", ";
			}

			//Prioridad
			if($prioridad_actual != $prioridad_nueva){
				$flag = 1;
				$texto_novedad .= "Prioridad: ".$model->DescPrioridad($prioridad_actual)." / ".$model->DescPrioridad($prioridad_nueva).", ";
			}

			//Estado
			if($estado_actual != $estado_nuevo){
				$flag = 1;
				$texto_novedad .= "Estado: ".$model->DescEstado($estado_actual)." / ".$model->DescEstado($estado_nuevo).", ";
			}

			//Estado completado
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
			'grupos'=>$grupos,
			'tipos'=>$tipos,	
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		

		$q_grupos=TipoActUsuario::model()->findAll(array('condition'=>'Estado=:estado AND Id_Usuario ='.Yii::app()->user->getState('id_user'), 'params'=>array(':estado'=>1)));

		if(!empty($q_grupos)){

			$model=new Actividad('search');
			$a = 1;
			$grupos = array();
			foreach ($q_grupos as $g) {
				$grupos[$g->idtipoact->idgrupo->Id_Dominio] = $g->idtipoact->idgrupo->Dominio;	
		    }

		    $model->unsetAttributes();  // clear any default values
			if(isset($_GET['Actividad'])){
				$model->attributes=$_GET['Actividad'];
			}

		}else{

			$model=new Actividad('search');
			$a = 0;
			$grupos = array();

		}

		$this->render('admin',array(
			'model'=>$model,
			'a'=>$a,
			'grupos'=>$grupos,
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

	public function actionGetTipos()
	{	
		$grupo = $_POST['grupo'];

		$tipos = Yii::app()->db->createCommand("
		SELECT TA.Id_Tipo, TA.Tipo FROM TH_TIPO_ACT TA 
		LEFT JOIN TH_TIPO_ACT_USUARIO TAU ON TAU.Id_Tipo = TA.Id_Tipo AND TAU.Estado = 1
		WHERE TA.Estado = 1 AND TA.Id_Grupo = ".$grupo." AND TAU.Id_Usuario = ".Yii::app()->user->getState('id_user')." AND (SELECT COUNT (*) FROM TH_TIPO_ACT C WHERE C.Padre = TA.Id_Tipo) = 0 ORDER BY 2
		")->queryAll();

		$i = 0;
		$array_tipos = array();
		foreach ($tipos as $t) {
			$array_tipos[$i] = array('id' => $t['Id_Tipo'],  'text' => $t['Tipo']);	
    		$i++; 
	    }

		//se retorna un json con las opciones
		echo json_encode($array_tipos);

	}

	public function actionGetUsuarios()
	{	
		$tipo = $_POST['tipo'];

		$q_user = Yii::app()->db->createCommand("
		SELECT TAU.Id_Usuario, U.Nombres FROM TH_TIPO_ACT_USUARIO TAU 
		LEFT JOIN TH_USUARIOS U ON TAU.Id_Usuario = U.Id_Usuario AND U.Estado = 1
		WHERE TAU.Estado = 1 AND TAU.Id_Tipo = ".$tipo." ORDER BY 2
		")->queryAll();

		$i = 0;
		$array_u = array();
		foreach ($q_user as $u) {
			$array_u[$i] = array('id' => $u['Id_Usuario'],  'text' => $u['Nombres']);	
    		$i++; 
	    }

		//se retorna un json con las opciones
		echo json_encode($array_u);

	}
}

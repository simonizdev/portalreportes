<?php

class TipoDoctoUsuarioController extends Controller
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
				'actions'=>array('export', 'exportexcel'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TipoDoctoUsuario');
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

		$model=new TipoDoctoUsuario('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));
		$tipos_docto=ITipoDocto::model()->findAll(array('order'=>'Descripcion'));

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TipoDoctoUsuario']))
			$model->attributes=$_GET['TipoDoctoUsuario'];

		$this->render('admin',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
			'tipos_docto'=>$tipos_docto,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TipoDoctoUsuario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TipoDoctoUsuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TipoDoctoUsuario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tipo-docto-usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionExport(){
    	
    	$model=new TipoDoctoUsuario('search');
	    $model->unsetAttributes();  // clear any default values
	    
	    if(isset($_GET['TipoDoctoUsuario'])) {
	        $model->attributes=$_GET['TipoDoctoUsuario'];
	    }

    	$dp = $model->search();
		$dp->setPagination(false);
 
		$data = $dp->getData();

		Yii::app()->user->setState('tipo-docto-usuario-export',$data);
	}

	public function actionExportExcel()
	{
		$data = Yii::app()->user->getState('tipo-docto-usuario-export');
		$this->renderPartial('tipo_docto_usuario_export_excel',array('data' => $data));	
	}
}

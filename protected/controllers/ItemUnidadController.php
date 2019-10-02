<?php

class ItemUnidadController extends Controller
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
				'actions'=>array('create','update','evaluarexistencia','export', 'exportexcel','searchunidad','searchunidadbyid','searchitem'),
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

		$model = $this->loadModel($id);

		if($model->Unidad_1 != "" && $model->Unidad_2 == "" && $model->Unidad_3 == "" && $model->Unidad_4 == ""){
			$num_und = 1;
		}

		if($model->Unidad_1 != "" && $model->Unidad_2 != "" && $model->Unidad_3 == "" && $model->Unidad_4 == ""){
			$num_und = 2;
		}

		if($model->Unidad_1 != "" && $model->Unidad_2 != "" && $model->Unidad_3 != "" && $model->Unidad_4 == ""){
			$num_und = 3;
		}

		if($model->Unidad_1 != "" && $model->Unidad_2 != "" && $model->Unidad_3 != "" && $model->Unidad_4 != ""){
			$num_und = 4;
		}

		$this->render('view',array(
			'model'=>$model,
			'num_und'=>$num_und
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ItemUnidad;

		$opc = 0;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ItemUnidad']))
		{

			$model->attributes=$_POST['ItemUnidad'];

			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');

			if($model->num_und == 1){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];

				$model->Unidad_2 = null;
				$model->Cantidad2 = null;
				$model->Largo2 = null;
				$model->Alto2 = null;
				$model->Ancho2 = null;
				$model->Volumen_Total2 = null;
				$model->Peso_Total2 = null;
				$model->Cod_Barras2 = null;

				$model->Unidad_3 = null;
				$model->Cantidad3 = null;
				$model->Largo3 = null;
				$model->Alto3 = null;
				$model->Ancho3 = null;
				$model->Volumen_Total3 = null;
				$model->Peso_Total3 = null;
				$model->Cod_Barras3 = null;

				$model->Unidad_4 = null;
				$model->Cantidad4 = null;
				$model->Largo4 = null;
				$model->Alto4 = null;
				$model->Ancho4 = null;
				$model->Volumen_Total4 = null;
				$model->Peso_Total4 = null;
				$model->Cod_Barras4 = null;
			}

			if($model->num_und == 2){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];
				$model->Unidad_2 = $_POST['ItemUnidad']['Unidad_2'];

				$model->Unidad_3 = null;
				$model->Cantidad3 = null;
				$model->Largo3 = null;
				$model->Alto3 = null;
				$model->Ancho3 = null;
				$model->Volumen_Total3 = null;
				$model->Peso_Total3 = null;
				$model->Cod_Barras3 = null;

				$model->Unidad_4 = null;
				$model->Cantidad4 = null;
				$model->Largo4 = null;
				$model->Alto4 = null;
				$model->Ancho4 = null;
				$model->Volumen_Total4 = null;
				$model->Peso_Total4 = null;
				$model->Cod_Barras4 = null;

			}

			if($model->num_und == 3){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];
				$model->Unidad_2 = $_POST['ItemUnidad']['Unidad_2'];
				$model->Unidad_3 = $_POST['ItemUnidad']['Unidad_3'];

				$model->Unidad_4 = null;
				$model->Cantidad4 = null;
				$model->Largo4 = null;
				$model->Alto4 = null;
				$model->Ancho4 = null;
				$model->Volumen_Total4 = null;
				$model->Peso_Total4 = null;
				$model->Cod_Barras4 = null;

			}

			if($model->num_und == 4){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];
				$model->Unidad_2 = $_POST['ItemUnidad']['Unidad_2'];
				$model->Unidad_3 = $_POST['ItemUnidad']['Unidad_3'];
				$model->Unidad_4 = $_POST['ItemUnidad']['Unidad_4'];

			}

			if($_FILES['ItemUnidad']['name']['Foto']  != "") {
		    	$rnd = rand(0,99999);  // genera un numero ramdom entre 0-99999
		        $img_subida = CUploadedFile::getInstance($model,'Foto');
	            $nombre_archivo = "{$model->Id_Item}-{$rnd}-{$img_subida}"; 
	            $model->Foto = $nombre_archivo;
	            $opc = 1;
		    } 
 
            if($model->save()){
        		if($opc == 1){
                	$img_subida->saveAs(Yii::app()->basePath.'/../images/items/'.$nombre_archivo);
            	}
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
		$opc = 0;

		$model=$this->loadModel($id);

		$foto_act = $model->Foto;

		if($model->Foto != ""){
			$del_foto = 1;
		}else{
			$del_foto = 0;
		}

		$ruta_img_act = Yii::app()->basePath.'/../images/items/'.$model->Foto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if($model->Unidad_1 != "" && $model->Unidad_2 == "" && $model->Unidad_3 == "" && $model->Unidad_4 == ""){
			$num_und = 1;
		}

		if($model->Unidad_1 != "" && $model->Unidad_2 != "" && $model->Unidad_3 == "" && $model->Unidad_4 == ""){
			$num_und = 2;
		}

		if($model->Unidad_1 != "" && $model->Unidad_2 != "" && $model->Unidad_3 != "" && $model->Unidad_4 == ""){
			$num_und = 3;
		}

		if($model->Unidad_1 != "" && $model->Unidad_2 != "" && $model->Unidad_3 != "" && $model->Unidad_4 != ""){
			$num_und = 4;
		}

		if(isset($_POST['ItemUnidad']))
		{
			$model->attributes=$_POST['ItemUnidad'];

			$model->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
			$model->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
			$model->Fecha_Creacion = date('Y-m-d H:i:s');
			$model->Fecha_Actualizacion = date('Y-m-d H:i:s');

			if($model->num_und == 1){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];

				$model->Unidad_2 = null;
				$model->Cantidad2 = null;
				$model->Largo2 = null;
				$model->Alto2 = null;
				$model->Ancho2 = null;
				$model->Volumen_Total2 = null;
				$model->Peso_Total2 = null;
				$model->Cod_Barras2 = null;

				$model->Unidad_3 = null;
				$model->Cantidad3 = null;
				$model->Largo3 = null;
				$model->Alto3 = null;
				$model->Ancho3 = null;
				$model->Volumen_Total3 = null;
				$model->Peso_Total3 = null;
				$model->Cod_Barras3 = null;

				$model->Unidad_4 = null;
				$model->Cantidad4 = null;
				$model->Largo4 = null;
				$model->Alto4 = null;
				$model->Ancho4 = null;
				$model->Volumen_Total4 = null;
				$model->Peso_Total4 = null;
				$model->Cod_Barras4 = null;
			}

			if($model->num_und == 2){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];
				$model->Unidad_2 = $_POST['ItemUnidad']['Unidad_2'];

				$model->Unidad_3 = null;
				$model->Cantidad3 = null;
				$model->Largo3 = null;
				$model->Alto3 = null;
				$model->Ancho3 = null;
				$model->Volumen_Total3 = null;
				$model->Peso_Total3 = null;
				$model->Cod_Barras3 = null;

				$model->Unidad_4 = null;
				$model->Cantidad4 = null;
				$model->Largo4 = null;
				$model->Alto4 = null;
				$model->Ancho4 = null;
				$model->Volumen_Total4 = null;
				$model->Peso_Total4 = null;
				$model->Cod_Barras4 = null;

			}

			if($model->num_und == 3){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];
				$model->Unidad_2 = $_POST['ItemUnidad']['Unidad_2'];
				$model->Unidad_3 = $_POST['ItemUnidad']['Unidad_3'];

				$model->Unidad_4 = null;
				$model->Cantidad4 = null;
				$model->Largo4 = null;
				$model->Alto4 = null;
				$model->Ancho4 = null;
				$model->Volumen_Total4 = null;
				$model->Peso_Total4 = null;
				$model->Cod_Barras4 = null;

			}

			if($model->num_und == 4){

				$model->Unidad_1 = $_POST['ItemUnidad']['Unidad_1'];
				$model->Unidad_2 = $_POST['ItemUnidad']['Unidad_2'];
				$model->Unidad_3 = $_POST['ItemUnidad']['Unidad_3'];
				$model->Unidad_4 = $_POST['ItemUnidad']['Unidad_4'];

			}

			if($_FILES['ItemUnidad']['name']['Foto']  != "") {
		    	$rnd = rand(0,99999);  // genera un numero ramdom entre 0-99999
		        $img_subida = CUploadedFile::getInstance($model,'Foto');
	            $nombre_archivo = "{$model->Id_Item}-{$rnd}-{$img_subida}"; 
	            $model->Foto = $nombre_archivo;
	            $opc = 1;
		    }else{
		    	$model->Foto = $foto_act;
		    }
 
            if($model->save()){
        		if($opc == 1){
        			if($del_foto == 1){
        				unlink($ruta_img_act);
        			}
                	$img_subida->saveAs(Yii::app()->basePath.'/../images/items/'.$nombre_archivo);
            	}
                $this->redirect(array('admin'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
			'num_und'=>$num_und	
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		$model=$this->loadModel($id);

		if($model->Foto != ""){

			$ruta_img_act = Yii::app()->basePath.'/../images/items/'.$model->Foto;
			unlink($ruta_img_act);

		}

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
		$dataProvider=new CActiveDataProvider('ItemUnidad');
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

		$model=new ItemUnidad('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));


		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ItemUnidad']))
			$model->attributes=$_GET['ItemUnidad'];

		$this->render('admin',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ItemUnidad the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ItemUnidad::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ItemUnidad $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='item-unidad-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionEvaluarExistencia()
	{
		$item = $_POST['item'];

		$model_und_item = ItemUnidad::model()->findByAttributes(array('Id_Item' => $item));

		if(empty($model_und_item)){
			echo 0;
		}else{
			echo 1;
		}
	}

	public function actionExport(){
    	
    	$model=new ItemUnidad('search');
	    $model->unsetAttributes();  // clear any default values
	    
	    if(isset($_GET['ItemUnidad'])) {
	        $model->attributes=$_GET['ItemUnidad'];
	    }

    	$dp = $model->search();
		$dp->setPagination(false);
 
		$data = $dp->getData();

		Yii::app()->user->setState('item-unidad-export',$data);
	}

	public function actionExportExcel()
	{
		$data = Yii::app()->user->getState('item-unidad-export');
		$this->renderPartial('item_unidad_export_excel',array('data' => $data));	
	}

	public function actionSearchUnidad(){
		$filtro = $_GET['q'];
        $data = ItemUnidad::model()->searchByUnidad($filtro);
        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['f101_id'],
               'text' => $item['f101_id'].' - '.$item['f101_descripcion'],
           );
        endforeach;
        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}

	public function actionSearchUnidadById(){
		$filtro = $_GET['id'];
        $data = ItemUnidad::model()->searchById($filtro);

        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['f101_id'],
               'text' => $item['f101_id'].' - '.$item['f101_descripcion'],
           );
        endforeach;

        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}

 	public function actionSearchItem(){
		$filtro = $_GET['q'];
        $data = ItemUnidad::model()->searchByItem($filtro);
        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['I_ID_ITEM'],
               'text' => $item['DESCR'],
           );
        endforeach;
        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}
}

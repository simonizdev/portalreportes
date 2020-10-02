<?php

class FichaItemController extends Controller
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
				'actions'=>array('view','create','create2','update','update2','rechazar','aprobar','searchitem','searchitembyid'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','rev'),
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
	public function actionView($id, $opc)
	{
		
		$model = $this->loadModel($id);

		$unidad = Yii::app()->db->createCommand("SELECT f101_id, f101_descripcion FROM UnoEE1..t101_mc_unidades_medida WHERE f101_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_unidad = array();
		foreach ($unidad as $uni) {
			$lista_unidad[trim($uni['f101_id'])] = $uni['f101_id'].' - '.$uni['f101_descripcion'];
		}

		$tipo_inv = Yii::app()->db->createCommand("SELECT f149_id, f149_descripcion FROM UnoEE1..t149_mc_tipo_inv_serv WHERE f149_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_tipo_inv = array();
		foreach ($tipo_inv as $ti_inv) {
			$lista_tipo_inv[trim($ti_inv['f149_id'])] = $ti_inv['f149_descripcion'];
		}

		$grupo_imp = Yii::app()->db->createCommand("SELECT f113_id, f113_descripcion FROM UnoEE1..t113_mc_grupos_impositivos WHERE f113_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_grupo_imp = array();
		foreach ($grupo_imp as $gr_i) {
			$lista_grupo_imp[trim($gr_i['f113_id'])] = $gr_i['f113_descripcion'];
		}

		$origen = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100 ORDER BY 2")->queryAll();

		$lista_origen = array();
		foreach ($origen as $ori) {
			$lista_origen[trim($ori['Id_Criterio'])] = $ori['Criterio_Descripcion'];
		}

		$tipo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 200 ORDER BY 2")->queryAll();

		$lista_tipo = array();
		foreach ($tipo as $tip) {
			$lista_tipo[trim($tip['Id_Criterio'])] = $tip['Criterio_Descripcion'];
		}

		$clasif = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 300 ORDER BY 2")->queryAll();

		$lista_clasif = array();
		foreach ($clasif as $clas) {
			$lista_clasif[trim($clas['Id_Criterio'])] = $clas['Criterio_Descripcion'];
		}

		$clase = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 400 ORDER BY 2")->queryAll();

		$lista_clase = array();
		foreach ($clase as $cl) {
			$lista_clase[trim($cl['Id_Criterio'])] = $cl['Criterio_Descripcion'];
		}

		$marca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500 ORDER BY 2")->queryAll();

		$lista_marca = array();
		foreach ($marca as $mar) {
			$lista_marca[trim($mar['Id_Criterio'])] = $mar['Criterio_Descripcion'];
		}

		$submarca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 550 ORDER BY 2")->queryAll();

		$lista_submarca = array();
		foreach ($submarca as $subm) {
			$lista_submarca[trim($subm['Id_Criterio'])] = $subm['Criterio_Descripcion'];
		}

		$segmento = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 600 ORDER BY 2")->queryAll();

		$lista_segmento = array();
		foreach ($segmento as $seg) {
			$lista_segmento[trim($seg['Id_Criterio'])] = $seg['Criterio_Descripcion'];
		}

		$familia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 650 ORDER BY 2")->queryAll();

		$lista_familia = array();
		foreach ($familia as $fam) {
			$lista_familia[trim($fam['Id_Criterio'])] = $fam['Criterio_Descripcion'];
		}

		$linea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700 ORDER BY 2")->queryAll();

		$lista_linea = array();
		foreach ($linea as $lin) {
			$lista_linea[trim($lin['Id_Criterio'])] = $lin['Criterio_Descripcion'];
		}

		$subfamilia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 750 ORDER BY 2")->queryAll();

		$lista_subfamilia = array();
		foreach ($subfamilia as $subfam) {
			$lista_subfamilia[trim($subfam['Id_Criterio'])] = $subfam['Criterio_Descripcion'];
		}

		$sublinea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 800 ORDER BY 2")->queryAll();

		$lista_sublinea = array();
		foreach ($sublinea as $sublin) {
			$lista_sublinea[trim($sublin['Id_Criterio'])] = $sublin['Criterio_Descripcion'];
		}

		$grupo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 850 ORDER BY 2")->queryAll();

		$lista_grupo = array();
		foreach ($grupo as $gr) {
			$lista_grupo[trim($gr['Id_Criterio'])] = $gr['Criterio_Descripcion'];
		}

		$uni_neg = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 900 ORDER BY 2")->queryAll();

		$lista_un = array();
		foreach ($uni_neg as $un) {
			$lista_un[trim($un['Id_Criterio'])] = $un['Criterio_Descripcion'];
		}

		$fabrica = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 920 ORDER BY 2")->queryAll();

		$lista_fabrica = array();
		foreach ($fabrica as $fab) {
			$lista_fabrica[trim($fab['Id_Criterio'])] = $fab['Criterio_Descripcion'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950 ORDER BY 2")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[trim($ora['Id_Criterio'])] = $ora['Criterio_Descripcion'];
		}

		$instalaciones = Yii::app()->db->createCommand("SELECT f157_id, f157_descripcion FROM UnoEE1..t157_mc_instalaciones WHERE f157_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_ins = array();
		foreach ($instalaciones as $ins) {
			$lista_ins[trim($ins['f157_id'])] = $ins['f157_id'].' - '.$ins['f157_descripcion'];
		}

		$bodegas = Yii::app()->db->createCommand("SELECT f150_id, f150_descripcion_corta FROM UnoEE1..t150_mc_bodegas WHERE f150_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_bodegas = array();
		foreach ($bodegas as $bod) {
			$lista_bodegas[trim($bod['f150_id'])] = $bod['f150_id'].' - '.$bod['f150_descripcion_corta'];
		}

		$array_inst_activas = array();
		//opciones activas en el combo perfiles
		$instalaciones =  explode(",", $model->Instalaciones);
		foreach ($instalaciones as $ins => $id) {
			array_push($array_inst_activas, $id);
		}

		$instalaciones_activas = json_encode($array_inst_activas);

		$array_bod_activas = array();
		//opciones activas en el combo perfiles
		$b =  explode(",", $model->Bodegas);
		foreach ($b as $bo => $id) {
			array_push($array_bod_activas, $id);
		}

		$bodegas_activas = json_encode($array_bod_activas);

		$this->render('view',array(
			'opc'=>$opc,
			'model'=>$model,
			'lista_unidad'=>$lista_unidad,
			'lista_tipo_inv'=>$lista_tipo_inv,
			'lista_grupo_imp'=>$lista_grupo_imp,
			'lista_origen'=>$lista_origen,
			'lista_tipo'=>$lista_tipo,
			'lista_clasif'=>$lista_clasif,
			'lista_clase'=>$lista_clase,
			'lista_marca'=>$lista_marca,
			'lista_submarca'=>$lista_submarca,
			'lista_segmento'=>$lista_segmento,
			'lista_familia'=>$lista_familia,
			'lista_linea'=>$lista_linea,
			'lista_subfamilia'=>$lista_subfamilia,
			'lista_sublinea'=>$lista_sublinea,
			'lista_grupo'=>$lista_grupo,
			'lista_un'=>$lista_un,
			'lista_fabrica'=>$lista_fabrica,
			'lista_oracle'=>$lista_oracle,
			'lista_ins'=>$lista_ins,
			'lista_bodegas'=>$lista_bodegas,
			'instalaciones_activas'=>$instalaciones_activas,
			'bodegas_activas'=>$bodegas_activas,

		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new FichaItem;
		$model->Scenario = 'create';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$unidad = Yii::app()->db->createCommand("SELECT f101_id, f101_descripcion FROM UnoEE1..t101_mc_unidades_medida WHERE f101_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_unidad = array();
		foreach ($unidad as $uni) {
			$lista_unidad[trim($uni['f101_id'])] = $uni['f101_id'].' - '.$uni['f101_descripcion'];
		}

		$origen = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100 ORDER BY 2")->queryAll();

		$lista_origen = array();
		foreach ($origen as $ori) {
			$lista_origen[trim($ori['Id_Criterio'])] = $ori['Criterio_Descripcion'];
		}

		$tipo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 200 ORDER BY 2")->queryAll();

		$lista_tipo = array();
		foreach ($tipo as $tip) {
			$lista_tipo[trim($tip['Id_Criterio'])] = $tip['Criterio_Descripcion'];
		}

		$clasif = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 300 ORDER BY 2")->queryAll();

		$lista_clasif = array();
		foreach ($clasif as $clas) {
			$lista_clasif[trim($clas['Id_Criterio'])] = $clas['Criterio_Descripcion'];
		}

		$clase = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 400 ORDER BY 2")->queryAll();

		$lista_clase = array();
		foreach ($clase as $cl) {
			$lista_clase[trim($cl['Id_Criterio'])] = $cl['Criterio_Descripcion'];
		}

		$marca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500 ORDER BY 2")->queryAll();

		$lista_marca = array();
		foreach ($marca as $mar) {
			$lista_marca[trim($mar['Id_Criterio'])] = $mar['Criterio_Descripcion'];
		}

		$submarca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 550 ORDER BY 2")->queryAll();

		$lista_submarca = array();
		foreach ($submarca as $subm) {
			$lista_submarca[trim($subm['Id_Criterio'])] = $subm['Criterio_Descripcion'];
		}

		$segmento = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 600 ORDER BY 2")->queryAll();

		$lista_segmento = array();
		foreach ($segmento as $seg) {
			$lista_segmento[trim($seg['Id_Criterio'])] = $seg['Criterio_Descripcion'];
		}

		$familia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 650 ORDER BY 2")->queryAll();

		$lista_familia = array();
		foreach ($familia as $fam) {
			$lista_familia[trim($fam['Id_Criterio'])] = $fam['Criterio_Descripcion'];
		}

		$linea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700 ORDER BY 2")->queryAll();

		$lista_linea = array();
		foreach ($linea as $lin) {
			$lista_linea[trim($lin['Id_Criterio'])] = $lin['Criterio_Descripcion'];
		}

		$subfamilia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 750 ORDER BY 2")->queryAll();

		$lista_subfamilia = array();
		foreach ($subfamilia as $subfam) {
			$lista_subfamilia[trim($subfam['Id_Criterio'])] = $subfam['Criterio_Descripcion'];
		}

		$sublinea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 800 ORDER BY 2")->queryAll();

		$lista_sublinea = array();
		foreach ($sublinea as $sublin) {
			$lista_sublinea[trim($sublin['Id_Criterio'])] = $sublin['Criterio_Descripcion'];
		}

		$grupo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 850 ORDER BY 2")->queryAll();

		$lista_grupo = array();
		foreach ($grupo as $gr) {
			$lista_grupo[trim($gr['Id_Criterio'])] = $gr['Criterio_Descripcion'];
		}

		$uni_neg = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 900 ORDER BY 2")->queryAll();

		$lista_un = array();
		foreach ($uni_neg as $un) {
			$lista_un[trim($un['Id_Criterio'])] = $un['Criterio_Descripcion'];
		}

		$fabrica = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 920 ORDER BY 2")->queryAll();

		$lista_fabrica = array();
		foreach ($fabrica as $fab) {
			$lista_fabrica[trim($fab['Id_Criterio'])] = $fab['Criterio_Descripcion'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950 ORDER BY 2")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[trim($ora['Id_Criterio'])] = $ora['Criterio_Descripcion'];
		}

		$instalaciones = Yii::app()->db->createCommand("SELECT f157_id, f157_descripcion FROM UnoEE1..t157_mc_instalaciones WHERE f157_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_ins = array();
		foreach ($instalaciones as $ins) {
			$lista_ins[trim($ins['f157_id'])] = $ins['f157_id'].' - '.$ins['f157_descripcion'];
		}

		$bodegas = Yii::app()->db->createCommand("SELECT f150_id, f150_descripcion_corta FROM UnoEE1..t150_mc_bodegas WHERE f150_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_bodegas = array();
		foreach ($bodegas as $bod) {
			$lista_bodegas[trim($bod['f150_id'])] = $bod['f150_id'].' - '.$bod['f150_descripcion_corta'];
		}

		if(isset($_POST['FichaItem']))
		{
			$model->attributes=$_POST['FichaItem'];
			$model->Instalaciones = implode(",", $_POST['FichaItem']['Instalaciones']);
			$model->Bodegas = implode(",", $_POST['FichaItem']['Bodegas']);
			$model->Estado_Solicitud = 1;
			$model->Tipo = 1;
			$model->Id_Usuario_Solicitud = Yii::app()->user->getState('id_user');
			$model->Fecha_Hora_Solicitud = date('Y-m-d H:i:s');
			if($model->Tipo_Producto != 1){
				$model->Ep_Medida = null;
				$model->Ep_Cant = null;
				$model->Ep_Peso = null;
				$model->Ep_Largo = null;
				$model->Ep_Ancho = null;
				$model->Ep_Alto = null;
				$model->Ep_Volumen = null;
				$model->Cad_Medida = null;
				$model->Cad_Cant = null;
				$model->Cad_Peso = null;
				$model->Cad_Largo = null;
				$model->Cad_Ancho = null;
				$model->Cad_Alto = null;
				$model->Cad_Volumen = null;
			}
			if($model->save())	{
				$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'lista_unidad'=>$lista_unidad,
			'lista_origen'=>$lista_origen,
			'lista_tipo'=>$lista_tipo,
			'lista_clasif'=>$lista_clasif,
			'lista_clase'=>$lista_clase,
			'lista_marca'=>$lista_marca,
			'lista_submarca'=>$lista_submarca,
			'lista_segmento'=>$lista_segmento,
			'lista_familia'=>$lista_familia,
			'lista_linea'=>$lista_linea,
			'lista_subfamilia'=>$lista_subfamilia,
			'lista_sublinea'=>$lista_sublinea,
			'lista_grupo'=>$lista_grupo,
			'lista_un'=>$lista_un,
			'lista_fabrica'=>$lista_fabrica,
			'lista_oracle'=>$lista_oracle,
			'lista_ins'=>$lista_ins,
			'lista_bodegas'=>$lista_bodegas,
		));
	}

	public function actionCreate2()
	{
		$model=new FichaItem;
		$model->Scenario = 'create2';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$origen = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100 ORDER BY 2")->queryAll();

		$lista_origen = array();
		foreach ($origen as $ori) {
			$lista_origen[trim($ori['Id_Criterio'])] = $ori['Criterio_Descripcion'];
		}

		$tipo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 200 ORDER BY 2")->queryAll();

		$lista_tipo = array();
		foreach ($tipo as $tip) {
			$lista_tipo[trim($tip['Id_Criterio'])] = $tip['Criterio_Descripcion'];
		}

		$clasif = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 300 ORDER BY 2")->queryAll();

		$lista_clasif = array();
		foreach ($clasif as $clas) {
			$lista_clasif[trim($clas['Id_Criterio'])] = $clas['Criterio_Descripcion'];
		}

		$clase = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 400 ORDER BY 2")->queryAll();

		$lista_clase = array();
		foreach ($clase as $cl) {
			$lista_clase[trim($cl['Id_Criterio'])] = $cl['Criterio_Descripcion'];
		}

		$marca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500 ORDER BY 2")->queryAll();

		$lista_marca = array();
		foreach ($marca as $mar) {
			$lista_marca[trim($mar['Id_Criterio'])] = $mar['Criterio_Descripcion'];
		}

		$submarca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 550 ORDER BY 2")->queryAll();

		$lista_submarca = array();
		foreach ($submarca as $subm) {
			$lista_submarca[trim($subm['Id_Criterio'])] = $subm['Criterio_Descripcion'];
		}

		$segmento = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 600 ORDER BY 2")->queryAll();

		$lista_segmento = array();
		foreach ($segmento as $seg) {
			$lista_segmento[trim($seg['Id_Criterio'])] = $seg['Criterio_Descripcion'];
		}

		$familia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 650 ORDER BY 2")->queryAll();

		$lista_familia = array();
		foreach ($familia as $fam) {
			$lista_familia[trim($fam['Id_Criterio'])] = $fam['Criterio_Descripcion'];
		}

		$linea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700 ORDER BY 2")->queryAll();

		$lista_linea = array();
		foreach ($linea as $lin) {
			$lista_linea[trim($lin['Id_Criterio'])] = $lin['Criterio_Descripcion'];
		}

		$subfamilia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 750 ORDER BY 2")->queryAll();

		$lista_subfamilia = array();
		foreach ($subfamilia as $subfam) {
			$lista_subfamilia[trim($subfam['Id_Criterio'])] = $subfam['Criterio_Descripcion'];
		}

		$sublinea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 800 ORDER BY 2")->queryAll();

		$lista_sublinea = array();
		foreach ($sublinea as $sublin) {
			$lista_sublinea[trim($sublin['Id_Criterio'])] = $sublin['Criterio_Descripcion'];
		}

		$grupo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 850 ORDER BY 2")->queryAll();

		$lista_grupo = array();
		foreach ($grupo as $gr) {
			$lista_grupo[trim($gr['Id_Criterio'])] = $gr['Criterio_Descripcion'];
		}

		$uni_neg = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 900 ORDER BY 2")->queryAll();

		$lista_un = array();
		foreach ($uni_neg as $un) {
			$lista_un[trim($un['Id_Criterio'])] = $un['Criterio_Descripcion'];
		}

		$fabrica = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 920 ORDER BY 2")->queryAll();

		$lista_fabrica = array();
		foreach ($fabrica as $fab) {
			$lista_fabrica[trim($fab['Id_Criterio'])] = $fab['Criterio_Descripcion'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950 ORDER BY 2")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[trim($ora['Id_Criterio'])] = $ora['Criterio_Descripcion'];
		}

		

		if(isset($_POST['FichaItem']))
		{
			$model->attributes=$_POST['FichaItem'];
			$model->Estado_Solicitud = 1;
			$model->Tipo = 2;
			$model->Id_Usuario_Solicitud = Yii::app()->user->getState('id_user');
			$model->Fecha_Hora_Solicitud = date('Y-m-d H:i:s');
			if($model->save())	{
				$this->redirect(array('admin'));
			}
		}

		$this->render('create2',array(
			'model'=>$model,
			'lista_origen'=>$lista_origen,
			'lista_tipo'=>$lista_tipo,
			'lista_clasif'=>$lista_clasif,
			'lista_clase'=>$lista_clase,
			'lista_marca'=>$lista_marca,
			'lista_submarca'=>$lista_submarca,
			'lista_segmento'=>$lista_segmento,
			'lista_familia'=>$lista_familia,
			'lista_linea'=>$lista_linea,
			'lista_subfamilia'=>$lista_subfamilia,
			'lista_sublinea'=>$lista_sublinea,
			'lista_grupo'=>$lista_grupo,
			'lista_un'=>$lista_un,
			'lista_fabrica'=>$lista_fabrica,
			'lista_oracle'=>$lista_oracle,
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
		$model->Scenario = 'update';

		$unidad = Yii::app()->db->createCommand("SELECT f101_id, f101_descripcion FROM UnoEE1..t101_mc_unidades_medida WHERE f101_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_unidad = array();
		foreach ($unidad as $uni) {
			$lista_unidad[trim($uni['f101_id'])] = $uni['f101_id'].' - '.$uni['f101_descripcion'];
		}

		$tipo_inv = Yii::app()->db->createCommand("SELECT f149_id, f149_descripcion FROM UnoEE1..t149_mc_tipo_inv_serv WHERE f149_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_tipo_inv = array();
		foreach ($tipo_inv as $ti_inv) {
			$lista_tipo_inv[trim($ti_inv['f149_id'])] = $ti_inv['f149_descripcion'];
		}

		$grupo_imp = Yii::app()->db->createCommand("SELECT f113_id, f113_descripcion FROM UnoEE1..t113_mc_grupos_impositivos WHERE f113_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_grupo_imp = array();
		foreach ($grupo_imp as $gr_i) {
			$lista_grupo_imp[trim($gr_i['f113_id'])] = $gr_i['f113_descripcion'];
		}

		$origen = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100 ORDER BY 2")->queryAll();

		$lista_origen = array();
		foreach ($origen as $ori) {
			$lista_origen[trim($ori['Id_Criterio'])] = $ori['Criterio_Descripcion'];
		}

		$tipo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 200 ORDER BY 2")->queryAll();

		$lista_tipo = array();
		foreach ($tipo as $tip) {
			$lista_tipo[trim($tip['Id_Criterio'])] = $tip['Criterio_Descripcion'];
		}

		$clasif = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 300 ORDER BY 2")->queryAll();

		$lista_clasif = array();
		foreach ($clasif as $clas) {
			$lista_clasif[trim($clas['Id_Criterio'])] = $clas['Criterio_Descripcion'];
		}

		$clase = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 400 ORDER BY 2")->queryAll();

		$lista_clase = array();
		foreach ($clase as $cl) {
			$lista_clase[trim($cl['Id_Criterio'])] = $cl['Criterio_Descripcion'];
		}

		$marca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500 ORDER BY 2")->queryAll();

		$lista_marca = array();
		foreach ($marca as $mar) {
			$lista_marca[trim($mar['Id_Criterio'])] = $mar['Criterio_Descripcion'];
		}

		$submarca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 550 ORDER BY 2")->queryAll();

		$lista_submarca = array();
		foreach ($submarca as $subm) {
			$lista_submarca[trim($subm['Id_Criterio'])] = $subm['Criterio_Descripcion'];
		}

		$segmento = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 600 ORDER BY 2")->queryAll();

		$lista_segmento = array();
		foreach ($segmento as $seg) {
			$lista_segmento[trim($seg['Id_Criterio'])] = $seg['Criterio_Descripcion'];
		}

		$familia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 650 ORDER BY 2")->queryAll();

		$lista_familia = array();
		foreach ($familia as $fam) {
			$lista_familia[trim($fam['Id_Criterio'])] = $fam['Criterio_Descripcion'];
		}

		$linea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700 ORDER BY 2")->queryAll();

		$lista_linea = array();
		foreach ($linea as $lin) {
			$lista_linea[trim($lin['Id_Criterio'])] = $lin['Criterio_Descripcion'];
		}

		$subfamilia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 750 ORDER BY 2")->queryAll();

		$lista_subfamilia = array();
		foreach ($subfamilia as $subfam) {
			$lista_subfamilia[trim($subfam['Id_Criterio'])] = $subfam['Criterio_Descripcion'];
		}

		$sublinea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 800 ORDER BY 2")->queryAll();

		$lista_sublinea = array();
		foreach ($sublinea as $sublin) {
			$lista_sublinea[trim($sublin['Id_Criterio'])] = $sublin['Criterio_Descripcion'];
		}

		$grupo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 850 ORDER BY 2")->queryAll();

		$lista_grupo = array();
		foreach ($grupo as $gr) {
			$lista_grupo[trim($gr['Id_Criterio'])] = $gr['Criterio_Descripcion'];
		}

		$uni_neg = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 900 ORDER BY 2")->queryAll();

		$lista_un = array();
		foreach ($uni_neg as $un) {
			$lista_un[trim($un['Id_Criterio'])] = $un['Criterio_Descripcion'];
		}

		$fabrica = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 920 ORDER BY 2")->queryAll();

		$lista_fabrica = array();
		foreach ($fabrica as $fab) {
			$lista_fabrica[trim($fab['Id_Criterio'])] = $fab['Criterio_Descripcion'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950 ORDER BY 2")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[trim($ora['Id_Criterio'])] = $ora['Criterio_Descripcion'];
		}

		$instalaciones = Yii::app()->db->createCommand("SELECT f157_id, f157_descripcion FROM UnoEE1..t157_mc_instalaciones WHERE f157_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_ins = array();
		foreach ($instalaciones as $ins) {
			$lista_ins[trim($ins['f157_id'])] = $ins['f157_id'].' - '.$ins['f157_descripcion'];
		}

		$bodegas = Yii::app()->db->createCommand("SELECT f150_id, f150_descripcion_corta FROM UnoEE1..t150_mc_bodegas WHERE f150_id_cia = 2 ORDER BY 2")->queryAll();

		$lista_bodegas = array();
		foreach ($bodegas as $bod) {
			$lista_bodegas[trim($bod['f150_id'])] = $bod['f150_id'].' - '.$bod['f150_descripcion_corta'];
		}

		$array_inst_activas = array();
		//opciones activas en el combo perfiles
		$instalaciones =  explode(",", $model->Instalaciones);
		foreach ($instalaciones as $ins => $id) {
			array_push($array_inst_activas, $id);
		}

		$instalaciones_activas = json_encode($array_inst_activas);

		$array_bod_activas = array();
		//opciones activas en el combo perfiles
		$b =  explode(",", $model->Bodegas);
		foreach ($b as $bo => $id) {
			array_push($array_bod_activas, $id);
		}

		$bodegas_activas = json_encode($array_bod_activas);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FichaItem']))
		{
			$model->attributes=$_POST['FichaItem'];
			$model->Estado_Solicitud = 2;
			$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
			$model->Fecha_Hora_Revision = date('Y-m-d H:i:s');
			if($model->Tipo_Producto != 1){
				$model->Un_Gtin = null;
				$model->Ep_Gtin = null;
				$model->Cad_Gtin = null;
			}
			if($model->save())	{
				$this->redirect(array('rev'));
			}
		}



		$this->render('update',array(
			'model'=>$model,
			'lista_unidad'=>$lista_unidad,
			'lista_tipo_inv'=>$lista_tipo_inv,
			'lista_grupo_imp'=>$lista_grupo_imp,
			'lista_origen'=>$lista_origen,
			'lista_tipo'=>$lista_tipo,
			'lista_clasif'=>$lista_clasif,
			'lista_clase'=>$lista_clase,
			'lista_marca'=>$lista_marca,
			'lista_submarca'=>$lista_submarca,
			'lista_segmento'=>$lista_segmento,
			'lista_familia'=>$lista_familia,
			'lista_linea'=>$lista_linea,
			'lista_subfamilia'=>$lista_subfamilia,
			'lista_sublinea'=>$lista_sublinea,
			'lista_grupo'=>$lista_grupo,
			'lista_un'=>$lista_un,
			'lista_fabrica'=>$lista_fabrica,
			'lista_oracle'=>$lista_oracle,
			'lista_ins'=>$lista_ins,
			'lista_bodegas'=>$lista_bodegas,
			'instalaciones_activas'=>$instalaciones_activas,
			'bodegas_activas'=>$bodegas_activas,
		));
	}

	public function actionUpdate2($id)
	{
		$model=$this->loadModel($id);
		$model->Scenario = 'update';

		$origen = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100 ORDER BY 2")->queryAll();

		$lista_origen = array();
		foreach ($origen as $ori) {
			$lista_origen[trim($ori['Id_Criterio'])] = $ori['Criterio_Descripcion'];
		}

		$tipo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 200 ORDER BY 2")->queryAll();

		$lista_tipo = array();
		foreach ($tipo as $tip) {
			$lista_tipo[trim($tip['Id_Criterio'])] = $tip['Criterio_Descripcion'];
		}

		$clasif = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 300 ORDER BY 2")->queryAll();

		$lista_clasif = array();
		foreach ($clasif as $clas) {
			$lista_clasif[trim($clas['Id_Criterio'])] = $clas['Criterio_Descripcion'];
		}

		$clase = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 400 ORDER BY 2")->queryAll();

		$lista_clase = array();
		foreach ($clase as $cl) {
			$lista_clase[trim($cl['Id_Criterio'])] = $cl['Criterio_Descripcion'];
		}

		$marca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500 ORDER BY 2")->queryAll();

		$lista_marca = array();
		foreach ($marca as $mar) {
			$lista_marca[trim($mar['Id_Criterio'])] = $mar['Criterio_Descripcion'];
		}

		$submarca = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 550 ORDER BY 2")->queryAll();

		$lista_submarca = array();
		foreach ($submarca as $subm) {
			$lista_submarca[trim($subm['Id_Criterio'])] = $subm['Criterio_Descripcion'];
		}

		$segmento = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 600 ORDER BY 2")->queryAll();

		$lista_segmento = array();
		foreach ($segmento as $seg) {
			$lista_segmento[trim($seg['Id_Criterio'])] = $seg['Criterio_Descripcion'];
		}

		$familia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 650 ORDER BY 2")->queryAll();

		$lista_familia = array();
		foreach ($familia as $fam) {
			$lista_familia[trim($fam['Id_Criterio'])] = $fam['Criterio_Descripcion'];
		}

		$linea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700 ORDER BY 2")->queryAll();

		$lista_linea = array();
		foreach ($linea as $lin) {
			$lista_linea[trim($lin['Id_Criterio'])] = $lin['Criterio_Descripcion'];
		}

		$subfamilia = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 750 ORDER BY 2")->queryAll();

		$lista_subfamilia = array();
		foreach ($subfamilia as $subfam) {
			$lista_subfamilia[trim($subfam['Id_Criterio'])] = $subfam['Criterio_Descripcion'];
		}

		$sublinea = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 800 ORDER BY 2")->queryAll();

		$lista_sublinea = array();
		foreach ($sublinea as $sublin) {
			$lista_sublinea[trim($sublin['Id_Criterio'])] = $sublin['Criterio_Descripcion'];
		}

		$grupo = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 850 ORDER BY 2")->queryAll();

		$lista_grupo = array();
		foreach ($grupo as $gr) {
			$lista_grupo[trim($gr['Id_Criterio'])] = $gr['Criterio_Descripcion'];
		}

		$uni_neg = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 900 ORDER BY 2")->queryAll();

		$lista_un = array();
		foreach ($uni_neg as $un) {
			$lista_un[trim($un['Id_Criterio'])] = $un['Criterio_Descripcion'];
		}

		$fabrica = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 920 ORDER BY 2")->queryAll();

		$lista_fabrica = array();
		foreach ($fabrica as $fab) {
			$lista_fabrica[trim($fab['Id_Criterio'])] = $fab['Criterio_Descripcion'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950 ORDER BY 2")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[trim($ora['Id_Criterio'])] = $ora['Criterio_Descripcion'];
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['FichaItem']))
		{
			/*$model->attributes=$_POST['FichaItem'];
			$model->Estado_Solicitud = 2;
			$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
			$model->Fecha_Hora_Revision = date('Y-m-d H:i:s');
			if($model->Tipo_Producto != 1){
				$model->Un_Gtin = null;
				$model->Ep_Gtin = null;
				$model->Cad_Gtin = null;
			}
			if($model->save())	{
				$this->redirect(array('rev'));
			}*/
		}



		$this->render('update2',array(
			'model'=>$model,
			'lista_origen'=>$lista_origen,
			'lista_tipo'=>$lista_tipo,
			'lista_clasif'=>$lista_clasif,
			'lista_clase'=>$lista_clase,
			'lista_marca'=>$lista_marca,
			'lista_submarca'=>$lista_submarca,
			'lista_segmento'=>$lista_segmento,
			'lista_familia'=>$lista_familia,
			'lista_linea'=>$lista_linea,
			'lista_subfamilia'=>$lista_subfamilia,
			'lista_sublinea'=>$lista_sublinea,
			'lista_grupo'=>$lista_grupo,
			'lista_un'=>$lista_un,
			'lista_fabrica'=>$lista_fabrica,
			'lista_oracle'=>$lista_oracle,
		));
	}

	public function actionRechazar($id)
	{
		$model=$this->loadModel($id);
		$model->Scenario = 'rechazo';
		$model->Estado_Solicitud = 0;
		$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
		$model->Fecha_Hora_Revision = date('Y-m-d H:i:s');
		if($model->save())	{
			$this->redirect(array('rev'));
		}
	}

	public function actionAprobar($id)
	{
		$model=$this->loadModel($id);
		$model->Scenario = 'aprobacion';
		$model->Estado_Solicitud = 2;
		$model->Id_Usuario_Revision = Yii::app()->user->getState('id_user');
		$model->Fecha_Hora_Revision = date('Y-m-d H:i:s');
		if($model->save())	{
			$this->redirect(array('rev'));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FichaItem('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FichaItem']))
			$model->attributes=$_GET['FichaItem'];

		$this->render('admin',array(
			'model'=>$model,
			'usuarios'=>$usuarios,

		));
	}

	/**
	 * Manages all models.
	 */
	public function actionRev()
	{
		$model=new FichaItem('search');
		$usuarios=Usuario::model()->findAll(array('order'=>'Usuario'));

		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FichaItem']))
			$model->attributes=$_GET['FichaItem'];

		$this->render('rev',array(
			'model'=>$model,
			'usuarios'=>$usuarios,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FichaItem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FichaItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FichaItem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ficha-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSearchItem(){
		$filtro = $_GET['q'];
        $data = FichaItem::model()->searchByItem($filtro);
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

	public function actionSearchItemById(){
		$filtro = $_GET['id'];
        $data = FichaItem::model()->searchById($filtro);

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

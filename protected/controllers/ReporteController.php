<?php

class ReporteController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */


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

	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform actions
				'actions'=>array('rentmarca','rentmarcaitem','rentcliente','nivelserviciomarca','nivelserviciopedidoxmarca','nivelserviciopedidoxev','ventasperiodoprom', 'searchcliente','rentoracle', 'rentoracleitem','rentcriterios','saldocarteraruta','saldocarteravendedor','saldocarteracliente','searchclientecart','logmobile','logmobilepant','saldocarteraco','saldocarteraco999','saldocarteracototal','saldocarteracolitigio','clientexfecha','vendedores','vendedorespant','diferenciasrutas','diferenciasrutaspant','diferenciasun','diferenciasunpant','notascredito','rentitem','registroguia','uploadguia','rentiteml560','histcliente','searchclientecartnit','seguimientodoc','uploadseguimientodoc','saldocliente','cambioasesor','facturacomstar','facturapansell','controlpedidoslinea','controlpedidosmarca','controlpedidosoracle','controlpedidossegmento','controlpedidosorigen','pedidosacumlinea','pedidosacummarca','pedidosacumoracle','listasvs560','itemscostos','pqrsdetalle','docsclientespotenciales','clientescrmsiesa','ventaempleado','analisisxproducto','nivelserviciolinea','recaudosvendedor','cobroprejuridico','actualizaciondatos','controlpedidoslinealista','controlpedidosmarcalista','rentinvmarca','rentinvlinea','rentinvoracle','notasdevolucion','notasanulacion','cruceantcli','crucenotcon','errorept','erroreptpant','errortal','errortalpant','errorconectores','errorconectorespant','pedidospenddesreqmarca','docsasesor','pedidospenddesreqlinea','rentxcliente','acttal','acttalpant','actualizartal','rentxcliente560','rentmarcap','rentmarcae','invperu','invperupant','invecuador','invecuadorpant','invcosperu','invcosperupant','invcosecuador','invcosecuadorpant','rentinvmarcap','rentinvmarcae','pedidospenddesmarcap','pedidospenddesmarcae','pedidosacummarcap','pedidosacummarcae','rentmarcaiteml560','listamateriales','listamaterialesdet','listamaterialespant','searchitem','searchitembyid','crucenotcar','actualizaciondatossaldo','revisioncomercial','rentxestructura560','uncomercial','clientespot', 'loadcriterios', 'getopcionplan', 'indpqrs','actept','acteptpant','actualizarbod','logisticaexterior', 'naf','saldocarteraev','fleteguia','uploadfleteguia','cambiofecpedxml','actreca','actrecapant','actualizarreca','consultapagos','consultapagospant','elimrecibo','pedidosacumlineatot','auditoriapedidos','auditoriapedidospant','listap','venposfalt','venposfaltpant','venposentr','venposentrpant','costoxitempos','facturaproforma','elimpedido','fotocart','recxwebservice','facturatitan','rentcriterios560','feeterpeldet','feeterpelcons','cuadrocompraspt','histlibped','itemsexentosiva','descb2b', 'logisticacomercialxora','logisticacomercialxun','analisisventas','pedidospenddesreqtop','estadoitems','uploadestadoitems','consultafactelect','consultafactelectpant','cuadrocomprasmp','pagostiendabinner','uploadpagostiendabinner','printcheq','existcheq','regimpcheq','rprintcheq','verifcheq','regrimpcheq','ingresoswebbinner','uploadingresoswebbinner','facttiendasweb','desptiendasweb','facturapos','confirmacionpagos','uploadconfirmacionpagos','dettranstiendasweb','uploaddettranstiendasweb', 'remisiontugo','elimerrortrans','errortransf','errortransfpant','logcrossdocking','cuadrocompraspt2','pedidosretenidos','seguimientorutas','calidadpqrs','consolidadoun','segrutasmarcacoord','compinc','compincpant'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionRentMarca()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_marca';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('rent_marca_resp',array('model' => $model));	
		}

		$this->render('rent_marca',array(
			'model'=>$model,		
		));
	}

	public function actionRentMarcaItem()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_marca_item';

		$m_marcas=Marca::model()->findAll(array('order'=>'M_Descripcion'));

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('rent_marca_item_resp',array('model' => $model));	
		}

		$this->render('rent_marca_item',array(
			'model'=>$model,
			'marcas'=>$m_marcas,
		));
	}

	public function actionRentCliente()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_cliente';


		$clases = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->clases." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_clases = array();
		foreach ($clases as $cla) {
			$lista_clases[$cla['Id_Criterio']] = $cla['Criterio_Descripcion'];
		}

		$canales = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->canales." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_canales = array();
		foreach ($canales as $can) {
			$lista_canales[$can['Id_Criterio']] = $can['Criterio_Descripcion'];
		}

		$evs = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->evs." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_evs = array();
		foreach ($evs as $ev) {
			$lista_evs[$ev['Id_Criterio']] = $ev['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_cliente_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_cliente',array(
			'model'=>$model,
			//'clases'=>$m_clases,
			'lista_clases'=>$lista_clases,
			'lista_canales'=>$lista_canales,
			'lista_evs'=>$lista_evs,
		));
	}

	public function actionNivelServicioMarca()
	{		
		$model=new Reporte;
		$model->scenario = 'nivel_servicio_marca';

		$m_marcas=Marca::model()->findAll(array('order'=>'M_Descripcion'));

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('nivel_servicio_marca_resp',array('model' => $model));	
		}

		$this->render('nivel_servicio_marca',array(
			'model'=>$model,
			'marcas'=>$m_marcas,
		));
	}

	public function actionNivelServicioPedidoXmarca()
	{		
		$model=new Reporte;
		$model->scenario = 'nivel_servicio_pedido_x_marca';

		$m_marcas=Marca::model()->findAll(array('order'=>'M_Descripcion'));

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('nivel_servicio_pedido_x_marca_resp',array('model' => $model));	
		}

		$this->render('nivel_servicio_pedido_x_marca',array(
			'model'=>$model,
			'marcas'=>$m_marcas,
		));
	}

	public function actionNivelServicioPedidoXev()
	{		
		$model=new Reporte;
		$model->scenario = 'nivel_servicio_pedido_x_ev';

		$model_ev = Yii::app()->db->createCommand("SELECT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan=300 Order by Criterio_Descripcion")->queryAll();

		$lista_ev = array();
		foreach ($model_ev as $m_ev) {
			$lista_ev[$m_ev['Criterio_Descripcion']] = $m_ev['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('nivel_servicio_pedido_x_ev_resp',array('model' => $model));	
		}

		$this->render('nivel_servicio_pedido_x_ev',array(
			'model'=>$model,
			'lista_ev'=>$lista_ev,
		));
	}

	public function actionVentasPeriodoProm()
	{		
		$model=new Reporte;
		$model->scenario = 'ventas_periodo_prom';

		$m_marcas=Marca::model()->findAll(array('order'=>'M_Descripcion'));

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('ventas_periodo_prom_resp',array('model' => $model));	
		}

		$this->render('ventas_periodo_prom',array(
			'model'=>$model,
			'marcas'=>$m_marcas,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param Menu $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reporte-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSearchCliente(){
		$filtro = $_GET['q'];
        $data = Cliente::model()->searchByCliente($filtro);
        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['C_ROWID_CLIENTE'],
               'text' => $item['C_NIT_CLIENTE'].' - '.$item['C_NOMBRE_CLIENTE'],
           );
        endforeach;
        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}

	public function actionRentOracle()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_oracle';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('rent_oracle_resp',array('model' => $model));	
		}

		$this->render('rent_oracle',array(
			'model'=>$model,		
		));
	}	

 	public function actionRentOracleItem()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_oracle_item';

		$oracle = Yii::app()->db->createCommand("SELECT M_Rowid, M_Descripcion FROM TH_ORACLE ORDER BY M_Descripcion")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $lorac) {
			$lista_oracle[$lorac['M_Descripcion']] = $lorac['M_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('rent_oracle_item_resp',array('model' => $model));	
		}

		$this->render('rent_oracle_item',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,		
		));
	}

	public function actionRentCriterios()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_criterios';

		$clases = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->clases." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_clases = array();
		foreach ($clases as $cla) {
			$lista_clases[$cla['Id_Criterio']] = $cla['Criterio_Descripcion'];
		}

		$canales = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->canales." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_canales = array();
		foreach ($canales as $can) {
			$lista_canales[$can['Id_Criterio']] = $can['Criterio_Descripcion'];
		}

		$regionales = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->regionales." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_regionales = array();
		foreach ($regionales as $re) {
			$lista_regionales[$re['Id_Criterio']] = $re['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_criterios_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_criterios',array(
			'model'=>$model,
			'lista_clases'=>$lista_clases,
			'lista_canales'=>$lista_canales,
			'lista_regionales'=>$lista_regionales,
		));
	}

	public function actionSaldoCarteraRuta()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_ruta';

		$rutas = Yii::app()->db->createCommand("SELECT DISTINCT f5790_id AS Id, f5790_descripcion as Ruta FROM UnoEE1..t5790_sm_ruta WHERE f5790_estado = 1 ")->queryAll();

		$lista_rutas = array();
		foreach ($rutas as $ru) {
			$lista_rutas[$ru['Id']] = $ru['Ruta'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('saldo_cartera_ruta_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('saldo_cartera_ruta',array(
			'model'=>$model,
			'lista_rutas'=>$lista_rutas,
		));
	}

	public function actionSaldoCarteraVendedor()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_vendedor';

		$vendedores = Yii::app()->db->createCommand("SELECT distinct t2001.f200_razon_social as Nombre_Vendedor FROM UnoEE1.dbo.t210_mm_vendedores WITH (NOLOCK) inner join UnoEE1.dbo.t200_mm_terceros as t2001 WITH (NOLOCK) ON t2001.f200_rowid = [f210_rowid_tercero] where [f210_id_cia] = 2")->queryAll();
 
		$lista_vendedores = array();
		foreach ($vendedores as $vend) {
			$lista_vendedores[$vend['Nombre_Vendedor']] = $vend['Nombre_Vendedor'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('saldo_cartera_vendedor_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('saldo_cartera_vendedor',array(
			'model'=>$model,
			'lista_vendedores'=>$lista_vendedores,
		));
	}

	public function actionSaldoCarteraCliente()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_cliente';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('saldo_cartera_cliente_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('saldo_cartera_cliente',array(
			'model'=>$model,
		));
	}

	public function actionSearchClienteCart(){
		$filtro = $_GET['q'];
        $data = Cliente::model()->searchByClienteCart($filtro);
        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['CLIENTE'],
               'text' => $item['CLIENTE'],
           );
        endforeach;
        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}

 	public function actionSearchClienteCartNit(){
		$filtro = $_GET['q'];
        $data = Cliente::model()->searchByClienteCartNit($filtro);
        $result = array();
        foreach($data as $item):
           $result[] = array(
               'id'   => $item['NIT'],
               'text' => $item['NIT'].' - '.$item['CLIENTE'],
           );
        endforeach;
        header('Content-type: application/json');
        echo CJSON::encode( $result );
        Yii::app()->end(); 
 	}

 	public function actionLogMobile()
	{		
		$model=new Reporte;
		$model->scenario = 'log_mobile';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('log_mobile_resp',array('model' => $model));	
		}

		$this->render('log_mobile',array(
			'model'=>$model,
		));
	}

	public function actionLogMobilePant()
	{		
		$fecha_inicial = $_POST['fecha_inicial'];
		$fecha_final = $_POST['fecha_final'];

		$resultados = UtilidadesReportes::logmobilepantalla($fecha_inicial, $fecha_final);

		echo $resultados;
	}

	public function actionSaldoCarteraCo()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_co';

		$cos = Yii::app()->db->createCommand("SELECT DISTINCT f285_id, f285_descripcion FROM UnoEE1..t285_co_centro_op WHERE f285_id_cia = 2")->queryAll();

		$lista_co = array();
		foreach ($cos as $co) {
			$lista_co[$co['f285_id']] = $co['f285_descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('saldo_cartera_co_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('saldo_cartera_co',array(
			'model'=>$model,
			'lista_co'=>$lista_co,
		));
	}

	public function actionSaldoCarteraCo999()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_co_999';

		$this->renderPartial('saldo_cartera_co_999_resp');
	}

	public function actionSaldoCarteraCoTotal()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_co_total';

		$this->renderPartial('saldo_cartera_co_total_resp');
	}

	public function actionSaldoCarteraCoLitigio()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_co_litigio';

		$this->renderPartial('saldo_cartera_co_litigio_resp');
	}

	public function actionClientexFecha()
	{		
		$model=new Reporte;
		$model->scenario = 'cliente_x_fecha';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('cliente_x_fecha_resp',array('model' => $model));	
		}

		$this->render('cliente_x_fecha',array(
			'model'=>$model,
		));
	}

	public function actionVendedores()
	{		
		$model=new Reporte;
		$model->scenario = 'vendedores';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('vendedores_resp');	
		}

		$this->render('vendedores',array(
			'model'=>$model,
		));
	}

	public function actionVendedoresPant()
	{		

		$resultados = UtilidadesReportes::vendedorespantalla();

		echo $resultados;
	}

	public function actionDiferenciasRutas()
	{		
		$model=new Reporte;
		$model->scenario = 'diferencias_rutas';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('diferencias_rutas_resp');	
		}

		$this->render('diferencias_rutas',array(
			'model'=>$model,
		));
	}

	public function actionDiferenciasRutasPant()
	{		

		$resultados = UtilidadesReportes::diferenciasrutaspantalla();

		echo $resultados;
	}

	public function actionDiferenciasUn()
	{		
		$model=new Reporte;
		$model->scenario = 'diferencias_un';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('diferencias_un_resp');	
		}

		$this->render('diferencias_un',array(
			'model'=>$model,
		));
	}

	public function actionDiferenciasUnPant()
	{		

		$resultados = UtilidadesReportes::diferenciasunpantalla();

		echo $resultados;
	}

	public function actionNotasCredito()
	{		
		$model=new Reporte;
		$model->scenario = 'notas_credito';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('notas_credito_resp',array('model' => $model));	
		}

		$this->render('notas_credito',array(
			'model'=>$model,
		));
	}

	public function actionRentItem()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_item';

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[$ora['Id_Criterio']] = $ora['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_item_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_item',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,
		));
	}

	public function actionRegistroGuia()
	{		
		$model=new Reporte;

		$this->render('registro_guia',array(
			'model'=>$model,
		));
	}

	public function actionUploadGuia()
	{		
		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

        // Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));   

		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php';

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
        $objPHPExcel->setActiveSheetIndex(0);

        //Convierto la data de la Hoja en un arreglo
        $dataExcel = $objPHPExcel->getActiveSheet()->toArray();

        $filas = count($dataExcel);

        $cont = 0;

        if($filas < 2){

        	$opc = 0;
        	$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5> El archivo esta vacio.';

        }else{

    		$opc = 1;
    	
    		//se ejecuta el sp por cada fila en el archivo

    		$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5>';

    		for($i = 1; $i <= $filas -1 ; $i++){
        		$param1 = $dataExcel[$i][0];
        		$param2 = $dataExcel[$i][1];
        		$param3 = $dataExcel[$i][2];
        		$param4 = $dataExcel[$i][3];
        		$param5 = $dataExcel[$i][4];
        		$param6 = $dataExcel[$i][5];
        		$param7 = $dataExcel[$i][6];
        		$param8 = $dataExcel[$i][7];
        		$param9 = $dataExcel[$i][8];

        		if($param1 == '' || $param2 == '' || $param3 == '' || $param4 == '' || $param5 == '' || $param6 == '' || $param7 == '' || $param8 == '' || $param9 == ''){
    				$fila_error = $i + 1;
        			$msj .= 'Error en la fila # '.$fila_error.', hay columnas vacias.<br>'; 
        			$valid = 0;
        		}else{

        			//se valida si el documento existe

        			$co    = $param1;
					$td    = $param2;
					$cons  = $param3;

        			$query_exist_doc = "SELECT DISTINCT f350_rowid FROM [UnoEE1].[dbo].t350_co_docto_contable WHERE f350_id_co = '".$co."' AND f350_id_tipo_docto = '".$td."' AND f350_consec_docto = ".$cons."";

    				$row_exist_doc =  Yii::app()->db->createCommand($query_exist_doc)->queryRow();

					$doc = $row_exist_doc['f350_rowid'];

					if(is_null($doc)){
						$fila_error = $i + 1;
						$msj .= 'Error en la fila # '.$fila_error.', el documento no existe.<br>'; 
					}else{

						//se valida si el documento tiene ruta asignada

						$co    = $param1;
						$td    = $param2;
						$cons  = $param3;

						$query_exist_guia = "SELECT DISTINCT f462_id_vehiculo FROM [UnoEE1].[dbo].t350_co_docto_contable INNER JOIN [UnoEE1].[dbo].[t462_cm_docto_transportador] ON f462_rowid_docto = f350_rowid WHERE f350_id_co = '".$co."' AND f350_id_tipo_docto = '".$td."' AND f350_consec_docto = ".$cons."";
						
						$row_exist_guia =  Yii::app()->db->createCommand($query_exist_guia)->queryRow();

						$GUIA = $row_exist_guia['f462_id_vehiculo'];

						if(!is_null($GUIA)){
							$fila_error = $i + 1;
							$msj .= 'Error en la fila # '.$fila_error.', el documento ya tiene guía asignada.<br>'; 
						}else{

							//se valida si la placa a asignar existe
							$placa = $param4;

							$query_placa = "SELECT f163_id FROM [UnoEE1].[dbo].[t163_mc_vehiculos] WHERE f163_id_cia = 2 AND LTRIM(RTRIM([f163_id])) = '".$placa."'";
							$row_placa =  Yii::app()->db->createCommand($query_placa)->queryRow();

							$placa = $row_placa['f163_id'];

							if(is_null($placa)){
								$fila_error = $i + 1;
								$msj .= 'Error en la fila # '.$fila_error.', la placa no existe.<br>'; 
							}else{

							 	$connection = Yii::app()->db;
								$command = $connection->createCommand("
									EXEC [dbo].[CONF_GUIA_DESPACHO]
									@CO = N'".$param1."',
									@DOCTO = N'".$param2."',
									@CONSECUTIVO = N'".$param3."',
									@PLACA = N'".$param4."',
									@CONDUCTOR = N'".$param5."',
									@NIT_CONDUCTOR = N'".$param6."',
									@GUIA = N'".$param7."',
									@NOTAS = N'".$param8."',
									@VLR_FLETE = N'".$param9."'
								");

								$command->execute();

								$cont = $cont + 1;

							}	
						}
					}
        		}		        		
        	}
        }

        $f = $filas -1;

        if($f == $cont && $opc == 1){
        	$msj .= $f.' Registro(s) ejecutado(s) correctamente.<br>'; 	
        }

        $resp = array('opc' => $opc, 'msj' => $msj);

        echo json_encode($resp);
	}

	public function actionRentItemL560()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_item_l560';

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[$ora['Id_Criterio']] = $ora['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_item_l560_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_item_l560',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,
		));
	}

	public function actionHistCliente()
	{		
		$model=new Reporte;
		$model->scenario = 'hist_cliente';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('hist_cliente_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('hist_cliente',array(
			'model'=>$model,
		));
	}

	public function actionSeguimientoDoc()
	{		
		$model=new Reporte;

		$this->render('seguimiento_doc',array(
			'model'=>$model,
		));
	}

	public function actionUploadSeguimientoDoc()
	{		
		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

        // Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));   

		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php';

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
        $objPHPExcel->setActiveSheetIndex(0);

        //Convierto la data de la Hoja en un arreglo
        $dataExcel = $objPHPExcel->getActiveSheet()->toArray();
        $filas = count($dataExcel);

        $cont = 0;

        if($filas < 2){

        	$opc = 0;
        	$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5> El archivo esta vacio.';

        }else{

    		$opc = 1;
    	
    		//se ejecuta el sp por cada fila en el archivo

    		$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5>';

    		for($i = 1; $i <= $filas -1 ; $i++){
        		$param1 = $dataExcel[$i][0];
        		$param2 = $dataExcel[$i][1];
        		$param3 = $dataExcel[$i][2];
        		$param4 = $dataExcel[$i][3];
        		$param5 = $dataExcel[$i][4];

        		if($param1 == '' || $param2 == '' || $param3 == '' || $param4 == '' || $param5 == ''){
    				$fila_error = $i + 1;
        			$msj .= 'Error en la fila # '.$fila_error.', hay columnas vacias.<br>'; 
        			$valid = 0;
        		}else{

        			//se valida si el documento existe

        			$co    = $param1;
					$td    = $param2;
					$cons  = $param3;

        			$query_exist_doc = "SELECT DISTINCT f350_rowid FROM [UnoEE1].[dbo].t350_co_docto_contable WHERE f350_id_co = '".$co."' AND f350_id_tipo_docto = '".$td."' AND f350_consec_docto = ".$cons."";

    				$row_exist_doc =  Yii::app()->db->createCommand($query_exist_doc)->queryRow();

					$doc = $row_exist_doc['f350_rowid'];

					if(is_null($doc)){
						$fila_error = $i + 1;
						$msj .= 'Error en la fila # '.$fila_error.', el documento no existe.<br>'; 
					}else{

					 	$connection = Yii::app()->db;
						$command = $connection->createCommand("
							EXEC [dbo].[CONF_SEG_DESPACHO]
							@CO = N'".$param1."',
							@DOCTO = N'".$param2."',
							@CONSECUTIVO = N'".$param3."',
							@NOTAS = N'".$param4."',
							@FECHA = N'".$param5."'
						");
						$command->execute();
						
						$cont = $cont + 1;
							
					}
        		}		        		
        	}
        }

        $f = $filas -1;

        if($f == $cont && $opc == 1){
        	$msj .= $f.' Registro(s) ejecutado(s) correctamente.<br>'; 	
        }

        $resp = array('opc' => $opc, 'msj' => $msj);

        echo json_encode($resp);
	}

	public function actionSaldoCliente()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cliente';

		$rutas = Yii::app()->db->createCommand("SELECT DISTINCT f5790_id AS Id, f5790_descripcion as Ruta FROM UnoEE1..t5790_sm_ruta WHERE f5790_estado = 1 ")->queryAll();

		$lista_rutas = array();
		foreach ($rutas as $ru) {
			$lista_rutas[$ru['Id']] = $ru['Ruta'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('saldo_cliente_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('saldo_cliente',array(
			'model'=>$model,
			'lista_rutas'=>$lista_rutas,
		));
	}

	public function actionCambioAsesor()
	{		
		$model=new Reporte;
		$model->scenario = 'cambio_asesor';

		$rutas = Yii::app()->db->createCommand("SELECT DISTINCT f5790_id AS Id, f5790_descripcion as Ruta FROM UnoEE1..t5790_sm_ruta WHERE f5790_estado = 1 ")->queryAll();

		$lista_rutas = array();
		foreach ($rutas as $ru) {
			$lista_rutas[$ru['Id']] = $ru['Ruta'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('cambio_asesor_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('cambio_asesor',array(
			'model'=>$model,
			'lista_rutas'=>$lista_rutas,
		));
	}

	public function actionFacturaComstar()
	{		
		$model=new Reporte;
		$model->scenario = 'factura_comstar';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('factura_comstar_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('factura_comstar',array(
			'model'=>$model,
		));
	}

	public function actionFacturaPansell()
	{		
		$model=new Reporte;
		$model->scenario = 'factura_pansell';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('factura_pansell_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('factura_pansell',array(
			'model'=>$model,
		));
	}

	public function actionControlPedidosLinea()
	{		
		$model=new Reporte;
		$model->scenario = 'control_pedidos_linea';

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('control_pedidos_linea_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('control_pedidos_linea',array(
			'model'=>$model,
			'lista_lineas'=>$lista_lineas,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionControlPedidosMarca()
	{		
		$model=new Reporte;
		$model->scenario = 'control_pedidos_marca';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('control_pedidos_marca_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('control_pedidos_marca',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionControlPedidosOracle()
	{		
		$model=new Reporte;
		$model->scenario = 'control_pedidos_oracle';

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $or) {
			$lista_oracle[$or['DESCRIPCION']] = $or['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('control_pedidos_oracle_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('control_pedidos_oracle',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionControlPedidosSegmento()
	{		
		$model=new Reporte;
		$model->scenario = 'control_pedidos_segmento';

		$segmentos = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=600")->queryAll();

		$lista_segmentos = array();
		foreach ($segmentos as $se) {
			$lista_segmentos[$se['DESCRIPCION']] = $se['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('control_pedidos_segmento_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('control_pedidos_segmento',array(
			'model'=>$model,
			'lista_segmentos'=>$lista_segmentos,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}
	

	public function actionControlPedidosOrigen()
	{		
		$model=new Reporte;
		$model->scenario = 'control_pedidos_origen';

		$origenes = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS ORIGEN FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100")->queryAll();

		$lista_origenes = array();
		foreach ($origenes as $or) {
			$lista_origenes[$or['ORIGEN']] = $or['ORIGEN'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('control_pedidos_origen_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('control_pedidos_origen',array(
			'model'=>$model,
			'lista_origenes'=>$lista_origenes,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionPedidosAcumLinea()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_acum_linea';

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('pedidos_acum_linea_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('pedidos_acum_linea',array(
			'model'=>$model,
			'lista_lineas'=>$lista_lineas,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionPedidosAcumMarca()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_acum_marca';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('pedidos_acum_marca_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('pedidos_acum_marca',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionPedidosAcumOracle()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_acum_oracle';

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM portal_reportes..TH_CRITERIOS_ITEMS WHERE Id_Plan=950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $or) {
			$lista_oracle[$or['DESCRIPCION']] = $or['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('pedidos_acum_oracle_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('pedidos_acum_oracle',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionListasVs560()
	{		
		$model=new Reporte;
		$model->scenario = 'listas_vs_560';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$listas = Yii::app()->db->createCommand("SELECT DISTINCT f112_id AS LISTA, f112_descripcion AS DESCRIPCION FROM UnoEE1.dbo.t112_mc_listas_precios WHERE f112_id_cia = '2' and f112_id_moneda = 'COP' AND f112_id <> '560' ORDER BY 2")->queryAll();

		$lista_l = array();
		foreach ($listas as $li) {
			$lista_l[$li['LISTA']] = $li['LISTA'].' - '.$li['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('listas_vs_560_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('listas_vs_560',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_estados'=>$lista_estados,
			'lista_l'=>$lista_l,
		));
	}

	public function actionItemsCostos()
	{		
		$model=new Reporte;
		$model->scenario = 'items_costos';

		$clases = Yii::app()->db->createCommand("SELECT DISTINCT I_CRI_CLASE FROM TH_ITEMS")->queryAll();

		$lista_clases = array();
		foreach ($clases as $cl) {
			$lista_clases[$cl['I_CRI_CLASE']] = $cl['I_CRI_CLASE'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = ".Yii::app()->params->oracle." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $oracle) {
			$lista_oracle[$oracle['Id_Criterio']] = $oracle['Criterio_Descripcion'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('items_costos_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('items_costos',array(
			'model'=>$model,
			'lista_clases'=>$lista_clases,
			'lista_oracle'=>$lista_oracle,
			'lista_estados'=>$lista_estados,
		));
	}

	public function actionPqrsDetalle()
	{		
		$model=new Reporte;
		$model->scenario = 'pqrs_detalle';

		$this->renderPartial('pqrs_detalle_resp');
	}

	public function actionDocsClientesPotenciales()
	{		
		$model=new Reporte;
		$model->scenario = 'docs_clientes_potenciales';

		$this->renderPartial('docs_clientes_potenciales_resp');
	}

	public function actionClientesCrmSiesa()
	{		
		$model=new Reporte;
		$model->scenario = 'clientes_crm_siesa';

		$this->renderPartial('clientes_crm_siesa_resp');
	}

	public function actionVentaEmpleado()
	{		
		$model=new Reporte;
		$model->scenario = 'venta_empleado';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('venta_empleado_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('venta_empleado',array(
			'model'=>$model,
		));
	}

	public function actionAnalisisXProducto()
	{		
		$model=new Reporte;
		$model->scenario = 'analisis_x_producto';

		$this->renderPartial('analisis_x_producto_resp');
	}

	public function actionNivelServicioLinea()
	{		
		$model=new Reporte;
		$model->scenario = 'nivel_servicio_linea';

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=700 ORDER BY 1")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('nivel_servicio_linea_resp',array('model' => $model));	
		}

		$this->render('nivel_servicio_linea',array(
			'model'=>$model,
			'lista_lineas'=>$lista_lineas,
		));
	}

	public function actionRecaudosVendedor()
	{		
		$model=new Reporte;
		$model->scenario = 'recaudos_vendedor';

		$vendedores = Yii::app()->db->createCommand("SELECT distinct t2001.f200_razon_social as Nombre_Vendedor FROM UnoEE1.dbo.t210_mm_vendedores WITH (NOLOCK) inner join UnoEE1.dbo.t200_mm_terceros as t2001 WITH (NOLOCK) ON t2001.f200_rowid = [f210_rowid_tercero] where [f210_id_cia] = 2")->queryAll();
 
		$lista_vendedores = array();
		foreach ($vendedores as $vend) {
			$lista_vendedores[$vend['Nombre_Vendedor']] = $vend['Nombre_Vendedor'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('recaudos_vendedor_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('recaudos_vendedor',array(
			'model'=>$model,
			'lista_vendedores'=>$lista_vendedores,
		));
	}

	public function actionCobroPrejuridico()
	{		
		$model=new Reporte;
		$model->scenario = 'cobro_prejuridico';

		$rutas = Yii::app()->db->createCommand("SELECT DISTINCT f5790_id AS Id, f5790_descripcion as Ruta FROM UnoEE1..t5790_sm_ruta WHERE f5790_estado = 1 ")->queryAll();

		$lista_rutas = array();
		foreach ($rutas as $ru) {
			$lista_rutas[$ru['Id']] = $ru['Ruta'];
		}

		$lista_estados = array(0 => 'INACTIVOS', 1 => 'ACTIVOS');

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('cobro_prejuridico_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('cobro_prejuridico',array(
			'model'=>$model,
			'lista_rutas'=>$lista_rutas,
			'lista_estados'=>$lista_estados,
		));
	}

	public function actionActualizacionDatos()
	{		
		$model=new Reporte;
		$model->scenario = 'actualizacion_datos';

		$rutas = Yii::app()->db->createCommand("SELECT DISTINCT f5790_id AS Id, f5790_descripcion as Ruta FROM UnoEE1..t5790_sm_ruta WHERE f5790_estado = 1 ")->queryAll();

		$lista_rutas = array();
		foreach ($rutas as $ru) {
			$lista_rutas[$ru['Id']] = $ru['Ruta'];
		}

		$lista_estados = array(0 => 'INACTIVOS', 1 => 'ACTIVOS');

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('actualizacion_datos_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('actualizacion_datos',array(
			'model'=>$model,
			'lista_rutas'=>$lista_rutas,
			'lista_estados'=>$lista_estados,
		));
	}

	public function actionControlPedidosLineaLista()
	{		
		$model=new Reporte;
		$model->scenario = 'control_pedidos_linea_lista';

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('control_pedidos_linea_lista_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('control_pedidos_linea_lista',array(
			'model'=>$model,
			'lista_lineas'=>$lista_lineas,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionControlPedidosMarcaLista()
	{		
		$model=new Reporte;
		$model->scenario = 'control_pedidos_marca_lista';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('control_pedidos_marca_lista_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('control_pedidos_marca_lista',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionRentInvMarca()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_inv_marca';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_inv_marca_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_inv_marca',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
		));
	}

	public function actionRentInvLinea()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_inv_linea';

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_inv_linea_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_inv_linea',array(
			'model'=>$model,
			'lista_lineas'=>$lista_lineas,
		));
	}

	public function actionRentInvOracle()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_inv_oracle';

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $or) {
			$lista_oracle[$or['DESCRIPCION']] = $or['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_inv_oracle_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_inv_oracle',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,
		));
	}

	public function actionNotasDevolucion()
	{		
		$model=new Reporte;
		$model->scenario = 'notas_devolucion';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('notas_devolucion_resp',array('model' => $model));	
		}

		$this->render('notas_devolucion',array(
			'model'=>$model,
		));
	}

	public function actionNotasAnulacion()
	{		
		$model=new Reporte;
		$model->scenario = 'notas_anulacion';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('notas_anulacion_resp',array('model' => $model));	
		}

		$this->render('notas_anulacion',array(
			'model'=>$model,
		));
	}

	public function actionCruceAntCli()
	{		
		$model=new Reporte;
		$model->scenario = 'cruce_ant_cli';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('cruce_ant_cli_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('cruce_ant_cli',array(
			'model'=>$model,
		));
	}

	public function actionCruceNotCon()
	{		
		$model=new Reporte;
		$model->scenario = 'cruce_not_con';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('cruce_not_con_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('cruce_not_con',array(
			'model'=>$model,
		));
	}

	public function actionErrorEpt()
	{		
		$model=new Reporte;
		$model->scenario = 'error_ept';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('error_ept_resp',array('model' => $model));	
		}

		$this->render('error_ept',array(
			'model'=>$model,
		));
	}

	public function actionErrorEptPant()
	{		
		$resultados = UtilidadesReportes::erroreptpantalla();
		echo $resultados;
	}

	public function actionErrorTal()
	{		
		$model=new Reporte;
		$model->scenario = 'error_tal';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('error_tal_resp',array('model' => $model));	
		}

		$this->render('error_tal',array(
			'model'=>$model,
		));
	}

	public function actionErrorTalPant()
	{		
		$resultados = UtilidadesReportes::errortalpantalla();
		echo $resultados;
	}

	public function actionErrorConectores()
	{		
		$model=new Reporte;
		$model->scenario = 'error_conectores';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('error_conectores_resp',array('model' => $model));	
		}

		$this->render('error_conectores',array(
			'model'=>$model,
		));
	}

	public function actionErrorConectoresPant()
	{		
		$fecha = $_POST['fecha'];

		$resultados = UtilidadesReportes::errorconectorespantalla($fecha);

		echo $resultados;
	}

	public function actionPedidosPendDesReqMarca()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_pend_des_req_marca';

		$m_marcas=Marca::model()->findAll(array('order'=>'M_Descripcion'));

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('pedidos_pend_des_req_marca_resp',array('model' => $model));	
		}

		$this->render('pedidos_pend_des_req_marca',array(
			'model'=>$model,
			'marcas'=>$m_marcas,
		));
	}

	public function actionDocsAsesor()
	{		
		$model=new Reporte;
		$model->scenario = 'docs_asesor';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('docs_asesor_resp',array('model' => $model));	
		}

		$this->render('docs_asesor',array(
			'model'=>$model,
		));
	}

	public function actionPedidosPendDesReqLinea()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_pend_des_req_linea';

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=700 ORDER BY 1")->queryAll();

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('pedidos_pend_des_req_linea_resp',array('model' => $model));	
		}

		$this->render('pedidos_pend_des_req_linea',array(
			'model'=>$model,
			'lineas'=>$lineas,
		));
	}

	public function actionRentxCliente()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_x_cliente';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('rent_x_cliente_resp',array('model' => $model));	
		}

		$this->render('rent_x_cliente',array(
			'model'=>$model,
		));
	}

	public function actionActTal()
	{		
		$model=new Reporte;

		$this->render('act_tal',array(
			'model'=>$model,
		));
	}

	public function actionActTalPant()
	{		
		$resultados = UtilidadesReportes::acttalpantalla();
		echo $resultados;
	}

	public function actionActualizarTal()
	{		
		$tal = $_POST['tal'];

		$command = Yii::app()->db2->createCommand();

		$sql='UPDATE tbl_IN_Almacen_12 SET Integrado_Pangea = :int_pangea WHERE Rowid = :tal';
		$params = array(
		    "int_pangea" => 0,
		    "tal" => $tal
		);
		$command->setText($sql)->execute($params);

		Yii::app()->user->setFlash('success',"La TAL ".$tal." se actualizo correctamente.");
		echo 1;

	}

	public function actionActualizarBod()
	{		
		$tal = $_POST['tal'];

		$command = Yii::app()->db2->createCommand();

		$sql="UPDATE tbl_IN_Almacen_12 SET Bod_Salida = 'BDPOP' WHERE Rowid = :tal";
		$params = array(
		    "tal" => $tal
		);
		$command->setText($sql)->execute($params);

		Yii::app()->user->setFlash('success',"La bodega de salida de la TAL ".$tal." se actualizo correctamente.");
		echo 1;

	}

	public function actionRentxCliente560()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_x_cliente_560';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('rent_x_cliente_560_resp',array('model' => $model));	
		}

		$this->render('rent_x_cliente_560',array(
			'model'=>$model,
		));
	}


	/*INICIO rent. marca ecuador / peru*/

	public function actionRentMarcaP()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_marca_p';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('rent_marca_peru_resp',array('model' => $model));	
		}

		$this->render('rent_marca_peru',array(
			'model'=>$model,		
		));
	}

	public function actionRentMarcaE()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_marca_e';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('rent_marca_ecuador_resp',array('model' => $model));	
		}

		$this->render('rent_marca_ecuador',array(
			'model'=>$model,		
		));
	}

	/*FIN rent. marca ecuador / peru*/

	/*INICIO inventario ecuador / peru*/

	public function actionInvPeru()
	{		
		$model=new Reporte;
		$model->scenario = 'inv_peru';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('inv_peru_resp');	
		}

		$this->render('inv_peru',array(
			'model'=>$model,
		));
	}

	public function actionInvPeruPant()
	{		

		$resultados = UtilidadesReportes::invperupantalla();

		echo $resultados;
	}

	public function actionInvEcuador()
	{		
		$model=new Reporte;
		$model->scenario = 'inv_ecuador';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('inv_ecuador_resp');	
		}

		$this->render('inv_ecuador',array(
			'model'=>$model,
		));
	}

	public function actionInvEcuadorPant()
	{		

		$resultados = UtilidadesReportes::invecuadorpantalla();

		echo $resultados;
	}

	/*FIN inventario ecuador / peru*/

	/*INICIO Inventario costo ecuador / peru*/

	public function actionInvCosEcuador()
	{		
		$model=new Reporte;
		$model->scenario = 'inv_cos_ecuador';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('inv_cos_ecuador_resp');	
		}

		$this->render('inv_cos_ecuador',array(
			'model'=>$model,
		));
	}

	public function actionInvCosEcuadorPant()
	{		

		$resultados = UtilidadesReportes::invcosecuadorpantalla();

		echo $resultados;
	}

	public function actionInvCosPeru()
	{		
		$model=new Reporte;
		$model->scenario = 'inv_cos_peru';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('inv_cos_peru_resp');	
		}

		$this->render('inv_cos_peru',array(
			'model'=>$model,
		));
	}

	public function actionInvCosPeruPant()
	{		

		$resultados = UtilidadesReportes::invcosperupantalla();

		echo $resultados;
	}


	/*FIN Inventario costo ecuador / peru*/


	/*INICIO Rent Inventario marca ecuador / peru*/

	public function actionRentInvMarcaP()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_inv_marca_p';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM Qlik.dbo.PR_CRITERIOS_ITEMS where Id_Plan='PL4' ORDER BY 2")->queryAll();

		$lista_marcas = array();
		$lista_marcas['||'] = 'SIN MARCA';
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['Id_Criterio']] = $ma['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_inv_marca_p_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_inv_marca_p',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
		));
	}


	public function actionRentInvMarcaE()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_inv_marca_e';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM Qlik.dbo.ED_CRITERIOS_ITEMS where Id_Plan='PL4' ORDER BY 2")->queryAll();

		$lista_marcas = array();
		$lista_marcas['||'] = 'SIN MARCA';
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['Id_Criterio']] = $ma['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_inv_marca_e_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_inv_marca_e',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
		));
	}

	/*FIN Rent Inventario marca ecuador / peru*/

	/*INICIO pedidos pend despacho ecuador / peru*/

	public function actionPedidosPendDesMarcaP()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_pend_des_marca_p';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM Qlik.dbo.PR_CRITERIOS_ITEMS where Id_Plan='PL4' ORDER BY Criterio_Descripcion")->queryAll();

		$lista_marcas = array();
		$lista_marcas['||'] = 'SIN MARCA';
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['Id_Criterio']] = $ma['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('pedidos_pend_des_marca_p_resp',array('model' => $model));	
		}

		$this->render('pedidos_pend_des_marca_p',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
		));
	}

	public function actionPedidosPendDesMarcaE()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_pend_des_marca_e';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM Qlik.dbo.ED_CRITERIOS_ITEMS where Id_Plan='PL4'")->queryAll();

		$lista_marcas = array();
		$lista_marcas['||'] = 'SIN MARCA';
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['Id_Criterio']] = $ma['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('pedidos_pend_des_marca_e_resp',array('model' => $model));	
		}

		$this->render('pedidos_pend_des_marca_e',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
		));
	}

	/*FIN pedidos pend despacho ecuador / peru*/

	/*INICIO pedidos acum marca ecuador / peru*/

	public function actionPedidosAcumMarcaP()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_acum_marca_p';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM Qlik.dbo.PR_CRITERIOS_ITEMS where Id_Plan='PL4' ORDER BY Criterio_Descripcion")->queryAll();

		$lista_marcas = array();
		$lista_marcas['||'] = 'SIN MARCA';
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['Id_Criterio']] = $ma['Criterio_Descripcion'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('pedidos_acum_marca_p_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('pedidos_acum_marca_p',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_estados'=>$lista_estados,
		));
	}

	public function actionPedidosAcumMarcaE()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_acum_marca_e';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM Qlik.dbo.ED_CRITERIOS_ITEMS where Id_Plan='PL4'")->queryAll();

		$lista_marcas = array();
		$lista_marcas['||'] = 'SIN MARCA';
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['Id_Criterio']] = $ma['Criterio_Descripcion'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('pedidos_acum_marca_e_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('pedidos_acum_marca_e',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_estados'=>$lista_estados,
		));
	}

	/*FIN pedidos acum marca ecuador / peru*/

	public function actionRentMarcaItemL560()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_marca_item_l560';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_marca_item_l560_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_marca_item_l560',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
		));
	}

	public function actionListaMateriales()
	{		
		$model=new Reporte;
		$model->scenario = 'lista_materiales';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->redirect(array('reporte/listamaterialesdet','i'=>$model->item));
		}

		$this->render('lista_materiales',array(
			'model'=>$model,
		));
	}

	public function actionListaMaterialesDet($i)
	{		
		$model=new Reporte;
	
		$this->render('lista_materiales_det',array(
			'item'=>$i,
		));
	}

	public function actionListaMaterialesPant()
	{		
		$item = $_POST['item'];

		$resultados = UtilidadesReportes::listamaterialespantalla($item);
		echo $resultados;
	}

	public function actionSearchItem(){
		$filtro = $_GET['q'];
		$model=new Reporte;
        $data = $model->searchByItem($filtro);
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

 	public function actionSearchItemById(){
		$filtro = $_GET['id'];
        $model=new Reporte;
        $data = $model->searchById($filtro);

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

 	public function actionCruceNotCar()
	{		
		$model=new Reporte;
		$model->scenario = 'cruce_not_car';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('cruce_not_car_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('cruce_not_car',array(
			'model'=>$model,
		));
	}

	public function actionActualizacionDatosSaldo()
	{		
		$model=new Reporte;
		$model->scenario = 'actualizacion_datos_saldo';

		$rutas = Yii::app()->db->createCommand("SELECT DISTINCT f5790_id AS Id, f5790_descripcion as Ruta FROM UnoEE1..t5790_sm_ruta WHERE f5790_estado = 1 ")->queryAll();

		$lista_rutas = array();
		foreach ($rutas as $ru) {
			$lista_rutas[$ru['Id']] = $ru['Ruta'];
		}

		$lista_estados = array(0 => 'INACTIVOS', 1 => 'ACTIVOS');

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('actualizacion_datos_saldo_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('actualizacion_datos_saldo',array(
			'model'=>$model,
			'lista_rutas'=>$lista_rutas,
			'lista_estados'=>$lista_estados,
		));
	}

	public function actionRevisionComercial()
	{		
		$model=new Reporte;
		$model->scenario = 'revision_comercial';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('revision_comercial_resp',array('model' => $model));	
		}

		$this->render('revision_comercial',array(
			'model'=>$model,
			'lista_marcas' => $lista_marcas,		
		));
	}

	public function actionRentxEstructura560()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_x_estructura_560';

		$model_ev = Yii::app()->db->createCommand("SELECT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan=300")->queryAll();

		$lista_ev = array();
		foreach ($model_ev as $m_ev) {
			$lista_ev[$m_ev['Id_Criterio']] = $m_ev['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('rent_x_estructura_560_resp',array('model' => $model));	
		}

		$this->render('rent_x_estructura_560',array(
			'model'=>$model,
			'lista_ev' => $lista_ev,
		));
	}

	public function actionUnComercial()
	{		
		$model=new Reporte;
		$model->scenario = 'un_comercial';

		$this->renderPartial('un_comercial_resp');
	}

	public function actionClientesPot()
	{		
		$model=new Reporte;
		$model->scenario = 'clientes_pot';

		$planes = Yii::app()->db->createCommand("SELECT DISTINCT Id_Plan, Plan_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan <> 970 ORDER BY Plan_Descripcion")->queryAll();

		$lista_planes = array();
		foreach ($planes as $pla) {
			$lista_planes[$pla['Id_Plan']] = $pla['Plan_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('clientes_pot_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('clientes_pot',array(
			'model'=>$model,
			'lista_planes'=>$lista_planes,
		));
	}

	public function actionLoadCriterios()
	{
		$plan = $_POST['plan'];

		$criterios= Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".$plan." ORDER BY Criterio_Descripcion")->queryAll();	

		$i = 0;
		$array_criterios = array();
		
		foreach ($criterios as $c) {
			$array_criterios[$i] = array('id' => $c['Id_Criterio'],  'text' => $c['Criterio_Descripcion']);
			$i++; 

		}
		
		echo json_encode($array_criterios);
	}

	public function actionGetOpcionPlan()
	{

		$plan = $_POST['plan'];

		switch ($plan) {
		    case 100:
		        $opc = 'C_CLASE'; 
		        break;
		    case 200:
		        $opc = 'C_CANAL'; 
		        break;
		    case 300:
		        $opc = 'C_ESTRUCTURA'; 
		        break;
		    case 400:
		        $opc = 'C_SEGMENTO'; 
		        break;
		    case 500:
		        $opc = 'C_TIPOLOGIA'; 
		        break;
		    case 600:
		        $opc = 'C_REGIONALES'; 
		        break;
		    case 700:
		        $opc = 'C_WMS'; 
		        break;
		    case 800:
		        $opc = 'C_RUTA'; 
		        break;
		    case 850:
		        $opc = 'C_DEPARTAMENTO'; 
		        break;
		    case 870:
		        $opc = 'C_COND_PAGO'; 
		        break;
		    case 900:
		        $opc = 'C_CLASIFICACION'; 
		        break;
		    case 950:
		        $opc = 'C_COORDINADOR'; 
		        break;
		    case 960:
		        $opc = 'C_REGIMEN'; 
		        break;
		}

		echo $opc;

	}

	public function actionIndPqrs()
	{		
		$model=new Reporte;
		$model->scenario = 'ind_pqrs';

		$this->renderPartial('ind_pqrs_resp');
	}

	public function actionActEpt()
	{		
		$model=new Reporte;
		$model->scenario = 'act_ept';

		if(isset($_POST['Reporte']))
		{
			$c = 0;

			$model->attributes=$_POST['Reporte'];
			$ids = explode(",", $_POST['Reporte']['consecutivo']);

			foreach ($ids as $i) {

				if($i != ""){

					$command = Yii::app()->db2->createCommand("UPDATE Repositorio_Datos.dbo.tbl_IN_Transf_29 SET Integrado_Pangea = 0 WHERE Rowid_Movto = ".$i);

					if($command->execute() > 0){
						$c++;
					}
				}
			}

			Yii::app()->user->setFlash('success', "Se procesaron ".$c." documento(s).");
			$this->redirect(array('ActEpt'));

		}

		$this->render('act_ept',array(
			'model'=>$model,
		));
	}

	public function actionActEptPant()
	{		
		$resultados = UtilidadesReportes::acteptpantalla();
		echo $resultados;
	}

	public function actionLogisticaExterior()
	{		
		$model=new Reporte;
		$model->scenario = 'logistica_exterior';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('logistica_exterior_resp',array('model' => $model));	
		}

		$this->render('logistica_exterior',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
		));
	}

	public function actionNaf()
	{		
		$model=new Reporte;
		$model->scenario = 'naf';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('naf_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('naf',array(
			'model'=>$model,
		));
	}

	public function actionSaldoCarteraEv()
	{		
		$model=new Reporte;
		$model->scenario = 'saldo_cartera_ev';

		$evs = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->evs." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_evs = array();
		foreach ($evs as $ev) {
			$lista_evs[$ev['Id_Criterio']] = $ev['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('saldo_cartera_ev_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('saldo_cartera_ev',array(
			'model'=>$model,
			'lista_evs'=>$lista_evs,
		));
	}

	public function actionFleteGuia()
	{		
		$model=new Reporte;

		$this->render('flete_guia',array(
			'model'=>$model,
		));
	}

	public function actionUploadFleteGuia()
	{		

		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

        // Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));   

		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php';

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
        $objPHPExcel->setActiveSheetIndex(0);

        //Convierto la data de la Hoja en un arreglo
        $dataExcel = $objPHPExcel->getActiveSheet()->toArray();

        $filas = count($dataExcel);

        $cont = 0;

        if($filas < 2){

        	$opc = 0;
        	$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5> El archivo esta vacio.';

        }else{

    		$opc = 1;
    	
    		//se ejecuta el sp por cada fila en el archivo

    		$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5>';

    		for($i = 1; $i <= $filas -1 ; $i++){
        		$param1 = $dataExcel[$i][0];
        		$param2 = $dataExcel[$i][1];
        		$param3 = $dataExcel[$i][2];
        		$param4 = $dataExcel[$i][3];

        		if($param1 == '' || $param2 == '' || $param3 == '' || $param4 == ''){
    				$fila_error = $i + 1;
        			$msj .= 'Error en la fila # '.$fila_error.', hay columnas vacias.<br>'; 
        			$valid = 0;
        		}else{

        			//se valida si el documento existe

        			$co    = $param1;
					$td    = $param2;
					$cons  = $param3;

        			$query_exist_doc = "SELECT DISTINCT f350_rowid FROM [UnoEE1].[dbo].t350_co_docto_contable WHERE f350_id_co = '".$co."' AND f350_id_tipo_docto = '".$td."' AND f350_consec_docto = ".$cons."";

    				$row_exist_doc =  Yii::app()->db->createCommand($query_exist_doc)->queryRow();

					$doc = $row_exist_doc['f350_rowid'];

					if(is_null($doc)){
						$fila_error = $i + 1;
						$msj .= 'Error en la fila # '.$fila_error.', el documento no existe.<br>'; 
					}else{

						$co    = $param1;
						$td    = $param2;
						$cons  = $param3;

					 	$connection = Yii::app()->db;
						$command = $connection->createCommand("
							EXEC [dbo].[CONF_ACT_VLR_GUIA]
							@CO = N'".$param1."',
							@DOCTO = N'".$param2."',
							@CONSECUTIVO = N'".$param3."',
							@VLR_FLETE = N'".$param4."'
						");

						$command->execute();

						$cont = $cont + 1;

        			}		        		
        		}
        	}
        }

        $f = $filas -1;

        if($f == $cont && $opc == 1){
        	$msj .= $f.' Registro(s) ejecutado(s) correctamente.<br>'; 	
        }

        $resp = array('opc' => $opc, 'msj' => $msj);

        echo json_encode($resp);
		
	}

	public function actionCambioFecPedXml()
	{		
		$model=new Reporte;
		$model->scenario = 'cambio_fecha_pedidos_xml';

		if(isset($_POST['Reporte']))
		{
			
			$command = Yii::app()->db->createCommand();
			$sql='EXEC [dbo].[CONF_MOBILE_PED_ERROR]';
			$command->setText($sql)->execute();

			Yii::app()->user->setFlash('success', "El proceso se ejecuto correctamente.");
			$this->redirect(array('CambioFecPedXml'));
		}

		$this->render('cambio_fecha_pedidos_xml',array(
			'model'=>$model,
		));
	}

	public function actionActReca()
	{		
		$model=new Reporte;

		$this->render('act_reca',array(
			'model'=>$model,
		));
	}

	public function actionActRecaPant()
	{		
		$resultados = UtilidadesReportes::actrecapantalla();
		echo $resultados;
	}

	public function actionActualizarReCa()
	{		
		$reca = $_POST['reca'];

		$command = Yii::app()->db2->createCommand();

		$sql='  UPDATE [Repositorio_Datos].[dbo].[T_IN_Recibos_Caja] set [INTEGRADO] = 0 WHERE [INTEGRADO]=1 and [ROWID] = :reca';
		$params = array(
		    "reca" => $reca,
		);
		$command->setText($sql)->execute($params);

		Yii::app()->user->setFlash('success',"El recibo se actualizo correctamente.");
		echo 1;

	}

	public function actionConsultaPagos()
	{		
		$model=new Reporte;
		$model->scenario = 'consulta_pagos';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('consulta_pagos_resp',array('model' => $model));	
		}

		$this->render('consulta_pagos',array(
			'model'=>$model,
		));
	}

	public function actionConsultaPagosPant()
	{		
		$resultados = UtilidadesReportes::consultapagospantalla();
		echo $resultados;
	}

	public function actionElimRecibo()
	{		
		$model=new Reporte;
		$model->scenario = 'elim_recibo';

		if(isset($_POST['Reporte']))
		{
			
			$command = Yii::app()->db->createCommand();
			$sql='EXEC [dbo].[CONF_ELIM_ERROR_REC]';
			$command->setText($sql)->execute();

			Yii::app()->user->setFlash('success', "El proceso se ejecuto correctamente.");
			$this->redirect(array('ElimRecibo'));
		}

		$this->render('elim_recibo',array(
			'model'=>$model,
		));
	}

	public function actionPedidosAcumLineaTot()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_acum_linea_tot';

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT CI_TIPO, CASE CI_TIPO WHEN 'COM' THEN 'COMPRADOS' WHEN 'FAB' THEN 'FABRICADOS' END DESCRIPCION FROM TH_CONTROL_ITEMS WHERE CI_TIPO IS NOT NULL")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['CI_TIPO']] = $ti['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('pedidos_acum_linea_tot_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('pedidos_acum_linea_tot',array(
			'model'=>$model,
			'lista_lineas'=>$lista_lineas,
			'lista_estados'=>$lista_estados,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionAuditoriaPedidos()
	{		
		$model=new Reporte;
		$model->scenario = 'auditoria_pedidos';

		$cos = Yii::app()->db->createCommand("SELECT DISTINCT f430_id_co FROM UnoEE1..t430_cm_pv_docto")->queryAll();

		$lista_co = array();
		foreach ($cos as $co) {
			$lista_co[$co['f430_id_co']] = $co['f430_id_co'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT f430_id_tipo_docto FROM UnoEE1..t430_cm_pv_docto")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $ti) {
			$lista_tipos[$ti['f430_id_tipo_docto']] = $ti['f430_id_tipo_docto'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('auditoria_pedidos_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('auditoria_pedidos',array(
			'model'=>$model,
			'lista_co'=>$lista_co,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionAuditoriaPedidosPant()
	{		

		$co = $_POST['co'];
		$tipo = $_POST['tipo'];
		$consecutivo = $_POST['consecutivo'];

		$resultados = UtilidadesReportes::auditoriapedidospantalla($co, $tipo, $consecutivo);

		echo $resultados;
	}

	public function actionListaP()
	{		
		
		$model=new Reporte;
		$model->scenario = 'lista_p';

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[$ora['Criterio_Descripcion']] = $ora['Criterio_Descripcion'];
		}

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['Criterio_Descripcion']] = $ma['Criterio_Descripcion'];
		}

		$lps = Yii::app()->db->createCommand("SELECT DISTINCT f112_id, f112_descripcion FROM UnoEE1..t112_mc_listas_precios")->queryAll();

		$lista_pr = array();
		foreach ($lps as $lp) {
			$lista_pr[$lp['f112_id']] = $lp['f112_descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('lista_p_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('lista_p',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,
			'lista_marcas'=>$lista_marcas,
			'lista_pr'=>$lista_pr,
		));
		
	}

	public function actionVenPosFalt()
	{		
		$model=new Reporte;
		$model->scenario = 'ven_pos_falt';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('ven_pos_falt_resp',array('model' => $model));	
		}

		$this->render('ven_pos_falt',array(
			'model'=>$model,
		));
	}

	public function actionVenPosFaltPant()
	{		
		$fecha_inicial = $_POST['fecha_inicial'];
		$fecha_final = $_POST['fecha_final'];

		$resultados = UtilidadesReportes::venposfaltpantalla($fecha_inicial, $fecha_final);

		echo $resultados;
	}

	public function actionVenPosEntr()
	{		
		$model=new Reporte;
		$model->scenario = 'ven_pos_entr';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('ven_pos_entr_resp',array('model' => $model));	
		}

		$this->render('ven_pos_entr',array(
			'model'=>$model,
		));
	}

	public function actionVenPosEntrPant()
	{		
		$fecha_inicial = $_POST['fecha_inicial'];
		$fecha_final = $_POST['fecha_final'];

		$resultados = UtilidadesReportes::venposentrpantalla($fecha_inicial, $fecha_final);

		echo $resultados;
	}

	public function actionCostoXItemPos()
	{		
		$model=new Reporte;
		$model->scenario = 'costo_x_item_pos';

		$this->renderPartial('costo_x_item_pos_resp');
	}

	public function actionFacturaProforma()
	{		
		$model=new Reporte;
		$model->scenario = 'factura_proforma';

		$cos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_co FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2")->queryAll();

		$lista_co = array();
		foreach ($cos as $co) {
			$lista_co[$co['f350_id_co']] = $co['f350_id_co'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_tipo_docto FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2 AND f350_id_tipo_docto like 'R%'")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $td) {
			$lista_tipos[$td['f350_id_tipo_docto']] = $td['f350_id_tipo_docto'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('factura_proforma_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('factura_proforma',array(
			'model'=>$model,
			'lista_co'=>$lista_co,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionElimPedido()
	{		
		$model=new Reporte;
		$model->scenario = 'elim_pedido';

		if(isset($_POST['Reporte']))
		{
			
			$command = Yii::app()->db->createCommand();
			$sql='EXEC [dbo].[CONF_ELIM_ERROR_PED]';
			$command->setText($sql)->execute();

			Yii::app()->user->setFlash('success', "El proceso se ejecuto correctamente.");
			$this->redirect(array('ElimPedido'));
		}

		$this->render('elim_pedido',array(
			'model'=>$model,
		));
	}

	public function actionFotoCart()
	{		
		$model=new Reporte;
		$model->scenario = 'foto_cart';

		if(isset($_POST['Reporte']))
		{
			
			$q_consec = Yii::app()->db->createCommand("SELECT MAX(Cons) AS Consecutivo FROM TH_FOTO_CARTERA")->queryRow();

			if(empty($q_consec)){
				$cons = 1;
			}else{
				$cons = $q_consec['Consecutivo'] + 1;
			}

			$dia = intval(date('d'));

			if($dia <= 15){
				$mes_act = intval(date('m'));
				$mes = $mes_act - 1;

				if($mes < 10){
					$mes_per = '0'.$mes;
				}else{
					$mes_per = $mes;	
				}

				$periodo = date('Y').$mes_per;

			}else{
				$mes = date('m');
				$periodo = date('Y').$mes;
			}

			$date = date('Y-m-d H:i:s');

			$query ="EXEC unoee1..sp_cons_cxc 2,NULL,'PUC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,30,31,60,61,90,91,120,121,180,181,360,361,9999,0,0,0,0,0,0,0,999999,0,'".$date."',1,'COP',1,10261,'Cons_Cart_Cort',0,190,0,'".$date."','".$date."',0,0";


    		$q1 = Yii::app()->db->createCommand($query)->queryAll();

    		$i = 0; 

    		if(!empty($q1)){
      			foreach ($q1 as $reg1) {

      				$modelo_foto_cartera = new FotoCartera;
      				$modelo_foto_cartera->Cons = $cons;
      				$modelo_foto_cartera->Saldo_Total = $reg1['f1_saldo_total'];
      				$modelo_foto_cartera->Saldo_1_30 = $reg1['f1_saldo_vencido1'];
      				$modelo_foto_cartera->Saldo_31_60 = $reg1['f1_saldo_vencido2'];
      				$modelo_foto_cartera->Saldo_61_90 = $reg1['f1_saldo_vencido3'];
      				$modelo_foto_cartera->Saldo_91_120 = $reg1['f1_saldo_vencido4'];
      				$modelo_foto_cartera->Saldo_121_180 = $reg1['f1_saldo_vencido5'];
      				$modelo_foto_cartera->Saldo_181_360 = $reg1['f1_saldo_vencido6'];
      				$modelo_foto_cartera->Saldo_361_9999 = $reg1['f1_saldo_vencido7'];
      				$modelo_foto_cartera->Estructura_Ventas = $reg1['f_02_300'];
      				$modelo_foto_cartera->Canal = $reg1['f_02_200'];
      				$modelo_foto_cartera->Periodo = $periodo;
      				$modelo_foto_cartera->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
      				$modelo_foto_cartera->Fecha_Creacion = date('Y-m-d H:i:s');
      				
      				if($modelo_foto_cartera->save()){
      					$i++;
      				}
      				
      			}
			}

			Yii::app()->user->setFlash('success', "Se insertaron ".$i." registros con el consecutivo ".$cons.".");
			$this->redirect(array('FotoCart'));
		}

		$this->render('foto_cart',array(
			'model'=>$model,
		));
	}

	public function actionRecXWebService()
	{		
		$model=new Reporte;
		$model->scenario = 'rec_x_web_service';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('rec_x_web_service_resp',array('model' => $model));	
		}

		$this->render('rec_x_web_service',array(
			'model'=>$model,		
		));
	}

	public function actionFacturaTitan()
	{		
		$model=new Reporte;
		$model->scenario = 'factura_titan';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('factura_titan_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('factura_titan',array(
			'model'=>$model,
		));
	}

	public function actionRentCriterios560()
	{		
		$model=new Reporte;
		$model->scenario = 'rent_criterios_560';

		$clases = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->clases." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_clases = array();
		foreach ($clases as $cla) {
			$lista_clases[$cla['Id_Criterio']] = $cla['Criterio_Descripcion'];
		}

		$canales = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->canales." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_canales = array();
		foreach ($canales as $can) {
			$lista_canales[$can['Id_Criterio']] = $can['Criterio_Descripcion'];
		}

		$regionales = Yii::app()->db->createCommand("SELECT Id_Plan, Plan_Descripcion, Id_Criterio, Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".Yii::app()->params->regionales." ORDER BY Criterio_Descripcion")->queryAll();

		$lista_regionales = array();
		foreach ($regionales as $re) {
			$lista_regionales[$re['Id_Criterio']] = $re['Criterio_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('rent_criterios_560_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('rent_criterios_560',array(
			'model'=>$model,
			'lista_clases'=>$lista_clases,
			'lista_canales'=>$lista_canales,
			'lista_regionales'=>$lista_regionales,
		));
	}

	public function actionFeeTerpelDet()
	{		
		$model=new Reporte;
		$model->scenario = 'fee_terpel_det';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('fee_terpel_det_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('fee_terpel_det',array(
			'model'=>$model,
		));
	}

	public function actionFeeTerpelCons()
	{		
		$model=new Reporte;
		$model->scenario = 'fee_terpel_cons';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('fee_terpel_cons_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('fee_terpel_cons',array(
			'model'=>$model,
		));
	}

	public function actionCuadroComprasPt()
	{		
		$model=new Reporte;
		$model->scenario = 'cuadro_compras_pt';

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}
		
		$origenes = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100")->queryAll();

		$lista_origenes = array();
		foreach ($origenes as $or) {
			$lista_origenes[$or['DESCRIPCION']] = $or['DESCRIPCION'];
		}

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[$ora['DESCRIPCION']] = $ora['DESCRIPCION'];
		}

		$proveedor = Yii::app()->db->createCommand("SELECT DISTINCT f123_dato as Proveedor FROM UnoEE1..t123_mc_items_desc_tecnicas WHERE f123_id_Cia = 2 AND f123_rowid_campo = 675 AND f123_dato != '' ORDER BY 1")->queryAll();

		$lista_pro = array();
		foreach ($proveedor as $pro) {
			$lista_pro[$pro['Proveedor']] = $pro['Proveedor'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('cuadro_compras_pt_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('cuadro_compras_pt',array(
			'model'=>$model,
			'lista_estados'=>$lista_estados,
			'lista_origenes'=>$lista_origenes,
			'lista_marcas'=>$lista_marcas,
			'lista_lineas'=>$lista_lineas,
			'lista_oracle'=>$lista_oracle, 
			'lista_pro'=>$lista_pro,			
		));
	}

	public function actionHistLibPed()
	{		
		$model=new Reporte;
		$model->scenario = 'hist_lib_ped';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('hist_lib_ped_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('hist_lib_ped',array(
			'model'=>$model,
		));
	}

	public function actionItemsExentosIva()
	{		
		$model=new Reporte;
		$model->scenario = 'items_exentos_iva';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('items_exentos_iva_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('items_exentos_iva',array(
			'model'=>$model,
		));
	}

	public function actionDescB2B()
	{		
		$model=new Reporte;
		$model->scenario = 'desc_b2b';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('desc_b2b_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('desc_b2b',array(
			'model'=>$model,
		));
	}

	public function actionLogisticaComercialxOra()
	{		
		$model=new Reporte;
		$model->scenario = 'logistica_comercial_x_ora';

		$oracle = Yii::app()->db->createCommand("SELECT M_Rowid, M_Descripcion FROM TH_ORACLE ORDER BY M_Descripcion")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $lorac) {
			$lista_oracle[$lorac['M_Descripcion']] = $lorac['M_Descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('logistica_comercial_x_ora_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('logistica_comercial_x_ora',array(
			'model'=>$model,
			'lista_oracle'=>$lista_oracle,
		));
	}

	public function actionLogisticaComercialxUn()
	{		
		$model=new Reporte;
		$model->scenario = 'logistica_comercial_x_un';

		$un = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan=900")->queryAll();

		$lista_un = array();
		foreach ($un as $lun) {
			$lista_un[$lun['DESCRIPCION']] = $lun['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('logistica_comercial_x_un_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('logistica_comercial_x_un',array(
			'model'=>$model,
			'lista_un'=>$lista_un,
		));
	}

	public function actionAnalisisVentas()
	{		
		$model=new Reporte;
		$model->scenario = 'analisis_ventas';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[$ora['DESCRIPCION']] = $ora['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('analisis_ventas_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('analisis_ventas',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_lineas'=>$lista_lineas,
			'lista_oracle'=>$lista_oracle, 
		));
	}

	public function actionPedidosPendDesReqTop()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_pend_des_req_top';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('pedidos_pend_des_req_top_resp',array('model' => $model));	
		}

		$this->render('pedidos_pend_des_req_top',array(
			'model'=>$model,
		));
	}

	public function actionEstadoItems()
	{		
		$model=new Reporte;

		$this->render('estado_items',array(
			'model'=>$model,
		));
	}

	public function actionUploadEstadoItems()
	{		
		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

        // Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));   

		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php';

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
        $objPHPExcel->setActiveSheetIndex(0);

        //Convierto la data de la Hoja en un arreglo
        $dataExcel = $objPHPExcel->getActiveSheet()->toArray();

        $filas = count($dataExcel);

        $cont = 0;

        if($filas < 2){

        	$opc = 0;
        	$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5> El archivo esta vacio.';

        }else{

    		$opc = 1;
    	
    		//se ejecuta el sp por cada fila en el archivo

    		$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5>';

    		for($i = 1; $i <= $filas -1 ; $i++){
        		$param1 = $dataExcel[$i][0];
        		$param2 = $dataExcel[$i][1];

        		if($param1 === '' || $param2 === ''){
    				$fila_error = $i + 1;
        			$msj .= 'Error en la fila # '.$fila_error.', hay columnas vacias.<br>'; 
        			$valid = 0;
        		}else{

        			//se valida si el item existe

        			$codigo    = $param1;

        			$query_exist_item = "SELECT f120_id FROM UnoEE1..t120_mc_items WHERE f120_id = ".$param1;

    				$row_exist_item =  Yii::app()->db->createCommand($query_exist_item)->queryRow();

					$id_item = $row_exist_item['f120_id'];

					if(is_null($id_item)){
						$fila_error = $i + 1;
						$msj .= 'Error en la fila # '.$fila_error.', el item no existe.<br>'; 
					}else{

						//se valida si el estado es valido
						$estado = $param2;

						if($estado != 0 && $estado != 1 && $estado != 2){
							$fila_error = $i + 1;
							$msj .= 'Error en la fila # '.$fila_error.', el estado no es valido.<br>'; 
						}else{

						 	$connection = Yii::app()->db;
							$command = $connection->createCommand("
								UPDATE t1
								SET t1.f121_ind_estado = ".$estado."
								FROM UnoEE1..t121_mc_items_extensiones AS t1
								INNER JOIN UnoEE1..t120_mc_items ON f121_rowid_item=f120_rowid
								WHERE f120_id = ".$id_item." AND f120_id_cia=2
							");

							$command->execute();

							$cont = $cont + 1;

						}	
					}
					
        		}		        		
        	}
        }

        $f = $filas -1;

        if($f == $cont && $opc == 1){
        	$msj .= $f.' Item(s) actualizado(s) correctamente.<br>'; 	
        }

        $resp = array('opc' => $opc, 'msj' => $msj);

        echo json_encode($resp);
	}

	public function actionConsultaFactElect()
	{		
		$model=new Reporte;
		$model->scenario = 'consulta_fact_elect';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('fact_elect_resp',array('model' => $model));	
		}

		$this->render('fact_elect',array(
			'model'=>$model,
		));
	}

	public function actionConsultaFactElectPant()
	{		
		
		$tipo = $_POST['tipo'];
		$cons_inicial = $_POST['cons_inicial'];
		$cons_final = $_POST['cons_final'];

		$resultados = UtilidadesReportes::consultafactelectpantalla($tipo, $cons_inicial, $cons_final);
		echo $resultados;
	}

	public function actionCuadroComprasMp()
	{		
		
		$this->renderPartial('cuadro_compras_mp_resp');
	
	}

	public function actionPagosTiendaBinner()
	{		
		$model=new Reporte;

		$this->render('pagos_tienda_binner',array(
			'model'=>$model,
		));
	}

	public function actionUploadPagosTiendaBinner()
	{		
		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

		$lineas = file($file_tmp);
		$num_lineas = count($lineas) - 1;

		$i=0;

		for ($c=1; $c < $num_lineas; $c++) { 
			$data = explode(";",str_replace("'", "", $lineas[$c]));
			$n_trans_interno = $data[0];
        	$forma_pago = $data[1];
        	$ambiente = $data[2];
        	$tipo_trans = $data[3];
        	$tipo_tarjeta = $data[4];
        	$fran_tarjeta = $data[5];
        	$ult_dig_tarjeta = $data[6];
        	$cuotas = $data[7];
        	$valor = $data[8];
        	$impuesto = $data[9];
        	$descripcion = $data[10];
        	$n_autorizacion = $data[11];
        	$msg_red = $data[12];
        	$n_recibo = $data[13];
        	$ref_1 = $data[14];
        	$ref_2 = $data[15];
        	$ref_3 = $data[16];
        	$cod_pse = $data[17];
        	$fecha_tr = $data[18];
        	$canal = $data[19];
        	$tipo_docto_cliente = $data[20];
        	$n_docto_cliente = $data[21];
        	$nombre_completo_cliente = $data[22];
        	$email_cliente = $data[23];
        	$telefono_cliente = $data[24];
        	$ciudad_cliente = $data[25];
        	$direccion_cliente = $data[26];
        	$celular_cliente = $data[27];

        	$exist = Yii::app()->db->createCommand("SELECT n_trans_interno FROM Pagos_Inteligentes..T_PAGOS WHERE n_trans_interno = ".$n_trans_interno)->queryRow();

        	if(empty($exist)){

        		$connection = Yii::app()->db;
				$command = $connection->createCommand("
				INSERT INTO Pagos_Inteligentes..T_PAGOS
				([n_trans_interno]
				,[forma_pago]
				,[ambiente]
				,[tipo_trans]
				,[tipo_tarjeta]
				,[fran_tarjeta]
				,[ult_dig_tarjeta]
				,[cuotas]
				,[valor]
				,[impuesto]
				,[descripcion]
				,[n_autorizacion]
				,[msg_red]
				,[n_recibo]
				,[ref_1]
				,[ref_2]
				,[ref_3]
				,[cod_pse]
				,[fecha_tr]
				,[canal]
				,[tipo_docto_cliente]
				,[n_docto_cliente]
				,[nombre_completo_cliente]
				,[email_cliente]
				,[telefono_cliente]
				,[ciudad_cliente]
				,[direccion_cliente]
				,[celular_cliente])
				VALUES
				(".$n_trans_interno."
				,'".$forma_pago."'
				,'".$ambiente."'
				,'".$tipo_trans."'
				,'".$tipo_tarjeta."'
				,'".$fran_tarjeta."'
				,'".$ult_dig_tarjeta."'
				,'".$cuotas."'
				,".$valor."
				,".$impuesto."
				,'".$descripcion."'
				,'".$n_autorizacion."'
				,'".$msg_red."'
				,'".$n_recibo."'
				,'".$ref_1."'
				,'".$ref_2."'
				,'".$ref_3."'
				,'".$cod_pse."'
				,'".$fecha_tr."'
				,'".$canal."'
				,'".$tipo_docto_cliente."'
				,'".$n_docto_cliente."'
				,'".$nombre_completo_cliente."'
				,'".$email_cliente."'
				,'".$telefono_cliente."'
				,'".$ciudad_cliente."'
				,'".$direccion_cliente."'
				,'".$celular_cliente."'
				)");

				$command->execute();
				$i++;

        	}

		}
		
        $msj .= $i.' Registro(s) insertados.<br>'; 	

        $resp = array('msj' => $msj);

        echo json_encode($resp);

	}

	public function actionPrintCheq()
	{		
		$model=new Reporte;
		$model->scenario = 'print_cheq';

		$cos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_co FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2")->queryAll();

		$lista_co = array();
		foreach ($cos as $co) {
			$lista_co[$co['f350_id_co']] = $co['f350_id_co'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_tipo_docto FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $td) {
			$lista_tipos[$td['f350_id_tipo_docto']] = $td['f350_id_tipo_docto'];
		}

		$this->render('print_cheq',array(
			'model'=>$model,
			'lista_co'=>$lista_co,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionExistCheq()
	{
		$cia = $_POST['cia'];
		$co = $_POST['co'];
		$tipo = $_POST['tipo'];
		$consecutivo = $_POST['consecutivo'];
		$firma = $_POST['firma'];

		//se verifica si el cheque ya fue impreso
		$modelocheque = ImpCheq::model()->findByAttributes(array('Cia'=>$cia, 'Co'=>$co, "Tipo_Docto"=>$tipo, "Consecutivo"=>$consecutivo));

		if(!empty($modelocheque)){
			$opc = 1;
		}else{
			//se verifica si la combinacion de info trae datos para generar el archivo 
			$query ="
			  SET NOCOUNT ON
			  EXEC [dbo].[FIN_CH1]
			  @CIA = '".$cia."',
			  @CO = '".$co."',
			  @DOCTO = '".$tipo."',
			  @NUM_INI = ".$consecutivo.",
			  @NUM_FIN = ".$consecutivo."
			";

			$data = Yii::app()->db->createCommand($query)->queryAll();

			if(!empty($data)){
				$this->renderPartial('save_pdf_cheq',array('cia' => $cia, 'co' => $co, 'tipo' => $tipo, 'consecutivo' => $consecutivo, 'firma' => $firma));	
				$opc = 2;
			}else{
				$opc = 0;
			}
		}	

        echo $opc;
		
	}

	public function actionRegImpCheq()
	{
		$cia = $_POST['cia'];
		$co = $_POST['co'];
		$tipo = $_POST['tipo'];
		$consecutivo = $_POST['consecutivo'];
		$firma = $_POST['firma'];

		//se guarda el registro de impresión del cheque
		$modelocheque = new ImpCheq;
		$modelocheque->Cia = $cia;
		$modelocheque->Co = $co;
		$modelocheque->Tipo_Docto = $tipo;
		$modelocheque->Consecutivo = $consecutivo;
		$modelocheque->Firma = $firma;
		$modelocheque->Soporte = $cia.'_'.$co.'_'.$tipo.'_'.$consecutivo.'.pdf';
		$modelocheque->Usuario_Impresion = Yii::app()->user->getState('id_user');
		$modelocheque->Fecha_Hora_Impresion = date('Y-m-d H:i:s');
		if($modelocheque->save()){
			$resp = 1;
		}else{
			$resp = 0;
		}
	
        echo $resp;
		
	}

	public function actionRPrintCheq()
	{		
		$model=new Reporte;
		$model->scenario = 'r_print_cheq';

		$cos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_co FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2")->queryAll();

		$lista_co = array();
		foreach ($cos as $co) {
			$lista_co[$co['f350_id_co']] = $co['f350_id_co'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_tipo_docto FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $td) {
			$lista_tipos[$td['f350_id_tipo_docto']] = $td['f350_id_tipo_docto'];
		}

		$this->render('r_print_cheq',array(
			'model'=>$model,
			'lista_co'=>$lista_co,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionVerifCheq()
	{
		$cia = $_POST['cia'];
		$co = $_POST['co'];
		$tipo = $_POST['tipo'];
		$consecutivo = $_POST['consecutivo'];

		//se verifica si el cheque ya fue impreso
		$modelocheque = ImpCheq::model()->findByAttributes(array('Cia'=>$cia, 'Co'=>$co, "Tipo_Docto"=>$tipo, "Consecutivo"=>$consecutivo));

		if(!empty($modelocheque)){
			if($modelocheque->Usuario_Reimpresion1 != ""){

				if($modelocheque->Usuario_Reimpresion2 != ""){
					//el cheque solo ha sido impreso 3 veces
					$opc = 1;

				}else{
					//el cheque solo ha sido impreso 2 veces
					$opc = 2;
				}
	
			}else{
				//el cheque solo ha sido impreso 1 vez
				$opc = 2;	
			}
	
		}else{
			//el cheque no ha sido impreso
			$opc = 0;
		}	

        echo $opc;
		
	}

	public function actionRegRImpCheq()
	{
		$cia = $_POST['cia'];
		$co = $_POST['co'];
		$tipo = $_POST['tipo'];
		$consecutivo = $_POST['consecutivo'];

		//se guarda el registro de reimpresión del cheque
		$modelocheque = ImpCheq::model()->findByAttributes(array('Cia'=>$cia, 'Co'=>$co, "Tipo_Docto"=>$tipo, "Consecutivo"=>$consecutivo));
		
		if($modelocheque->Usuario_Reimpresion1 == ""){
			$modelocheque->Usuario_Reimpresion1 = Yii::app()->user->getState('id_user');
			$modelocheque->Fecha_Hora_Reimpresion1 = date('Y-m-d H:i:s');
		}else{
			$modelocheque->Usuario_Reimpresion2 = Yii::app()->user->getState('id_user');
			$modelocheque->Fecha_Hora_Reimpresion2 = date('Y-m-d H:i:s');
		}

		if($modelocheque->save()){
			$resp = 1;
		}else{
			$resp = 0;
		}
		
        echo $resp;
		
	}

	public function actionIngresosWebBinner()
	{		
		$model=new Reporte;

		$this->render('ingresos_web_binner',array(
			'model'=>$model,
		));
	}

	public function actionUploadIngresosWebBinner()
	{		
		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

        // Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));   

		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php';

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
        $objPHPExcel->setActiveSheetIndex(0);

        //Convierto la data de la Hoja en un arreglo
        $dataExcel = $objPHPExcel->getActiveSheet()->toArray();

        $filas = count($dataExcel);

        if($filas > 2){

       		$c = 0;
    	
    		//se ejecuta el sp por cada fila en el archivo

    		$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5>';

    		for($i = 1; $i <= $filas -1 ; $i++){
        		$param1 = intval($dataExcel[$i][0]); //Número de pedido
        		$param2 = str_replace("'", "", $dataExcel[$i][1]); //Estado del pedido
        		$param3 = str_replace("'", "", $dataExcel[$i][2]);  //Fecha del pedido
        		$param4 = str_replace("'", "", $dataExcel[$i][3]);  //Nota del cliente
        		$param5 = str_replace("'", "", $dataExcel[$i][4]);  //Nombre (facturación)
        		$param6 = str_replace("'", "", $dataExcel[$i][5]);  //Apellidos (facturación)
        		$param7 = str_replace("'", "", $dataExcel[$i][6]);  //Identificacion
        		$param8 = str_replace("'", "", $dataExcel[$i][7]); //Empresa (facturación)
        		$param9 = str_replace("'", "", $dataExcel[$i][8]); //Dirección lineas 1 y 2 (facturación)
        		$param10 = str_replace("'", "", $dataExcel[$i][9]); //Ciudad (facturación)
        		$param11 = str_replace("'", "", $dataExcel[$i][10]); //Código de provincia (facturación)
        		$param12 = str_replace("'", "", $dataExcel[$i][11]); //Código postal (facturación)
        		$param13 = str_replace("'", "", $dataExcel[$i][12]); //Código del país (facturación)
        		$param14 = str_replace("'", "", $dataExcel[$i][13]); //Correo electrónico (facturación)
        		$param15 = str_replace("'", "", $dataExcel[$i][14]); //Teléfono (facturación)
        		$param16 = str_replace("'", "", $dataExcel[$i][15]); //Nombre (envío)
        		$param17 = str_replace("'", "", $dataExcel[$i][16]); //Apellidos (envío)
        		$param18 = str_replace("'", "", $dataExcel[$i][17]); //Dirección lineas 1 y 2 (envío)
        		$param19 = str_replace("'", "", $dataExcel[$i][18]); //Ciudad (envío)
        		$param20 = str_replace("'", "", $dataExcel[$i][19]); //Código de provincia (envío)
        		$param21 = str_replace("'", "", $dataExcel[$i][20]); //Código postal (envío)
        		$param22 = str_replace("'", "", $dataExcel[$i][21]); //Código del país (envío)
        		$param23 = str_replace("'", "", $dataExcel[$i][22]); //Título del método de pago
        		$param24 = str_replace("'", "", $dataExcel[$i][23]); //Importe de descuento del carrito
        		$param25 = str_replace("'", "", $dataExcel[$i][24]); //Importe de subtotal del pedido
        		$param26 = str_replace("'", "", $dataExcel[$i][25]); //Título del método de envío
        		$param27 = str_replace("'", "", $dataExcel[$i][26]); //Importe de envío del pedido
        		$param28 = str_replace("'", "", $dataExcel[$i][27]); //Importe reembolsado del pedido
        		$param29 = str_replace("'", "", $dataExcel[$i][28]); //Importe total del pedido
        		$param30 = str_replace("'", "", $dataExcel[$i][29]); //Importe total de impuestos del pedido
        		$param31 = str_replace("'", "", $dataExcel[$i][30]); //SKU
        		$param32 = str_replace("'", "", $dataExcel[$i][31]); //Artículo #
        		$param33 = str_replace("'", "", $dataExcel[$i][32]); //Item Name
        		$param34 = str_replace("'", "", $dataExcel[$i][33]); //Cantidad
        		$param35 = str_replace("'", "", $dataExcel[$i][34]); //Coste de artículo
        		$param36 = str_replace("'", "", $dataExcel[$i][35]); //Código de cupón
        		$param37 = str_replace("'", "", $dataExcel[$i][36]); //Importe de descuento
        		$param38 = str_replace("'", "", $dataExcel[$i][37]); //Importe de impuestos del descuento

        		$query_exist_cab = "SELECT Order_Number FROM Tiendabinner..Web_Orders WHERE Order_Number = ".$param1;

				$row_exist_cab =  Yii::app()->db->createCommand($query_exist_cab)->queryRow();

				if(empty($row_exist_cab)){
					//no existe la cabecera

					if(is_numeric($param31)){
				
						$command = Yii::app()->db->createCommand("
						INSERT INTO Tiendabinner..Web_Orders
						([Order_Number]
			           ,[Order_Status]
			           ,[Order_Date]
			           ,[Customer_Note]
			           ,[Billing_First_Name]
			           ,[Billing_Last_Name]
			           ,[Plain_Orders__Billing_Ident]
			           ,[Billing_Company]
			           ,[Billing_Address]
			           ,[Billing_City]
			           ,[Billing_State]
			           ,[Billing_Postcode]
			           ,[Billing_Country]
			           ,[Billing_Email]
			           ,[Billing_Phone]
			           ,[Shipping_First_Name]
			           ,[Shipping_Last_Name]
			           ,[Shipping_Address]
			           ,[Shipping_City]
			           ,[Shipping_State]
			           ,[Shipping_Postcode]
			           ,[Shipping_Country]
			           ,[Payment_Method_Title]
			           ,[Cart_Discount]
			           ,[Order_Subtotal]
			           ,[Shipping_Method_Title]
			           ,[Order_Shipping]
			           ,[Order_Refund]
			           ,[Order_Total]
			           ,[Order_Total_Tax]
			           ,[Coupons]
			           ,[Fecha]
			           )
						VALUES
						(".$param1."
			           ,'".$param2."'
			           ,'".$param3."'
			           ,'".$param4."'
			           ,'".$param5."'
			           ,'".$param6."'
			           ,'".$param7."'
			           ,'".$param8."'
			           ,'".$param9."'
			           ,'".$param10."'
			           ,'".$param11."'
			           ,'".$param12."'
			           ,'".$param13."'
			           ,'".$param14."'
			           ,'".$param15."'
			           ,'".$param16."'
			           ,'".$param17."'
			           ,'".$param18."'
			           ,'".$param19."'
			           ,'".$param20."'
			           ,'".$param21."'
			           ,'".$param22."'
			           ,'".$param23."'
			           ,".$param24."
			           ,".$param25."
			           ,'".$param26."'
			           ,".$param27."
			           ,".$param28."
			           ,".$param29."
			           ,".$param30."
			           ,'".$param36."'
			           ,'".date('Y-m-d H:i:s')."'
						)");

						$command->execute();
						$c++;

						$command2 = Yii::app()->db->createCommand("
						INSERT INTO Tiendabinner..Web_Orders_Details
			           ([Order_Number]
			           ,[Sku]
			           ,[Line_Id]
			           ,[Name]
			           ,[Qty]
			           ,[Item_Price]
			           ,[Fecha])
			     		VALUES
			           (".$param1."
			           ,".$param31."
			           ,".$param32."
			           ,'".$param33."'
			           ,".$param34."
			           ,".$param35."
			           ,'".date('Y-m-d H:i:s')."'
						)");

						$command2->execute();
						$c++;

					}

				}else{

					$query_exist_det = "SELECT Order_Number FROM Tiendabinner..Web_Orders_Details WHERE Order_Number = ".$param1." AND Line_Id = ".$param32;

					$row_exist_det =  Yii::app()->db->createCommand($query_exist_det)->queryRow();

					if(empty($row_exist_det)){
						//no existe el detalle

						if(is_numeric($param31)){

							$command2 = Yii::app()->db->createCommand("
							INSERT INTO Tiendabinner..Web_Orders_Details
				           ([Order_Number]
				           ,[Sku]
				           ,[Line_Id]
				           ,[Name]
				           ,[Qty]
				           ,[Item_Price]
				           ,[Fecha])
				     		VALUES
				           (".$param1."
				           ,".$param31."
				           ,".$param32."
				           ,'".$param33."'
				           ,".$param34."
				           ,".$param35."
				           ,'".date('Y-m-d H:i:s')."'
							)");

							$command2->execute();
							$c++;
						}

					}

				}
			}

			$msj .= $c.' Registro(s) insertados.<br>'; 	

        	$resp = array('msj' => $msj);

        	echo json_encode($resp);

		}

	}

	public function actionFactTiendasWeb()
	{		
		$model=new Reporte;
		$model->scenario = 'fact_tiendas_web';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('fact_tiendas_web_resp',array('model' => $model));	
		}

		$this->render('fact_tiendas_web',array(
			'model'=>$model,		
		));
	}

	public function actionDespTiendasWeb()
	{		
		$model=new Reporte;
		$model->scenario = 'desp_tiendas_web';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('desp_tiendas_web_resp',array('model' => $model));	
		}

		$this->render('desp_tiendas_web',array(
			'model'=>$model,		
		));
	}

	public function actionFacturaPos()
	{		
		$model=new Reporte;
		$model->scenario = 'factura_pos';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('factura_pos_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('factura_pos',array(
			'model'=>$model,
		));
	}

	public function actionConfirmacionPagos()
	{		
		$model=new Reporte;

		$this->render('confirmacion_pagos',array(
			'model'=>$model,
		));
	}

	public function actionUploadConfirmacionPagos()
	{		
		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

        // Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));   

		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php';

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
        $objPHPExcel->setActiveSheetIndex(0);

        //Convierto la data de la Hoja en un arreglo
        $dataExcel = $objPHPExcel->getActiveSheet()->toArray();

        $filas = count($dataExcel);

        if($filas > 2){

       		$c = 0;
    	
    		//se ejecuta el sp por cada fila en el archivo

    		$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5>';

    		$clean_number_caract = array("$", ",");

    		for($i = 1; $i <= $filas -1 ; $i++){

        		$param1 = $dataExcel[$i][0]; //TypeStatus
        		$param2 = $dataExcel[$i][1]; //Status_Details
        		$param3 = $dataExcel[$i][2];  //Id_Transaccion
        		$param4 = $dataExcel[$i][3];  //Autorizacion
        		$param5 = str_replace($clean_number_caract, "", $dataExcel[$i][4]);  //Valor_Venta
        		$param6 = $dataExcel[$i][5];  //Fecha_Venta
        		$param7 = $dataExcel[$i][6];  //Medio_Pago
        		$param8 = $dataExcel[$i][7]; //Franquicia
        		$param9 = $dataExcel[$i][8]; //N_Identif
        		$param10 = $dataExcel[$i][9]; //Ref1
        		$param11 = $dataExcel[$i][10]; //Ref2
        		$param12 = $dataExcel[$i][11]; //Ref3
        		$param13 = $dataExcel[$i][12]; //Descripcion
        		$param14 = str_replace($clean_number_caract, "", $dataExcel[$i][13]); //Comision
        		$param15 = $dataExcel[$i][14]; //Porcentaje
        		$param16 = str_replace($clean_number_caract, "", $dataExcel[$i][15]); //Iva_Comision
        		$param17 = str_replace($clean_number_caract, "", $dataExcel[$i][16]); //Fee
        		$param18 = str_replace($clean_number_caract, "", $dataExcel[$i][17]); //IvaFee
        		$param19 = str_replace($clean_number_caract, "", $dataExcel[$i][18]); //ReteIca
        		$param20 = str_replace($clean_number_caract, "", $dataExcel[$i][19]); //ReteIva
        		$param21 = str_replace($clean_number_caract, "", $dataExcel[$i][20]); //ReteFTE
        		$param22 = str_replace($clean_number_caract, "", $dataExcel[$i][21]); //Gravamen
        		$param23 = str_replace($clean_number_caract, "", $dataExcel[$i][22]); //Valor_Desembolsar
        		$param24 = $dataExcel[$i][23]; //Desembolso
        		$param25 = $dataExcel[$i][24]; //Fecha_Desembolso

        		$query_exist = "SELECT Id_Transaccion FROM Tiendabinner..Confirmacion_Pagos WHERE Id_Transaccion = ".$param3;

				$row_exist =  Yii::app()->db->createCommand($query_exist)->queryRow();

				if(empty($row_exist)){
					//no existe la cabecera
				
					$command = Yii::app()->db->createCommand("
					INSERT INTO Tiendabinner..Confirmacion_Pagos
					([TypeStatus]
		           ,[Status_Details]
		           ,[Id_Transaccion]
		           ,[Autorizacion]
		           ,[Valor_Venta]
		           ,[Fecha_Venta]
		           ,[Medio_Pago]
		           ,[Franquicia]
		           ,[N_Identif]
		           ,[Ref1]
		           ,[Ref2]
		           ,[Ref3]
		           ,[Descripcion]
		           ,[Comision]
		           ,[Porcentaje]
		           ,[Iva_Comision]
		           ,[Fee]
		           ,[IvaFee]
		           ,[ReteIca]
		           ,[ReteIva]
		           ,[ReteFTE]
		           ,[Gravamen]
		           ,[Valor_Desembolsar]
		           ,[Desembolso]
		           ,[Fecha_Desembolso]
		           )
					VALUES
					('".$param1."'
		           ,'".$param2."'
		           ,".$param3."
		           ,'".$param4."'
		           ,".$param5."
		           ,'".$param6."'
		           ,'".$param7."'
		           ,'".$param8."'
		           ,'".$param9."'
		           ,'".$param10."'
		           ,'".$param11."'
		           ,'".$param12."'
		           ,'".$param13."'
		           ,".$param14."
		           ,'".$param15."'
		           ,".$param16."
		           ,".$param17."
		           ,".$param18."
		           ,".$param19."
		           ,".$param20."
		           ,".$param21."
		           ,".$param22."
		           ,".$param23."
		           ,'".$param24."'
		           ,'".$param25."'
					)");


					$command->execute();
					$c++;

				}
			}

			$msj .= $c.' Registro(s) insertados.<br>'; 	

        	$resp = array('msj' => $msj);

        	echo json_encode($resp);

		}

	}


	public function actionDetTransTiendasWeb()
	{		
		$model=new Reporte;

		$this->render('det_trans_tiendas_web',array(
			'model'=>$model,
		));
	}

	public function actionUploadDetTransTiendasWeb()
	{		
		$opc = '';
       	$msj = '';

		$file_tmp = $_FILES['Reporte']['tmp_name']['archivo'];
        
        set_time_limit(0);

        // Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));   

		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/Reader/Excel2007.php';
		require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel/IOFactory.php';

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
        $objPHPExcel->setActiveSheetIndex(0);

        //Convierto la data de la Hoja en un arreglo
        $dataExcel = $objPHPExcel->getActiveSheet()->toArray();

        $filas = count($dataExcel);

        if($filas > 2){

       		$c = 0;
    	
    		//se ejecuta el sp por cada fila en el archivo

    		$msj = '<h5><i class="icon fas fa-info-circle"></i>Info</h5>';

    		$clean_number_caract = array("$", ",");

    		for($i = 1; $i <= $filas -1 ; $i++){

    			print_r($dataExcel[$i]);die;

        		$param1 = $dataExcel[$i][0]; //Id
        		$param2 = $dataExcel[$i][1]; //Autorizacion
        		$param3 = $dataExcel[$i][2];  //Recibo
        		$param4 = $dataExcel[$i][3];  //Valor
        		$param5 = $dataExcel[$i][4];  //Iva
        		$param6 = $dataExcel[$i][5];  //Tipo_Identificacion
        		$param7 = $dataExcel[$i][6];  //Identificacion
        		$param8 = $dataExcel[$i][7]; //Ref1
        		$param9 = $dataExcel[$i][8]; //Ref2
        		$param10 = $dataExcel[$i][9]; //Ref3
        		$param11 = $dataExcel[$i][10]; //Servicio
        		$param12 = $dataExcel[$i][11]; //Descripcion
        		$param13 = $dataExcel[$i][12]; //Fecha
        		$param14 = $dataExcel[$i][13]; //Nombre
        		$param15 = $dataExcel[$i][14]; //Franquisia
        		$param16 = $dataExcel[$i][15]; //Tipo
        		$param17 = $dataExcel[$i][16]; //Tarjeta
        		$param18 = $dataExcel[$i][17]; //Cuotas
        		$param19 = $dataExcel[$i][18]; //Origen
        		$param20 = $dataExcel[$i][19]; //Score
        		$param21 = $dataExcel[$i][20]; //Respuesta
        		$param22 = $dataExcel[$i][21]; //Status
        		$param23 = $dataExcel[$i][22]; //Pais

        		$query_exist = "SELECT Id FROM Tiendabinner..Det_Trans WHERE Id_Transaccion = ".$param1;

				$row_exist =  Yii::app()->db->createCommand($query_exist)->queryRow();

				if(empty($row_exist)){
					//no existe la cabecera
				
					$command = Yii::app()->db->createCommand("
					INSERT INTO Tiendabinner..Det_Trans
		           ([Id]
		           ,[Autorizacion]
		           ,[Recibo]
		           ,[Valor]
		           ,[Iva]
		           ,[Tipo_Identificacion]
		           ,[Identificacion]
		           ,[Ref1]
		           ,[Ref2]
		           ,[Ref3]
		           ,[Servicio]
		           ,[Descripcion]
		           ,[Fecha]
		           ,[Nombre]
		           ,[Franquisia]
		           ,[Tipo]
		           ,[Tarjeta]
		           ,[Cuotas]
		           ,[Origen]
		           ,[Score]
		           ,[Respuesta]
		           ,[Status]
		           ,[Pais])
		     VALUES
		           (".$param1."
		           ,'".$param2."'
		           ,'".$param3."'
		           ,".$param4."
		           ,".$param5."
		           ,'".$param6."'
		           ,'".$param7."'
		           ,'".$param8."'
		           ,'".$param9."'
		           ,'".$param10."'
		           ,'".$param11."'
		           ,'".$param12."'
		           ,'".$param13."'
		           ,'".$param14."'
		           ,'".$param15."'
		           ,'".$param16."'
		           ,'".$param17."'
		           ,".$param18."
		           ,'".$param19."'
		           ,".$param20."
		           ,'".$param21."'
		           ,'".$param22."'
		           ,'".$param23."'
					)");

					$command->execute();
					$c++;

				}
			}

			$msj .= $c.' Registro(s) insertados.<br>'; 	

        	$resp = array('msj' => $msj);

        	echo json_encode($resp);

		}

	}

	public function actionRemisionTuGo()
	{		
		$model=new Reporte;
		$model->scenario = 'remision_tu_go';

		$cos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_co FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2")->queryAll();

		$lista_co = array();
		foreach ($cos as $co) {
			$lista_co[$co['f350_id_co']] = $co['f350_id_co'];
		}

		$tipos = Yii::app()->db->createCommand("SELECT DISTINCT f350_id_tipo_docto FROM UnoEE1..t350_co_docto_contable WHERE f350_id_cia = 2 AND f350_id_tipo_docto like 'R%'")->queryAll();

		$lista_tipos = array();
		foreach ($tipos as $td) {
			$lista_tipos[$td['f350_id_tipo_docto']] = $td['f350_id_tipo_docto'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('remision_tu_go_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('remision_tu_go',array(
			'model'=>$model,
			'lista_co'=>$lista_co,
			'lista_tipos'=>$lista_tipos,
		));
	}

	public function actionElimErrorTrans()
	{		
		$model=new Reporte;
		$model->scenario = 'elim_error_trans';

		if(isset($_POST['Reporte']))
		{
			$c = 0;
			
			$array_cons = explode(",", $_POST['Reporte']['consecutivo']);
			$array_td = array('EPM' => 'PME', 'EPP' => 'PPE', 'EPT' => 'PTE');

			$array_cd_act = array();

			$td = $_POST['Reporte']['tipo'];
			$td_i = $array_td[$td];

			foreach ($array_cons as $cd) {

				if($cd != ""){

					$command = Yii::app()->db2->createCommand("
					UPDATE Repositorio_Datos.dbo.tbl_IN_Transf_29 SET Integrado_Pangea= 99 , Tipo_Docto='".$td_i."' WHERE Tipo_Docto='".$td."' AND Consec_Docto in (".$cd.") AND Integrado_Pangea = 4");

					if($command->execute() > 0){
						$c++;
						$array_cd_act[] = $cd;
					}
				}

			}

			if ($c > 0) {
				$cd_act = implode(",", $array_cd_act);
				$cad_res = $td. " (".$cd_act.")";
				Yii::app()->user->setFlash('success', "Se procesaron ".$c." documento(s), ".$cad_res.".");
			}else{
				Yii::app()->user->setFlash('warning', "No se proceso ningún documento.");	
			}			

		}

		$this->render('elim_error_trans',array(
			'model'=>$model,
		));
	}

	public function actionErrorTransf()
	{		
		$model=new Reporte;
		$model->scenario = 'error_transf';

		if(isset($_POST['Reporte']))
		{
			$model=$_POST['Reporte'];
			$this->renderPartial('error_transf_resp',array('model' => $model));	
		}

		$this->render('error_transf',array(
			'model'=>$model,
		));
	}

	public function actionErrorTransfPant()
	{		
		$fecha = $_POST['fecha'];

		$resultados = UtilidadesReportes::errortransfpantalla($fecha);

		echo $resultados;
	}

	public function actionLogCrossdocking()
	{		
		$model=new Reporte;
		$model->scenario = 'log_crossdocking';

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('log_crossdocking_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('log_crossdocking',array(
			'model'=>$model,
		));
	}

	public function actionCuadroComprasPt2()
	{		
		$model=new Reporte;
		$model->scenario = 'cuadro_compras_pt2';

		$estados = Yii::app()->db->createCommand("SELECT DISTINCT I_ESTADO FROM TH_ITEMS")->queryAll();

		$lista_estados = array();
		foreach ($estados as $es) {
			$lista_estados[$es['I_ESTADO']] = $es['I_ESTADO'];
		}
		
		$origenes = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 100")->queryAll();

		$lista_origenes = array();
		foreach ($origenes as $or) {
			$lista_origenes[$or['DESCRIPCION']] = $or['DESCRIPCION'];
		}

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$lineas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 700")->queryAll();

		$lista_lineas = array();
		foreach ($lineas as $li) {
			$lista_lineas[$li['DESCRIPCION']] = $li['DESCRIPCION'];
		}

		$oracle = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 950")->queryAll();

		$lista_oracle = array();
		foreach ($oracle as $ora) {
			$lista_oracle[$ora['DESCRIPCION']] = $ora['DESCRIPCION'];
		}

		$proveedor = Yii::app()->db->createCommand("SELECT DISTINCT f123_dato as Proveedor FROM UnoEE1..t123_mc_items_desc_tecnicas WHERE f123_id_Cia = 2 AND f123_rowid_campo = 675 AND f123_dato != '' ORDER BY 1")->queryAll();

		$lista_pro = array();
		foreach ($proveedor as $pro) {
			$lista_pro[$pro['Proveedor']] = $pro['Proveedor'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('cuadro_compras_pt2_resp',array('model' => $_POST['Reporte']));
		}

		$this->render('cuadro_compras_pt2',array(
			'model'=>$model,
			'lista_estados'=>$lista_estados,
			'lista_origenes'=>$lista_origenes,
			'lista_marcas'=>$lista_marcas,
			'lista_lineas'=>$lista_lineas,
			'lista_oracle'=>$lista_oracle, 
			'lista_pro'=>$lista_pro,			
		));
	}

	public function actionPedidosRetenidos()
	{		
		$model=new Reporte;
		$model->scenario = 'pedidos_retenidos';

		$this->renderPartial('pedidos_retenidos_resp');
	}

	public function actionSeguimientoRutas()
	{		
		$model=new Reporte;
		$model->scenario = 'seguimiento_rutas';

		$rutas = Yii::app()->db->createCommand("SELECT distinct f5790_id, f5790_descripcion FROM UnoEE1.dbo.t5790_sm_ruta WHERE f5790_id_cia = 2")->queryAll();
 
		$lista_rutas = array();
		foreach ($rutas as $rut) {
			$lista_rutas[$rut['f5790_id']] = $rut['f5790_descripcion'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('seguimiento_rutas_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('seguimiento_rutas',array(
			'model'=>$model,
			'lista_rutas'=>$lista_rutas,
		));
	}

	public function actionCalidadPqrs()
	{		
		$model=new Reporte;
		$model->scenario = 'calidad_pqrs';

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('calidad_pqrs_resp',array('model' => $model));	
		}

		$this->render('calidad_pqrs',array(
			'model'=>$model,		
		));
	}

	public function actionConsolidadoUn()
	{		
		$model=new Reporte;
		$model->scenario = 'consolidado_un';

		$un = Yii::app()->db->createCommand("SELECT DISTINCT Id_Criterio, Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan=300")->queryAll();

		$lista_un = array();
		foreach ($un as $lun) {
			$lista_un[$lun['Id_Criterio']] = $lun['DESCRIPCION'];
		}

		if(isset($_POST['Reporte']))
		{
			$model->attributes=$_POST['Reporte'];
			$this->renderPartial('consolidado_un_resp',array('model' => $model));	
		}

		$this->render('consolidado_un',array(
			'model'=>$model,
			'lista_un'=>$lista_un,		
		));
	}

	public function actionSegRutasMarcaCoord()
	{		
		$model=new Reporte;
		$model->scenario = 'seg_rutas_marca_coord';

		$marcas = Yii::app()->db->createCommand("SELECT DISTINCT Criterio_Descripcion AS DESCRIPCION FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = 500")->queryAll();

		$lista_marcas = array();
		foreach ($marcas as $ma) {
			$lista_marcas[$ma['DESCRIPCION']] = $ma['DESCRIPCION'];
		}

		$coordinadores = Yii::app()->db->createCommand("
			SELECT DISTINCT f200_id ,f200_razon_social FROM UnoEE1..t210_mm_vendedores 
			INNER JOIN UnoEE1..t200_mm_terceros ON f210_rowid_terc_supervisor = f200_rowid AND f200_ind_estado = 1
			WHERE f210_id_cia = 2 AND f200_id not IN (111157,111140,111141,111143,111149,111150,111151,111152,111153)
			ORDER BY 2"
		)->queryAll();

		$lista_coord = array();
		foreach ($coordinadores as $coord) {
			$lista_coord[$coord['f200_id']] = $coord['f200_razon_social'];
		}

		if(isset($_POST['Reporte']))
		{
			$this->renderPartial('seg_rutas_marca_coord_resp',array('model' => $_POST['Reporte']));	
		}

		$this->render('seg_rutas_marca_coord',array(
			'model'=>$model,
			'lista_marcas'=>$lista_marcas,
			'lista_coord'=>$lista_coord,
		));
	}

	public function actionCompInc()
	{		
		$model=new Reporte;
		$model->scenario = 'comp_inc';

		$this->render('comp_inc',array(
			'model'=>$model,
		));
	}

	public function actionCompIncPant()
	{		

		$tipo = $_POST['tipo'];
		$cons_inicial = $_POST['cons_inicial'];
		$cons_final = $_POST['cons_final'];

		$resultados = UtilidadesReportes::compincpantalla($tipo, $cons_inicial, $cons_final);

		echo $resultados;
	}
	
}

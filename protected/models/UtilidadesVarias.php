<?php

class UtilidadesVarias {
   
	public static function textofechahora($datetime) {

		$fecha = date_create($datetime);

		$diatxt = date_format($fecha, 'l');
		$dianro = date_format($fecha, 'd');
		$mestxt = date_format($fecha, 'F');
		$anionro = date_format($fecha, 'Y');

		$hora = date_format($fecha, 'g');
		$min = date_format($fecha, 'i');
		$jorn = date_format($fecha, 'A');
		
		// *********** traducciones y modificaciones de fechas a letras y a español ***********
		$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
		$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
		$diaesp=str_replace($ding, $desp, $diatxt);
		$mesesp=str_replace($ming, $mesp, $mestxt);

		return $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro.' - '.$hora.':'.$min.' '.$jorn;	

	}

	public static function textofecha($date) {

		$fecha = date_create($date);

		$diatxt = date_format($fecha, 'l');
		$dianro = date_format($fecha, 'd');
		$mestxt = date_format($fecha, 'F');
		$anionro = date_format($fecha, 'Y');
		
		// *********** traducciones y modificaciones de fechas a letras y a español ***********
		$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
		$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
		$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
		$diaesp=str_replace($ding, $desp, $diatxt);
		$mesesp=str_replace($ming, $mesp, $mestxt);

		return $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro;	
	}

	public static function textoestado1($opc) {

		if($opc == 0){
			return 'INACTIVO';
		}

		if($opc == 1){
			return 'ACTIVO';	
		}
	}


	public static function textoestado2($opc) {

		if($opc == 0){
			return 'NO';
		}

		if($opc == 1){
			return 'SI';	
		}
	}

	public static function textoavatar($opc) {

		if($opc == 1){
			return 'FEMENINO';
		}

		if($opc == 2){
			return 'MASCULINO';	
		}
	}

	public static function listaareas() {

		$areas = Yii::app()->db->createCommand("SELECT Id_Area, Area FROM Nomina_Real..TH_AREA WHERE Estado = 1 ORDER BY Area")->queryAll();

		$lista_areas = array();
		foreach ($areas as $ar) {
			$lista_areas[$ar['Id_Area']] = $ar['Area'];
		}

		return $lista_areas;
	}


	public static function descarea($id_area) {

		$area = Yii::app()->db->createCommand("SELECT Area FROM Nomina_Real..TH_AREA WHERE Id_Area = ".$id_area)->queryRow();
		return $area['Area'];
	}

	public static function listaareasusuario() {

		$array_areas_usuario = Yii::app()->user->getState('array_areas');
		$lista_areas = array();

		if(!empty($array_areas_usuario)){

			$areas_usuario = implode(",", $array_areas_usuario);
			$areas = Yii::app()->db->createCommand("SELECT Id_Area, Area FROM Nomina_Real..TH_AREA WHERE Estado = 1 AND Id_Area IN (".$areas_usuario.") ORDER BY Area")->queryAll();
			foreach ($areas as $ar) {
				$lista_areas[$ar['Id_Area']] = $ar['Area'];
			}

		}

		return $lista_areas;
	}

	public static function estadoexiststock($item, $cantidad) {
		
		$cant_min_stock_item = IItem::model()->findByPk($item)->Min_Stock;

		if($cantidad >= $cant_min_stock_item){
			return "";
		}else{
			return "bg-danger";
		}
		
	}

	public static function digitocontrolean13($digits){
  	
  		$digits =(string)$digits;
		
		$even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};

		$even_sum_three = $even_sum * 3;

		$odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};

		$total_sum = $even_sum_three + $odd_sum;
		
		$next_ten = (ceil($total_sum/10))*10;
		$check_digit = $next_ten - $total_sum;
		return $check_digit;

	}

	public static function digitocontrolean14($digits){
  	
  		$digits =(string)$digits;

  		//print_r($digits);die;
		
		$even_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10} + $digits{12};
		
		$even_sum_three = $even_sum * 3;
		
		$odd_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
		
		$total_sum = $even_sum_three + $odd_sum;
		
		$next_ten = (ceil($total_sum/10))*10;
		$check_digit = $next_ten - $total_sum;
		return $check_digit;

	}

	public static function listaplanescliente() {

		$planes_cliente = Yii::app()->db->createCommand("SELECT DISTINCT Id_Plan, Plan_Descripcion FROM TH_CRITERIOS_CLIENTES ORDER BY Id_Plan")->queryAll();

		$lista_planes = array();
		foreach ($planes_cliente as $pc) {
			$lista_planes[trim($pc['Id_Plan'])] = trim($pc['Plan_Descripcion']);
		}

		return $lista_planes;
	}

	public static function descplancliente($id_plan) {

		$plan = Yii::app()->db->createCommand("SELECT Plan_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".$id_plan)->queryRow();
		return $plan['Plan_Descripcion'];
	}

	public static function listaplanesitem() {

		$planes_item = Yii::app()->db->createCommand("SELECT DISTINCT Id_Plan, Plan_Descripcion FROM TH_CRITERIOS_ITEMS ORDER BY Id_Plan")->queryAll();

		$lista_planes = array();
		foreach ($planes_item as $pc) {
			$lista_planes[trim($pc['Id_Plan'])] = trim($pc['Plan_Descripcion']);
		}

		return $lista_planes;
	}

	public static function descplanitem($id_plan) {

		$plan = Yii::app()->db->createCommand("SELECT Plan_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = ".$id_plan)->queryRow();
		return $plan['Plan_Descripcion'];
	}

	public static function desccricliente($id_plan, $criterios) {

		$array_criterios = explode(",", $criterios);

		$texto_criterios = "";

		foreach ($array_criterios as $key => $value) {
			$q_criterio = Yii::app()->db->createCommand("SELECT Criterio_Descripcion FROM TH_CRITERIOS_CLIENTES WHERE Id_Plan = ".$id_plan." AND Id_Criterio = '".$value."'")->queryRow();
			$texto_criterios .= $q_criterio['Criterio_Descripcion'].", ";
		}

		$texto_criterios = substr ($texto_criterios, 0, -2);

		return $texto_criterios;
	}

	public static function desccriitem($id_plan, $criterios) {

		$array_criterios = explode(",", $criterios);

		$texto_criterios = "";

		foreach ($array_criterios as $key => $value) {
			$q_criterio = Yii::app()->db->createCommand("SELECT Criterio_Descripcion FROM TH_CRITERIOS_ITEMS WHERE Id_Plan = ".$id_plan." AND Id_Criterio = '".$value."'")->queryRow();
			$texto_criterios .= $q_criterio['Criterio_Descripcion'].", ";
		}

		$texto_criterios = substr ($texto_criterios, 0, -2);

		return $texto_criterios;
	}

	public function DescItem($Id_Item){

        $desc= Yii::app()->db->createCommand("
        	SELECT
            CONCAT(f120_id,' - ',f120_descripcion) AS DESCR
            FROM UnoEE1..t120_mc_items
            INNER JOIN UnoEE1..t121_mc_items_extensiones ON f120_rowid = f121_rowid_item
            WHERE f120_id_cia = 2 AND f120_id = '".$Id_Item."'"
        )->queryRow();

		return $desc['DESCR'];

    }
}

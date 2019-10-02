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
		$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
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
		$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
		$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
		$diaesp=str_replace($ding, $desp, $diatxt);
		$mesesp=str_replace($ming, $mesp, $mestxt);

		return $diaesp.", ".$dianro." de ".$mesesp." de ".$anionro;	
	}

	public static function estadoexiststock($item, $cantidad) {
		
		$cant_min_stock_item = IItem::model()->findByPk($item)->Min_Stock;

		if($cantidad >= $cant_min_stock_item){
			return "";
		}else{
			return "label-danger";
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

}

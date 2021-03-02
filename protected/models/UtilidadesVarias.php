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

    public static function envioemailwip($id, $email, $ruta_archivo) {


		$modelo_wip = Wip::model()->findByPk($id);

		$info = $modelo_wip->WIP;

		set_time_limit(0); 

		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.phpmailer.php');
		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.smtp.php');

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$cuenta = Yii::app()->params->email_send_emails;
		$password = Yii::app()->params->psw_send_emails;
		$de = Yii::app()->params->email_send_emails;
		$de_nombre = Yii::app()->params->name_send_emails_com;

		$para = $email;
		
		$asunto = "Detalle WIP ".$info;
	
		$hora = date('H');

	    if($hora >= 0 && $hora <= 12){
	        $mensaje_hora = "Buenos días,";
	    }

	    if($hora >= 13 && $hora <= 16){
	        $mensaje_hora = "Buenas tardes,";
	    }

	    if($hora >= 17 && $hora <= 23){
	        $mensaje_hora = "Buenas noches,";
	    }
		
		$mensaje = $mensaje_hora."<br><br>
		Se Adjunta documento PDF con detalle de WIP.<br>";

		$mail = new PHPMailer\PHPMailer\PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->Host = "secure.emailsrvr.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465;
	 	$mail->Username= $cuenta;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';
		$mail->From = $de;
 		$mail->FromName= $de_nombre;
		$mail->isHTML(true);
		$mail->Subject = $asunto;
		$mail->Body = $mensaje; 

		$mail->addAddress($email);

		$mail->AddAttachment( $ruta_archivo, "WIP ".$info.'.pdf');

		if(!$mail->send()){
			return 0;
		}else{
		 	return 1;
		}
	
	}

	public static function envioemailfichaitem($id, $tipo, $step, $array_emails, $obs) {

		//tipo -  0 revision, 1 avance en proceso
		//steps -  al proceso que se va a enviar el correo

		$url = Yii::app()->getBaseUrl(true).'/index.php?r=fichaItem/redirect&id='.$id;

		$modelo_fi = FichaItem::model()->findByPk($id);

		$hora = date('H');

	    if($hora >= 0 && $hora <= 12){
	        $mensaje_hora = "Buenos días,";
	    }

	    if($hora >= 13 && $hora <= 16){
	        $mensaje_hora = "Buenas tardes,";
	    }

	    if($hora >= 17 && $hora <= 23){
	        $mensaje_hora = "Buenas noches,";
	    }
		
		if($step == 10){
			if($modelo_fi->Tipo == 1){
				$asunto = "Se ha creado el ítem ".$modelo_fi->Codigo_Item;
				$mensaje = $mensaje_hora."<br><br>
				Se ha creado el ítem (".$modelo_fi->DescTipoProducto($modelo_fi->Tipo_Producto)." / ".$modelo_fi->Codigo_Item." - ".$modelo_fi->Descripcion_Corta.").<br><br>";
			}else{
				$asunto = "Se ha actualizado el ítem ".$modelo_fi->Codigo_Item;
				$mensaje = $mensaje_hora."<br><br>
				Se ha actualizado el ítem con Código ".$modelo_fi->Codigo_Item.".<br><br>";
			}
		}else{
			if($modelo_fi->Tipo == 1){
				if($tipo == 0){
					$asunto = 'Solicitud revisión de datos para creación de ítem';
					$mensaje = $mensaje_hora.'<br><br>
					Se ha solicitado una revisión de los datos registrados para la creación del ítem ('.$modelo_fi->DescTipoProducto($modelo_fi->Tipo_Producto).' / '.$modelo_fi->Descripcion_Corta.').<br><br>
					Observaciones: '.$obs.'<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}else{
					$asunto = 'Solicitud de información para creación de ítem';
					$mensaje = $mensaje_hora.'<br><br>
					Se ha solicitado que registre / revise los datos correpondientes a la creación del ítem ('.$modelo_fi->DescTipoProducto($modelo_fi->Tipo_Producto).' / '.$modelo_fi->Descripcion_Corta.').<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}
			}else{
				if($tipo == 0){
					$asunto = 'Solicitud revisión de datos para actualización de ítem';
					$mensaje = $mensaje_hora.'<br><br>
					Se ha solicitado una revisión de los datos registrados para la actualización del ítem con Código '.$modelo_fi->Codigo_Item.'.<br><br>
					Observaciones: '.$obs.'<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}else{
					$asunto = 'Solicitud revisión de datos para actualización de ítem';
					$mensaje = $mensaje_hora.'<br><br>
					Se ha solicitado que registre / revise los datos correpondientes a la actualización del ítem con Código '.$modelo_fi->Codigo_Item.'.<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}
			}
		}

		set_time_limit(0); 

		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.phpmailer.php');
		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.smtp.php');

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$cuenta = Yii::app()->params->email_send_emails;
		$password = Yii::app()->params->psw_send_emails;
		$de = Yii::app()->params->email_send_emails;
		$de_nombre = Yii::app()->params->name_send_emails_com;

		$mail = new PHPMailer\PHPMailer\PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->Host = "secure.emailsrvr.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465;
	 	$mail->Username= $cuenta;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';
		$mail->From = $de;
 		$mail->FromName= $de_nombre;
		$mail->isHTML(true);
		$mail->Subject = $asunto;
		$mail->Body = $mensaje;

		$num_notif = 0;

		foreach ($array_emails as $llave => $email) {
            $mail->addAddress($email);
            $num_notif++;
        }

		if(!$mail->send()){
			return 0;
		}else{
		 	return $num_notif;
		}
	
	}

	public static function emailsfichaitem($step) {
		switch ($step) {
		   	case 2:
		   		$users = FichaItemUsuario::model()->findByPk(1)->Id_Users_Notif;
		        break;
		    case 3:
		   		$users = FichaItemUsuario::model()->findByPk(2)->Id_Users_Notif;
		        break;
		    case 4:
		        $users = FichaItemUsuario::model()->findByPk(2)->Id_Users_Notif;
		        break;
		    case 5:
		        $users = FichaItemUsuario::model()->findByPk(3)->Id_Users_Notif;
		        break;
		    case 6:
				$users = FichaItemUsuario::model()->findByPk(3)->Id_Users_Notif;
		        break;
		    case 7:
				$users = FichaItemUsuario::model()->findByPk(4)->Id_Users_Notif;
		        break;
		    case 8:
		        $users = FichaItemUsuario::model()->findByPk(4)->Id_Users_Notif;
		        break;
		    case 9:
				$users = FichaItemUsuario::model()->findByPk(5)->Id_Users_Notif;
		        break;
		    case 10:
				$users = FichaItemUsuario::model()->findByPk(6)->Id_Users_Notif;
		        break; 
		}

		$q_emails = Yii::app()->db->createCommand("SELECT Correo FROM TH_USUARIOS WHERE Id_Usuario IN (".$users.")")->queryAll();

		$lista_email = array();
		foreach ($q_emails as $e) {
			$lista_email[] = $e['Correo'];
		}

		return $lista_email;
	
	}

	public static function usuariosfichaitem($step) {
		switch ($step) {
		   	case 1:
		   		$users = FichaItemUsuario::model()->findByPk(1)->Id_Users_Reg;
		        break;
		    case 2:
		   		$users = FichaItemUsuario::model()->findByPk(2)->Id_Users_Reg;
		        break;
		    case 3:
		        $users = FichaItemUsuario::model()->findByPk(3)->Id_Users_Reg;
		        break;
		    case 4:
		        $users = FichaItemUsuario::model()->findByPk(4)->Id_Users_Reg;
		        break;
		   	case 5:
		        $users = FichaItemUsuario::model()->findByPk(5)->Id_Users_Reg;
		        break; 
		}

		return explode(",", $users);
	
	}

	public static function listapaises(){
		return array(1 => 'COLOMBIA', 2 => 'ECUADOR', 3 => 'PERÚ', 4 => 'CHILE');
	}

	public static function descpaises($paises){

		$array_paises = explode(",", $paises);

		$texto_pais = "";

		foreach ($array_paises as $key => $value) {
			
			switch ($value) {
			    case 1:
			        $pais = 'COLOMBIA';
			        break;
			    case 2:
			        $pais = 'ECUADOR';
			        break;
			    case 3:
			        $pais = 'PERÚ';
			        break;
			    case 4:
			        $pais = 'CHILE';
			        break;
			}

			$texto_pais .= $pais.", ";
		}

		$texto = substr ($texto_pais, 0, -2);
		return $texto;

	}

	public static function envioemailpedido($id, $array_emails) {


		$url = Yii::app()->getBaseUrl(true).'/index.php?r=pedCom';

		$modelo_pedido = PedCom::model()->findByPk($id);

		$hora = date('H');

	    if($hora >= 0 && $hora <= 12){
	        $mensaje_hora = "Buenos días,";
	    }

	    if($hora >= 13 && $hora <= 16){
	        $mensaje_hora = "Buenas tardes,";
	    }

	    if($hora >= 17 && $hora <= 23){
	        $mensaje_hora = "Buenas noches,";
	    }
		
		$asunto = 'Se ha cargado un pedido';
		$mensaje = $mensaje_hora.'<br><br>
		El vendedor '.$modelo_pedido->idusuario->Nombres.' ha solicitado la revisión del pedido '.$id.'.<br><br>
		Pulse <a href="'.$url.'/update2&id='.$id.'"/>aqui</a> para ver la solicitud.';
		set_time_limit(0); 

		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.phpmailer.php');
		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.smtp.php');

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$cuenta = Yii::app()->params->email_send_emails;
		$password = Yii::app()->params->psw_send_emails;
		$de = Yii::app()->params->email_send_emails;
		$de_nombre = Yii::app()->params->name_send_emails_com;

		$mail = new PHPMailer\PHPMailer\PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->Host = "secure.emailsrvr.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465;
	 	$mail->Username= $cuenta;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';
		$mail->From = $de;
 		$mail->FromName= $de_nombre;
		$mail->isHTML(true);
		$mail->Subject = $asunto;
		$mail->Body = $mensaje;

		$num_notif = 0;

		foreach ($array_emails as $llave => $email) {
            $mail->addAddress($email);
            $num_notif++;
        }

		if(!$mail->send()){
			return 0;
		}else{
		 	return $num_notif;
		}
	
	}

	public static function emailssolprom($step) {
		switch ($step) {
		   	case 1:
		   		$users = SolPromUsuario::model()->findByPk(1)->Id_Users_Notif;
		        break;
		    case 2:
		   		$users = SolPromUsuario::model()->findByPk(2)->Id_Users_Notif;
		        break;
		    case 3:
		        $users = SolPromUsuario::model()->findByPk(3)->Id_Users_Notif;
		        break;
		    case 4:
		        $users = SolPromUsuario::model()->findByPk(4)->Id_Users_Notif;
		        break;
		    case 5:
				$users = SolPromUsuario::model()->findByPk(5)->Id_Users_Notif;
		        break;
		}

		$q_emails = Yii::app()->db->createCommand("SELECT Correo FROM TH_USUARIOS WHERE Id_Usuario IN (".$users.")")->queryAll();

		$lista_email = array();
		foreach ($q_emails as $e) {
			$lista_email[] = $e['Correo'];
		}

		return $lista_email;
	
	}

	public static function usuariossolprom($step) {
		switch ($step) {
		   	case 1:
		   		$users = SolPromUsuario::model()->findByPk(1)->Id_Users_Reg;
		        break;
		    case 2:
		   		$users = SolPromUsuario::model()->findByPk(2)->Id_Users_Reg;
		        break;
		    case 3:
		        $users = SolPromUsuario::model()->findByPk(3)->Id_Users_Reg;
		        break;
		    case 4:
		        $users = SolPromUsuario::model()->findByPk(4)->Id_Users_Reg;
		        break;
		   	case 5:
		        $users = SolPromUsuario::model()->findByPk(5)->Id_Users_Reg;
		        break; 
		}

		return explode(",", $users);
	
	}

	public static function envioemailsolprom($id, $array_emails) {

		$modelo_sol = SolProm::model()->findByPk($id);

		$url = Yii::app()->getBaseUrl(true).'/index.php?r=solProm/redirect&id='.$id;

		$hora = date('H');

	    if($hora >= 0 && $hora <= 12){
	        $mensaje_hora = "Buenos días,";
	    }

	    if($hora >= 13 && $hora <= 16){
	        $mensaje_hora = "Buenas tardes,";
	    }

	    if($hora >= 17 && $hora <= 23){
	        $mensaje_hora = "Buenas noches,";
	    }

	    if($modelo_sol->Estado == 4){
			
			$asunto = "Se ha completado la solicitud";
			$mensaje = $mensaje_hora."<br><br>
			Ha finalizado el proceso.<br><br>";
			
		}else{

			$asunto = 'Tiene una nueva solicitud para revisión de kit';
			$mensaje = $mensaje_hora.'<br><br>
			'.$modelo_sol->idusuarioact->Nombres.' ha solicitado la revisión del número de promoción '.$modelo_sol->Num_Sol.'.<br><br>
			Pulse <a href="'.$url.'"/>aqui</a> para ver la solicitud.';	

		}
		
		
		set_time_limit(0); 

		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.phpmailer.php');
		//require_once(Yii::app()->basePath . '\extensions\PHPMailer\class.smtp.php');

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$cuenta = Yii::app()->params->email_send_emails;
		$password = Yii::app()->params->psw_send_emails;
		$de = Yii::app()->params->email_send_emails;
		$de_nombre = Yii::app()->params->name_send_emails_com;

		$mail = new PHPMailer\PHPMailer\PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->Host = "secure.emailsrvr.com";
		$mail->SMTPAuth= true;
		$mail->Port = 465;
	 	$mail->Username= $cuenta;
		$mail->Password= $password;
		$mail->SMTPSecure = 'ssl';
		$mail->From = $de;
 		$mail->FromName= $de_nombre;
		$mail->isHTML(true);
		$mail->Subject = $asunto;
		$mail->Body = $mensaje;

		$num_notif = 0;

		foreach ($array_emails as $llave => $email) {
            $mail->addAddress($email);
            $num_notif++;
        }

		if(!$mail->send()){
			return 0;
		}else{
		 	return $num_notif;
		}
	
	}

}
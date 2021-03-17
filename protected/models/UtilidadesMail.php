<?php

class UtilidadesMail {

	public static function horamensaje() {
		//se define la hora de mensaje
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

		return $mensaje_hora;
	}

  
	public static function enviowip($id, $email, $ruta_archivo) {

		set_time_limit(0);
		
		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\Exception.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$host = Yii::app()->params->env_mail_host;
		$port = Yii::app()->params->env_mail_port;
		$smtpsecure = Yii::app()->params->env_mail_smtpsecure;
		$smtpauth = Yii::app()->params->env_mail_smtpauth;
		$smtpdebug = Yii::app()->params->env_mail_smtpdebug;
		$username = Yii::app()->params->env_mail_cuenta;
		$password = Yii::app()->params->env_mail_password;
		$correo_rem = Yii::app()->params->env_mail_cuenta_rem;
		$desc_correo_rem = Yii::app()->params->env_mail_desc_cuenta_rem;

		$modelo_wip = Wip::model()->findByPk($id);

		$info = $modelo_wip->WIP;

		$asunto = "Detalle WIP ".$info;
		
		$mensaje = UtilidadesMail::horamensaje()."<br><br>
		Se Adjunta documento PDF con detalle de WIP.<br>";

		$mail = new PHPMailer\PHPMailer\PHPMailer;
		
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';

		$mail->Host 	  = $host;
		$mail->Port       = $port;
		$mail->SMTPSecure = $smtpsecure;
		$mail->SMTPAuth   = $smtpauth;
		$mail->SMTPDebug  = $smtpdebug;
		$mail->Username   = $username;
		$mail->Password   = $password;
		$mail->From       = $correo_rem;
 		$mail->FromName   = $desc_correo_rem;
		
		$mail->isHTML(true);
		$mail->Subject = $asunto;
		$mail->Body = $mensaje; 

		$mail->addAddress($email);

		$mail->AddAttachment($ruta_archivo, "WIP ".$info.'.pdf');

		if(!$mail->send()){
		 	return 0;
		}else{
		 	return 1;
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

	public static function enviofichaitem($id, $tipo, $step, $array_emails, $obs) {

		//tipo -  0 revision, 1 avance en proceso
		//steps -  al proceso que se va a enviar el correo

		set_time_limit(0);
		
		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\Exception.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$host = Yii::app()->params->env_mail_host;
		$port = Yii::app()->params->env_mail_port;
		$smtpsecure = Yii::app()->params->env_mail_smtpsecure;
		$smtpauth = Yii::app()->params->env_mail_smtpauth;
		$smtpdebug = Yii::app()->params->env_mail_smtpdebug;
		$username = Yii::app()->params->env_mail_cuenta;
		$password = Yii::app()->params->env_mail_password;
		$correo_rem = Yii::app()->params->env_mail_cuenta_rem;
		$desc_correo_rem = Yii::app()->params->env_mail_desc_cuenta_rem;

		$url = Yii::app()->getBaseUrl(true).'/index.php?r=fichaItem/redirect&id='.$id;

		$modelo_fi = FichaItem::model()->findByPk($id);
		
		if($step == 10){
			if($modelo_fi->Tipo == 1){
				$asunto = "Se ha creado el ítem ".$modelo_fi->Codigo_Item;
				$mensaje = UtilidadesMail::horamensaje()."<br><br>
				Se ha creado el ítem (".$modelo_fi->DescTipoProducto($modelo_fi->Tipo_Producto)." / ".$modelo_fi->Codigo_Item." - ".$modelo_fi->Descripcion_Corta.").<br><br>";
			}else{
				$asunto = "Se ha actualizado el ítem ".$modelo_fi->Codigo_Item;
				$mensaje = UtilidadesMail::horamensaje()."<br><br>
				Se ha actualizado el ítem con Código ".$modelo_fi->Codigo_Item.".<br><br>";
			}
		}else{
			if($modelo_fi->Tipo == 1){
				if($tipo == 0){
					$asunto = 'Solicitud revisión de datos para creación de ítem';
					$mensaje = UtilidadesMail::horamensaje().'<br><br>
					Se ha solicitado una revisión de los datos registrados para la creación del ítem ('.$modelo_fi->DescTipoProducto($modelo_fi->Tipo_Producto).' / '.$modelo_fi->Descripcion_Corta.').<br><br>
					Observaciones: '.$obs.'<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}else{
					$asunto = 'Solicitud de información para creación de ítem';
					$mensaje = UtilidadesMail::horamensaje().'<br><br>
					Se ha solicitado que registre / revise los datos correpondientes a la creación del ítem ('.$modelo_fi->DescTipoProducto($modelo_fi->Tipo_Producto).' / '.$modelo_fi->Descripcion_Corta.').<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}
			}else{
				if($tipo == 0){
					$asunto = 'Solicitud revisión de datos para actualización de ítem';
					$mensaje = UtilidadesMail::horamensaje().'<br><br>
					Se ha solicitado una revisión de los datos registrados para la actualización del ítem con Código '.$modelo_fi->Codigo_Item.'.<br><br>
					Observaciones: '.$obs.'<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}else{
					$asunto = 'Solicitud revisión de datos para actualización de ítem';
					$mensaje = UtilidadesMail::horamensaje().'<br><br>
					Se ha solicitado que registre / revise los datos correpondientes a la actualización del ítem con Código '.$modelo_fi->Codigo_Item.'.<br><br>
					Pulse <a href="'.$url.'"/>aqui</a> para ver el estado de la solicitud.<br><br>
					Usuario que solicita: '.$modelo_fi->idusuarioact->Nombres.'.';
				}
			}
		}

		$mail = new PHPMailer\PHPMailer\PHPMailer;
		
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';

		$mail->Host 	  = $host;
		$mail->Port       = $port;
		$mail->SMTPSecure = $smtpsecure;
		$mail->SMTPAuth   = $smtpauth;
		$mail->SMTPDebug  = $smtpdebug;
		$mail->Username   = $username;
		$mail->Password   = $password;
		$mail->From       = $correo_rem;

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

	public static function enviopedidocom($id, $array_emails) {

		set_time_limit(0);
		
		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\Exception.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$host = Yii::app()->params->env_mail_host;
		$port = Yii::app()->params->env_mail_port;
		$smtpsecure = Yii::app()->params->env_mail_smtpsecure;
		$smtpauth = Yii::app()->params->env_mail_smtpauth;
		$smtpdebug = Yii::app()->params->env_mail_smtpdebug;
		$username = Yii::app()->params->env_mail_cuenta;
		$password = Yii::app()->params->env_mail_password;
		$correo_rem = Yii::app()->params->env_mail_cuenta_rem;
		$desc_correo_rem = Yii::app()->params->env_mail_desc_cuenta_rem;

		$url = Yii::app()->getBaseUrl(true).'/index.php?r=pedCom';

		$modelo_pedido = PedCom::model()->findByPk($id);

		
		$asunto = 'Se ha cargado un pedido';
		$mensaje = UtilidadesMail::horamensaje().'<br><br>
		El vendedor '.$modelo_pedido->idusuario->Nombres.' ha solicitado la revisión del pedido '.$id.'.<br><br>
		Pulse <a href="'.$url.'/update2&id='.$id.'"/>aqui</a> para ver la solicitud.';
		
		$mail = new PHPMailer\PHPMailer\PHPMailer;
		
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';

		$mail->Host 	  = $host;
		$mail->Port       = $port;
		$mail->SMTPSecure = $smtpsecure;
		$mail->SMTPAuth   = $smtpauth;
		$mail->SMTPDebug  = $smtpdebug;
		$mail->Username   = $username;
		$mail->Password   = $password;
		$mail->From       = $correo_rem;

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

	public static function enviosolprom($id, $array_emails, $obs) {

		set_time_limit(0);
		
		// Se inactiva el autoloader de yii
		spl_autoload_unregister(array('YiiBase','autoload'));  

		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\PHPMailer.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\SMTP.php');
		require_once(Yii::app()->basePath . '\extensions\PHPMailer\src\Exception.php');

		//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
		spl_autoload_register(array('YiiBase','autoload'));

		$host = Yii::app()->params->env_mail_host;
		$port = Yii::app()->params->env_mail_port;
		$smtpsecure = Yii::app()->params->env_mail_smtpsecure;
		$smtpauth = Yii::app()->params->env_mail_smtpauth;
		$smtpdebug = Yii::app()->params->env_mail_smtpdebug;
		$username = Yii::app()->params->env_mail_cuenta;
		$password = Yii::app()->params->env_mail_password;
		$correo_rem = Yii::app()->params->env_mail_cuenta_rem;
		$desc_correo_rem = Yii::app()->params->env_mail_desc_cuenta_rem;

		$modelo_sol = SolProm::model()->findByPk($id);

		$url = Yii::app()->getBaseUrl(true).'/index.php?r=solProm/redirect&id='.$id;

	    if($modelo_sol->Estado == 4){
			
			$asunto = "Se ha completado la solicitud";
			$mensaje = UtilidadesMail::horamensaje()."<br><br>
			la promoción número ".$modelo_sol->Num_Sol." ha cambiado a estado: EN ENSAMBLE.<br><br>";
			
		}else{
			if($modelo_sol->Estado == 2 && $modelo_sol->Estado_Rechazo == 3){
				$asunto = 'Tiene una nueva solicitud para revisión de kit';
				$mensaje = UtilidadesMail::horamensaje().'<br><br>
				'.$modelo_sol->idusuarioact->Nombres.' ha solicitado la revisión del número de promoción '.$modelo_sol->Num_Sol.'.<br><br>
				Observaciones: '.$obs.'.<br><br>
				Pulse <a href="'.$url.'"/>aqui</a> para ver la solicitud.';	

				$modelo_sol->Estado_Rechazo = null;
				$modelo_sol->save();
			}else{
				$asunto = 'Tiene una nueva solicitud para revisión de kit';
				$mensaje = UtilidadesMail::horamensaje().'<br><br>
				'.$modelo_sol->idusuarioact->Nombres.' ha solicitado la revisión del número de promoción '.$modelo_sol->Num_Sol.'.<br><br>
				Pulse <a href="'.$url.'"/>aqui</a> para ver la solicitud.';	
			}

		}
		
		$mail = new PHPMailer\PHPMailer\PHPMailer;
		
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';

		$mail->Host 	  = $host;
		$mail->Port       = $port;
		$mail->SMTPSecure = $smtpsecure;
		$mail->SMTPAuth   = $smtpauth;
		$mail->SMTPDebug  = $smtpdebug;
		$mail->Username   = $username;
		$mail->Password   = $password;
		$mail->From       = $correo_rem;
		
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
<?php

//clase creada para funciones relacionadas con el modelo de usuario

class UtilidadesUsuario {
   
	public static function adminperfilusuario($id_user, $array) {
		$array_per_selec = array();
		foreach ($array as $clave => $valor) {
		    
		    //se busca el registro para saber si tiene que ser creado 
		    $criteria=new CDbCriteria;
			$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Perfil=:Id_Perfil';
			$criteria->params=array(':Id_Usuario'=>$id_user,':Id_Perfil'=>$valor);
			$modelo_perfil_usuario=PerfilUsuario::model()->find($criteria);

			if(!is_null($modelo_perfil_usuario)){
				//si el estado es inactivo se cambia a activo, si ya esta activo no se realiza ninguna acción
				if($modelo_perfil_usuario->Estado == 0){
					$modelo_perfil_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$modelo_perfil_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$modelo_perfil_usuario->Estado = 1;
					if($modelo_perfil_usuario->save()){
						array_push($array_per_selec, intval($valor));
					}	
				}else{
					array_push($array_per_selec, intval($valor));	
				}
			}else{
				//se debe insertar un nuevo registro en la tabla
				$nuevo_perfil_usuario = new PerfilUsuario;
			    $nuevo_perfil_usuario->Id_Usuario = $id_user;
			    $nuevo_perfil_usuario->Id_Perfil = $valor;
				$nuevo_perfil_usuario->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
				$nuevo_perfil_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
				$nuevo_perfil_usuario->Fecha_Creacion = date('Y-m-d H:i:s');
				$nuevo_perfil_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
				$nuevo_perfil_usuario->Estado = 1;
				if($nuevo_perfil_usuario->save()){
					array_push($array_per_selec, intval($valor));
				}
			}
		}

		//se inactivan los perfiles que no vienen en el array
		$perfiles_excluidos = implode(",",$array_per_selec);
		$pe = str_replace("'", "", $perfiles_excluidos);
		$criteria=new CDbCriteria;
		$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Perfil NOT IN ('.$pe.')';
		$criteria->params=array(':Id_Usuario'=>$id_user);
		$modelo_perfil_usuario_inactivar=PerfilUsuario::model()->findAll($criteria);
		if(!is_null($modelo_perfil_usuario_inactivar)){
			foreach ($modelo_perfil_usuario_inactivar as $perfiles_inactivar) {
				//si el estado es activo se cambia a inactivo, si ya esta inactivo no se realiza ninguna acción
				if($perfiles_inactivar->Estado == 1){
					$perfiles_inactivar->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$perfiles_inactivar->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$perfiles_inactivar->Estado = 0;
					$perfiles_inactivar->save();
				}	
			}
		}
	}

	public static function perfilesactivos($id_user) {
		//opciones activas en el combo perfiles
		$criteria=new CDbCriteria;
		$criteria->condition='Id_Usuario=:Id_Usuario AND Estado=:Estado';
		$criteria->params=array(':Id_Usuario'=>$id_user,':Estado'=> 1);
		$array_per_activos = array();
		$perfiles_activos=PerfilUsuario::model()->findAll($criteria);
		foreach ($perfiles_activos as $perf_act) {
			array_push($array_per_activos, $perf_act->Id_Perfil);
		}

		return json_encode($array_per_activos);
	}

	public static function adminbodegausuario($id_user, $array) {
		$array_bodegas_selec = array();
		if(!empty($array)){

			foreach ($array as $clave => $valor) {
			    
			    //se busca el registro para saber si tiene que ser creado 
			    $criteria=new CDbCriteria;
				$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Bodega=:Id_Bodega';
				$criteria->params=array(':Id_Usuario'=>$id_user,':Id_Bodega'=>$valor);
				$modelo_bodega_usuario=BodegaUsuario::model()->find($criteria);

				if(!is_null($modelo_bodega_usuario)){
					//si el estado es inactivo se cambia a activo, si ya esta activo no se realiza ninguna acción
					if($modelo_bodega_usuario->Estado == 0){
						$modelo_bodega_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
						$modelo_bodega_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
						$modelo_bodega_usuario->Estado = 1;
						if($modelo_bodega_usuario->save()){
							array_push($array_bodegas_selec, intval($valor));
						}	
					}else{
						array_push($array_bodegas_selec, intval($valor));	
					}
				}else{
					//se debe insertar un nuevo registro en la tabla
					$nueva_bodega_usuario = new BodegaUsuario;
				    $nueva_bodega_usuario->Id_Usuario = $id_user;
				    $nueva_bodega_usuario->Id_Bodega = $valor;
					$nueva_bodega_usuario->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
					$nueva_bodega_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$nueva_bodega_usuario->Fecha_Creacion = date('Y-m-d H:i:s');
					$nueva_bodega_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$nueva_bodega_usuario->Estado = 1;
					if($nueva_bodega_usuario->save()){
						array_push($array_bodegas_selec, intval($valor));
					}
				}
			}

			//se inactivan las bodegas que no vienen en el array
			$bodegas_excluidas = implode(",",$array_bodegas_selec);
			$be = str_replace("'", "", $bodegas_excluidas);

			$criteria=new CDbCriteria;
			$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Bodega NOT IN ('.$be.')';
			$criteria->params=array(':Id_Usuario'=>$id_user);
			$modelo_bodega_usuario_inactivar=BodegaUsuario::model()->findAll($criteria);
			if(!is_null($modelo_bodega_usuario_inactivar)){
				foreach ($modelo_bodega_usuario_inactivar as $bodegas_inactivar) {
					//si el estado es activo se cambia a inactivo, si ya esta inactivo no se realiza ninguna acción
					if($bodegas_inactivar->Estado == 1){
						$bodegas_inactivar->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
						$bodegas_inactivar->Fecha_Actualizacion = date('Y-m-d H:i:s');
						$bodegas_inactivar->Estado = 0;
						$bodegas_inactivar->save();
					}	
				}
			}
		}else{
			//si el array llega vacio se inactivan todos los registros que esten activos 
		    $criteria=new CDbCriteria;
			$criteria->condition='Id_Usuario=:Id_Usuario AND Estado = 1';
			$criteria->params=array(':Id_Usuario'=>$id_user);
			$modelo_bodega_usuario=BodegaUsuario::model()->findAll($criteria);
			if(!is_null($modelo_bodega_usuario)){
				foreach ($modelo_bodega_usuario as $bodegas_act) {
					$bodegas_act->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$bodegas_act->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$bodegas_act->Estado = 0;
					$bodegas_act->save();
		
				}
			}
		}
	}

	public static function bodegasactivas($id_user) {
		//opciones activas en el combo bodegas
		$criteria=new CDbCriteria;
		$criteria->condition='Id_Usuario=:Id_Usuario AND Estado=:Estado';
		$criteria->params=array(':Id_Usuario'=>$id_user,':Estado'=> 1);
		$array_bod_activas = array();
		$bodegas_activas=BodegaUsuario::model()->findAll($criteria);
		foreach ($bodegas_activas as $bod_act) {
			array_push($array_bod_activas, $bod_act->Id_Bodega);
		}

		return json_encode($array_bod_activas);
	}

	public static function admintipodoctousuario($id_user, $array) {
		$array_td_selec = array();
		if(!empty($array)){

			foreach ($array as $clave => $valor) {
			    
			    //se busca el registro para saber si tiene que ser creado 
			    $criteria=new CDbCriteria;
				$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Tipo_Docto=:Id_Tipo_Docto';
				$criteria->params=array(':Id_Usuario'=>$id_user,':Id_Tipo_Docto'=>$valor);
				$modelo_td_usuario=TipoDoctoUsuario::model()->find($criteria);

				if(!is_null($modelo_td_usuario)){
					//si el estado es inactivo se cambia a activo, si ya esta activo no se realiza ninguna acción
					if($modelo_td_usuario->Estado == 0){
						$modelo_td_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
						$modelo_td_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
						$modelo_td_usuario->Estado = 1;
						if($modelo_td_usuario->save()){
							array_push($array_td_selec, intval($valor));
						}	
					}else{
						array_push($array_td_selec, intval($valor));	
					}
				}else{
					//se debe insertar un nuevo registro en la tabla
					$nuevo_td_usuario = new TipoDoctoUsuario;
				    $nuevo_td_usuario->Id_Usuario = $id_user;
				    $nuevo_td_usuario->Id_Tipo_Docto = $valor;
					$nuevo_td_usuario->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
					$nuevo_td_usuario->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$nuevo_td_usuario->Fecha_Creacion = date('Y-m-d H:i:s');
					$nuevo_td_usuario->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$nuevo_td_usuario->Estado = 1;
					if($nuevo_td_usuario->save()){
						array_push($array_td_selec, intval($valor));
					}
				}
			}

			//se inactivan los tipos de docto que no vienen en el array
			$td_excluidos = implode(",",$array_td_selec);
			$tde = str_replace("'", "", $td_excluidos);

			$criteria=new CDbCriteria;
			$criteria->condition='Id_Usuario=:Id_Usuario AND Id_Tipo_Docto NOT IN ('.$tde.')';
			$criteria->params=array(':Id_Usuario'=>$id_user);
			$modelo_td_usuario_inactivar=TipoDoctoUsuario::model()->findAll($criteria);
			if(!is_null($modelo_td_usuario_inactivar)){
				foreach ($modelo_td_usuario_inactivar as $td_inactivar) {
					//si el estado es activo se cambia a inactivo, si ya esta inactivo no se realiza ninguna acción
					if($td_inactivar->Estado == 1){
						$td_inactivar->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
						$td_inactivar->Fecha_Actualizacion = date('Y-m-d H:i:s');
						$td_inactivar->Estado = 0;
						$td_inactivar->save();
					}	
				}
			}
		}else{
			//si el array llega vacio se inactivan todos los registros que esten activos 
		    $criteria=new CDbCriteria;
			$criteria->condition='Id_Usuario=:Id_Usuario AND Estado = 1';
			$criteria->params=array(':Id_Usuario'=>$id_user);
			$modelo_td_usuario=TipoDoctoUsuario::model()->findAll($criteria);
			if(!is_null($modelo_td_usuario)){
				foreach ($modelo_td_usuario as $td_act) {
					$td_act->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$td_act->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$td_act->Estado = 0;
					$td_act->save();
		
				}
			}
		}
	}

	public static function tiposdoctoactivos($id_user) {
		//opciones activas en el combo tipos de documento
		$criteria=new CDbCriteria;
		$criteria->condition='Id_Usuario=:Id_Usuario AND Estado=:Estado';
		$criteria->params=array(':Id_Usuario'=>$id_user,':Estado'=> 1);
		$array_td_activos = array();
		$tipos_docto_activos=TipoDoctoUsuario::model()->findAll($criteria);
		foreach ($tipos_docto_activos as $td_act) {
			array_push($array_td_activos, $td_act->Id_Tipo_Docto);
		}

		return json_encode($array_td_activos);
	}

}

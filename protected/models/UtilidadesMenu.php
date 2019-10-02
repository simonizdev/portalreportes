<?php

//clase creada para funciones relacionadas con el modelo de menu para perfiles

class UtilidadesMenu {
   
	public static function setmenu() {
		//opcion que muestra las opciones de menu para un nuevo perfil

		$array_menu = array();

		$criteria=new CDbCriteria;
		$criteria->condition='Id_Padre=:Id_Padre AND Estado=:Estado AND Id_Menu != 1';
		$criteria->params=array(':Id_Padre'=>1,':Estado'=> 1);
		$criteria->order= 'orden';
		$opciones_raiz=Menu::model()->findAll($criteria);
		if (!is_null($opciones_raiz)) {
		    foreach ($opciones_raiz as $or) {
		        $id1 = $or->Id_Menu;
		        $text1 = $or->Descripcion;
		        $criteria1=new CDbCriteria;
		        $criteria1->condition='Id_Padre=:Id_Padre AND Estado=:Estado';
		        $criteria1->params=array(':Id_Padre'=> $id1,':Estado'=> 1);
		        $criteria1->order= 'orden';
		        $hijos1=Menu::model()->findAll($criteria1);
		        $array_menu2 = array(); 
		        if (!is_null($hijos1)) {
		            foreach ($hijos1 as $h1) {
		                $id2 = $h1->Id_Menu;
		                $text2 = $h1->Descripcion;
		                $criteria2=new CDbCriteria;
		                $criteria2->condition='Id_Padre=:Id_Padre AND Estado=:Estado';
		                $criteria2->params=array(':Id_Padre'=> $id2,':Estado'=> 1);
		                $criteria2->order= 'orden';
		                $hijos2=Menu::model()->findAll($criteria2); 
		                $array_menu3 = array();
		                if (!is_null($hijos2)) {
		                    foreach ($hijos2 as $h2) {
		                        $id3 = $h2->Id_Menu;
		                        $text3 = $h2->Descripcion;
		                        $array_menu3[] = array('id' => $id3, 'text' => $text3, 'children' => array());
		                    }    
		                }
		                $array_menu2[] = array('id' => $id2, 'text' => $text2, 'children' => $array_menu3);
		                reset($array_menu3);
		            }

		        $array_menu[] = array('id' => $id1, 'text' => $text1, 'children' => $array_menu2);
		        reset($array_menu2);

		        }else{
		            $array_menu[] = array('id' => $id1, 'text' => $text1, 'children' => array());
		        }   
		    }
		}
		
		return json_encode($array_menu);
	}

	public static function getmenu($id_perfil) {
		//opcion para cargar las opciones de menu por perfil

		//se arma un array con las opciones actuales de el perfil
		$criteria=new CDbCriteria;
		$criteria->condition='Id_Perfil=:Id_Perfil AND Estado=:Estado';
		$criteria->params=array(':Id_Perfil'=>$id_perfil,':Estado'=> 1);
		
		$array_opciones_selec = array();
		$modelo_opciones_selec=MenuPerfil::model()->findAll($criteria);
		if(!is_null($modelo_opciones_selec)){
			foreach ($modelo_opciones_selec as $mos) {
				array_push($array_opciones_selec, $mos->Id_Menu);
			}
		}

		$array_menu = array();

		$criteria=new CDbCriteria;
		$criteria->condition='Id_Padre=:Id_Padre AND Estado=:Estado AND Id_Menu != 1';
		$criteria->params=array(':Id_Padre'=>1,':Estado'=> 1);
		$criteria->order= 'orden';
		$opciones_raiz=Menu::model()->findAll($criteria);
		if (!is_null($opciones_raiz)) {
		    foreach ($opciones_raiz as $or) {
		        $id1 = $or->Id_Menu;
		        $text1 = $or->Descripcion;
		        if (in_array($id1, $array_opciones_selec)) { $checked1 = 1; } else { $checked1 = 0; }
		        $criteria1=new CDbCriteria;
		        $criteria1->condition='Id_Padre=:Id_Padre AND Estado=:Estado';
		        $criteria1->params=array(':Id_Padre'=> $id1,':Estado'=> 1);
		        $criteria1->order= 'orden';
		        $hijos1=Menu::model()->findAll($criteria1);
		        $array_menu2 = array(); 
		        if (!is_null($hijos1)) {
		            foreach ($hijos1 as $h1) {
		                $id2 = $h1->Id_Menu;
		                $text2 = $h1->Descripcion;
		                if (in_array($id2, $array_opciones_selec)) { $checked2 = 1; } else { $checked2 = 0; }
		                $criteria2=new CDbCriteria;
		                $criteria2->condition='Id_Padre=:Id_Padre AND Estado=:Estado';
		                $criteria2->params=array(':Id_Padre'=> $id2,':Estado'=> 1);
		                $criteria2->order= 'orden';
		                $hijos2=Menu::model()->findAll($criteria2); 
		                $array_menu3 = array();
		                if (!is_null($hijos2)) {
		                    foreach ($hijos2 as $h2) {
		                        $id3 = $h2->Id_Menu;
		                        $text3 = $h2->Descripcion;
		                        if (in_array($id3, $array_opciones_selec)) { $checked3 = 1; } else { $checked3  = 0; }
		                        $array_menu3[] = array('id' => $id3, 'text' => $text3, 'check' => $checked3, 'children' => array());
		                    }    
		                }
		                $array_menu2[] = array('id' => $id2, 'text' => $text2, 'check' => $checked2, 'children' => $array_menu3);
		                reset($array_menu3);
		            }

		        $array_menu[] = array('id' => $id1, 'text' => $text1, 'check' => $checked1, 'children' => $array_menu2);
		        reset($array_menu2);

		        }else{
		            $array_menu[] = array('id' => $id1, 'text' => $text1, 'check' => $checked1, 'children' => array());
		        }   
		    }
		}
		
		return json_encode($array_menu);	
	}

	public static function adminmenuperfil($opcion, $id_perfil, $array) {
		//opcion para guardar o modificar las opciones de menu por perfil
		//opcion: 1. crear, 2. modificar
		if($opcion == 1){
			//se recorre el arreglo y por cada opcion se crea un registro en menu perfil
			foreach ($array as $key => $value) {
				$nueva_opcion_perfil = new MenuPerfil;
				$nueva_opcion_perfil->Id_Perfil = $id_perfil;
				$nueva_opcion_perfil->Id_Menu = $value;
				$nueva_opcion_perfil->Estado = 1;
				$nueva_opcion_perfil->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
				$nueva_opcion_perfil->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
				$nueva_opcion_perfil->Fecha_Creacion = date('Y-m-d H:i:s');
				$nueva_opcion_perfil->Fecha_Actualizacion = date('Y-m-d H:i:s');
				$nueva_opcion_perfil->save();
			}
		} else {

			//se arma un array con las opciones actuales de el perfil
			$criteria=new CDbCriteria;
			$criteria->condition='Id_Perfil=:Id_Perfil AND Estado=:Estado';
			$criteria->params=array(':Id_Perfil'=>$id_perfil,':Estado'=> 1);
		
			$array_opciones_actuales = array();

			$modelo_opciones_act=MenuPerfil::model()->findAll($criteria);
			if(!is_null($modelo_opciones_act)){
				foreach ($modelo_opciones_act as $moa) {
					array_push($array_opciones_actuales, $moa->Id_Menu);
				}
			}

			$opciones_add = array_diff($array, $array_opciones_actuales);
			$opciones_inac = array_diff($array_opciones_actuales, $array);

			//se recorren las opciones a añadir: primero se buscan para saber si no existen
			foreach ($opciones_add as $key => $value) {
				$criteria=new CDbCriteria;
				$criteria->condition='Id_Menu=:Id_Menu AND Id_Perfil=:Id_Perfil AND Estado=:Estado';
				$criteria->params=array(':Id_Menu'=>$value,':Id_Perfil'=>$id_perfil,':Estado'=> 0);
				$modelo_opcion=MenuPerfil::model()->find($criteria);
				if(!is_null($modelo_opcion)){
					$modelo_opcion->Estado = 1;
					$modelo_opcion->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$modelo_opcion->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$modelo_opcion->save();
				}else{
					$nueva_opcion_perfil = new MenuPerfil;
					$nueva_opcion_perfil->Id_Perfil = $id_perfil;
					$nueva_opcion_perfil->Id_Menu = $value;
					$nueva_opcion_perfil->Estado = 1;
					$nueva_opcion_perfil->Id_Usuario_Creacion = Yii::app()->user->getState('id_user');
					$nueva_opcion_perfil->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
					$nueva_opcion_perfil->Fecha_Creacion = date('Y-m-d H:i:s');
					$nueva_opcion_perfil->Fecha_Actualizacion = date('Y-m-d H:i:s');
					$nueva_opcion_perfil->save();
				}
			}

			//se recorren las opciones a inactivar
			foreach ($opciones_inac as $key => $value) {
				$criteria=new CDbCriteria;
				$criteria->condition='Id_Menu=:Id_Menu AND Id_Perfil=:Id_Perfil';
				$criteria->params=array(':Id_Menu'=>$value,':Id_Perfil'=>$id_perfil);
				$modelo_opcion=MenuPerfil::model()->find($criteria);
				$modelo_opcion->Estado = 0;
				$modelo_opcion->Id_Usuario_Actualizacion = Yii::app()->user->getState('id_user');
				$modelo_opcion->Fecha_Actualizacion = date('Y-m-d H:i:s');
				$modelo_opcion->save();
			}
		}

	}

	public static function loadmenu() {
		//se obtienen los perfiles asociados al usuario
		$perfiles = implode(",", Yii::app()->user->getState('array_perfiles'));

		$array_opciones_menu = array();
		//se traen los id de menu asociados al perfil o perfiles del usuario
		$criteria = new CDbCriteria;
		$criteria->select = 'DISTINCT Id_Menu';
		$criteria->condition='Id_Perfil in ('.$perfiles.') AND Estado=:Estado';
		$criteria->params=array(':Estado'=> 1);
		$opciones_x_perfiles=MenuPerfil::model()->findAll($criteria);
		foreach ($opciones_x_perfiles as $oxp) {
		    array_push($array_opciones_menu, $oxp->Id_Menu);   
		}

		$array_menu = array();

		$criteria=new CDbCriteria;
		$criteria->condition='Id_Padre=:Id_Padre AND Estado=:Estado AND Id_Menu != 1';
		$criteria->params=array(':Id_Padre'=>1,':Estado'=> 1);
		$criteria->order= 'orden';
		$opciones_raiz=Menu::model()->findAll($criteria);
		if (!is_null($opciones_raiz)) {
		    foreach ($opciones_raiz as $or) {
		        $id1 = $or->Id_Menu;
		        $text1 = $or->Descripcion;
		        $link1 = $or->Link;
		        $icon1 = $or->Font_Icon;
		        if (in_array($id1, $array_opciones_menu)) { $visible1 = 1; } else { $visible1 = 0; }
		        $criteria1=new CDbCriteria;
		        $criteria1->condition='Id_Padre=:Id_Padre AND Estado=:Estado';
		        $criteria1->params=array(':Id_Padre'=> $id1,':Estado'=> 1);
		        $criteria1->order= 'orden';
		        $hijos1=Menu::model()->findAll($criteria1);
		        $array_menu2 = array(); 
		        if (!is_null($hijos1)) {
		            foreach ($hijos1 as $h1) {
		                $id2 = $h1->Id_Menu;
		                $text2 = $h1->Descripcion;
		                $link2 = $h1->Link;
		        		$icon2 = $h1->Font_Icon;
		                if (in_array($id2, $array_opciones_menu)) { $visible2 = 1; } else { $visible2 = 0; }
		                $criteria2=new CDbCriteria;
		                $criteria2->condition='Id_Padre=:Id_Padre AND Estado=:Estado';
		                $criteria2->params=array(':Id_Padre'=> $id2,':Estado'=> 1);
		                $criteria2->order= 'orden';
		                $hijos2=Menu::model()->findAll($criteria2); 
		                $array_menu3 = array();
		                if (!is_null($hijos2)) {
		                    foreach ($hijos2 as $h2) {
		                        $id3 = $h2->Id_Menu;
		                        $text3 = $h2->Descripcion;
		                        $link3 = $h2->Link;
		        				$icon3 = $h2->Font_Icon;
		                        if (in_array($id3, $array_opciones_menu)) { $visible3 = 1; } else { $visible3  = 0; }
		                        if($visible3 == 1){
		                        	$array_menu3[] = array('id' => $id3, 'text' => $text3, 'link' => $link3, 'icon' => $icon3, 'children' => array());	
		                        }    
		                    }    
		                }
		                if($visible2 == 1){
		                	$array_menu2[] = array('id' => $id2, 'text' => $text2, 'link' => $link2, 'icon' => $icon2, 'children' => $array_menu3);
		                	reset($array_menu3);	
                        }
		                
		            }

		        	if($visible1 == 1){    
		        		$array_menu[] = array('id' => $id1, 'text' => $text1, 'link' => $link1, 'icon' => $icon1, 'children' => $array_menu2);
		        		reset($array_menu2);
	        		}
		        }else{
		        	if($visible1 == 1){  
		            	$array_menu[] = array('id' => $id1, 'text' => $text1, 'link' => $link1, 'icon' => $icon1, 'children' => array());
		        	}
		        }   
		    }
		}

	return json_encode($array_menu);

	}


}

<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
  /**
   * Authenticates a user.
   * The example implementation makes sure if the username and password
   * are both 'demo'.
   * In practical applications, this should be changed to authenticate
   * against some persistent user identity storage (e.g. database).
   * @return boolean whether authentication succeeds.
   */

  const ERROR_USERNAME_NOT_FOUND = 3;
  const ERROR_USERNAME_INACTIVE = 4;
  const ERROR_PASSWORD_NO_VALID = 5;
  const ERROR_PERFILES_NOT_FOUND = 6;

  public function authenticate()
  {
    //se busca el registro en usuarios
    $modelousuario=Usuario::model()->findByAttributes(array('Usuario'=>$this->username));

    if (is_null($modelousuario)) {
      //no se encontro usuario
        $this->errorCode=self::ERROR_USERNAME_NOT_FOUND;
    } else if ($modelousuario->Estado == 0) {
        //usuario inactivo
        $this->errorCode=self::ERROR_USERNAME_INACTIVE;
    } else if ($modelousuario->Password !== sha1($this->password)) {
        //password incorrecto
        $this->errorCode=self::ERROR_PASSWORD_NO_VALID;
    } else {
      //usuario valido

      //permisos para actualizar registros
      $permiso_act = false;

      //se verifica cuantos perfiles tiene asociado el usuario
      $criteria = new CDbCriteria;
      $criteria->join ='LEFT JOIN TH_PERFIL p ON t.Id_Perfil = p.Id_Perfil';
      $criteria->condition = 't.Id_Usuario = :Id_Usuario AND t.Estado = :Estado';
      $criteria->order = 'p.Descripcion';
      $criteria->params = array(":Id_Usuario" => $modelousuario->Id_Usuario, ":Estado" => 1);
      $perfiles_usuario=PerfilUsuario::model()->findAll($criteria);

      $num_perf=0;
      foreach ($perfiles_usuario as $pu) {
        if($pu->idperfil->Estado != 0){
          $num_perf++;
        }
      }

      //se verifica cuantas bodegas tiene asociado el usuario
      $criteria = new CDbCriteria;
      $criteria->join ='LEFT JOIN TH_I_BODEGA b ON t.Id_Bodega = b.Id';
      $criteria->condition = 't.Id_Usuario = :Id_Usuario AND t.Estado = :Estado';
      $criteria->order = 'b.Descripcion';
      $criteria->params = array(":Id_Usuario" => $modelousuario->Id_Usuario, ":Estado" => 1);
      $bodegas_usuario=BodegaUsuario::model()->findAll($criteria);

      //se verifica cuantos tipos de docto tiene asociado el usuario
      $criteria = new CDbCriteria;
      $criteria->join ='LEFT JOIN TH_I_TIPO_DOCTO td ON t.Id_Tipo_Docto = td.Id';
      $criteria->condition = 't.Id_Usuario = :Id_Usuario AND t.Estado = :Estado';
      $criteria->order = 'td.Descripcion';
      $criteria->params = array(":Id_Usuario" => $modelousuario->Id_Usuario, ":Estado" => 1);
      $td_usuario=TipoDoctoUsuario::model()->findAll($criteria);

      //se verifica cuantas areas tiene asociado el usuario
      $criteria = new CDbCriteria;
      $criteria->join ='LEFT JOIN Nomina_Real..TH_AREA a ON t.Id_Area = a.Id_Area';
      $criteria->condition = 't.Id_Usuario = :Id_Usuario AND t.Estado = :Estado';
      $criteria->order = 'a.Area';
      $criteria->params = array(":Id_Usuario" => $modelousuario->Id_Usuario, ":Estado" => 1);
      $areas_usuario=AreaUsuario::model()->findAll($criteria);
      
      if ($num_perf == 0){
        //usuario sin perfiles asociados o perfiles asociados inactivos
        $this->errorCode=self::ERROR_PERFILES_NOT_FOUND;
      } else {

        $array_perfiles = array();
        foreach ($perfiles_usuario as $p) {
          if($p->idperfil->Estado != 0){
              array_push($array_perfiles, $p->Id_Perfil);
              if($p->idperfil->Modificacion_Reg != 0){
                $permiso_act = true; 
              }
          } 
        }

        $array_bodegas = array();
        foreach ($bodegas_usuario as $b) {
          if($b->idbodega->Estado != 0){
              array_push($array_bodegas, $b->Id_Bodega);
          } 
        }

        $array_td = array();
        foreach ($td_usuario as $tdu) {
          if($tdu->idtipodocto->Estado != 0){
              array_push($array_td, $tdu->Id_Tipo_Docto);
          } 
        }

        $array_areas = array();
        foreach ($areas_usuario as $a) {

          $est_area = Yii::app()->db->createCommand("SELECT Estado FROM Nomina_Real..TH_AREA WHERE Id_Area = ".$a->Id_Area)->queryRow();
          $estado = $est_area['Estado'];

          if($estado != 0){
              array_push($array_areas, $a->Id_Area);
          } 
        }

        $this->setState('id_user', $modelousuario->Id_Usuario);
        $this->setState('name_user', strtoupper($modelousuario->Nombres));
        $this->setState('username_user', strtoupper($modelousuario->Usuario));
        $this->setState('email_user', $modelousuario->Correo);
        $this->setState('avatar_user', $modelousuario->Avatar);
        $this->setState('array_perfiles', $array_perfiles);
        $this->setState('array_bodegas', $array_bodegas);
        $this->setState('array_td', $array_td);
        $this->setState('array_areas', $array_areas);
        $this->setState('permiso_act', $permiso_act);
        $this->errorCode=self::ERROR_NONE;

      }
    }

    return $this->errorCode;
  }
}
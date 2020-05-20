<?php

/**
 * This is the model class for table "TH_USUARIOS".
 *
 * The followings are the available columns in table 'TH_USUARIOS':
 * @property integer $Id_Usuario
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Usuario
 * @property string $Nombres
 * @property string $Correo
 * @property string $Password
 * @property boolean $Estado
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 * @property integer $Avatar
 *
 * The followings are the available model relations:
 * @property THEMPRESAUSUARIO[] $tHEMPRESAUSUARIOs
 * @property THEMPRESAUSUARIO[] $tHEMPRESAUSUARIOs1
 * @property THEMPRESAUSUARIO[] $tHEMPRESAUSUARIOs2
 * @property THEMPRESA[] $tHEMPRESAs
 * @property THEMPRESA[] $tHEMPRESAs1
 * @property Usuario $idUsuarioActualizacion
 * @property Usuario[] $tHUSUARIOSes
 * @property Usuario $idUsuarioCreacion
 * @property Usuario[] $tHUSUARIOSes1
 * @property THPERFILUSUARIO[] $tHPERFILUSUARIOs
 * @property THPERFILUSUARIO[] $tHPERFILUSUARIOs1
 * @property THPERFIL[] $tHPERFILs
 * @property THPERFIL[] $tHPERFILs1
 * @property THMENUPERFIL[] $tHMENUPERFILs
 * @property THMENUPERFIL[] $tHMENUPERFILs1
 * @property THMENU[] $tHMENUs
 * @property THMENU[] $tHMENUs1
 */
class Usuario extends CActiveRecord
{
	
	public $usuario_creacion;
	public $usuario_actualizacion;
	public $perfiles;
	public $areas;
	public $bodegas;
	public $tipos_docto;
	public $old_password;
    public $new_password;
    public $repeat_password;
    public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_USUARIOS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Nombres, Correo, Usuario, Password, Estado, Avatar, perfiles','required','on'=>'create'),
			array('Nombres, Correo, Usuario, Estado, Avatar, perfiles','required','on'=>'update'),
			array('Usuario','unique','on'=>'create'),
			array('Usuario', 'uniqueUsuario','on'=>'update'),
			array('Correo','email', 'message'=>'E-mail no valido' ,'on'=>'create , update'),
			array('Password', 'match', 'pattern'=>'/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/', 'message'=>'Se requieren de 8 a 10 caracteres, <br> por lo menos una letra y un número, <br> sin caracteres especiales.','on'=>'create , update'),
			//array('Nombres, Correo, Usuario, Password, Estado', 'required'),
			array('Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Usuario', 'length', 'max'=>30),
			array('Nombres', 'length', 'max'=>60),
			array('Correo', 'length', 'max'=>50),
			array('Password', 'length', 'max'=>200),
			array('Fecha_Creacion, Fecha_Actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Usuario, usuario_creacion, usuario_actualizacion, Usuario, Nombres, Correo, Estado, Fecha_Creacion, Fecha_Actualizacion, orderby', 'safe', 'on'=>'search'),
			//reglas para el cambio de credenciales
			array('old_password, new_password, repeat_password', 'required', 'on' => 'profile'),
        	array('old_password', 'comparePassword', 'on' => 'profile'),
        	array('new_password', 'match', 'pattern'=>'/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/', 'message'=>'Se requieren de 8 a 10 caracteres, <br> por lo menos una letra y un número, sin caracteres especiales.','on'=>'profile'),
        	array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'profile'),
		);
	}

	public function uniqueUsuario($attribute,$params){
        
  		//se busca el mismo nombre de usuario con id diferente al registro afectado
        $criteria=new CDbCriteria;
		$criteria->condition='Usuario=:Usuario AND Id_Usuario!=:Id_Usuario';
		$criteria->params=array(':Usuario'=>$this->Usuario,':Id_Usuario'=>$this->Id_Usuario);
		$modelousuario=Usuario::model()->find($criteria);

        if(!is_null($modelousuario)){
        	$this->addError($attribute, 'Este usuario ya esta registrado.');
        }      
    }


    public function comparePassword($attribute, $params){

        $modelousuario = Usuario::model()->findByPk(Yii::app()->user->getState('id_user'));
        if ($modelousuario->Password != sha1($this->old_password)){
            $this->addError($attribute, 'Password actual incorrecto.');
        }
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'tHEMPRESAUSUARIOs' => array(self::HAS_MANY, 'THEMPRESAUSUARIO', 'Id_Usuario'),
			'tHEMPRESAUSUARIOs1' => array(self::HAS_MANY, 'THEMPRESAUSUARIO', 'Id_Usuario_Actualizcion'),
			'tHEMPRESAUSUARIOs2' => array(self::HAS_MANY, 'THEMPRESAUSUARIO', 'Id_Usuario_Creacion'),
			'tHEMPRESAs' => array(self::HAS_MANY, 'THEMPRESA', 'Id_Usuario_Creacion'),
			'tHEMPRESAs1' => array(self::HAS_MANY, 'THEMPRESA', 'Id_Usuario_Actualizacion'),
			'tHUSUARIOSes' => array(self::HAS_MANY, 'Usuario', 'Id_Usuario_Actualizacion'),
			'tHUSUARIOSes1' => array(self::HAS_MANY, 'Usuario', 'Id_Usuario_Creacion'),
			'tHPERFILUSUARIOs' => array(self::HAS_MANY, 'THPERFILUSUARIO', 'Id_Usuario_Actualizcion'),
			'tHPERFILUSUARIOs1' => array(self::HAS_MANY, 'THPERFILUSUARIO', 'Id_Usuario_Creacion'),
			'tHPERFILs' => array(self::HAS_MANY, 'THPERFIL', 'Id_Usuario_Actualizacion'),
			'tHPERFILs1' => array(self::HAS_MANY, 'THPERFIL', 'Id_Usuario_Creacion'),
			'tHMENUPERFILs' => array(self::HAS_MANY, 'THMENUPERFIL', 'Id_Usuario_Actualizacion'),
			'tHMENUPERFILs1' => array(self::HAS_MANY, 'THMENUPERFIL', 'Id_Usuario_Creacion'),
			'tHMENUs' => array(self::HAS_MANY, 'THMENU', 'Id_Usuario_Actualizacion'),
			'tHMENUs1' => array(self::HAS_MANY, 'THMENU', 'Id_Usuario_Creacion'),
			'idusuariocre' => array(self::BELONGS_TO, 'Usuario', 'Id_Usuario_Creacion'),
			'idusuarioact' => array(self::BELONGS_TO, 'Usuario', 'Id_Usuario_Actualizacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id_Usuario' => 'ID',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Usuario' => 'Usuario',
			'Nombres' => 'Nombres',
			'Correo' => 'E-mail',
			'Password' => 'Password',
			'Estado' => 'Estado',
			'Avatar' => 'Avatar',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'usuario_creacion' => 'Usuario que creo',
			'usuario_actualizacion' => 'Usuario que actualizó',
			'perfiles' => 'Perfiles asociados',
			'old_password' => 'Password actual',
			'new_password' => 'Nuevo password',
			'repeat_password' => 'Nuevo password (Verificación)',
			'orderby' => 'Orden de resultados',
			'tipos_docto' => 'Tipos de docto asociados',
			'bodegas' => 'Bodegas asociadas',
			'areas' => 'Áreas asociadas',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->together  =  true;
	   	$criteria->with=array('idusuariocre','idusuarioact');

		$criteria->compare('t.Id_Usuario',$this->Id_Usuario);
		$criteria->compare('t.Usuario',$this->Usuario,true);
		$criteria->compare('t.Nombres',$this->Nombres,true);
		$criteria->compare('t.Correo',$this->Correo,true);
		$criteria->compare('t.Estado',$this->Estado);
		
		if($this->Fecha_Creacion != ""){
      		$fci = $this->Fecha_Creacion." 00:00:00";
      		$fcf = $this->Fecha_Creacion." 23:59:59";

      		$criteria->addBetweenCondition('t.Fecha_Creacion', $fci, $fcf);
    	}

    	if($this->Fecha_Actualizacion != ""){
      		$fai = $this->Fecha_Actualizacion." 00:00:00";
      		$faf = $this->Fecha_Actualizacion." 23:59:59";

      		$criteria->addBetweenCondition('t.Fecha_Actualizacion', $fai, $faf);
    	}

		if($this->usuario_creacion != ""){
			$criteria->AddCondition("idusuariocre.Usuario = '".$this->usuario_creacion."'"); 
	    }

    	if($this->usuario_actualizacion != ""){
			$criteria->AddCondition("idusuarioact.Usuario = '".$this->usuario_actualizacion."'"); 
	    }

	    if(empty($this->orderby)){
			$criteria->order = 't.Id_Usuario DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Id_Usuario ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Id_Usuario DESC'; 
			        break;
			    case 3:
			        $criteria->order = 't.Usuario ASC'; 
			        break;
			    case 4:
			        $criteria->order = 't.Usuario DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Nombres ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Nombres DESC'; 
			        break;
			    case 7:
			        $criteria->order = 't.Correo ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.Correo DESC'; 
			        break;
		        case 9:
			        $criteria->order = 'idusuariocre.Usuario ASC'; 
			        break;
			    case 10:
			        $criteria->order = 'idusuariocre.Usuario DESC'; 
			        break;
			    case 11:
			        $criteria->order = 't.Fecha_Creacion ASC'; 
			        break;
			    case 12:
			        $criteria->order = 't.Fecha_Creacion DESC'; 
			        break;
			    case 13:
			        $criteria->order = 'idusuarioact.Usuario ASC'; 
			        break;
			    case 14:
			        $criteria->order = 'idusuarioact.Usuario DESC'; 
			        break;
				case 15:
			        $criteria->order = 't.Fecha_Actualizacion ASC'; 
			        break;
			    case 16:
			        $criteria->order = 't.Fecha_Actualizacion DESC'; 
			        break;
			    case 17:
			        $criteria->order = 't.Estado DESC'; 
			        break;
			    case 18:
			        $criteria->order = 't.Estado ASC'; 
			        break;
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize'])),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

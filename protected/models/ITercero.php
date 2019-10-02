<?php

/**
 * This is the model class for table "TH_I_TERCERO".
 *
 * The followings are the available columns in table 'TH_I_TERCERO':
 * @property integer $Id
 * @property integer $Id_Tipo
 * @property string $Nit
 * @property string $Nombre
 * @property string $Telefono
 * @property string $Direccion
 * @property string $Ciudad
 * @property integer $Estado
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property THITIPOTERCERO $idTipo
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class ITercero extends CActiveRecord
{
	
	public $usuario_creacion;
	public $usuario_actualizacion;
	public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_I_TERCERO';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Tipo, Nit, Nombre, Telefono, Direccion, Ciudad, Estado', 'required'),
			array('Nit', 'unique'),
			array('Id_Tipo, Estado, Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Nombre, Telefono, Direccion, Ciudad', 'length', 'max'=>100),
			array('Nit', 'length', 'max'=>50),
			array('Fecha_Creacion, Fecha_Actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Id_Tipo, Nit, Nombre, Telefono, Direccion, Ciudad, Estado, usuario_creacion, usuario_actualizacion, Fecha_Creacion, Fecha_Actualizacion, orderby', 'safe', 'on'=>'search'),
		);
	}

	public function searchByTercero($filtro) {
        
        $resp = Yii::app()->db->createCommand("
		    SELECT TOP 10 Id, CONCAT (Nit, ' - ', Nombre) AS Descr FROM TH_I_TERCERO WHERE (Nit LIKE '%".$filtro."%' OR Nombre LIKE '%".$filtro."%') AND Estado = 1 ORDER BY Descr 
		")->queryAll();
        return $resp;
        
 	}

 	public function searchById($filtro) {
 
        $resp = Yii::app()->db->createCommand("
		    SELECT Id, CONCAT (Nit, ' - ', Nombre) AS Descr FROM TH_I_TERCERO WHERE Id = '".$filtro."'")->queryAll();
        return $resp;

 	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idtipo' => array(self::BELONGS_TO, 'ITipoTercero', 'Id_Tipo'),
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
			'Id' => 'ID',
			'Id_Tipo' => 'Tipo',
			'Nit' => 'Nit',
			'Nombre' => 'Nombres',
			'Telefono' => 'Teléfono',
			'Direccion' => 'Dirección',
			'Ciudad' => 'Ciudad',
			'Estado' => 'Estado',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'usuario_creacion' => 'Usuario que creo',
			'usuario_actualizacion' => 'Usuario que actualizó',
			'orderby' => 'Orden de resultados',
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
	   	$criteria->with=array('idtipo','idusuariocre','idusuarioact');

		$criteria->compare('t.Id',$this->Id);
		$criteria->compare('t.Id_Tipo',$this->Id_Tipo);
		$criteria->compare('t.Nit',$this->Nit);
		$criteria->compare('t.Nombre',$this->Nombre,true);
		$criteria->compare('t.Telefono',$this->Telefono,true);
		$criteria->compare('t.Direccion',$this->Direccion,true);
		$criteria->compare('t.Ciudad',$this->Ciudad,true);
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
			$criteria->order = 't.Id DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Id ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Id DESC'; 
			        break;
			    case 3:
			        $criteria->order = 'idtipo.Descripcion ASC'; 
			        break;
			    case 4:
			        $criteria->order = 'idtipo.Descripcion DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Nit ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Nit DESC'; 
			        break;
			    case 7:
			        $criteria->order = 't.Nombre ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.Nombre DESC'; 
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
	 * @return ITercero the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

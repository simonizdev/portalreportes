<?php

/**
 * This is the model class for table "TH_SUMINISTRO".
 *
 * The followings are the available columns in table 'TH_SUMINISTRO':
 * @property integer $Id_Suministro
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Codigo
 * @property string $Descripcion
 * @property boolean $Estado
 * @property string $Referencia
 * @property string $Impresora
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property THINVENTARIO[] $tHINVENTARIOs
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class Suministro extends CActiveRecord
{
	
	public $usuario_creacion;
	public $usuario_actualizacion;
	public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_SUMINISTRO';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Codigo, Descripcion, Estado', 'required'),
			array('Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Codigo', 'length', 'max'=>8),
			array('Descripcion, Impresora', 'length', 'max'=>50),
			array('Referencia', 'length', 'max'=>20),
			array('Fecha_Creacion, Fecha_Actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Suministro, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Codigo, Descripcion, Estado, Referencia, Impresora, Fecha_Creacion, Fecha_Actualizacion, usuario_creacion, usuario_actualizacion, orderby', 'safe', 'on'=>'search'),
		);
	}

	public function searchBySuministro($filtro) {
        
        $resp = Yii::app()->db->createCommand("
		    SELECT TOP 10 Id_Suministro, CONCAT (Codigo, ' - ', Descripcion) AS DESCR FROM TH_SUMINISTRO WHERE (Codigo LIKE '%".$filtro."%' OR Descripcion LIKE '%".$filtro."%') AND Estado = 1 ORDER BY DESCR 
		")->queryAll();
        return $resp;
        
 	}

 	public function searchById($filtro) {
 
        $resp = Yii::app()->db->createCommand("
		    SELECT Id_Suministro , CONCAT (Codigo, ' - ', Descripcion) AS DESCR FROM TH_SUMINISTRO WHERE Id_Suministro = '".$filtro."'")->queryAll();
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
			'tHINVENTARIOs' => array(self::HAS_MANY, 'THINVENTARIO', 'Id_Suministro'),
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
			'Id_Suministro' => 'ID',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Codigo' => 'Código',
			'Descripcion' => 'Descripción',
			'Estado' => 'Estado',
			'Referencia' => 'Referencia',
			'Impresora' => 'Impresora',
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
	   	$criteria->with=array('idusuariocre','idusuarioact');

		$criteria->compare('t.Id_Suministro',$this->Id_Suministro);
		$criteria->compare('t.Codigo',$this->Codigo,true);
		$criteria->compare('t.Descripcion',$this->Descripcion,true);
		$criteria->compare('t.Estado',$this->Estado);
		$criteria->compare('t.Referencia',$this->Referencia,true);
		$criteria->compare('t.Impresora',$this->Impresora,true);

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
			$criteria->order = 't.Id_Suministro DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Id_Suministro ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Id_Suministro DESC'; 
			        break;
			    case 3:
			        $criteria->order = 't.Codigo ASC'; 
			        break;
			    case 4:
			        $criteria->order = 't.Codigo DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Descripcion ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Descripcion DESC'; 
			        break;
			    case 7:
			        $criteria->order = 't.Referencia ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.Referencia DESC'; 
			        break;
			    case 9:
			        $criteria->order = 't.Impresora ASC'; 
			        break;
			    case 10:
			        $criteria->order = 't.Impresora DESC'; 
			        break; 
		        case 11:
			        $criteria->order = 'idusuariocre.Usuario ASC'; 
			        break;
			    case 12:
			        $criteria->order = 'idusuariocre.Usuario DESC'; 
			        break;
			    case 13:
			        $criteria->order = 't.Fecha_Creacion ASC'; 
			        break;
			    case 14:
			        $criteria->order = 't.Fecha_Creacion DESC'; 
			        break;
			    case 15:
			        $criteria->order = 'idusuarioact.Usuario ASC'; 
			        break;
			    case 16:
			        $criteria->order = 'idusuarioact.Usuario DESC'; 
			        break;
				case 17:
			        $criteria->order = 't.Fecha_Actualizacion ASC'; 
			        break;
			    case 18:
			        $criteria->order = 't.Fecha_Actualizacion DESC'; 
			        break;
			    case 19:
			        $criteria->order = 't.Estado DESC'; 
			        break;
			    case 20:
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
	 * @return THSUMINISTRO the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

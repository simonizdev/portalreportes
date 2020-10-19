<?php

/**
 * This is the model class for table "TH_TIPO_ACT".
 *
 * The followings are the available columns in table 'TH_TIPO_ACT':
 * @property integer $Id_Tipo
 * @property integer $Id_Grupo
 * @property string $Tipo
 * @property integer $Cantidad
 * @property integer $Estado
 * @property integer $Id_Usuario_Creacion
 * @property string $Fecha_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property THDOMINIO $idGrupo
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class TipoAct extends CActiveRecord
{
	public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_TIPO_ACT';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Grupo, Tipo, Estado, Id_Usuario_Creacion, Fecha_Creacion, Id_Usuario_Actualizacion, Fecha_Actualizacion', 'required'),
			array('Id_Tipo, Id_Grupo, Cantidad, Estado, Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Tipo', 'length', 'max'=>100),
			//array('Cantidad', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Tipo, Id_Grupo, Tipo, Cantidad, Estado, Id_Usuario_Creacion, Fecha_Creacion, Id_Usuario_Actualizacion, Fecha_Actualizacion, orderby', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idgrupo' => array(self::BELONGS_TO, 'Dominio', 'Id_Grupo'),
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
			'Id_Tipo' => 'ID',
			'Id_Grupo' => 'Grupo',
			'Tipo' => 'Tipo',
			'Cantidad' => 'Cantidad',
			'Estado' => 'Estado',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Ultimo usuario que actualizó',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Ultima fecha de actualización ',
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
	   	$criteria->with=array('idusuariocre','idusuarioact', 'idgrupo');

		$criteria->compare('t.Id_Tipo',$this->Id_Tipo);
		$criteria->compare('t.Id_Grupo',$this->Id_Grupo);
		$criteria->compare('t.Tipo',$this->Tipo,true);
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

		if($this->Id_Usuario_Creacion != ""){
			$criteria->AddCondition("t.Id_Usuario_Creacion = ".$this->Id_Usuario_Creacion); 
	    }

    	if($this->Id_Usuario_Actualizacion != ""){
			$criteria->AddCondition("t.Id_Usuario_Actualizacion = ".$this->Id_Usuario_Actualizacion); 
	    }

		if(empty($this->orderby)){
			$criteria->order = 't.Id_Tipo DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Id_Tipo ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Id_Tipo DESC'; 
			        break;
			    case 3:
			        $criteria->order = 'idgrupo.Dominio ASC'; 
			        break;
			    case 4:
			        $criteria->order = 'idgrupo.Dominio DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Tipo ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Tipo DESC'; 
			        break; 
		        case 7:
			        $criteria->order = 'idusuariocre.Usuario ASC'; 
			        break;
			    case 8:
			        $criteria->order = 'idusuariocre.Usuario DESC'; 
			        break;
			    case 9:
			        $criteria->order = 't.Fecha_Creacion ASC'; 
			        break;
			    case 10:
			        $criteria->order = 't.Fecha_Creacion DESC'; 
			        break;
			    case 11:
			        $criteria->order = 'idusuarioact.Usuario ASC'; 
			        break;
			    case 12:
			        $criteria->order = 'idusuarioact.Usuario DESC'; 
			        break;
				case 13:
			        $criteria->order = 't.Fecha_Actualizacion ASC'; 
			        break;
			    case 14:
			        $criteria->order = 't.Fecha_Actualizacion DESC'; 
			        break;
			    case 15:
			        $criteria->order = 't.Estado DESC'; 
			        break;
			    case 16:
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
	 * @return TipoAct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

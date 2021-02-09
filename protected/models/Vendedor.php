<?php

/**
 * This is the model class for table "TH_VENDEDORES".
 *
 * The followings are the available columns in table 'TH_VENDEDORES':
 * @property integer $Rowid
 * @property string $Cedula
 * @property string $Celular
 * @property string $Ciudad
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 * @property integer $Estado
 *
 * The followings are the available model relations:
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class Vendedor extends CActiveRecord
{
	
	public $usuario_creacion;
	public $usuario_actualizacion;
    public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_VENDEDORES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Cedula, Ciudad', 'required','on'=>'create'),
			array('Cedula, Ciudad, Estado', 'required','on'=>'update'),
			array('Cedula','unique','on'=>'create'),
			array('Cedula', 'unique','on'=>'update'),
			array('Id_Usuario_Creacion, Id_Usuario_Actualizacion, Estado', 'numerical', 'integerOnly'=>true),
			array('Cedula, Celular, Ciudad', 'length', 'max'=>50),
			array('Fecha_Creacion, Fecha_Actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Rowid, Cedula, Celular, Ciudad, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Fecha_Creacion, Fecha_Actualizacion, Estado, usuario_creacion, usuario_actualizacion, orderby', 'safe', 'on'=>'search'),
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
			'Rowid' => 'ID',
			'Cedula' => 'Cédula',
			'Celular' => 'Celular',
			'Ciudad' => 'Ciudad',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'Estado' => 'Estado', 
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

		$criteria->compare('t.Rowid',$this->Rowid);
		$criteria->compare('t.Cedula',$this->Cedula,true);
		$criteria->compare('t.Celular',$this->Celular,true);
		$criteria->compare('t.Ciudad',$this->Ciudad,true);
		$criteria->compare('t.Estado',$this->Estado,true);

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
			$criteria->order = 't.Rowid ASC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Rowid ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Rowid DESC'; 
			        break;
			    case 3:
			        $criteria->order = 't.Cedula ASC'; 
			        break;
			    case 4:
			        $criteria->order = 't.Cedula DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Celular ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Celular DESC'; 
			        break;
			    case 7:
			        $criteria->order = 't.Ciudad ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.Ciudad DESC'; 
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
	 * @return Vendedor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

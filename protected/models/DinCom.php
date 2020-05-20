<?php

/**
 * This is the model class for table "TH_DIN_COM".
 *
 * The followings are the available columns in table 'TH_DIN_COM':
 * @property integer $Id_Dic_Com
 * @property string $Fecha_Inicio
 * @property string $Fecha_Fin
 * @property string $Id_Plan_Cliente
 * @property string $Id_Criterio_Cliente
 * @property string $Id_Plan_Item
 * @property string $Id_Criterio_Item
 * @property string $Porc
 * @property integer $Estado
 * @property integer $Id_Usuario_Creacion
 * @property string $Fecha_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class DinCom extends CActiveRecord
{
	public $usuario_creacion;
	public $usuario_actualizacion;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_DIN_COM';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha_Inicio, Fecha_Fin, Id_Plan_Cliente, Id_Criterio_Cliente, Id_Plan_Item, Id_Criterio_Item, Porc, Estado', 'required'),
			array('Estado, Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Id_Plan_Cliente, Id_Plan_Item', 'length', 'max'=>10),
			//array('Id_Criterio_Cliente, Id_Criterio_Item', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Dic_Com, Fecha_Inicio, Fecha_Fin, Id_Plan_Cliente, Id_Criterio_Cliente, Id_Plan_Item, Id_Criterio_Item, Estado, Porc, usuario_creacion, usuario_actualizacion, Fecha_Creacion, Fecha_Actualizacion', 'safe', 'on'=>'search'),
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
			'Id_Dic_Com' => 'ID',
			'Fecha_Inicio' => 'Fecha inicio',
			'Fecha_Fin' => 'Fecha fin',
			'Id_Plan_Cliente' => 'Plan cliente',
			'Id_Criterio_Cliente' => 'Criterio(s) cliente',
			'Id_Plan_Item' => 'Plan item',
			'Id_Criterio_Item' => 'Criterio(s) item',
			'Porc' => 'Porcentaje',
			'Estado' => 'Estado',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'usuario_creacion' => 'Usuario que creo',
			'usuario_actualizacion' => 'Usuario que actualizó',
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

		$criteria->compare('t.Id_Dic_Com',$this->Id_Dic_Com);
		$criteria->compare('t.Fecha_Inicio',$this->Fecha_Inicio,true);
		$criteria->compare('t.Fecha_Fin',$this->Fecha_Fin,true);
		$criteria->compare('t.Id_Plan_Cliente',$this->Id_Plan_Cliente,true);
		$criteria->compare('t.Id_Plan_Item',$this->Id_Plan_Item,true);

		$criteria->compare('t.Id_Criterio_Cliente',$this->Id_Criterio_Cliente,true);
		$criteria->compare('t.Id_Criterio_Item',$this->Id_Criterio_Item,true);

		$criteria->compare('t.Porc',$this->Porc,true);
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

		$criteria->order = 't.Id_Dic_Com DESC'; 	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize'])),		
		));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DinCom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

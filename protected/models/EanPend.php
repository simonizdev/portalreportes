<?php

/**
 * This is the model class for table "TH_EAN_PEND".
 *
 * The followings are the available columns in table 'TH_EAN_PEND':
 * @property integer $Id_Ean_Pend
 * @property integer $Criterio
 * @property string $Ean
 * @property integer $Dig_Ver
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
class EanPend extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_EAN_PEND';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Criterio, Ean, Dig_Ver, Estado, Id_Usuario_Creacion, Fecha_Creacion, Id_Usuario_Actualizacion, Fecha_Actualizacion', 'required'),
			array('Criterio, Dig_Ver, Estado, Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Ean', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Ean_Pend, Criterio, Ean, Dig_Ver, Estado, Id_Usuario_Creacion, Fecha_Creacion, Id_Usuario_Actualizacion, Fecha_Actualizacion', 'safe', 'on'=>'search'),
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
			'idUsuarioCreacion' => array(self::BELONGS_TO, 'THUSUARIOS', 'Id_Usuario_Creacion'),
			'idUsuarioActualizacion' => array(self::BELONGS_TO, 'THUSUARIOS', 'Id_Usuario_Actualizacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id_Ean_Pend' => 'Id Ean Pend',
			'Criterio' => 'Criterio',
			'Ean' => 'Ean',
			'Dig_Ver' => 'Dig Ver',
			'Estado' => 'Estado',
			'Id_Usuario_Creacion' => 'Id Usuario Creacion',
			'Fecha_Creacion' => 'Fecha Creacion',
			'Id_Usuario_Actualizacion' => 'Id Usuario Actualizacion',
			'Fecha_Actualizacion' => 'Fecha Actualizacion',
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

		$criteria->compare('Id_Ean_Pend',$this->Id_Ean_Pend);
		$criteria->compare('Criterio',$this->Criterio);
		$criteria->compare('Ean',$this->Ean,true);
		$criteria->compare('Dig_Ver',$this->Dig_Ver);
		$criteria->compare('Estado',$this->Estado);
		$criteria->compare('Id_Usuario_Creacion',$this->Id_Usuario_Creacion);
		$criteria->compare('Fecha_Creacion',$this->Fecha_Creacion,true);
		$criteria->compare('Id_Usuario_Actualizacion',$this->Id_Usuario_Actualizacion);
		$criteria->compare('Fecha_Actualizacion',$this->Fecha_Actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EanPend the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

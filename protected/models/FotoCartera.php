<?php

/**
 * This is the model class for table "TH_FOTO_CARTERA".
 *
 * The followings are the available columns in table 'TH_FOTO_CARTERA':
 * @property integer $Id
 * @property integer $Cons
 * @property string $Saldo_Total
 * @property string $Saldo_1_30
 * @property string $Saldo_31_60
 * @property string $Saldo_61_90
 * @property string $Saldo_91_120
 * @property string $Saldo_121_180
 * @property string $Saldo_181_360
 * @property string $Saldo_361_9999
 * @property string $Estructura_Ventas
 * @property string $Canal
 * @property string $Periodo
 * @property integer $Id_Usuario_Creacion
 * @property string $Fecha_Creacion
 *
 * The followings are the available model relations:
 * @property THUSUARIOS $idUsuarioCreacion
 */
class FotoCartera extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_FOTO_CARTERA';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Cons, Saldo_Total, Saldo_1_30, Saldo_31_60, Saldo_61_90, Saldo_91_120, Saldo_121_180, Saldo_181_360, Saldo_361_9999, Estructura_Ventas, Canal, Periodo, Id_Usuario_Creacion, Fecha_Creacion', 'required'),
			array('Cons, Id_Usuario_Creacion', 'numerical', 'integerOnly'=>true),
			array('Saldo_Total, Saldo_1_30, Saldo_31_60, Saldo_61_90, Saldo_91_120, Saldo_121_180, Saldo_181_360, Saldo_361_9999', 'length', 'max'=>18),
			array('Estructura_Ventas, Canal', 'length', 'max'=>200),
			array('Periodo', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Cons, Saldo_Total, Saldo_1_30, Saldo_31_60, Saldo_61_90, Saldo_91_120, Saldo_121_180, Saldo_181_360, Saldo_361_9999, Estructura_Ventas, Canal, Periodo, Id_Usuario_Creacion, Fecha_Creacion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Cons' => 'Cons',
			'Saldo_Total' => 'Saldo Total',
			'Saldo_1_30' => 'Saldo 1 30',
			'Saldo_31_60' => 'Saldo 31 60',
			'Saldo_61_90' => 'Saldo 61 90',
			'Saldo_91_120' => 'Saldo 91 120',
			'Saldo_121_180' => 'Saldo 121 180',
			'Saldo_181_360' => 'Saldo 181 360',
			'Saldo_361_9999' => 'Saldo 361 9999',
			'Estructura_Ventas' => 'Estructura_Ventas',
			'Canal' => 'Canal',
			'Periodo' => 'Periodo',
			'Id_Usuario_Creacion' => 'Id Usuario Creacion',
			'Fecha_Creacion' => 'Fecha Creacion',
		);
	}

	/**
	 * RetriEstructura_Ventases a list of models based on the current search/filter conditions.
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Cons',$this->Cons);
		$criteria->compare('Saldo_Total',$this->Saldo_Total,true);
		$criteria->compare('Saldo_1_30',$this->Saldo_1_30,true);
		$criteria->compare('Saldo_31_60',$this->Saldo_31_60,true);
		$criteria->compare('Saldo_61_90',$this->Saldo_61_90,true);
		$criteria->compare('Saldo_91_120',$this->Saldo_91_120,true);
		$criteria->compare('Saldo_121_180',$this->Saldo_121_180,true);
		$criteria->compare('Saldo_181_360',$this->Saldo_181_360,true);
		$criteria->compare('Saldo_361_9999',$this->Saldo_361_9999,true);
		$criteria->compare('Estructura_Ventas',$this->Estructura_Ventas,true);
		$criteria->compare('Canal',$this->Canal,true);
		$criteria->compare('Periodo',$this->Periodo,true);
		$criteria->compare('Id_Usuario_Creacion',$this->Id_Usuario_Creacion);
		$criteria->compare('Fecha_Creacion',$this->Fecha_Creacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FotoCartera the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

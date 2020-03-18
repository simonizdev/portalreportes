<?php

/**
 * This is the model class for table "TH_DET_PAR_PED_ESP".
 *
 * The followings are the available columns in table 'TH_DET_PAR_PED_ESP':
 * @property integer $Id_Det_Par_Ped_Esp
 * @property integer $Id_Par_Ped_Esp
 * @property string $Codigo
 * @property string $Descripcion
 * @property string $Marca
 * @property string $Cat_Oracle
 * @property string $Vlr_Unit
 * @property integer $Cant
 * @property integer $Iva
 * @property string $Nota
 * @property integer $Id_Usuario_Creacion
 * @property string $Fecha_Creacion
 *
 * The followings are the available model relations:
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THPARPEDESP $idParPedEsp
 */
class DetParPedEsp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_DET_PAR_PED_ESP';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Par_Ped_Esp, Codigo, Descripcion, Marca, Cat_Oracle, Vlr_Unit, Cant, Iva, Nota, Id_Usuario_Creacion, Fecha_Creacion', 'required'),
			array('Id_Par_Ped_Esp, Cant, Iva, Id_Usuario_Creacion', 'numerical', 'integerOnly'=>true),
			array('Codigo, Descripcion, Marca, Cat_Oracle', 'length', 'max'=>200),
			array('Vlr_Unit', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Det_Par_Ped_Esp, Id_Par_Ped_Esp, Codigo, Descripcion, Marca, Vlr_Unit, Cant, Iva, Nota, Id_Usuario_Creacion, Fecha_Creacion', 'safe', 'on'=>'search'),
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
			'idParPedEsp' => array(self::BELONGS_TO, 'THPARPEDESP', 'Id_Par_Ped_Esp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id_Det_Par_Ped_Esp' => 'ID',
			'Id_Par_Ped_Esp' => 'Id Par Ped Esp',
			'Codigo' => 'Codigo',
			'Descripcion' => 'Descripcion',
			'Marca' => 'Marca',
			'Cat_Oracle' => 'Cat Oracle',
			'Vlr_Unit' => 'Vlr Unit',
			'Cant' => 'Cant',
			'Iva' => 'Iva',
			'Nota' => 'Nota',
			'Id_Usuario_Creacion' => 'Id Usuario Creacion',
			'Fecha_Creacion' => 'Fecha Creacion',
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

		$criteria->compare('Id_Det_Par_Ped_Esp',$this->Id_Det_Par_Ped_Esp);
		$criteria->compare('Id_Par_Ped_Esp',$this->Id_Par_Ped_Esp);
		$criteria->compare('Codigo',$this->Codigo,true);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Marca',$this->Marca,true);
		$criteria->compare('Cat_Oracle',$this->Cat_Oracle,true);
		$criteria->compare('Vlr_Unit',$this->Vlr_Unit,true);
		$criteria->compare('Cant',$this->Cant);
		$criteria->compare('Iva',$this->Iva);
		$criteria->compare('Nota',$this->Nota,true);
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
	 * @return DetParPedEsp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "TH_MARCAS".
 *
 * The followings are the available columns in table 'TH_MARCAS':
 * @property integer $M_Rowid
 * @property integer $M_Id_Marca
 * @property string $M_Id_Tipo
 * @property string $M_Descripcion
 */
class Marca extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_MARCAS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('M_Id_Marca, M_Id_Tipo, M_Descripcion', 'required'),
			array('M_Id_Marca', 'numerical', 'integerOnly'=>true),
			array('M_Id_Tipo, M_Descripcion', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('M_Rowid, M_Id_Marca, M_Id_Tipo, M_Descripcion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'M_Rowid' => 'M Rowid',
			'M_Id_Marca' => 'M Id Marca',
			'M_Id_Tipo' => 'M Id Tipo',
			'M_Descripcion' => 'M Descripcion',
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

		$criteria->compare('M_Rowid',$this->M_Rowid);
		$criteria->compare('M_Id_Marca',$this->M_Id_Marca);
		$criteria->compare('M_Id_Tipo',$this->M_Id_Tipo,true);
		$criteria->compare('M_Descripcion',$this->M_Descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Marca the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

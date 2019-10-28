<?php

/**
 * This is the model class for table "TH_ITEM_REP".
 *
 * The followings are the available columns in table 'TH_ITEM_REP':
 * @property integer $Id_Item_Rep
 * @property integer $Id_Rep
 * @property integer $Id_Item
 * @property integer $Orden
 * @property string $Porcentaje
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property THREP $idRep
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class ItemRep extends CActiveRecord
{
		
	public $usuario_creacion;
	public $usuario_actualizacion;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_ITEM_REP';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('Id_Rep, Id_Item, Orden, Porcentaje, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Fecha_Creacion, Fecha_Actualizacion', 'required'),
			array('Id_Rep, Id_Item, Orden, Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Porcentaje', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Item_Rep, Id_Rep, Id_Item, Orden, Porcentaje, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Fecha_Creacion, Fecha_Actualizacion', 'safe', 'on'=>'search'),
		);
	}

	public function Desc_Item($Id_Item){

        $desc= Yii::app()->db->createCommand("
		    SELECT CONCAT (I_ID_ITEM, ' - ', I_DESCRIPCION) AS DESCR FROM TH_ITEMS WHERE I_ID_ITEM = ".$Id_Item." AND I_CIA = 2")->queryRow();

		return $desc['DESCR'];

    }

	public function NumDet($id_rep) {
 
        $modelo_num_items = ItemRep::model()->findAllByAttributes(array('Id_Rep' => $id_rep));
		return count($modelo_num_items);
 	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idrep' => array(self::BELONGS_TO, 'Rep', 'Id_Rep'),
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
			'Id_Item_Rep' => 'ID',
			'Id_Rep' => 'Reporte',
			'Id_Item' => 'Item',
			'Orden' => 'Orden',
			'Porcentaje' => 'Porcentaje',
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

		$criteria->compare('Id_Item_Rep',$this->Id_Item_Rep);
		$criteria->compare('Id_Rep',$this->Id_Rep);
		$criteria->compare('Id_Item',$this->Id_Item);
		$criteria->compare('Orden',$this->Orden);
		$criteria->compare('Porcentaje',$this->Porcentaje,true);
		$criteria->compare('Id_Usuario_Creacion',$this->Id_Usuario_Creacion);
		$criteria->compare('Id_Usuario_Actualizacion',$this->Id_Usuario_Actualizacion);
		$criteria->compare('Fecha_Creacion',$this->Fecha_Creacion,true);
		$criteria->compare('Fecha_Actualizacion',$this->Fecha_Actualizacion,true);
		$criteria->order = 't.Orden'; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize'=> 50),		
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemRep the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

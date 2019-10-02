<?php

/**
 * This is the model class for table "TH_EAN_ITEM".
 *
 * The followings are the available columns in table 'TH_EAN_ITEM':
 * @property integer $Id_Ean_Item
 * @property integer $Id_Item
 * @property integer $Criterio
 * @property integer $Num_Und
 * @property string $Ean
 * @property integer $Dig_Ver
 * @property integer $Und_x_Caja
 * @property integer $Id_Usuario_Creacion
 * @property string $Fecha_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class EanItem extends CActiveRecord
{
	
	public $cod_asoc;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_EAN_ITEM';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Item, Criterio', 'required', 'on'=>'create'),
			array('Id_Item, Criterio, Num_Und, Und_x_Caja', 'required', 'on'=>'add'),
			array('Id_Ean_Item, Id_Item, Criterio, Num_Und, Dig_Ver, Und_x_Caja, Id_Usuario_Creacion, Id_Usuario_Actualizacion', 'numerical', 'integerOnly'=>true),
			array('Ean', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Ean_Item, Id_Item, Criterio, Num_Und, Ean, Dig_Ver, Und_x_Caja', 'safe', 'on'=>'search'),
		);
	}

	public function DescItem($Id_Item){

        $desc= Yii::app()->db->createCommand("
		    SELECT CONCAT (LTRIM(RTRIM(f120_id)), ' - ',LTRIM(RTRIM(f120_referencia)), ' - ',LTRIM(RTRIM(f120_descripcion))) AS DESCR FROM UnoEE1..t120_mc_items WHERE 
		    f120_rowid = ".$Id_Item)->queryRow();

		return $desc['DESCR'];

    }

    public function EanDig($id_ean_item) {
 
        $ean_item = EanItem::model()->findByAttributes(array('Id_Ean_Item' => $id_ean_item));
		return $ean_item->Ean.''.$ean_item->Dig_Ver;
 	}

    public function searchByItem($filtro) {
        
        $resp = Yii::app()->db->createCommand("
        	SELECT TOP 10 f120_rowid AS ID, CONCAT (LTRIM(RTRIM(f120_id)), ' - ',LTRIM(RTRIM(f120_referencia)), ' - ',LTRIM(RTRIM(f120_descripcion))) AS DESCR FROM UnoEE1..t120_mc_items WHERE (f120_id LIKE '%".$filtro."%' OR f120_referencia LIKE '%".$filtro."%' OR f120_descripcion LIKE '%".$filtro."%') AND f120_id_cia = 2 AND f120_rowid NOT IN (SELECT Id_Item FROM TH_EAN_ITEM) ORDER BY DESCR
		")->queryAll();
        return $resp;
        
 	}

 	public function searchByAllItems($filtro) {
        
        $resp = Yii::app()->db->createCommand("
        	SELECT TOP 10 f120_rowid AS ID, CONCAT (LTRIM(RTRIM(f120_id)), ' - ',LTRIM(RTRIM(f120_referencia)), ' - ',LTRIM(RTRIM(f120_descripcion))) AS DESCR FROM UnoEE1..t120_mc_items WHERE (f120_id LIKE '%".$filtro."%' OR f120_referencia LIKE '%".$filtro."%' OR f120_descripcion LIKE '%".$filtro."%') AND f120_id_cia = 2 ORDER BY DESCR
		")->queryAll();
        return $resp;
        
 	}

 	public function CodAsoc($id_item) {
 
        $modelo_cod_x_item = EanItem::model()->findAllByAttributes(array('Id_Item' => $id_item));
        $cods_asoc = count ($modelo_cod_x_item);

		return $cods_asoc;
 	}

 	public function DescCriterio($criterio){

        switch ($criterio) {
		    case 1:
		        return 'FAB. SIMONIZ';
		    case 2:
		        return 'FAB. TITAN';
		    case 3:
		        return 'IMPORT.';
		}

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
			'Id_Ean_Item' => 'ID',
			'Id_Item' => 'Item',
			'Criterio' => 'Criterio',
			'Num_Und' => '# Und',
			'Ean' => 'Ean',
			'Dig_Ver' => 'Dig. control',
			'Und_x_Caja' => 'Unds x caja',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'cod_asoc' => '# cod. asoc.'
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

		$criteria->compare('t.Id_Ean_Item',$this->Id_Ean_Item);
		$criteria->compare('t.Id_Item',$this->Id_Item);
		$criteria->compare('t.Criterio',$this->Criterio);
		$criteria->AddCondition("t.Num_Und = 0"); 
		$criteria->compare('t.Ean',$this->Ean,true);
		$criteria->compare('t.Dig_Ver',$this->Dig_Ver,true);
		$criteria->compare('t.Und_x_Caja',$this->Und_x_Caja);
		$criteria->order = 't.Id_Ean_Item DESC'; 	
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize'])),
		));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EanItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "TH_ITEMS_UNIDADES".
 *
 * The followings are the available columns in table 'TH_ITEMS_UNIDADES':
 * @property integer $Id_Item_Unidad
 * @property integer $Id_Item
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Foto
 * @property integer $Lead_Time
 * @property integer $UN_Venta
 * @property integer $UN_Cadena
 * @property string $Unidad_1
 * @property integer $Cantidad1
 * @property string $Largo1
 * @property string $Alto1
 * @property string $Ancho1
 * @property string $Volumen_Total1
 * @property string $Peso_Total1
 * @property string $Cod_Barras1
 * @property string $Unidad_2
 * @property integer $Cantidad2
 * @property string $Largo2
 * @property string $Alto2
 * @property string $Ancho2
 * @property string $Volumen_Total2
 * @property string $Peso_Total2
 * @property string $Cod_Barras2
 * @property string $Unidad_3
 * @property integer $Cantidad3
 * @property string $Largo3
 * @property string $Alto3
 * @property string $Ancho3
 * @property string $Volumen_Total3
 * @property string $Peso_Total3
 * @property string $Cod_Barras3
 * @property string $Unidad_4
 * @property integer $Cantidad4
 * @property string $Largo4
 * @property string $Alto4
 * @property string $Ancho4
 * @property string $Volumen_Total4
 * @property string $Peso_Total4
 * @property string $Cod_Barras4
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class ItemUnidad extends CActiveRecord
{

	public $usuario_creacion;
	public $usuario_actualizacion;
	public $num_und;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_ITEMS_UNIDADES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Item, num_und, Lead_Time, UN_Venta, UN_Cadena', 'required'),
			array('Id_Item, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Lead_Time, UN_Venta, UN_Cadena, Cantidad1, Cantidad2, Cantidad3, Cantidad4', 'numerical', 'integerOnly'=>true),
			array('Foto', 'length', 'max'=>200),
			//array('Unidad_1, Unidad_2, Unidad_3, Unidad_4', 'length', 'max'=>3),
			//array('Largo1, Alto1, Ancho1, Volumen_Total1, Peso_Total1, Largo2, Alto2, Ancho2, Volumen_Total2, Peso_Total2, Largo3, Alto3, Ancho3, Volumen_Total3, Peso_Total3, Largo4, Alto4, Ancho4, Volumen_Total4, Peso_Total4', 'length', 'max'=>12),
			array('Cod_Barras1, Cod_Barras2, Cod_Barras3, Cod_Barras4', 'length', 'max'=>128),
			array('Fecha_Creacion, Fecha_Actualizacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Item_Unidad, Id_Item, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Foto, Lead_Time, UN_Venta, UN_Cadena, Unidad_1, Cantidad1, Largo1, Alto1, Ancho1, Volumen_Total1, Peso_Total1, Cod_Barras1, Unidad_2, Cantidad2, Largo2, Alto2, Ancho2, Volumen_Total2, Peso_Total2, Cod_Barras2, Unidad_3, Cantidad3, Largo3, Alto3, Ancho3, Volumen_Total3, Peso_Total3, Cod_Barras3, Unidad_4, Cantidad4, Largo4, Alto4, Ancho4, Volumen_Total4, Peso_Total4, Cod_Barras4, Fecha_Creacion, Fecha_Actualizacion', 'safe', 'on'=>'search'),
		);
	}

	public function Desc_Item($Id_Item){

        $desc= Yii::app()->db->createCommand("
		    SELECT CONCAT (I_ID_ITEM, ' - ', I_REFERENCIA, ' - ', I_DESCRIPCION) AS DESCR FROM TH_ITEMS WHERE I_ID_ITEM = ".$Id_Item." AND I_CIA = 2")->queryRow();

		return $desc['DESCR'];

    }

    public function Desc_Unidad($Id_Unidad){

        $desc= Yii::app()->db->createCommand("
		    SELECT CONCAT (f101_id, ' - ', f101_descripcion) AS DESCR FROM UnoEE1..t101_mc_unidades_medida WHERE f101_id_cia=2 AND f101_id = '".$Id_Unidad."'
		")->queryRow();

		return $desc['DESCR'];

    }

    public function searchByItem($filtro) {
        
        $resp = Yii::app()->db->createCommand("
		    SELECT TOP 10 I_ID_ITEM, CONCAT (I_ID_ITEM, ' - ', I_REFERENCIA, ' - ', I_DESCRIPCION) AS DESCR FROM TH_ITEMS WHERE I_CIA = 2 AND (I_ID_ITEM LIKE '%".$filtro."%'  OR I_REFERENCIA  LIKE '%".$filtro."%' OR I_DESCRIPCION  LIKE '%".$filtro."%') ORDER BY DESCR 
		")->queryAll();
        return $resp;
        
 	}

    public function searchByUnidad($filtro) {
        
        $resp = Yii::app()->db->createCommand("SELECT DISTINCT TOP 10 f101_id, f101_descripcion FROM UnoEE1..t101_mc_unidades_medida WHERE f101_id_cia=2 AND (f101_id LIKE '%".$filtro."%' OR f101_descripcion  LIKE '%".$filtro."%') ORDER BY f101_descripcion")->queryAll();
        return $resp;
        
 	}

 	public function searchById($filtro) {

        $resp = Yii::app()->db->createCommand("SELECT DISTINCT f101_id, f101_descripcion FROM UnoEE1..t101_mc_unidades_medida WHERE f101_id_cia=2 AND f101_id = '".$filtro."'")->queryAll();
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
			'Id_Item_Unidad' => 'ID',
			'Id_Item' => 'Item',

			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'usuario_creacion' => 'Usuario que creo',
			'usuario_actualizacion' => 'Usuario que actualizó',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',

			'Foto' => 'Foto',
			'Lead_Time' => 'Lead time',
			'num_und' => '# de unidades',
			'UN_Venta' => 'Und. de venta',
			'UN_Cadena' => 'Und. de cadena',
			
			'Unidad_1' => 'Und.',
			'Cantidad1' => 'Cantidad',
			'Largo1' => 'Largo (mm)',
			'Alto1' => 'Alto (mm)',
			'Ancho1' => 'Ancho (mm)',
			'Volumen_Total1' => 'Volumen total',
			'Peso_Total1' => 'Peso total (kg)',
			'Cod_Barras1' => 'Cód. barras',
			
			'Unidad_2' => 'Und.',
			'Cantidad2' => 'Cantidad',
			'Largo2' => 'Largo (mm)',
			'Alto2' => 'Alto (mm)',
			'Ancho2' => 'Ancho (mm)',
			'Volumen_Total2' => 'Volumen total',
			'Peso_Total2' => 'Peso total (kg)',
			'Cod_Barras2' => 'Código de barras',
			
			'Unidad_3' => 'Und.',
			'Cantidad3' => 'Cantidad',
			'Largo3' => 'Largo (mm)',
			'Alto3' => 'Alto (mm)',
			'Ancho3' => 'Ancho (mm)',
			'Volumen_Total3' => 'Volumen total',
			'Peso_Total3' => 'Peso total (kg)',
			'Cod_Barras3' => 'Código de barras',
			
			'Unidad_4' => 'Und.',
			'Cantidad4' => 'Cantidad',
			'Largo4' => 'Largo (mm)',
			'Alto4' => 'Alto (mm)',
			'Ancho4' => 'Ancho (mm)',
			'Volumen_Total4' => 'Volumen total',
			'Peso_Total4' => 'Peso total (kg)',
			'Cod_Barras4' => 'Código de barras',

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
	   	//$criteria->join = 'LEFT JOIN related_tbl as tbl_alias ON tbl_alias.id =  t.fk_id';

		if($this->Id_Item != ""){
			$criteria->AddCondition("t.Id_Item = '".$this->Id_Item."'"); 
	    }

		if($this->Fecha_Creacion != ""){
      		$fci = $this->Fecha_Creacion." 00:00:00";
      		$fcf = $this->Fecha_Creacion." 23:59:59";

      		$criteria->addBetweenCondition('t.Fecha_Creacion', $fci, $fcf);
    	}

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

		$criteria->order = 't.Id_Item';	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize'=>Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize'])),	
		));


		/*$criteria=new CDbCriteria;

		$criteria->compare('Id_Item_Unidad',$this->Id_Item_Unidad);
		$criteria->compare('Id_Item',$this->Id_Item);
		$criteria->compare('Id_Usuario_Creacion',$this->Id_Usuario_Creacion);
		$criteria->compare('Id_Usuario_Actualizacion',$this->Id_Usuario_Actualizacion);
		$criteria->compare('Foto',$this->Foto,true);
		$criteria->compare('Lead_Time',$this->Lead_Time);
		$criteria->compare('UN_Venta',$this->UN_Venta);
		$criteria->compare('UN_Cadena',$this->UN_Cadena);
		$criteria->compare('Unidad_1',$this->Unidad_1,true);
		$criteria->compare('Cantidad1',$this->Cantidad1);
		$criteria->compare('Largo1',$this->Largo1,true);
		$criteria->compare('Alto1',$this->Alto1,true);
		$criteria->compare('Ancho1',$this->Ancho1,true);
		$criteria->compare('Volumen_Total1',$this->Volumen_Total1,true);
		$criteria->compare('Peso_Total1',$this->Peso_Total1,true);
		$criteria->compare('Cod_Barras1',$this->Cod_Barras1,true);
		$criteria->compare('Unidad_2',$this->Unidad_2,true);
		$criteria->compare('Cantidad2',$this->Cantidad2);
		$criteria->compare('Largo2',$this->Largo2,true);
		$criteria->compare('Alto2',$this->Alto2,true);
		$criteria->compare('Ancho2',$this->Ancho2,true);
		$criteria->compare('Volumen_Total2',$this->Volumen_Total2,true);
		$criteria->compare('Peso_Total2',$this->Peso_Total2,true);
		$criteria->compare('Cod_Barras2',$this->Cod_Barras2,true);
		$criteria->compare('Unidad_3',$this->Unidad_3,true);
		$criteria->compare('Cantidad3',$this->Cantidad3);
		$criteria->compare('Largo3',$this->Largo3,true);
		$criteria->compare('Alto3',$this->Alto3,true);
		$criteria->compare('Ancho3',$this->Ancho3,true);
		$criteria->compare('Volumen_Total3',$this->Volumen_Total3,true);
		$criteria->compare('Peso_Total3',$this->Peso_Total3,true);
		$criteria->compare('Cod_Barras3',$this->Cod_Barras3,true);
		$criteria->compare('Unidad_4',$this->Unidad_4,true);
		$criteria->compare('Cantidad4',$this->Cantidad4);
		$criteria->compare('Largo4',$this->Largo4,true);
		$criteria->compare('Alto4',$this->Alto4,true);
		$criteria->compare('Ancho4',$this->Ancho4,true);
		$criteria->compare('Volumen_Total4',$this->Volumen_Total4,true);
		$criteria->compare('Peso_Total4',$this->Peso_Total4,true);
		$criteria->compare('Cod_Barras4',$this->Cod_Barras4,true);
		$criteria->compare('Fecha_Creacion',$this->Fecha_Creacion,true);
		$criteria->compare('Fecha_Actualizacion',$this->Fecha_Actualizacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemUnidad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

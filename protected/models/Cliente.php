<?php

/**
 * This is the model class for table "TH_CLIENTES".
 *
 * The followings are the available columns in table 'TH_CLIENTES':
 * @property integer $C_ROWID
 * @property integer $C_CIA
 * @property integer $C_ROWID_CLIENTE
 * @property string $C_NIT_CLIENTE
 * @property string $C_NOMBRE_CLIENTE
 * @property string $C_ID_SUCURSAL
 * @property string $C_NOMBRE_SUCURSAL
 * @property integer $C_ROWID_CONTACTO
 * @property string $C_NOMBRE_CONTACTO
 * @property string $C_CIUDAD
 * @property string $C_DIRECCION
 * @property string $C_TELEFONO
 * @property string $C_ESTADO
 * @property string $C_CUPO
 * @property string $C_CO
 * @property string $C_ID_TERCERO
 * @property string $C_TIPO_ID
 * @property string $C_TIPO_PERSONA
 * @property string $C_APELLIDO
 * @property string $C_NOMBRES
 * @property string $C_TIPO_CLIENTE
 * @property string $C_COND_PAGO_CLI
 * @property integer $C_DIAS_GRACIA
 * @property string $C_LISTA_PRECIO
 * @property string $C_BLOQUEADO
 * @property string $C_BLOQ_CUPO
 * @property string $C_BLOQ_MORA
 * @property string $C_IVA
 * @property string $C_ICA
 * @property string $C_RENTA
 * @property string $C_RTIVA
 * @property string $C_RTICA
 * @property string $C_RTCREE
 * @property string $C_CO_MOVTO
 * @property string $C_UN_MOVTO
 * @property string $C_FECHA_NAC
 * @property string $C_CLASE
 * @property string $C_CANAL
 * @property string $C_ESTRUCTURA
 * @property string $C_SEGMENTO
 * @property string $C_TIPOLOGIA
 * @property string $C_REGIONALES
 * @property string $C_WMS
 * @property string $C_RUTA
 * @property string $C_DEPARTAMENTO
 * @property string $C_COND_PAGO
 * @property string $C_CLASIFICACION
 * @property string $C_FECHA
 */
class Cliente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_CLIENTES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('C_NOMBRE_CLIENTE, C_CLASE, C_CANAL, C_ESTRUCTURA, C_SEGMENTO, C_TIPOLOGIA, C_REGIONALES, C_WMS, C_RUTA, C_DEPARTAMENTO, C_COND_PAGO, C_CLASIFICACION', 'required'),
			array('C_CIA, C_ROWID_CLIENTE, C_ROWID_CONTACTO, C_DIAS_GRACIA', 'numerical', 'integerOnly'=>true),
			array('C_NIT_CLIENTE, C_ID_TERCERO', 'length', 'max'=>25),
			array('C_NOMBRE_CLIENTE, C_NOMBRE_SUCURSAL, C_NOMBRE_CONTACTO, C_TIPO_ID, C_TIPO_PERSONA, C_APELLIDO, C_NOMBRES, C_TIPO_CLIENTE, C_COND_PAGO_CLI, C_IVA, C_ICA, C_RENTA, C_RTIVA, C_RTICA, C_RTCREE, C_FECHA_NAC, C_CLASE, C_CANAL, C_ESTRUCTURA, C_SEGMENTO, C_TIPOLOGIA, C_REGIONALES, C_WMS, C_RUTA, C_DEPARTAMENTO, C_COND_PAGO, C_CLASIFICACION', 'length', 'max'=>50),
			array('C_ID_SUCURSAL, C_CO, C_LISTA_PRECIO, C_BLOQUEADO, C_BLOQ_CUPO, C_BLOQ_MORA, C_CO_MOVTO, C_UN_MOVTO', 'length', 'max'=>3),
			array('C_CIUDAD, C_DIRECCION', 'length', 'max'=>30),
			array('C_TELEFONO, C_ESTADO', 'length', 'max'=>20),
			array('C_CUPO', 'length', 'max'=>19),
			array('C_FECHA', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('C_ROWID, C_CIA, C_ROWID_CLIENTE, C_NIT_CLIENTE, C_NOMBRE_CLIENTE, C_ID_SUCURSAL, C_NOMBRE_SUCURSAL, C_ROWID_CONTACTO, C_NOMBRE_CONTACTO, C_CIUDAD, C_DIRECCION, C_TELEFONO, C_ESTADO, C_CUPO, C_CO, C_ID_TERCERO, C_TIPO_ID, C_TIPO_PERSONA, C_APELLIDO, C_NOMBRES, C_TIPO_CLIENTE, C_COND_PAGO_CLI, C_DIAS_GRACIA, C_LISTA_PRECIO, C_BLOQUEADO, C_BLOQ_CUPO, C_BLOQ_MORA, C_IVA, C_ICA, C_RENTA, C_RTIVA, C_RTICA, C_RTCREE, C_CO_MOVTO, C_UN_MOVTO, C_FECHA_NAC, C_CLASE, C_CANAL, C_ESTRUCTURA, C_SEGMENTO, C_TIPOLOGIA, C_REGIONALES, C_WMS, C_RUTA, C_DEPARTAMENTO, C_COND_PAGO, C_CLASIFICACION, C_FECHA', 'safe', 'on'=>'search'),
		);
	}

	public function searchByCliente($filtro) {
        
        $resp = Yii::app()->db->createCommand("
			SELECT TOP 10 C_ROWID_CLIENTE, C_NIT_CLIENTE,C_NOMBRE_CLIENTE FROM TH_CLIENTES WHERE C_CIA = 2 AND (C_NIT_CLIENTE LIKE '".$filtro."%' OR C_NOMBRE_CLIENTE LIKE '%".$filtro."%') GROUP BY C_ROWID_CLIENTE, C_NIT_CLIENTE,C_NOMBRE_CLIENTE ORDER BY C_NOMBRE_CLIENTE
		")->queryAll();
        return $resp;
        
 	}

 	public function DescCliente($id_cliente) {
        
        $q = Yii::app()->db->createCommand("SELECT C_ROWID_CLIENTE, C_NIT_CLIENTE,C_NOMBRE_CLIENTE FROM TH_CLIENTES WHERE C_CIA = 2 AND C_ROWID_CLIENTE = '".$id_cliente."'")->queryRow();
        return $q['C_NIT_CLIENTE'].' - '.$q['C_NOMBRE_CLIENTE'];
        
 	}

 	public function searchByClienteCart($filtro) {
        
        $resp = Yii::app()->db->createCommand("SELECT DISTINCT TOP 10 t2001.f200_razon_social AS CLIENTE FROM UnoEE1.dbo.t201_mm_clientes WITH (NOLOCK) INNER JOIN UnoEE1.dbo.t200_mm_terceros AS t2001 WITH (NOLOCK) ON t2001.f200_rowid = f201_rowid_tercero WHERE f200_id_cia = 2 AND t2001.f200_razon_social LIKE '%".$filtro."%' order by CLIENTE
		")->queryAll();
        return $resp;
        
 	}

 	public function searchByClienteCartNit($filtro) {
        
        $resp = Yii::app()->db->createCommand("SELECT DISTINCT TOP 10 t2001.f200_nit AS NIT, t2001.f200_razon_social AS CLIENTE FROM UnoEE1.dbo.t201_mm_clientes WITH (NOLOCK) INNER JOIN UnoEE1.dbo.t200_mm_terceros AS t2001 WITH (NOLOCK) ON t2001.f200_rowid = f201_rowid_tercero WHERE f200_id_cia = 2 AND (t2001.f200_nit LIKE '%".$filtro."%' OR t2001.f200_razon_social LIKE '%".$filtro."%') order by CLIENTE
		")->queryAll();
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'C_ROWID' => 'C Rowid',
			'C_CIA' => 'C Cia',
			'C_ROWID_CLIENTE' => 'C Rowid Cliente',
			'C_NIT_CLIENTE' => 'C Nit Cliente',
			'C_NOMBRE_CLIENTE' => 'C Nombre Cliente',
			'C_ID_SUCURSAL' => 'C Id Sucursal',
			'C_NOMBRE_SUCURSAL' => 'C Nombre Sucursal',
			'C_ROWID_CONTACTO' => 'C Rowid Contacto',
			'C_NOMBRE_CONTACTO' => 'C Nombre Contacto',
			'C_CIUDAD' => 'C Ciudad',
			'C_DIRECCION' => 'C Direccion',
			'C_TELEFONO' => 'C Telefono',
			'C_ESTADO' => 'C Estado',
			'C_CUPO' => 'C Cupo',
			'C_CO' => 'C Co',
			'C_ID_TERCERO' => 'C Id Tercero',
			'C_TIPO_ID' => 'C Tipo',
			'C_TIPO_PERSONA' => 'C Tipo Persona',
			'C_APELLIDO' => 'C Apellido',
			'C_NOMBRES' => 'C Nombres',
			'C_TIPO_CLIENTE' => 'C Tipo Cliente',
			'C_COND_PAGO_CLI' => 'C Cond Pago Cli',
			'C_DIAS_GRACIA' => 'C Dias Gracia',
			'C_LISTA_PRECIO' => 'C Lista Precio',
			'C_BLOQUEADO' => 'C Bloqueado',
			'C_BLOQ_CUPO' => 'C Bloq Cupo',
			'C_BLOQ_MORA' => 'C Bloq Mora',
			'C_IVA' => 'C Iva',
			'C_ICA' => 'C Ica',
			'C_RENTA' => 'C Renta',
			'C_RTIVA' => 'C Rtiva',
			'C_RTICA' => 'C Rtica',
			'C_RTCREE' => 'C Rtcree',
			'C_CO_MOVTO' => 'C Co Movto',
			'C_UN_MOVTO' => 'C Un Movto',
			'C_FECHA_NAC' => 'C Fecha Nac',
			'C_CLASE' => 'C Clase',
			'C_CANAL' => 'C Canal',
			'C_ESTRUCTURA' => 'C Estructura',
			'C_SEGMENTO' => 'C Segmento',
			'C_TIPOLOGIA' => 'C Tipologia',
			'C_REGIONALES' => 'C Regionales',
			'C_WMS' => 'C Wms',
			'C_RUTA' => 'C Ruta',
			'C_DEPARTAMENTO' => 'C Departamento',
			'C_COND_PAGO' => 'C Cond Pago',
			'C_CLASIFICACION' => 'C Clasificacion',
			'C_FECHA' => 'C Fecha',
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

		$criteria->compare('C_ROWID',$this->C_ROWID);
		$criteria->compare('C_CIA',$this->C_CIA);
		$criteria->compare('C_ROWID_CLIENTE',$this->C_ROWID_CLIENTE);
		$criteria->compare('C_NIT_CLIENTE',$this->C_NIT_CLIENTE,true);
		$criteria->compare('C_NOMBRE_CLIENTE',$this->C_NOMBRE_CLIENTE,true);
		$criteria->compare('C_ID_SUCURSAL',$this->C_ID_SUCURSAL,true);
		$criteria->compare('C_NOMBRE_SUCURSAL',$this->C_NOMBRE_SUCURSAL,true);
		$criteria->compare('C_ROWID_CONTACTO',$this->C_ROWID_CONTACTO);
		$criteria->compare('C_NOMBRE_CONTACTO',$this->C_NOMBRE_CONTACTO,true);
		$criteria->compare('C_CIUDAD',$this->C_CIUDAD,true);
		$criteria->compare('C_DIRECCION',$this->C_DIRECCION,true);
		$criteria->compare('C_TELEFONO',$this->C_TELEFONO,true);
		$criteria->compare('C_ESTADO',$this->C_ESTADO,true);
		$criteria->compare('C_CUPO',$this->C_CUPO,true);
		$criteria->compare('C_CO',$this->C_CO,true);
		$criteria->compare('C_ID_TERCERO',$this->C_ID_TERCERO,true);
		$criteria->compare('C_TIPO_ID',$this->C_TIPO_ID,true);
		$criteria->compare('C_TIPO_PERSONA',$this->C_TIPO_PERSONA,true);
		$criteria->compare('C_APELLIDO',$this->C_APELLIDO,true);
		$criteria->compare('C_NOMBRES',$this->C_NOMBRES,true);
		$criteria->compare('C_TIPO_CLIENTE',$this->C_TIPO_CLIENTE,true);
		$criteria->compare('C_COND_PAGO_CLI',$this->C_COND_PAGO_CLI,true);
		$criteria->compare('C_DIAS_GRACIA',$this->C_DIAS_GRACIA);
		$criteria->compare('C_LISTA_PRECIO',$this->C_LISTA_PRECIO,true);
		$criteria->compare('C_BLOQUEADO',$this->C_BLOQUEADO,true);
		$criteria->compare('C_BLOQ_CUPO',$this->C_BLOQ_CUPO,true);
		$criteria->compare('C_BLOQ_MORA',$this->C_BLOQ_MORA,true);
		$criteria->compare('C_IVA',$this->C_IVA,true);
		$criteria->compare('C_ICA',$this->C_ICA,true);
		$criteria->compare('C_RENTA',$this->C_RENTA,true);
		$criteria->compare('C_RTIVA',$this->C_RTIVA,true);
		$criteria->compare('C_RTICA',$this->C_RTICA,true);
		$criteria->compare('C_RTCREE',$this->C_RTCREE,true);
		$criteria->compare('C_CO_MOVTO',$this->C_CO_MOVTO,true);
		$criteria->compare('C_UN_MOVTO',$this->C_UN_MOVTO,true);
		$criteria->compare('C_FECHA_NAC',$this->C_FECHA_NAC,true);
		$criteria->compare('C_CLASE',$this->C_CLASE,true);
		$criteria->compare('C_CANAL',$this->C_CANAL,true);
		$criteria->compare('C_ESTRUCTURA',$this->C_ESTRUCTURA,true);
		$criteria->compare('C_SEGMENTO',$this->C_SEGMENTO,true);
		$criteria->compare('C_TIPOLOGIA',$this->C_TIPOLOGIA,true);
		$criteria->compare('C_REGIONALES',$this->C_REGIONALES,true);
		$criteria->compare('C_WMS',$this->C_WMS,true);
		$criteria->compare('C_RUTA',$this->C_RUTA,true);
		$criteria->compare('C_DEPARTAMENTO',$this->C_DEPARTAMENTO,true);
		$criteria->compare('C_COND_PAGO',$this->C_COND_PAGO,true);
		$criteria->compare('C_CLASIFICACION',$this->C_CLASIFICACION,true);
		$criteria->compare('C_FECHA',$this->C_FECHA,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cliente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

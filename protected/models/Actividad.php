<?php

/**
 * This is the model class for table "TH_ACTIVIDAD".
 *
 * The followings are the available columns in table 'TH_ACTIVIDAD':
 * @property integer $Id
 * @property string $Fecha
 * @property string $Hora
 * @property integer $Id_Usuario
 * @property string $Actividad
 * @property integer $Estado
 * @property string $Fecha_Cierre
 * @property string $Hora_Cierre
 * @property integer $Id_Usuario_Creacion
 * @property string $Fecha_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Fecha_Actualizacion
 * @property integer $Tipo
 *
 * The followings are the available model relations:
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class Actividad extends CActiveRecord
{
	public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_ACTIVIDAD';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Fecha, Hora, Id_Usuario, Actividad, Tipo, Estado', 'required','on'=>'create'),
			array('Actividad, Estado, Tipo','required','on'=>'update'),
			array('Id_Usuario, Estado, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Tipo', 'numerical', 'integerOnly'=>true),
			array('Actividad', 'length', 'max'=>300),
			array('Fecha_Cierre', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Fecha, Hora, Id_Usuario, Actividad, Estado, Fecha_Cierre, Hora_Cierre, Id_Usuario_Creacion, Fecha_Creacion, Id_Usuario_Actualizacion, Fecha_Actualizacion, Tipo, orderby', 'safe', 'on'=>'search'),
		);
	}

	public function HoraAmPm($hora) {

		if($hora != ""){
			return date('h:i A', strtotime($hora));
		}else{
			return '';
		}    
		
 	}

 	public function DescEstado($estado){

		switch ($estado) {
		    case 1:
		        $texto_estado = 'ABIERTA';
		        break;
		    case 2:
		        $texto_estado = 'CERRADA';
		        break;
		    case 3:
		        $texto_estado = 'EN ESPERA';
		        break;
		    case 4:
		        $texto_estado = 'EN PROCESO';
		        break;
		    
		}

		return $texto_estado;

	}

	public function DescTipo($tipo){

		switch ($tipo) {
		    case 1:
		        $texto_tipo = 'CAPACITACIÓN';
		        break;
		    case 2:
		        $texto_tipo = 'PROYECTO';
		        break;
		    case 3:
		        $texto_tipo = 'SOLICITUD';
		        break;
		    case 4:
		        $texto_tipo = 'SOPORTE';
		        break;
		    
		}

		return $texto_tipo;

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idusuario' => array(self::BELONGS_TO, 'Usuario', 'Id_Usuario'),
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
			'Id' => 'ID',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
			'Id_Usuario' => 'Responsable',
			'Actividad' => 'Actividad',
			'Estado' => 'Estado',
			'Fecha_Cierre' => 'Fecha de cierre',
			'Hora_Cierre' => 'Hora de cierre',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'orderby' => 'Orden de resultados',
			'Tipo' => 'Tipo',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Actividad',$this->Actividad,true);
		$criteria->compare('Estado',$this->Estado);
		$criteria->compare('Fecha_Cierre',$this->Fecha_Cierre,true);
		$criteria->compare('Hora_Cierre',$this->Hora_Cierre,true);
		$criteria->compare('Tipo',$this->Tipo);

		if($this->Id_Usuario != ""){
			$criteria->AddCondition("t.Id_Usuario = ".$this->Id_Usuario); 
	    }

		if($this->Fecha_Creacion != ""){
      		$fci = $this->Fecha_Creacion." 00:00:00";
      		$fcf = $this->Fecha_Creacion." 23:59:59";

      		$criteria->addBetweenCondition('t.Fecha_Creacion', $fci, $fcf);
    	}

		if($this->Id_Usuario_Creacion != ""){
			$criteria->AddCondition("t.Id_Usuario_Creacion = ".$this->Id_Usuario_Creacion); 
	    }

	     if(empty($this->orderby)){
			$criteria->order = 't.Id DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Id ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Id DESC'; 
			        break;
			    case 3:
			        $criteria->order = 't.Fecha ASC'; 
			        break;
			    case 4:
			        $criteria->order = 't.Fecha DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Actividad ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Actividad DESC'; 
			        break;
		        case 7:
			        $criteria->order = 't.Tipo ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.Tipo DESC'; 
			        break;
			    case 9:
			        $criteria->order = 'idusuario.Nombres ASC'; 
			        break;
			    case 10:
			        $criteria->order = 'idusuario.Nombres DESC'; 
			        break;
			    case 11:
			        $criteria->order = 't.Estado DESC'; 
			        break;
			    case 12:
			        $criteria->order = 't.Estado ASC'; 
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
	 * @return Actividad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "TH_INVENTARIO".
 *
 * The followings are the available columns in table 'TH_INVENTARIO':
 * @property integer $Id_Inventario
 * @property integer $Id_Suministro
 * @property integer $Id_Departamento
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property integer $Documento
 * @property integer $Cantidad
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 * @property integer $Tipo
 * @property string $Fecha
 * @property string $Notas
 *
 * The followings are the available model relations:
 * @property THDEPARTAMENTO $idDepartamento
 * @property THSUMINISTRO $idSuministro
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THUSUARIOS $idUsuarioActualizacion
 */
class Inventario extends CActiveRecord
{
	
	public $usuario_creacion;
	public $usuario_actualizacion;
	public $orderby;
	public $suminist;
	public $cant;
	public $dep;
	public $sum;
	public $not;
	public $opcion_exp;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_INVENTARIO';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Suministro, Id_Departamento, Documento, Cantidad, Tipo, Fecha', 'required'),
			array('opcion_exp', 'required','on'=>'existencias'),
			array('Id_Suministro, Id_Departamento, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Documento, Cantidad, Tipo', 'numerical', 'integerOnly'=>true),
			//array('Notas', 'length', 'max'=>250),
			array('Fecha_Creacion, Fecha_Actualizacion, Fecha', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Inventario, Id_Suministro, Id_Departamento, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Documento, Cantidad, Fecha_Creacion, Fecha_Actualizacion, Tipo, Fecha, usuario_creacion, usuario_actualizacion, orderby', 'safe', 'on'=>'search'),
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
			'iddepartamento' => array(self::BELONGS_TO, 'Departamento', 'Id_Departamento'),
			'idsuministro' => array(self::BELONGS_TO, 'Suministro', 'Id_Suministro'),
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
			'Id_Inventario' => 'ID',
			'Id_Suministro' => 'Suministro',
			'Id_Departamento' => 'Departamento',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Documento' => 'Documento',
			'Cantidad' => 'Cantidad',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'usuario_creacion' => 'Usuario que creo',
			'usuario_actualizacion' => 'Usuario que actualizó',
			'Tipo' => 'Tipo',
			'orderby' => 'Orden de resultados',
			'suminist' => 'Suministro',
			'cant' => 'Cantidad',
			'Fecha' => 'Fecha',
			'sum' => 'Suministro',
			'dep' => 'Departamento',
			'opcion_exp'=>'Mostrar en / Exportar a',
			'not' => 'Nota',
			'Notas' => 'Nota',
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

		$criteria->compare('t.Id_Inventario',$this->Id_Inventario);
		$criteria->compare('t.Documento',$this->Documento);
		$criteria->compare('t.Cantidad',$this->Cantidad);
		$criteria->compare('t.Tipo',$this->Tipo);

		if($this->Fecha != ""){
      		$fi = $this->Fecha." 00:00:00";
      		$ff = $this->Fecha." 23:59:59";

      		$criteria->addBetweenCondition('t.Fecha', $fi, $ff);
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

	    if($this->Id_Suministro != ""){
			$criteria->AddCondition("t.Id_Suministro = '".$this->Id_Suministro."'"); 
	    }

	     if($this->Id_Departamento != ""){
			$criteria->AddCondition("t.Id_Departamento = '".$this->Id_Departamento."'"); 
	    }

	    if(empty($this->orderby)){
			$criteria->order = 't.Id_Inventario DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Id_Inventario ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Id_Inventario DESC'; 
			        break;
			    case 3:
			        $criteria->order = 't.Documento ASC'; 
			        break;
			    case 4:
			        $criteria->order = 't.Documento DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Fecha ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Fecha DESC'; 
			        break;
			    case 7:
			        $criteria->order = 't.Tipo ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.Tipo DESC'; 
			        break;
			    case 9:
			        $criteria->order = 't.Cantidad ASC'; 
			        break;
			    case 10:
			        $criteria->order = 't.Cantidad DESC'; 
			        break;
			    case 11:
			        $criteria->order = 'idsuministro.Descripcion ASC'; 
			        break;
			    case 12:
			        $criteria->order = 'idsuministro.Descripcion DESC'; 
			        break;
			    case 13:
			        $criteria->order = 'iddepartamento.Descripcion ASC'; 
			        break;
			    case 14:
			        $criteria->order = 'iddepartamento.Descripcion DESC'; 
			        break; 
		        case 15:
			        $criteria->order = 'idusuariocre.Usuario ASC'; 
			        break;
			    case 16:
			        $criteria->order = 'idusuariocre.Usuario DESC'; 
			        break;
			    case 17:
			        $criteria->order = 't.Fecha_Creacion ASC'; 
			        break;
			    case 18:
			        $criteria->order = 't.Fecha_Creacion DESC'; 
			        break;
			    case 19:
			        $criteria->order = 'idusuarioact.Usuario ASC'; 
			        break;
			    case 20:
			        $criteria->order = 'idusuarioact.Usuario DESC'; 
			        break;
				case 21:
			        $criteria->order = 't.Fecha_Actualizacion ASC'; 
			        break;
			    case 22:
			        $criteria->order = 't.Fecha_Actualizacion DESC'; 
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
	 * @return Inventario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

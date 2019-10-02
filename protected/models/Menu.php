<?php

/**
 * This is the model class for table "TH_MENU".
 *
 * The followings are the available columns in table 'TH_MENU':
 * @property integer $Id_Menu
 * @property integer $Id_Padre
 * @property integer $Id_Usuario_Creacion
 * @property integer $Id_Usuario_Actualizacion
 * @property string $Descripcion
 * @property string $Link
 * @property integer $Orden
 * @property boolean $Estado
 * @property string $Font_Icon
 * @property string $Fecha_Creacion
 * @property string $Fecha_Actualizacion
 *
 * The followings are the available model relations:
 * @property Menu $idPadre
 * @property Menu[] $tHMENUs
 * @property THUSUARIOS $idUsuarioActualizacion
 * @property THUSUARIOS $idUsuarioCreacion
 * @property THMENUPERFIL[] $tHMENUPERFILs
 */
class Menu extends CActiveRecord
{
	
	public $usuario_creacion;
	public $usuario_actualizacion;
	public $padre;
	public $orderby;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'TH_MENU';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id_Padre, Descripcion, Link, Orden, Estado, Font_Icon', 'required','on'=>'create , update'),
			array('Id_Padre, Id_Usuario_Creacion, Id_Usuario_Actualizacion, Orden', 'numerical', 'integerOnly'=>true),
			array('Descripcion, Link, Font_Icon', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id_Menu, padre, Descripcion, Link, Orden, Estado, Fecha_Creacion, Fecha_Actualizacion, usuario_creacion, usuario_actualizacion, orderby', 'safe', 'on'=>'search'),
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
			'idpadre' => array(self::BELONGS_TO, 'Menu', 'Id_Padre'),
			'tHMENUs' => array(self::HAS_MANY, 'Menu', 'Id_Padre'),
			'idusuariocre' => array(self::BELONGS_TO, 'Usuario', 'Id_Usuario_Creacion'),
			'idusuarioact' => array(self::BELONGS_TO, 'Usuario', 'Id_Usuario_Actualizacion'),
			'tHMENUPERFILs' => array(self::HAS_MANY, 'THMENUPERFIL', 'Id_Menu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id_Menu' => 'ID',
			'Id_Padre' => 'Opción padre',
			'Id_Usuario_Creacion' => 'Usuario que creo',
			'Id_Usuario_Actualizacion' => 'Usuario que actualizó',
			'Descripcion' => 'Descripción',
			'Link' => 'Link',
			'Orden' => 'Orden',
			'Estado' => 'Estado',
			'Font_Icon' => 'Icono font awesome',
			'Fecha_Creacion' => 'Fecha de creación',
			'Fecha_Actualizacion' => 'Fecha de actualización',
			'usuario_creacion' => 'Usuario que creo',
			'usuario_actualizacion' => 'Usuario que actualizó',
			'padre' => 'Opción padre',
			'orderby' => 'Orden de resultados',
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
	   	$criteria->with=array('idusuariocre','idusuarioact', 'idpadre');

		$criteria->compare('t.Id_Menu',$this->Id_Menu);
		$criteria->compare('t.Descripcion',$this->Descripcion,true);
		$criteria->compare('t.Link',$this->Link,true);
		$criteria->compare('t.Orden',$this->Orden);
		$criteria->compare('t.Estado',$this->Estado);
		$criteria->compare('t.Font_Icon',$this->Font_Icon,true);
		$criteria->AddCondition("t.Id_Menu != 1"); 

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

	    if($this->padre != ""){
			$criteria->AddCondition("idpadre.Descripcion = '".$this->padre."'"); 
	    }

	    if(empty($this->orderby)){
			$criteria->order = 't.Id_Menu DESC'; 	
		}else{
			switch ($this->orderby) {
			    case 1:
			        $criteria->order = 't.Id_Menu ASC'; 
			        break;
			    case 2:
			        $criteria->order = 't.Id_Menu DESC'; 
			        break;
			    case 3:
			        $criteria->order = 'idpadre.Descripcion ASC'; 
			        break;
			    case 4:
			        $criteria->order = 'idpadre.Descripcion DESC'; 
			        break;
			    case 5:
			        $criteria->order = 't.Descripcion ASC'; 
			        break;
			    case 6:
			        $criteria->order = 't.Descripcion DESC'; 
			        break;
			    case 7:
			        $criteria->order = 't.Orden ASC'; 
			        break;
			    case 8:
			        $criteria->order = 't.Orden DESC'; 
			        break;
			    case 9:
			        $criteria->order = 't.Link ASC'; 
			        break;
			    case 10:
			        $criteria->order = 't.Link DESC'; 
			        break; 
		        case 11:
			        $criteria->order = 'idusuariocre.Usuario ASC'; 
			        break;
			    case 12:
			        $criteria->order = 'idusuariocre.Usuario DESC'; 
			        break;
			    case 13:
			        $criteria->order = 't.Fecha_Creacion ASC'; 
			        break;
			    case 14:
			        $criteria->order = 't.Fecha_Creacion DESC'; 
			        break;
			    case 15:
			        $criteria->order = 'idusuarioact.Usuario ASC'; 
			        break;
			    case 16:
			        $criteria->order = 'idusuarioact.Usuario DESC'; 
			        break;
				case 17:
			        $criteria->order = 't.Fecha_Actualizacion ASC'; 
			        break;
			    case 18:
			        $criteria->order = 't.Fecha_Actualizacion DESC'; 
			        break;
			    case 19:
			        $criteria->order = 't.Estado DESC'; 
			        break;
			    case 20:
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
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

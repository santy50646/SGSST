<?php

/**
 * This is the model class for table "cronograma".
 *
 * The followings are the available columns in table 'cronograma':
 * @property integer $id
 * @property string $Descripcion
 * @property string $Fecha
 * @property integer $estado
 * @property integer $PersonasProgramadas
 * @property integer $PersonasAsistieron
 */
class Cronograma extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cronograma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Descripcion, Fecha, estado', 'required'),
			array('estado, PersonasProgramadas, PersonasAsistieron', 'numerical', 'integerOnly'=>true),
			array('Descripcion', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Descripcion, Fecha, estado, PersonasProgramadas, PersonasAsistieron', 'safe', 'on'=>'search'),
			
			array('Descripcion', 'match', 'pattern'=>'/^[¿!¡;,:\.\?#@()"\p{L}\p{N}\s_]+$/u', 'message'=>Yii::t('app','Special characters are not valid')),
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
			'id' => 'ID',
			'Descripcion' => 'Descripcion',
			'Fecha' => 'Fecha',
			'estado' => 'Estado',
			'PersonasProgramadas' => 'Personas Programadas',
			'PersonasAsistieron' => 'Personas Asistieron',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('PersonasProgramadas',$this->PersonasProgramadas);
		$criteria->compare('PersonasAsistieron',$this->PersonasAsistieron);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cronograma the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	* Retorna la metrica que equivale al porcentaje de las personas invitadas que asistieron a la realizacion del cronograma.
	*/
	public function getMetrica()
	{
		$metrica=0; 
		$citados=$this->PersonasProgramadas; 
		$asistentes=$this->PersonasAsistieron; 
		$state=$this->estado; 
		if($asistentes!==null && $asistentes!==0 && $state == 1 )
		{
			$metrica=($asistentes*100)/$citados;		
		}

		return $metrica;

	}
	/**
	Retorna true si la fecha actual es mayor a la fecha de realizacion del cronograma, y de esta forma, saber si el cronograma esta vencido y debe realizarse.
	*/
	public function getVencido()
	{
		$date1=date('Y-m-d');
		$date2=$this->Fecha;
		if(strtotime($date1)>=strtotime($date2)&&$this->estado==0)
		{
			return true;
		}
		return false;
	}


	
}

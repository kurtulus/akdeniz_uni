<?php

/**
 * This is the model class for table "listening".
 *
 * The followings are the available columns in table 'listening':
 * @property integer $listening_id
 * @property string $listening_name
 * @property integer $listening_repeat_number
 * @property integer $listening_learning_guide_availability
 *
 * The followings are the available model relations:
 * @property Current[] $currents
 * @property ListeningLog[] $listeningLogs
 * @property Question[] $questions
 * @property SessionListening[] $sessionListenings
 */
class Listening extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'listening';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('listening_name, listening_repeat_number, listening_learning_guide_availability', 'required'),
			array('listening_repeat_number, listening_learning_guide_availability', 'numerical', 'integerOnly'=>true),
			array('listening_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('listening_id, listening_name, listening_repeat_number, listening_learning_guide_availability', 'safe', 'on'=>'search'),
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
			'currents' => array(self::HAS_MANY, 'Current', 'listening_id'),
			'listeningLogs' => array(self::HAS_MANY, 'ListeningLog', 'listening_id'),
			'questions' => array(self::HAS_MANY, 'Question', 'listening_id'),
			'sessionListenings' => array(self::HAS_MANY, 'SessionListening', 'listening_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'listening_id' => 'Listening',
			'listening_name' => 'Listening Name',
			'listening_repeat_number' => 'Listening Repeat Number',
			'listening_learning_guide_availability' => 'Listening Learning Guide Availability',
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

		$criteria->compare('listening_id',$this->listening_id);
		$criteria->compare('listening_name',$this->listening_name,true);
		$criteria->compare('listening_repeat_number',$this->listening_repeat_number);
		$criteria->compare('listening_learning_guide_availability',$this->listening_learning_guide_availability);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Listening the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

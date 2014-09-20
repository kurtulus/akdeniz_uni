<?php

/**
 * This is the model class for table "session_listening".
 *
 * The followings are the available columns in table 'session_listening':
 * @property integer $session_listening_id
 * @property integer $session_id
 * @property integer $listening_id
 *
 * The followings are the available model relations:
 * @property Listening $listening
 * @property Session $session
 */
class SessionListening extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'session_listening';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session_id, listening_id', 'required'),
			array('session_id, listening_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('session_listening_id, session_id, listening_id', 'safe', 'on'=>'search'),
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
			'listening' => array(self::BELONGS_TO, 'Listening', 'listening_id'),
			'session' => array(self::BELONGS_TO, 'Session', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'session_listening_id' => 'Session Listening',
			'session_id' => 'Session',
			'listening_id' => 'Listening',
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

		$criteria->compare('session_listening_id',$this->session_listening_id);
		$criteria->compare('session_id',$this->session_id);
		$criteria->compare('listening_id',$this->listening_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SessionListening the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

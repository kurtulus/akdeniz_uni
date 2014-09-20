<?php

/**
 * This is the model class for table "current".
 *
 * The followings are the available columns in table 'current':
 * @property integer $current_id
 * @property integer $student_id
 * @property integer $mod_id
 * @property integer $session_id
 * @property integer $listening_id
 *
 * The followings are the available model relations:
 * @property Listening $listening
 * @property Student $student
 * @property Mod $mod
 * @property Session $session
 */
class Current extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'current';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, mod_id, session_id, listening_id', 'required'),
			array('student_id, mod_id, session_id, listening_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('current_id, student_id, mod_id, session_id, listening_id', 'safe', 'on'=>'search'),
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
			'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
			'mod' => array(self::BELONGS_TO, 'Mod', 'mod_id'),
			'session' => array(self::BELONGS_TO, 'Session', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'current_id' => 'Current',
			'student_id' => 'Student',
			'mod_id' => 'Mod',
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

		$criteria->compare('current_id',$this->current_id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('mod_id',$this->mod_id);
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
	 * @return Current the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

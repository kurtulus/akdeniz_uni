<?php

/**
 * This is the model class for table "session_log".
 *
 * The followings are the available columns in table 'session_log':
 * @property integer $session_log_id
 * @property integer $session_id
 * @property integer $student_id
 * @property string $session_begin_time
 * @property string $session_end_time
 *
 * The followings are the available model relations:
 * @property Session $session
 * @property Student $student
 */
class SessionLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'session_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session_id, student_id', 'required'),
			array('session_id, student_id', 'numerical', 'integerOnly'=>true),
			array('session_begin_time, session_end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('session_log_id, session_id, student_id, session_begin_time, session_end_time', 'safe', 'on'=>'search'),
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
			'session' => array(self::BELONGS_TO, 'Session', 'session_id'),
			'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'session_log_id' => 'Session Log',
			'session_id' => 'Session',
			'student_id' => 'Student',
			'session_begin_time' => 'Session Begin Time',
			'session_end_time' => 'Session End Time',
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

		$criteria->compare('session_log_id',$this->session_log_id);
		$criteria->compare('session_id',$this->session_id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('session_begin_time',$this->session_begin_time,true);
		$criteria->compare('session_end_time',$this->session_end_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SessionLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

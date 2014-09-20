<?php

/**
 * This is the model class for table "student".
 *
 * The followings are the available columns in table 'student':
 * @property integer $student_id
 * @property string $student_username
 * @property string $student_name
 * @property string $student_surname
 * @property string $student_password
 *
 * The followings are the available model relations:
 * @property Current[] $currents
 * @property ListeningLog[] $listeningLogs
 * @property Questionnaire[] $questionnaires
 * @property SessionLog[] $sessionLogs
 * @property StudentQuestion[] $studentQuestions
 */
class Student extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'student';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_username, student_name, student_surname, student_password', 'required'),
			array('student_username, student_name, student_surname', 'length', 'max'=>100),
			array('student_password', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('student_id, student_username, student_name, student_surname, student_password', 'safe', 'on'=>'search'),
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
			'currents' => array(self::HAS_MANY, 'Current', 'student_id'),
			'listeningLogs' => array(self::HAS_MANY, 'ListeningLog', 'student_id'),
			'questionnaires' => array(self::HAS_MANY, 'Questionnaire', 'student_id'),
			'sessionLogs' => array(self::HAS_MANY, 'SessionLog', 'student_id'),
			'studentQuestions' => array(self::HAS_MANY, 'StudentQuestion', 'student_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'student_id' => 'Student',
			'student_username' => 'Student Username',
			'student_name' => 'Student Name',
			'student_surname' => 'Student Surname',
			'student_password' => 'Student Password',
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

		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('student_username',$this->student_username,true);
		$criteria->compare('student_name',$this->student_name,true);
		$criteria->compare('student_surname',$this->student_surname,true);
		$criteria->compare('student_password',$this->student_password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Student the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

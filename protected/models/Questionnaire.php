<?php

/**
 * This is the model class for table "questionnaire".
 *
 * The followings are the available columns in table 'questionnaire':
 * @property integer $questionnaire_id
 * @property integer $session_id
 * @property integer $student_id
 * @property integer $begin_questionnaire_answer
 * @property string $end_questionnaire_answer
 *
 * The followings are the available model relations:
 * @property Student $student
 * @property Session $session
 */
class Questionnaire extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'questionnaire';
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
			array('session_id, student_id, begin_questionnaire_answer', 'numerical', 'integerOnly'=>true),
			array('end_questionnaire_answer', 'length', 'max'=>1000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('questionnaire_id, session_id, student_id, begin_questionnaire_answer, end_questionnaire_answer', 'safe', 'on'=>'search'),
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
			'student' => array(self::BELONGS_TO, 'Student', 'student_id'),
			'session' => array(self::BELONGS_TO, 'Session', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'questionnaire_id' => 'Questionnaire',
			'session_id' => 'Session',
			'student_id' => 'Student',
			'begin_questionnaire_answer' => 'Begin Questionnaire Answer',
			'end_questionnaire_answer' => 'End Questionnaire Answer',
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

		$criteria->compare('questionnaire_id',$this->questionnaire_id);
		$criteria->compare('session_id',$this->session_id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('begin_questionnaire_answer',$this->begin_questionnaire_answer);
		$criteria->compare('end_questionnaire_answer',$this->end_questionnaire_answer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Questionnaire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

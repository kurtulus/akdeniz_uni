<?php

/**
 * This is the model class for table "listening_log".
 *
 * The followings are the available columns in table 'listening_log':
 * @property integer $listening_log_id
 * @property integer $student_id
 * @property integer $listening_id
 * @property string $listening_begin_time
 * @property string $listening_end_time
 *
 * The followings are the available model relations:
 * @property Student $student
 * @property Listening $listening
 */
class ListeningLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'listening_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student_id, listening_id', 'required'),
			array('student_id, listening_id', 'numerical', 'integerOnly'=>true),
			array('listening_begin_time, listening_end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('listening_log_id, student_id, listening_id, listening_begin_time, listening_end_time', 'safe', 'on'=>'search'),
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
			'listening' => array(self::BELONGS_TO, 'Listening', 'listening_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'listening_log_id' => 'Listening Log',
			'student_id' => 'Student',
			'listening_id' => 'Listening',
			'listening_begin_time' => 'Listening Begin Time',
			'listening_end_time' => 'Listening End Time',
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

		$criteria->compare('listening_log_id',$this->listening_log_id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('listening_id',$this->listening_id);
		$criteria->compare('listening_begin_time',$this->listening_begin_time,true);
		$criteria->compare('listening_end_time',$this->listening_end_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ListeningLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

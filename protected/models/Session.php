<?php

/**
 * This is the model class for table "session".
 *
 * The followings are the available columns in table 'session':
 * @property integer $session_id
 * @property string $session_name
 * @property integer $session_order
 * @property integer $mod_id
 *
 * The followings are the available model relations:
 * @property Current[] $currents
 * @property Questionnaire[] $questionnaires
 * @property Mod $mod
 * @property SessionListening[] $sessionListenings
 * @property SessionLog[] $sessionLogs
 */
class Session extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session_name, session_order, mod_id', 'required'),
			array('session_order, mod_id', 'numerical', 'integerOnly'=>true),
			array('session_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('session_id, session_name, session_order, mod_id', 'safe', 'on'=>'search'),
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
			'currents' => array(self::HAS_MANY, 'Current', 'session_id'),
			'questionnaires' => array(self::HAS_MANY, 'Questionnaire', 'session_id'),
			'mod' => array(self::BELONGS_TO, 'Mod', 'mod_id'),
			'sessionListenings' => array(self::HAS_MANY, 'SessionListening', 'session_id'),
			'sessionLogs' => array(self::HAS_MANY, 'SessionLog', 'session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'session_id' => 'Session',
			'session_name' => 'Session Name',
			'session_order' => 'Session Order',
			'mod_id' => 'Mod',
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

		$criteria->compare('session_id',$this->session_id);
		$criteria->compare('session_name',$this->session_name,true);
		$criteria->compare('session_order',$this->session_order);
		$criteria->compare('mod_id',$this->mod_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Session the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

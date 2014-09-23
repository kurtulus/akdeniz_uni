<?php

class ListController extends Controller
{
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	public function actionStudents(){
		$currents=Current::model()->with('student')->with('mod')->with('session')->with('listening')->findAll();

		$this->render('students',array('currents'=>$currents));
	}
	protected function getCorrectAnswerId($question_id)
	{
		$question=Question::model()->find('question_id=:question_id',array('question_id'=>$question_id));
		if($question){
			return $question->question_correct_answer_id;
		}
		else
		{
			return 0;
		}
	}
	protected function getSessionCompletionTime($session_id)
	{
		$session_log=SessionLog::model()->find('session_id=:session_id',array('session_id'=>$session_id));
		if($session_log)
		{
			if($session_log->session_end_time)
			{
				return "<b>Başlangıç: </b>".$session_log->session_begin_time." - <b>Bitiş: </b>".$session_log->session_end_time;
			}
			else
			{
				return "<b>Başlangıç: </b>".$session_log->session_begin_time." - <b>Bitiş: </b>Henüz tamamlanmadı!";
			}
		}
		else
		{
			return "<b>Henüz başlamadı!</b>";
		}
	}
	protected function getListeningCompletionTime($listening_id,$student_id)
	{
		$listening_log=ListeningLog::model()->find('listening_id=:listening_id AND student_id=:student_id',array(':listening_id'=>$listening_id,':student_id'=>$student_id));
		if($listening_log)
		{
			if($listening_log->listening_end_time)
			{
				return "<b>Başlangıç: </b>".$listening_log->listening_begin_time." - <b>Bitiş: </b>".$listening_log->listening_end_time;
			}
			else
			{
				return "<b>Başlangıç: </b>".$listening_log->listening_begin_time." - <b>Bitiş: </b>Henüz tamamlanmadı!";
			}
		}
		else
		{
			return "<b>Henüz başlamadı!</b>";
		}
	}
	protected function getYourAnswerId($question_id,$student_id)
	{
		$student_question=StudentQuestion::model()->find('student_id=:student_id AND question_id=:question_id',array('student_id'=>$student_id,'question_id'=>$question_id));
		if($student_question)
		{
			return $student_question->answer_id;
		}
		else
		{
			return 0;
		}		
	}
	public function actionResults()
	{
		$student_id=Yii::app()->request->getQuery("student_id",NULL);
		$current=Current::model()->find('student_id=:student_id',array(':student_id'=>$student_id));
		$all_sessions=Session::model()->findAll('mod_id=:mod_id',array(':mod_id'=>$current->mod_id));
		$all=array();
		foreach ($all_sessions as $key0=>$session) {

			$session_id=$session->session_id;

			$session_listenings=SessionListening::model()->findAll('session_id=:session_id',array(':session_id'=>$session_id));
			$all[$key0]["session_id"]=$session->session_id;
			$all[$key0]["session_name"]=$session->session_name;
			$all[$key0]["session_order"]=$session->session_order;
			$all[$key0]["mod_id"]=$session->mod_id;
			$all[$key0]["listenings"]=array();
			foreach ($session_listenings as $key=>$session_listening) 
			{
				$temp_listening_id=$session_listening->listening_id;
				$listening=Listening::model()->find('listening_id=:listening_id',array(':listening_id'=>$temp_listening_id));
				$all[$key0]["listenings"][$key]=array('listening_id'=>$listening->listening_id,
											  'listening_name'=>$listening->listening_name,
											  'listening_repeat_number'=>$listening->listening_repeat_number,
											  'listening_learning_guide_availability'=>$listening->listening_learning_guide_availability,

											);
				$criteria = new CDbCriteria();
				$criteria->addCondition("listening_id=:listening_id");
				//$criteria->order='RAND()';
				$criteria->params=array(':listening_id'=>$listening->listening_id);
				$questions = Question::model()->findAll($criteria);
				//$questions=Question::model()->findAll('listening_id=:listening_id',array('listening_id'=>$listening->listening_id));
				foreach ($questions as $key2 => $question) {
					$all[$key0]["listenings"][$key]['questions'][$key2]=array('question_id'=>$question->question_id,
																	  'question_body'=>$question->question_body,
																	  'question_correct_answer_id'=>$question->question_correct_answer_id,
																		);
					$criteria = new CDbCriteria();
					$criteria->addCondition("question_id=:question_id");
					//$criteria->order='RAND()';
					$criteria->params=array(':question_id'=>$question->question_id);
					$answers = Answer::model()->findAll($criteria);

					//$answers=Answer::model()->findAll('question_id=:question_id',array(':question_id'=>$question->question_id));
					foreach ($answers as $key3 => $answer) {
						$all[$key0]["listenings"][$key]['questions'][$key2]['answers'][$key3]=array('answer_id'=>$answer->answer_id,
																							'answer_body'=>$answer->answer_body
																							)	;				
					}
				}
			}
		}

		$this->render('results',array('all'=>$all,'student_id'=>$student_id));
	}
	protected function getSessionLogs($student_id){
		$session_logs=SessionLog::model()->findAll('student_id=:student_id AND (session_end_time!=NULL or session_end_time!="")',array(':student_id'=>$student_id));
		return $session_logs;		
	}
	protected function getPanel($id){
			$panel_array=array(
								1=>'info',
								2=>'success',
								3=>'warning',
								4=>'danger'
				);
			return $panel_array[$id];
	}
	protected function getModNumberofSession($id){
		$mod_array=array(
						1=>17,
						2=>17,
						3=>15,
						4=>15
			);
		return $mod_array[$id];
	}
	/*
	public function actionExam(){

		$chosenYear=Yii::app()->request->getParam('chosenYear','Year');
		$chosenTerm=Yii::app()->request->getParam('chosenTerm','Term');
		$chosenCourse=Yii::app()->request->getParam('chosenCourse','Course');
		$queryArray=array();

		$Criteria = new CDbCriteria();
		if($chosenYear!="Year"){$Criteria->addCondition("exam_year=".$chosenYear);}
		if($chosenTerm!="Term"){$Criteria->addCondition("exam_term_id=".$chosenTerm);}
		if($chosenCourse!="Course"){$Criteria->addCondition("exam_course_id='".$chosenCourse."'");}
		$Criteria->order = 'exam_year DESC, exam_term_id DESC';
		$exams = Exam::model()->findAll($Criteria);

		$terms=Term::model()->findAll();
		$courses=Course::model()->findAll();
		$minmax= Yii::app()->db->createCommand('SELECT MAX( exam_year ) AS maxYear, MIN(exam_year) AS minYear FROM  exam')->queryRow();


		$this->render('exam',array(
									'exams'=>$exams,
									'terms'=>$terms,
									'courses'=>$courses,
									'minYear'=>$minmax['minYear'],
									'maxYear'=>$minmax['maxYear'],
									'chosenYear'=>$chosenYear,
									'chosenTerm'=>$chosenTerm,
									'chosenCourse'=>$chosenCourse
									));

	}
	public function actionQuestion(){
		$Criteria = new CDbCriteria();
		$chosenCourse=Yii::app()->request->getParam('chosenCourse','Course');
		$chosenType=Yii::app()->request->getParam('chosenType','Type');
		$Criteria = new CDbCriteria();
		$Criteria->addCondition("question_template=1");//if it is template then list
		if($chosenCourse!="Course"){$Criteria->addCondition("question_course_id='".$chosenCourse."'");}
		if($chosenType!="Type"){$Criteria->addCondition("question_type='".$chosenType."'");}

		$Criteria->order = 'question_course_id DESC';
		$questions=Question::model()->findAll($Criteria);
		$courses=Course::model()->findAll();
		$this->render('question',array(
			'questions'=>$questions,
			'courses'=>$courses,
			'chosenCourse'=>$chosenCourse,
			'chosenType'=>$chosenType
			));
	}
	public function actionCourse(){
		$Criteria = new CDbCriteria();
		$Criteria->order = 'course_id ASC';
		$courses=Course::model()->findAll($Criteria);
		$this->render('course',array('courses'=>$courses));
	}
	public function actionCourseAndTerm(){
				$courses=Course::model()->findAll();
				$terms=Term::model()->findAll();
				$this->renderJSON(array("courses"=>$courses,"terms"=>$terms));
	}
	public function actionBasket()
	{
		$basket_base=base64_decode(Yii::app()->request->getParam('basket'));
		$basket_json=json_decode($basket_base);
		if(!empty($basket_json)){
			$Criteria = new CDbCriteria();
			foreach ($basket_json as $item) {
				$Criteria->addCondition("question_id=".$item,"OR");
			}
			$questions=Question::model()->findAll($Criteria);
		}
		else
		{
			$questions=array();
		}
		$this->renderJSON($questions);


	}
	public function getCourseCode($course_id)
	{
		if(is_numeric($course_id))
			return Course::model()->find('course_id=:course_id',array('course_id'=>$course_id))->course_code;
		else
			return $course_id;
	}
	public function getSpaceName($space_number)
	{
		return array("No Space","Short","Long","Whole Page")[$space_number];

	}
	public function getCourse($course_id)
	{
		return Course::model()->find('course_id=:course_id',array('course_id'=>$course_id));
	}
	public function getTermFormat($term,$type){
                $class="";

                if($term==1){
                    $class=$type."-warning";
                }
                else if($term==2){
                    $class=$type."-success";
                }
                else if($term==3){
                    $class=$type."-danger";
                }
                else if($term==4){
                    $class=$type."-info";
                }
                else
                {
                	$class=$type."-default";
                }
                return $class;
	}
	public function getQuestionType($type){
		return array("OpenEnded"=>4,"MultipleChoice"=>2,"Type"=>NULL)[$type];
	}*/

	public function renderJSON($data)
	{
	    header('Content-type: application/json');
	    echo CJSON::encode($data);

	    foreach (Yii::app()->log->routes as $route) {
	        if($route instanceof CWebLogRoute) {
	            $route->enabled = false; // disable any weblogroutes
	        }
	    }
	    Yii::app()->end();
	}

	public function filters()
    {
        return array(
            'accessControl',
        );
    }
	public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('@'),
            ),

            array('deny'),
        );
    }
	protected function beforeAction()
    {
    	if(!Yii::app()->user->isGuest)
    	{
		        if(Yii::app()->user->checkAccess(ucfirst($this->getId()) . ucfirst($this->getAction()->getId())))
		        {
		            return true;
		        } else {
		        	error_log(ucfirst($this->getId()) . ucfirst($this->getAction()->getId()));
		        	throw new CHttpException(401,'You are not authorized to perform this operation');
		            //Yii::app()->request->redirect(Yii::app()->user->returnUrl);
		        }
		}
		else
		{
			$this->redirect(Yii::app()->createUrl('site/login'));
		}
   }

}
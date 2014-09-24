<?php

class ApiController extends Controller
{

	public function actionOpen(){

	}
	public function actionGetAll(){

		$session_id=Yii::app()->request->getPost("session_id",NULL);
		
		$session=Session::model()->find('session_id=:session_id',array(':session_id'=>$session_id));
		$session_listenings=SessionListening::model()->findAll('session_id=:session_id',array(':session_id'=>$session_id));
		$all=array();
		$all["session_id"]=$session->session_id;
		$all["session_name"]=$session->session_name;
		$all["session_order"]=$session->session_order;
		$all["mod_id"]=$session->mod_id;
		$all["listenings"]=array();
		foreach ($session_listenings as $key=>$session_listening) 
		{
			$temp_listening_id=$session_listening->listening_id;
			$listening=Listening::model()->find('listening_id=:listening_id',array(':listening_id'=>$temp_listening_id));
			$all["listenings"][$key]=array('listening_id'=>$listening->listening_id,
										  'listening_name'=>$listening->listening_name,
										  'listening_repeat_number'=>$listening->listening_repeat_number,
										  'listening_learning_guide_availability'=>$listening->listening_learning_guide_availability,

										);
			$criteria = new CDbCriteria();
			$criteria->addCondition("listening_id=:listening_id");
			$criteria->order='RAND()';
			$criteria->params=array(':listening_id'=>$listening->listening_id);
			$questions = Question::model()->findAll($criteria);
			//$questions=Question::model()->findAll('listening_id=:listening_id',array('listening_id'=>$listening->listening_id));
			foreach ($questions as $key2 => $question) {
				$all["listenings"][$key]['questions'][$key2]=array('question_id'=>$question->question_id,
																  'question_body'=>$question->question_body,
																  'question_correct_answer_id'=>$question->question_correct_answer_id,
																	);
				$criteria = new CDbCriteria();
				$criteria->addCondition("question_id=:question_id");
				$criteria->order='RAND()';
				$criteria->params=array(':question_id'=>$question->question_id);
				$answers = Answer::model()->findAll($criteria);

				//$answers=Answer::model()->findAll('question_id=:question_id',array(':question_id'=>$question->question_id));
				foreach ($answers as $key3 => $answer) {
					$all["listenings"][$key]['questions'][$key2]['answers'][$key3]=array('answer_id'=>$answer->answer_id,
																						'answer_body'=>$answer->answer_body
																						)	;				
				}
			}
		}
		$this->renderJSON($all);

	}
	public function actionPushAnswer(){
		$student_id=Yii::app()->request->getPost("student_id",NULL);
		$answers=json_decode(Yii::app()->request->getPost("answers",NULL),true);
		$response=array();
		foreach ($answers as $answer) 
		{

	 		$question_id=key($answer);
	 		$answer_id=$answer[$question_id];
	 		$studentQuestion=new StudentQuestion();
	 		$studentQuestion->student_id=$student_id;
	 		$studentQuestion->question_id=$question_id;
	 		$studentQuestion->answer_id=$answer_id;

	 		if(!$studentQuestion->save()){
	 			$this->renderJSON($studentQuestion->getErrors());
	 		}
		}

	 	$this->renderJSON(array('status'=>1,'message'=>'Successfully saved!'));
	}

////////////////////////////////////////////////////////////////////////////
	public function actionPushQuestionnaireBegin()
	{
		$student_id=Yii::app()->request->getPost("student_id",NULL);	
		$session_id=Yii::app()->request->getPost("session_id",NULL);	
		$begin_questionnaire_answer=Yii::app()->request->getPost("begin_questionnaire_answer",NULL);
		$questionnaire=new Questionnaire();
		$questionnaire->student_id=$student_id;
		$questionnaire->session_id=$session_id;
		$questionnaire->begin_questionnaire_answer=$begin_questionnaire_answer;
		$questionnaire->end_questionnaire_answer="";
		if(!$questionnaire->save())
		{
	 		$this->renderJSON($questionnaire->getErrors());
	 	}
	 	else
	 	{
	 		$this->renderJSON(array('status'=>1,'message'=>'Successfully saved!'));	 		
	 	}



	}
	protected function getMaxOrder($student_id){
		$current=Current::model()->find('student_id=:student_id',array('student_id'=>$student_id));
		if($current)
		{
			$model = new Session;
			$criteria=new CDbCriteria;
			$criteria->condition = "mod_id =:mod_id";
			$criteria->params = array(':mod_id' => $current->mod_id);
			//$criteria->order="'session_id DESC'";
			$rows = $model->model()->findAll($criteria);
			//print_r($row);
			return sizeof($rows);
			//return $row['maxColumn'];

		}
	}
	public function actionPushQuestionnaireEnd()
	{
		$student_id=Yii::app()->request->getPost("student_id",NULL);	
		$session_id=Yii::app()->request->getPost("session_id",NULL);


		/*
			next session
		*/
		$session=Session::model()->find('session_id=:session_id',array(':session_id'=>$session_id));

		$mod_id=$session->mod_id;
		$next_order=($session->session_order)+1;
		$next_session=Session::model()->find('mod_id=:mod_id AND session_order=:session_order',array(':mod_id'=>$mod_id,':session_order'=>$next_order));

		$current=Current::model()->find('student_id=:student_id',array(':student_id'=>$student_id));
		//error_log(print_r($current,1));
		//error_log("\n");
		//error_log(print_r($next_session,1));

		if($this->getMaxOrder($student_id)<$next_order)
		{

		}

		if($current && $next_session)
		{

			$session_listening=SessionListening::model()->find('session_id=:session_id',array('session_id'=>$next_session->session_id));
			$current->session_id=$next_session->session_id;
			if($current->save()){	
				$current->listening_id=$session_listening->listening_id;
				$current->save();
			}
			

		}



		$end_questionnaire_answer=Yii::app()->request->getPost("end_questionnaire_answer",NULL);
		$questionnaire=Questionnaire::model()->find('student_id=:student_id AND session_id=:session_id',array(':student_id'=>$student_id,':session_id'=>$session_id));
		if($questionnaire)
		{
			$questionnaire->end_questionnaire_answer=$end_questionnaire_answer;

			if(!$questionnaire->save())
			{
		 		$this->renderJSON($questionnaire->getErrors());
		 	}
		 	else
		 	{
		 		$this->renderJSON(array('status'=>1,'message'=>'Successfully saved!'));	 		
		 	}
		}
		else
		{
			$this->renderJSON(array('status'=>0,'message'=>'Given Questionnaire could not be found!'));	
		}
	}	

////////////////////////////////////////////////////////////////////////////
	public function actionPushSessionLogBegin()
	{
		$student_id=Yii::app()->request->getPost("student_id",NULL);	
		$session_id=Yii::app()->request->getPost("session_id",NULL);	
		$session_begin_time=Yii::app()->request->getPost("session_begin_time",NULL);
		$session=new SessionLog();
		$session->student_id=$student_id;
		$session->session_id=$session_id;
		$session->session_begin_time=$session_begin_time;

		if(!$session->save())
		{
	 		$this->renderJSON($session->getErrors());
	 	}
	 	else
	 	{
	 		$this->renderJSON(array('status'=>1,'message'=>'Successfully saved!'));	 		
	 	}		
	}
	public function actionPushSessionLogEnd()
	{
		$student_id=Yii::app()->request->getPost("student_id",NULL);	
		$session_id=Yii::app()->request->getPost("session_id",NULL);	
		$session_end_time=Yii::app()->request->getPost("session_end_time",NULL);

		$session=SessionLog::model()->find('student_id=:student_id AND session_id=:session_id',array(':student_id'=>$student_id,':session_id'=>$session_id));
		if($session)
		{
			$session->session_end_time=$session_end_time;

			if(!$session->save())
			{
		 		$this->renderJSON($session->getErrors());
		 	}
		 	else
		 	{
		 		$this->renderJSON(array('status'=>1,'message'=>'Successfully saved!'));	 		
		 	}
		}
		else
		{
			$this->renderJSON(array('status'=>0,'message'=>'Given Questionnaire could not be found!'));	
		}
	}

///////////////////////////////////////////////////////////////////////////


	public function actionPushListeningLogBegin()
	{
		$student_id=Yii::app()->request->getPost("student_id",NULL);	
		$listening_id=Yii::app()->request->getPost("listening_id",NULL);	
		$listening_begin_time=Yii::app()->request->getPost("listening_begin_time",NULL);
		$listening=new ListeningLog();
		$listening->student_id=$student_id;
		$listening->listening_id=$listening_id;
		$listening->listening_begin_time=$listening_begin_time;

		if(!$listening->save())
		{
	 		$this->renderJSON($listening->getErrors());
	 	}
	 	else
	 	{
	 		$this->renderJSON(array('status'=>1,'message'=>'Successfully saved!'));	 		
	 	}		

	}
	protected function getNextListening(&$session_listenings,$listening_id){
		$next_flag=false;

		foreach ($session_listenings as $session_listening) 
		{
			if($next_flag)
			{
				return $session_listening->listening_id;
			}
			if($session_listening->listening_id==$listening_id)
			{
				$next_flag=true;
			}
		}
		return -1;

	}
	protected function setNextListening($student_id,$listening_id){

		$current=Current::model()->find('student_id=:student_id',array(':student_id'=>$student_id));
		$current_session_id=$current->session_id;
		//set next listening
		$session_listenings=SessionListening::model()->findAll('session_id=:session_id',array(':session_id'=>$current_session_id));

		$next_listening_id=$this->getNextListening($session_listenings,$listening_id);
		if($next_listening_id!=-1)
		{
			
			if($current)
			{
				$current->listening_id=$next_listening_id;
				$current->save();
			}
		}
	}
	public function actionPushListeningLogEnd()
	{
		$student_id=Yii::app()->request->getPost("student_id",NULL);	
		$listening_id=Yii::app()->request->getPost("listening_id",NULL);	
		$listening_end_time=Yii::app()->request->getPost("listening_end_time",NULL);

		$this->setNextListening($student_id,$listening_id);


		$listening=ListeningLog::model()->find('student_id=:student_id AND listening_id=:listening_id',array(':student_id'=>$student_id,':listening_id'=>$listening_id));
		if($listening)
		{
			$listening->listening_end_time=$listening_end_time;

			if(!$listening->save())
			{
		 		$this->renderJSON($listening->getErrors());
		 	}
		 	else
		 	{
		 		$this->renderJSON(array('status'=>1,'message'=>'Successfully saved!'));	 		
		 	}
		}
		else
		{
			$this->renderJSON(array('status'=>0,'message'=>'Given Questionnaire could not be found!'));	
		}		
	}

////////////////////////////////////////////////////////////////////////////////////

	public function actionGetCurrent()
	{
		$student_id=Yii::app()->request->getPost("student_id",NULL);
		$current=Current::model()->find('student_id=:student_id',array('student_id'=>$student_id));
		$this->renderJSON($current);
	}
	public function actionGetMod()
	{
		$mod_id=Yii::app()->request->getPost("mod_id",NULL);
		$mod=Mod::model()->find('mod_id=:mod_id',array('mod_id'=>$mod_id));
		$this->renderJSON($mod);		
	}
	public function actionPushLogin(){
		$student_username=Yii::app()->request->getPost("student_username",NULL);
		$student_password=Yii::app()->request->getPost("student_password",NULL);
		$student=Student::model()->find('student_username=:student_username',array(':student_username'=>$student_username));
		if($student)
		{
			if($student->student_password==hash('sha512', $student_password.Yii::app()->params['salt']))
			{
				$current=Current::model()->find('student_id=:student_id',array('student_id'=>$student->student_id));
				$mod=Mod::model()->find('mod_id=:mod_id',array('mod_id'=>$current->mod_id));
				$response=array('student_id'=>$student->student_id,
								'student_username'=>$student->student_username,
								'student_name'=>$student->student_name,
								'student_surname'=>$student->student_surname,
								'mod_name'=>$mod->mod_name
								);
				
				$this->renderJSON($response);
			}
			else
			{
				$this->renderJSON(array('status'=>0,'message'=>'either username or password is not correct!'));	
			}
		}
		else
		{
			$this->renderJSON(array('status'=>0,'message'=>'there is no such a user registered!'));
		}

	}

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
	
}
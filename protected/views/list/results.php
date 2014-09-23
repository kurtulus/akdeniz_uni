<div class="container">

<?php
//print_r($all);
$results=array();
$results["incorrect"]=0;
$results["correct"]=0;
$results["empty"]=0;

foreach ($all as $session) {
	$results[$session['session_name']]=array();

	$results[$session['session_name']]["incorrect"]=0;
	$results[$session['session_name']]["correct"]=0;
	$results[$session['session_name']]["empty"]=0;
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><big><?php echo $session['session_name'];?></big></h3><br>
        <div class="alert alert-warning" role="alert"><?php echo $this->getSessionCompletionTime($session['session_id']);?></div>
    </div>
    <div class="panel-body">
    	<div class="alert alert-info" role="alert">
    	<?php 
    		$listenings=$session['listenings'];
    		foreach ($listenings as $listening) {
    			$results[$session['session_name']][$listening["listening_name"]]=array();
    			$results[$session['session_name']][$listening["listening_name"]]["correct"]=0;
    			$results[$session['session_name']][$listening["listening_name"]]["incorrect"]=0;
    			$results[$session['session_name']][$listening["listening_name"]]["empty"]=0;
    	?>
    		<div class="panel panel-info">
    			<div class="panel-heading">
    				<h5 class="panel-title"><?php echo "(".$listening["listening_name"].") X ".$listening["listening_repeat_number"];?></h5><br>
    				<div class="alert alert-warning" role="alert"><?php echo $this->getListeningCompletionTime($listening["listening_id"],$student_id);?></div>
    			</div>
    			<div class="panel-body">
    			    	<?php 
				    		$questions=$listening['questions'];
				    		foreach ($questions as $question) {
				    			$correct_answer_id=$this->getCorrectAnswerId($question["question_id"]);
				    			$your_answer_id=$this->getYourAnswerId($question["question_id"],$student_id);
				    			//error_log($listening["listening_name"].":"."correct_answer_id:".$correct_answer_id."-".$your_answer_id."\n");
				    	?>
				    	<div class="alert alert-info" role="alert">
				    	<?php echo $question["question_body"]."<br><br>";
				    		$answers=$question['answers'];
				    		foreach ($answers as $answer) 
				    		{
				    	?>
				    			<div style="margin-left:50px;background-color:white" class="alert alert-default" role="alert">
				    				<?php echo $answer["answer_body"];?>
				    				<?php 
				    					if($answer["answer_id"]==$correct_answer_id)
				    					{
				    						echo '<span class="label label-success">Doğru Cevap</span>';
				    					}
				    					if($answer["answer_id"]==$your_answer_id)
				    					{
				    						echo '<span class="label label-info">Öğrencinin Cevabı</span>';
				    					}


				    				?>
				    			</div>
				    	<?php }
	    					if($correct_answer_id==$your_answer_id)
	    					{
	    						$results[$session['session_name']][$listening["listening_name"]]["correct"]+=1;
	    						$results[$session['session_name']]["correct"]+=1;
	    						$results["correct"]+=1;

	    					}
				    		else if($your_answer_id!=0)
				    		{
				    			$results[$session['session_name']][$listening["listening_name"]]["incorrect"]+=1;
				    			$results[$session['session_name']]["incorrect"]+=1;
				    			$results["incorrect"]+=1;
				    		}
				    		else
				    		{
				    			$results[$session['session_name']][$listening["listening_name"]]["empty"]+=1;
				    			$results[$session['session_name']]["empty"]+=1;
				    			$results["empty"]+=1;
				    		}
				    	 ?>
				    	</div>
				    	<?php } ?>
    			</div>
    		</div>
    	<?php } ?>
    	</div>
    </div>
 	<div class="panel-footer clearfix">
        <div class="pull-right">
            <!--<a href="<?php echo Yii::app()->getBaseUrl(true);?>/list/results?student_id=" class="btn btn-primary">Sonuçlar</a>-->
        </div>
    </div>
</div>

<h3>Results</h3>
<hr>
<?php 
}
//print_r($results);

foreach ($results as $session_name=>$sessions) 
{
	//echo $session_name."<br>";
	if($session_name!="incorrect" && $session_name!="correct" && $session_name!="empty")
	{
	echo "<h4 style='margin-bottom:0px'>".$session_name."</h4><hr style='margin:0px'>";
	foreach ($sessions as $listening_name=>$session) 
	{
		?>
			<h5>
				<?php if($listening_name!="incorrect" && $listening_name!="correct" && $listening_name!="empty"){
					?>
					<span style="display:inline-block;width:100px;"><?php echo $listening_name;?>:</span>
					<span class="label label-success">Doğru:<?php echo $session["correct"] ?></span>
					<span class="label label-warning">Yanlış:<?php echo $session["incorrect"] ?></span>
					<span class="label label-info">Cevaplanmayan:<?php echo $session["empty"] ?></span>
			</h5>
		<!--
		/*echo $listening_name."<br>";
		echo "Correct:".$session["correct"]."<br>";
		echo "Incorrect:".$session["incorrect"]."<br>";
		echo "Empty:".$session["empty"]."<br>";*/
		//print_r($session);echo "<br>";-->

	<?php
		}
	}
	?>
		<h5><span style="display:inline-block;width:100px;">Toplam:</span>
					<span class="label label-success">Doğru:<?php echo $results[$session_name]["correct"];?></span>
					<span class="label label-warning">Yanlış:<?php echo $results[$session_name]["incorrect"];?></span>
					<span class="label label-info">Cevaplanmayan:<?php echo $results[$session_name]["empty"];?></span>
		</h5>
	<?php

	echo "<br>";
	
	}

}

?>
<hr>
<h4>Genel Toplam</h4>
<div class="alert alert-success col-lg-4">
<strong>Doğruların sayısı:</strong><?php echo $results["correct"];?>
</div>
<div class="alert alert-warning col-lg-4">
<strong>Yanlışların sayısı:</strong><?php echo $results["incorrect"];?>
</div>
<div class="alert alert-info col-lg-4">
<strong>Cevaplanmayanların sayısı:</strong><?php echo $results["empty"];?>
</div>
</div>
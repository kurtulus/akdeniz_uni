<div class="container">

<?php
//print_r($all);
foreach ($all as $session) {
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><big><?php echo $session['session_name'];?></big></h3>
    </div>
    <div class="panel-body">
    	<div class="alert alert-info" role="alert">
    	<?php 
    		$listenings=$session['listenings'];
    		foreach ($listenings as $listening) {
    	?>
    		<div class="panel panel-info">
    			<div class="panel-heading">
    				<h5 class="panel-title"><?php echo "(".$listening["listening_name"].") X ".$listening["listening_repeat_number"];?></h5>
    			</div>
    			<div class="panel-body">
    			    	<?php 
				    		$questions=$listening['questions'];
				    		foreach ($questions as $question) {
				    			$correct_answer_id=$this->getCorrectAnswerId($question["question_id"]);
				    			$your_answer_id=$this->getYourAnswerId($question["question_id"],$student_id);
				    	?>
				    	<div class="alert alert-info" role="alert">
				    	<?php echo $question["question_body"]."<br><br>";
				    		$answers=$question['answers'];
				    		foreach ($answers as $answer) {
				    	?>
				    			<div style="margin-left:50px;background-color:white" class="alert alert-default" role="alert">
				    				<?php echo $answer["answer_body"];?>
				    				<?php 
				    					if($answer["answer_id"]==$correct_answer_id)
				    					{
				    						echo '<span class="label label-success">Correct Answer</span>';
				    					}
				    					if($answer["answer_id"]==$your_answer_id)
				    					{
				    						echo '<span class="label label-info">Your Answer</span>';
				    					}

				    				?>
				    			</div>
				    	<?php } ?>
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


<?php 
}
?>
</div>
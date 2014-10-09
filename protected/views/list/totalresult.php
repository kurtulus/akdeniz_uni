<?php

	//print_r($all);

?>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Adı soyadı</th>
            <?php 
            $listening_number=0;
            for($i=0;$i<25*5;$i++)
            {
            	$question_number=(($i%5)+1);
            	if($question_number==1){
            		$listening_number++;
            	}
            	echo "<th>L".$listening_number."_".$question_number."</th>";
            }
            ?>
        </tr>
    </thead>
    <?php 
    	foreach ($all as $student) {
    ?>
    	
    <tr>
    	<td><?php echo $student["student_name"]." ".$student["student_surname"];?></td>
    	<?php foreach ($student["student_infos"] as $session) {
    		foreach ($session["listenings"] as $key=>$listening) 
    		{
    			foreach ($listening["questions"] as $key1 => $question) 
    			{
    				$your_answer_id=$this->getYourAnswerId($question["question_id"],$student["student_id"]);
    				$correct_answer_id=$question["question_correct_answer_id"];
    				if($your_answer_id)
    				{
    					if($your_answer_id==$correct_answer_id)
    					{
    						echo "<td>"."1"."</td>";
    					}
    					else
    					{
    						echo "<td>"."0"."</td>";
    					}
    				}
    				else
    				{
    					echo "<td>"."</td>";
    				}
    			}	
    		}
    	}
    	?>
    </tr>
    <?php }?>
</table>

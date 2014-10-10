<?php

	//print_r($all);

?>
<div class="container">
<div class="panel panel-<?php echo $this->getPanel($mod->mod_id);?>">
    <div class="panel-heading">
        <h3 class="panel-title"><big><?php echo $mod->mod_name;?><small> / <?php echo $all_student->student_name." ".$all_student->student_surname."(".$all_student->student_username.")";?></small></big></h3>
    </div>
    <div class="panel-body">

<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Soru No</th>
            <?php 
            foreach ($sessionListening as $session_listening_item) 
            {
            	echo "<th>".$session_listening_item->listening->listening_name."</th>";
            }
            ?>
        </tr>
    </thead>
        <?php
            for($j=0;$j<5;$j++)
            {
                echo "<tr>";
                echo "<td>".($j+1)."</td>";
                foreach ($sessionListening as $session_listening_item) 
                {
                    $result=$all[$session_listening_item->listening->listening_id][$j];
                    if($result==-1)
                    {
                        echo "<td></td>";
                    }
                    else
                    {
                        echo "<td>".$result."</td>";
                    }
                }
                echo "</tr>";
            }
        ?>
</table>
</div>
</div>
</div>

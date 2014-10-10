<?php

	//print_r($all);

?>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Oturum No</th>
            <th>Oturum Durumu</th>
            <?php
                for($i=1;$i<=26;$i++)
                {
                	echo "<th>".$i."</th>";
                }
            ?>
        </tr>
    </thead>
    <?php 
    	foreach ($all_sessions as $session) {
    ?>
    	
    <tr>
    	<td><?php echo $session->session_name;?></td>
    	<td><?php echo $this->checkSessionStatus($session->session_id);?></td>
        <?php
            for($i=1;$i<=26;$i++)
            {
                if(isset($session_listening_map[$session->session_id][$i]))
                {
                    $listening_id=$session_listening_map[$session->session_id][$i];
                    echo "<td>".$this->checkListeningStatus($student_id,$listening_id)."</td>";
                }
                else
                {
                    echo "<td></td>";
                }
                //if($listening_id)
                    //echo "<td>".checkListeningStatus($student_id,$listening_id)."</td>";
                
            }
        ?>
    </tr>
    <?php }?>
</table>

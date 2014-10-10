<?php

//print_r($session_listening_map);

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
    	<td><a style="width:100%" href="<?php echo Yii::app()->getBaseUrl(true);?>/list/sessionResults?session_id=<?php echo $session->session_id;?>&student_id=<?php echo $all_student->student_id;?>" class="btn btn-primary"><?php echo $session->session_name;?></a></td>
    	<td><?php echo $this->checkSessionStatus($session->session_id);?></td>
        <?php
            for($i=0;$i<26;$i++)
            {
                if(isset($session_listening_map[$session->session_order][$i+1]))
                {
                    $listening_id=$session_listening_map[$session->session_order][$i+1];
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

</div>
</div>

</div>
<div class="container">

<div class="panel">
	 <div class="panel-body">
        <div class="pull-right">
        	<a href="<?php echo Yii::app()->getBaseUrl(true);?>/list/totalResult" class="btn btn-info btn-lg">Toplu Sonuçlar</a>
            <a href="<?php echo Yii::app()->getBaseUrl(true);?>/list/reset" class="btn btn-danger btn-lg">Sıfırla</a>
        </div>	 
	 </div>
</div>

<?php
foreach ($currents as $current_order => $current) {
	$percentage=round(100*($current->session->session_order)/($this->getModNumberofSession($current->mod->mod_id)));
?>

<div class="panel <?php echo "panel-".$this->getPanel($current->mod->mod_id); ?>">
    <div class="panel-heading">
        <h3 class="panel-title"><big><?php echo $current->mod->mod_name;?><small> / <?php echo $current->student->student_name." ".$current->student->student_surname."(".$current->student->student_username.")";?></small></big></h3>
    </div>
    <div class="panel-body">

    	<div class="alert alert-<?php echo $this->getPanel($current->mod->mod_id);?>" role="alert">
    	<h4>Şu anki durum:</h4>
    		<?php echo $current->session->session_name;?>/<?php echo $current->listening->listening_name;?>
    		<div class="progress">
			  <div class="progress-bar progress-bar-striped active progress-bar-<?php echo $this->getPanel($current->mod->mod_id);?>" role="progressbar" aria-valuenow="<?php echo $percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage;?>%;">
			    <?php echo $percentage;?>%
			  </div>
			</div>
    	</div>
    	<div class="alert alert-<?php echo $this->getPanel($current->mod->mod_id);?>" role="alert">
    	 <?php $session_logs=$this->getSessionLogs($current->student_id); $complete_percentage=round(100*(sizeof($session_logs))/($this->getModNumberofSession($current->mod->mod_id)));?>
    	<h4>Tamamlananlar:</h4>
    		<div class="progress">
			  <div class="progress-bar progress-bar-<?php echo $this->getPanel($current->mod->mod_id);?>" role="progressbar" aria-valuenow="<?php echo $complete_percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $complete_percentage;?>%;">
			   <?php echo $complete_percentage;?>%
			  </div>
			</div>
    	</div>
    </div>
 <div class="panel-footer clearfix">
        <div class="pull-right">
            <a href="<?php echo Yii::app()->getBaseUrl(true);?>/list/results?student_id=<?php echo $current->student_id;?>" class="btn btn-primary">Sonuçlar</a>
        </div>
    </div>
</div>
<hr>
<?php
}
?>

</div>

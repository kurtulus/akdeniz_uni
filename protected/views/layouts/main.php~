<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Linden Question Builder</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true);?>/js/library/base64.js"></script>
<script type="text/javascript">
	$(document).ready(function(){




});	
</script>
<style type="text/css">
	.lindenLogo{
		height:180%;
		margin-top: -16px;
	}
</style>
</head> 
<body>
<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a href="<?php echo Yii::app()->request->getBaseUrl(true);?>" class="navbar-brand" id="lindenBrand"><img class="lindenLogo" src="<?php echo Yii::app()->getBaseUrl(true);?>/images/logo.png"/>YADEPOD eğitimi yoğun dinleme tabanlı yabancı dil öğrenme eğitimi</a>

        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <!--<ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Messages</a></li>
            </ul>-->
            <?php if(!Yii::app()->user->isGuest) {?>
            <ul class="nav navbar-nav navbar-right">

            <!--
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="add"><span class="glyphicon glyphicon-plus"></span></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#" data-toggle="modal" id="add_course">Add Course</a></li>
                         <li><a href="#" data-toggle="modal" id="add_exam">Add Exam</a></li>
                         <li><a href="#" data-toggle="modal" id="add_question">Add Question Template</a></li>
                    </ul>
                </li>-->
                <!--<li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" id="list"><span class="glyphicon glyphicon-th"></span></a>
                    <ul role="menu" class="dropdown-menu">
                         <li><a href="<?php echo Yii::app()->getBaseUrl(true);?>/list/exam">List Exams</a></li>
                         <li><a href="<?php echo Yii::app()->getBaseUrl(true);?>/list/course">List Courses</a></li>
                         <li><a href="<?php echo Yii::app()->getBaseUrl(true);?>/list/question">List Question Templates</a></li>
                    </ul>
                </li>-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <?php 
                    echo Yii::app()->user->name;
                    $roles=Yii::app()->authManager->getRoles(Yii::app()->user->id);
                    foreach ($roles as $role)
					{
					    echo "(".$role->name.")";
					}
					?>
<b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="<?php echo Yii::app()->getBaseUrl(true);?>/profile/open">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo Yii::app()->createUrl('site/logout',array()); ?>">Logout</a></li>
                    </ul>
                </li>

            </ul>
            <?php } ?>
        </div>
    </div>
</nav>



<br><br><br><br>



<?php echo $content; ?>


</body>
</html>                                  		

<?php 
include('header.php'); 
loginRequired();
?>

<div class="row header">
		<div class="col-5">
			
		</div>
		<div class="col-30">
			<h3 style="color:#ffffff;"><?php echo $GLOBALS['appName'];?></h3>
			<?php echo $GLOBALS['appNameSlogan'];?> 
		</div>
		<div class="col-50" style="text-align:right; padding-top:30px;">
		
		Welcome <?php echo $_SESSION['logged_in_arr'][1];?>! &nbsp;&nbsp;&nbsp; User ID: <?php echo $_SESSION['logged_in_arr'][0];?> &nbsp;&nbsp;&nbsp;
		
			<a href="<?php echo site_url('logout');?>" class="a-white">Logout</a>
		</div>
		<div class="col-5">
			
		</div>
</div>
 
 
 
 <div class="row" style="min-height:450px;">
		<div class="col-10">
			
		</div>
		<div class="col-70">
	 
	 <?php 
	 $quizData=getQuizData();
	 $quiz_detail=$quizData['quiz_detail'];
	
	 echo "<h2>".$quiz_detail[0]."</h2>";
	 
	 ?>
	 <strong>Instructions</strong><br><div class="sqm-instructions"><?php echo $quiz_detail[1];?></div>
	 <?php 
	 $validateTime=1;
	 if(time() <= strtotime($quiz_detail[2])){
		$validateTime=0;
		echo "<div class='sqm-alert-warning'>Quiz will start on ".$quiz_detail[2]."</div>";
	 }
	 if(time() >= strtotime($quiz_detail[3])){
		$validateTime=0;
		echo "<div class='sqm-alert-warning'>Quiz ended on ".$quiz_detail[3]."</div>";
	 }
	 
	 $fm="output/".$_SESSION['logged_in_arr'][0]."_closed.txt";
	
	 if(file_exists($fm)){
		$validateTime=0;
		echo "<div class='sqm-alert-warning'>Quiz already submitted from your ID ".$_SESSION['logged_in_arr'][0]." </div>"; 
		 
	 }
if($validateTime == 1){
 
	?>
<script>

function redirectToQuiz(){
	
	window.location="<?php echo site_url('quizAttempt');?>";
}
</script>
	<input type="checkbox" id="accept-terms" value="1" onClick="enableStartBtn();"> I read the instructions.<br><br> <button type="button" onClick="redirectToQuiz();" class="sqm-btn-primary" id="startBtn"  >Start Quiz</button> 
	<?php 
} 
?>	 
	 
		
		</div>
		 
		<div class="col-10">
			
		</div>
</div>



  <?php include('footer.php'); ?>
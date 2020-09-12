<?php 
include('header.php'); 
loginRequired();
 
	 $quizData=getQuizData();
	 $responses=getResponse();
	  
	 $quiz_detail=$quizData['quiz_detail'];
	 $questionData=$quizData['questionData'];
	 $st=time();
	 
	if(!isset($_SESSION['start_time'])){
		$_SESSION['start_time']=date('d-m-Y H:i:s',time());
	}else{
		$st=strtotime($_SESSION['start_time']);
	}
	if((time()-$st) >= ($quiz_detail[5]*60)){
		$remaningTime=0;
	}else{
		$remaningTime=($quiz_detail[5]*60)-(time()-$st);
	}
	
	 if(time() <= strtotime($quiz_detail[2])){
		  redirect('home');
	 }
	 if(time() >= strtotime($quiz_detail[3])){
		  redirect('home');
	 }
	$fm="output/".$_SESSION['logged_in_arr'][0]."_closed.txt";
 	 if(file_exists($fm)){
		  redirect('home');
	 }
	 

?>
<form method="post" id="testform">
<input type="hidden" name="quiz_status" value="Open" id="quiz_statrus">
<div class="row header">
		<div class="col-5">
			
		</div>
		<div class="col-30">
			<h3 style="color:#ffffff;"><?php echo $quiz_detail[0];?></h3>
			 
		</div>
		<div class="col-50" style="text-align:right; padding-top:30px;">
		
		Welcome <?php echo $_SESSION['logged_in_arr'][1];?>! &nbsp;&nbsp;&nbsp; User ID: <?php echo $_SESSION['logged_in_arr'][0];?> &nbsp;&nbsp;&nbsp;
		
		Time Left: <span id="timer"></span>
			 
		</div>
		<div class="col-5">
			
		</div>
</div>

 <div class="row" style="min-height:450px;" id="mainQuizContainer">
		<div class="col-70">
			<div >
			<?php 
		 
			$lang=explode(',',sqmtrim($quiz_detail[6]));
			if(count($lang) >=1){
				?>
				<select style="float:right;margin-top:3px;margin-right:3px;" onChange="changelanguage(this.value);">
				<?php foreach($lang as $lk => $lv){
					?>
					<option value=".lang-<?php echo $lk;?>">Language: <?php echo $lv;?></option>
					<?php 
				}
				?>
				</select>
				<?php 
			}
			?>
			</div>
			<?php 
			 
			
			foreach($questionData as $k => $questionArr){
				if(isset($questionArr[3])){
				?>
				<div class="sqm-question-content <?php if($k==0){ ?>sqm-display<?php } ?>" id="qno-<?php echo $k;?>" >
					<div class="sqm-question">
						<?php foreach($lang as $lk => $lv){
							
						?>
							<div class='language lang-<?php echo $lk;?>' style="<?php if($lk==0){ echo 'display:block;';}?>">
								Q<?php echo $k+1;?>)
								<?php 
								echo sqmtrim($questionArr[(3)+(($GLOBALS['noptions']+1)*$lk)]);
								?>
							</div>
						<?php 
						}
						?>
					</div>
					<div class="sqm-options">
						
					<?php 
					$opno=0;
						for($oj=4; $oj<=($GLOBALS['noptions']+3); $oj++){
					?>
					<div class="sqm-option ops-<?php echo $k;?> <?php if(isset($responses[$questionArr[0]])){ if($responses[$questionArr[0]]==$abcArr[$opno]){ echo 'sqm-selected'; } } ?>" onClick="selectOption(this,'.ops-<?php echo $k;?>');">
					<input type="radio" class="inputop-<?php echo $k;?> " <?php if(isset($responses[$questionArr[0]])){ if($responses[$questionArr[0]]==$abcArr[$opno]){  echo 'checked'; } } ?> style="float:left;" name="response[<?php echo $questionArr[0];?>]"  value="<?php if($GLOBALS['saveResponseIn']=='alphabet'){ echo $abcArr[$opno];}else{ echo $opno+1;} ?>"> 
						
					<?php foreach($lang as $lk => $lv){
						?>
							<div class='language lang-<?php echo $lk;?>'  style="<?php if($lk==0){ echo 'display:block;';}?>">
							
						
								<?php 
								echo sqmtrim($questionArr[$oj+(($GLOBALS['noptions']+1)*$lk)]);
								?>
								
							
							
					</div>
						<?php 
						}
						?>
						<div class="clear-both"></div>
						</div>
					<?php
							$opno+=1;					
						}
					?>					
						
					</div>
				</div>
				<?php 
			 }
			}
			?>
			<div class="sqm-footer-button">
			<button type="button" class="sqm-btn-primary sqm-disabled" id="backBtn" onClick="backQuestion();" >Back</button>
			<button type="button" class="sqm-btn-primary" id="nextBtn" onClick="nextQuestion();">Save & Next</button> <span id="savedResponse"></span>
			
			<button type="button" class="sqm-btn-submit" id=" " onClick="submitQuiz();" style="float:right;margin-right:5px;">Submit Quiz</button>
			<button type="button" class="sqm-btn-review" id=" " onClick="reviewLater();" style="float:right;margin-right:5px;">Review Later & Next</button>
			<button type="button" class="sqm-btn-secondary" id="clearBtn" onClick="clearResponse();" style="float:right;margin-right:5px;">Clear Response</button>
			
			</div>
		</div>
		<div class="col-25">  
	 <strong>Questions</strong><br>
	 <hr>
		<div class="sqm-question-selector">
			<?php 
				
			foreach($questionData as $k => $questionArr){
				if(isset($questionArr[1])){
				?>
					<div class="sqb-qbtn sqm-unviewed <?php if(isset($responses[$questionArr[0]])){ ?> sqm-answered <?php } ?>" id="qbtn-<?php echo $k;?>" onClick="showq('#qno-<?php echo $k;?>',<?php echo $k;?>);">
						<?php echo $k+1;?>
					</div>
				<?php 
				}
			}
			
			?>
	 
	 
		</div>
	</div>
		 
		 
</div>
</form>


<div id="bg_blur"></div>


<div id="submit_warning"><h2> Do you really want to submit quiz?</h2>
	<br>
	<button type="button" class="sqm-btn-secondary" onClick="submitCancel();">Cancel</button>

	<button type="button" class="sqm-btn-submit" onClick="submitNow();">Submit Now</button>
	<br><br>
	<span id="quiz_submit_status"></span>

</div>


<div id="timeover_warning"><h2> Time Over</h2>
Submitting Quiz....
 
</div>

<script>
var totalQuestions=<?php echo $k;?>;
var seconds=parseInt(<?php echo $remaningTime;?>);

var tim=setInterval(function(){
seconds-=1;
if(seconds <= 0){
timeOver();	
}
$('#timer').html(secondsToHms(seconds));
	
},1000);

</script>

  
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
		
		Welcome Admin &nbsp;&nbsp;&nbsp;
		
			<a href="<?php echo site_url('home');?>" class="a-white">Home</a> &nbsp;&nbsp;&nbsp; 
			<a href="<?php echo site_url('logout');?>" class="a-white">Logout</a>
		</div>
		<div class="col-5">
			
		</div>
</div>
 
 
 
 <div class="row" style="min-height:450px;">
		<div class="col-10">
			
		</div>
		<div class="col-30" >
	 
 <h2>1) Generate Encrypted Files</h2>
 <label>To share with local server(s)</label>
	 <form method="post" action="<?php echo site_url('upload');?>" enctype="multipart/form-data">
	 <br><br>
				<div class="sqm-form-group">
				
					<label>Upload user's list</label><br>
					<input type="file" name="userList" required >
					<p style="font-size:13px;"><a href="../sample_Files/userData.csv" target="new">Download</a> sample files</p>
				</div>
				<div class="sqm-form-group">
					<label>Upload Quiz Data (Quiz name, duration, questions list etc..)</label><br>
					<input type="file" name="questionList" required >
					<p style="font-size:13px;"><a href="../sample_Files/quizData.csv" target="new">Download</a> sample files</p>
				</div>
				<div class="sqm-form-group">
					<label>Encryption Key </label>
					<input type="text" name="passKey"  class="sqm-form-control" placeholder="eg. SMAIVCSROOFTV1" autocomplete="off" required >
					<p  style="font-size:13px;"><a href="javascript:readmore('#aboutEnc');">Read more</a></p><p id="aboutEnc" style="display:none;">An encryption key is typically a random string to scramble and unscramble data.
					User files and questions data will be encrypted with the help of encryption key and this encryption key is required to decode the files.
					You can share encrypted data files to local server anytime you wants and for security purpose share encryption key with local servers only few minutes before quiz.
					</p>
				</div>
				
					<button type="submit" class="sqm-btn-primary">Generate Encrypted Files</button>

	 
	 </form>
		
		</div>
		<div class="col-10" style="border-right:1px solid #dddddd;height:100%;">
			
		</div>
		<div class="col-10">
			
		</div>
		<div class="col-30">
	 
 <h2>2) Generate Result</h2>
 <label>Upload user's response and Questions file </label>
 
	  <form method="post" action="<?php echo site_url('generateResult');?>" enctype="multipart/form-data">
	 <br><br>
				<div class="sqm-form-group">
				
					<label>Upload user's response</label><br>
					<input type="file" name="zipfile" required >
					<p style="font-size:13px;">Upload zip file (Create .zip file of all responses)</p>
				</div>
				<div class="sqm-form-group">
					<label>Upload Quiz Data</label><br>
					<input type="file" name="questionList" required >
					<p style="font-size:13px;">CSV file which you uploaded in step 1 which contain quiz and question's data </p>
				</div>
				<div class="sqm-form-group">
					<label>Encryption Key </label>
					<input type="text" name="passKey"  class="sqm-form-control" placeholder="Which used in Step 1" autocomplete="off" required >
					 
				</div>
				<div class="sqm-form-group">
					<label>Result filename </label>
					<input type="text" name="rfilename"  class="sqm-form-control" placeholder="" autocomplete="off" onClick="this.select();" value="<?php echo time().'.csv';?>" required >
					 
				</div>
				
					<button type="submit" class="sqm-btn-primary">Generate Result File</button>

	 
	 </form>
		
		</div>
		 
		 
		 
</div>



  <?php include('footer.php'); ?>
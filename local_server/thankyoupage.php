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
	 
 <h2>Thank you for taking quiz.</h2>
		
		</div>
		 
		<div class="col-10">
			
		</div>
</div>



  <?php include('footer.php'); ?>
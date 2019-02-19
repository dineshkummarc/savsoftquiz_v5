<?php include('header.php'); ?>

<div class="row header">
		<div class="col-5">
			
		</div>
		<div class="col-30">
			<h2 style="color:#ffffff;"><?php echo $GLOBALS['appName'];?></h2>
			<?php echo $GLOBALS['appNameSlogan'];?><br><br>
		</div>
		<div class="col-60">
			
		</div>
		<div class="col-5">
			
		</div>
</div>
 

 
 <div class="row" style="min-height:450px;">
		<div class="col-25">
			
		</div>
		<div class="col-50">
		<form method="post" action="<?php echo site_url('validateLogin');?>">
		<div class="sqm-panel">
			<div class="sqm-heading"><h3>Administrator Login</h3></div>
			<div class="sqm-body">
				<div class="sqm-form-group">
					<label>User ID</label>
					<input type="text" name="userid" id="userid" class="sqm-form-control" placeholder=" " autocomplete="off" required >
				</div>
				<div class="sqm-form-group">
					<label>Password</label>
					<input type="password" name="password" id="password" class="sqm-form-control" placeholder=" " autocomplete="off" required >
				</div>
				<div class="sqm-form-group">
				<button type="submit" class="sqm-btn-primary">Login</button>
				</div>
			</div>
		</div>
		</form>
		</div>
		 
		<div class="col-25">
			
		</div>
</div>
  <?php include('footer.php'); ?>
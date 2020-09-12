<?php 
include('header.php'); 
loginRequired();

$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["userList"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 $userList="";
 $questionList="";
if($imageFileType != "csv") {
    echo "Only .csv file allowed"; exit;
    $uploadOk = 0;
}
 
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded."; exit;
 
} else {
    if (move_uploaded_file($_FILES["userList"]["tmp_name"], $target_file)) {
        $userList= $_FILES["userList"]["name"];  
    } else {
        echo "Sorry, there was an error uploading your file."; exit;
    }
}


$target_file = $target_dir . basename($_FILES["questionList"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 
if($imageFileType != "csv") {
    echo "Only .csv file allowed"; exit;
    $uploadOk = 0;
}
 
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
 
} else {
    if (move_uploaded_file($_FILES["questionList"]["tmp_name"], $target_file)) {
        $questionList= $_FILES["questionList"]["name"];  
    } else {
        echo "Sorry, there was an error uploading your file."; exit;
    }
}
 
 	$file=$target_dir."".$userList;
	$file_content=(file_get_contents($file));
	$passC=$_POST['passKey'];
	$eT=$GLOBALS['encryptType'];
	$fec=openssl_encrypt($file_content,$eT,$passC);
	$output1='output/'.str_replace('.csv','',$userList.'-encrypted-'.date('dmYHis',time()).'.txt');
file_put_contents($output1,$fec);

 	$file=$target_dir."".$questionList;
	$file_content=base64_encode(file_get_contents($file));
	$passC=$_POST['passKey'];
	$eT=$GLOBALS['encryptType'];
	$fec=openssl_encrypt($file_content,$eT,$passC);
	$output2='output/'.str_replace('.csv','',$questionList.'-encrypted-'.date('dmYHis',time()).'.txt');
file_put_contents($output2,$fec);
 
 
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
		<div class="col-70" >
	 
<p> User's login data file (encrypted): <a href="<?php echo base_url($output1);?>" target="new">Download</a> or Access Location <b><?php echo $output1;?></b></p> 
<p> Questions data file (encrypted): <a href="<?php echo base_url($output2);?>"  target="new">Download</a> or Access Location <b><?php echo $output2;?></b></p>  
<p>Encryption key: <?php echo $_POST['passKey'];?></p>
<span style="color:red;font-size:12px;">Don't forget your encryption key.</span>	
	 
	 
		
		</div>
		 
		 
		 
</div>



  <?php include('footer.php'); ?>
  
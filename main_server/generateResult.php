<?php 
include('header.php'); 
loginRequired();

$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["zipfile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 $zipfile="";
 $questionList="";
if($imageFileType != "zip") {
    echo "Only .zip file allowed as user response"; exit;
    $uploadOk = 0;
}
 
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded."; exit;
 
} else {
    if (move_uploaded_file($_FILES["zipfile"]["tmp_name"], $target_file)) {
        $zipfile= $_FILES["zipfile"]["name"];  
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
 
  
 	$file=$target_dir."".$questionList;
	$file_content=(file_get_contents($file));
$correctArr=getQuestions($file_content);
// print_r($correctArr);

$filenames=array();
$zippath="upload/".$zipfile;
$zip = new ZipArchive;
$res = $zip->open($zippath);
if ($res === TRUE) {
  $zip->extractTo('response/');
  $zip->close();
  

	if ($handle = opendir('response')) {
		while (false !== ($file = readdir($handle))) {
			if($file =="." || $file==".."){
				
			}else{ 
			 $filenames[]="response/".$file;
			}
		}
		closedir($handle);
	}


  
}else {
 exit('Unable to read zip');  
}

$resultArr=array();
$resultArrHead=array();
$resultArrHead[]="User ID";
$resultArrHead[]="Start Time";
$resultArrHead[]="End Time";
$resultArrHead[]="Total Questions";
$resultArrHead[]="Number of Correct";
$resultArrHead[]="Number of inCorrect";

foreach($correctArr as $ck => $cval){
$resultArrHead[]="Q ".($ck).") Correct Option: ".$cval;	
}


foreach($filenames as $k => $val){
		$file_content=file_get_contents($val);
	$passC=$_POST['passKey'];
	$eT=$GLOBALS['encryptType'];
	$userRow=array();
	$response=str_getcsv(base64_decode(openssl_decrypt($file_content,$eT,$passC)));
 
		$userRow[]=$response[0];
		$tim=explode(' -- ',$response[2]);	
		$userRow[]=$tim[0];		
		$userRow[]=$tim[1];		
		$userRow[]=count($correctArr); 
$ures=array();
 
foreach($response as $urk => $urval){
	if($urk >= 3){
		$ur=explode(':',$urval);
		$ures[$ur[0]]=$ur[1];
	}
}
  
	$noc=0;
	$noic=0;
	$userRow2=array();
	foreach($correctArr as $ck => $cval){
			if(isset($ures[$ck])){
				if($ures[$ck]==$cval){
				$noc+=1;	
				}else{
				$noic+=1;	
				}
				$userRow2[]=$ures[$ck];
			}else{
				$userRow2[]="Not Attempted";
			}
	} 
	$userRow[]=$noc;
	$userRow[]=$noic;
	$userRow[]=implode(',',$userRow2);
	
	$resultArr[]=implode(',',$userRow);
}
$result=implode(',',$resultArrHead).''.PHP_EOL.''.implode(PHP_EOL,$resultArr);
$ofilename='output/'.$_POST['rfilename'];
file_put_contents($ofilename,$result);
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
	 
 	 <p> Result file: <a href="<?php echo base_url($ofilename);?>" target="new">Download</a> or Access Location <b><?php echo $ofilename;?></b></p> 

		
		</div>
		 
		 
		 
</div>



  <?php include('footer.php'); ?>
  
<?php 

function site_url($filename=""){
	if($filename != ""){
	return $GLOBALS['base_url']."index.php?page=".$filename;
	}else{
	return $GLOBALS['base_url']."index.php";
	}
}

function base_url($filename=""){

	return $GLOBALS['base_url'].''.$filename;

}

function set_flash_message($fname,$fmessage){
	$_SESSION[$fname] = $fmessage;
}

function flash_message($fname){
	if(isset($_SESSION[$fname])){
	return $_SESSION[$fname];
	}else{
		return false;
	}
}

function redirect($filename){
	 $path="";
	if($filename != ""){
	$path=$GLOBALS['base_url']."index.php?page=".$filename;
	}else{
	$path=$GLOBALS['base_url']."index.php";
	}
	header("location:$path");
}




function loginRequired(){
if(!isset($_SESSION['logged_in_user'])){
	set_flash_message('message','Error Code: L004 - Login Required');
	redirect('login');
}
}




function sqmtrim($str){
	return trim($str,'"');
}


function validateLogin(){
	$userid=trim($_POST['userid']);
	$password=trim($_POST['password']);

	// get .csv file
	$file='input/'.$GLOBALS['userLogin'];
	if(!file_exists($file)){
	set_flash_message('message','Error Code: L001 - UserData file not imported into local server');	
	return false;	
	}
	
	$file_content=file_get_contents($file);
	$passC=$GLOBALS['passCode'];
	$eT=$GLOBALS['encryptType'];
	$od=openssl_decrypt($file_content,$eT,$passC);
	$userList=explode(PHP_EOL,$od);

	$users=array();
	foreach($userList as $k => $val){
		if($k >= 1){
		$u=explode(',',$val);
		$users[trim($u[0])]=$u;
		}
	}
	 
	if(isset($users[$userid])){
		if(trim($users[$userid][1])==$password){
	set_flash_message('message','Login Success');
	// create login session
	$_SESSION['logged_in_user']=$userid;
	$_SESSION['logged_in_arr']=array($userid,$users[$userid][2],time(),date('Y-m-d H:i:s',time()));
	

	
	
	return true;			
		}else{
	set_flash_message('message','Error Code: L003 - Invalid Password');	
	return false;			
		}
	}else{
	set_flash_message('message','Error Code: L002 - Invalid USER ID :');	
	return false;
	}
	
}



function getQuizData(){
	$returnData=array();
		// get .csv file
	$file='input/'.$GLOBALS['quizData'];
	if(!file_exists($file)){
	set_flash_message('message','Error Code: L005 - QuizData file not imported into local server');	
	return false;	
	}
	
	$file_content=file_get_contents($file);
	$passC=$GLOBALS['passCode'];
	$eT=$GLOBALS['encryptType'];
	$od=base64_decode(openssl_decrypt($file_content,$eT,$passC));
	$quizd=explode(PHP_EOL,$od);

	$quizValidations=array();
	$questionData=array();
	foreach($quizd as $k => $val){
		if($k == 1){
		$quizValidations=str_getcsv($val);
		 
		}
		if($k >= 3){
		$questionData[]=str_getcsv($val);
		 
		}
		
	}
	
	$returnData=array('quiz_detail'=>$quizValidations,'questionData'=>$questionData);
	return $returnData;
}




function getResponse(){
	 $fm="output/".$_SESSION['logged_in_arr'][0].".txt";
	  $resOld="";
	 if(file_exists($fm)){
		$file_content=file_get_contents($fm);
		$passC=$GLOBALS['passCode'];
		$eT=$GLOBALS['encryptType'];
		$resOld=base64_decode(openssl_decrypt($file_content,$eT,$passC));
		 
	}
	$resArr=explode(',',$resOld);
	$narr=array();
	foreach($resArr as $k => $val){
		if($k >= 3){
			$fr=explode(':',$val);
			$narr[$fr[0]]=$fr[1];
		}
	}
	return $narr;
}



$abcArr=array(
'0'=>'A',
'1'=>'B',
'2'=>'C',
'3'=>'D',
'4'=>'E',
'5'=>'F'
);


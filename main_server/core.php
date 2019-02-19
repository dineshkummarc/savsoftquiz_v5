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
if(!isset($_SESSION['logged_in_admin'])){
	set_flash_message('message','Error Code: L001 - Login Required');
	redirect('login');
}
}




function sqmtrim($str){
	return trim($str,'"');
}


function validateLogin(){
	$userid=trim($_POST['userid']);
	$pass=trim($_POST['password']);

	 
	
	$file_content=file_get_contents($file);
	$userID=$GLOBALS['userID'];
	$password=$GLOBALS['password'];
	 
		if(trim($userid.$pass)==trim($userID.$password)){
	set_flash_message('message','Login Success');
	// create login session
	$_SESSION['logged_in_admin']=$userid;
	 
	return true;			
		}else{
	set_flash_message('message', 'Error Code: L002 - Invalid Username & Password');	
	return false;			
		}
	 
	
}


 


$abcArr=array(
'0'=>'A',
'1'=>'B',
'2'=>'C',
'3'=>'D',
'4'=>'E',
'5'=>'F'
);


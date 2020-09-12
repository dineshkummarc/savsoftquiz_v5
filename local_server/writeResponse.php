<?php 
loginRequired();
$responseArr=array();
$responseArr[]=$_SESSION['logged_in_arr'][0];
$responseArr[]=$_POST['quiz_status'];
$responseArr[]=$_SESSION['start_time'].' -- '.date('d-m-Y H:i:s',time());
foreach($_POST['response'] as $pk => $pval){
$responseArr[]=$pk.':'.$pval;
}
$res=base64_encode(implode(',',$responseArr));
$fm="output/".$_SESSION['logged_in_arr'][0].".txt";
	$passC=$GLOBALS['passCode'];
	$eT=$GLOBALS['encryptType'];
	$fec=openssl_encrypt($res,$eT,$passC);
if(file_put_contents($fm,$fec)){
echo "DONE";
}else{
echo "Error";
}
if($_POST['quiz_status']=="Close"){
	$fm="output/".$_SESSION['logged_in_arr'][0].".txt";
	$fm_new="output/".$_SESSION['logged_in_arr'][0]."_closed.txt";
	rename($fm,$fm_new);
	$_SESSION['start_time']="";
	unset($_SESSION['start_time']);
	
}

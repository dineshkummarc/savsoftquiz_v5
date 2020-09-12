<?php 
loginRequired();
$responseArr=array();
$responseArr[]=$_SESSION['logged_in_arr'][0];
$responseArr[]=$_POST['quiz_status'];
$responseArr[]=$_SESSION['start_time'].' -- '.date('d-m-Y H:i:s',time());
foreach($_POST['response'] as $pk => $pval){
$responseArr[]=$pk.':'.$pval;
}
	$fm="logs/".$_SESSION['logged_in_arr'][0].".txt";
	$resOld="";
	if(file_exists($fm)){
		$file_content=file_get_contents($fm);
		$passC=$GLOBALS['passCode'];
		$eT=$GLOBALS['encryptType'];
		//$resOld=base64_decode(openssl_decrypt($file_content,$eT,$passC));
		$resOld=$file_content;
	}
	
	//$res=base64_encode($resOld."".PHP_EOL."".(implode(',',$responseArr)));

	//$fec=openssl_encrypt($res,$eT,$passC);
	$fec=$resOld."".PHP_EOL."".implode(',',$responseArr);
	
if(file_put_contents($fm,$fec)){
echo "DONE";

}else{
echo "Error";
}

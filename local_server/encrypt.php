<?php 
include('config.php');
	$file='input/quizData.csv';
	$file_content=base64_encode(file_get_contents($file));
	$passC=$GLOBALS['passCode'];
	$eT=$GLOBALS['encryptType'];
	$fec=openssl_encrypt($file_content,$eT,$passC);
file_put_contents('input/quizData-2019-02-07.txt',$fec);
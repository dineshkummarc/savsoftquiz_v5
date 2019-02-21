<?php 
ob_start();
session_start();
date_default_timezone_set('Asia/Kolkata');
// primary server path
$base_url="http://192.168.1.5/savsoftquiz_micro/local_server/";
/* secondary server path. Leave blank if no secondary server
secondary server is a backup server. which can be actived if primary server crashed
*/
$base_url_2="http://localhost/savsoftquiz_micro/local_server/";
$passCode="1234";
$userLogin="userData-encrypted-21022019095923.txt";
$quizData="quizData-encrypted-21022019095923.txt";
$encryptType="AES-128-ECB";
$appName="sqMicro (Savsoft Quiz Micro) ";
$appNameSlogan="Local Server";
// no of options
$noptions="4";
// numeric or alphabet
$saveResponseIn="alphabet";
$showResultInstantly=true;
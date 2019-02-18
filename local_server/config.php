<?php 
ob_start();
session_start();
date_default_timezone_set('Asia/Kolkata');
// primary server path
$base_url="http://localhost/savsoftquiz_micro/local_server/";
/* secondary server path. Leave blank if no secondary server
secondary server is a backup server. which can be actived if primary server crashed
*/
$base_url_2="http://localhost/savsoftquiz_micro/local_server/";
$passCode="123";
$userLogin="centerCode-2019-02-07.txt";
$quizData="quizData-2019-02-07.txt";
$encryptType="AES-128-ECB";
$appName="sqMicro (Savsoft Quiz Micro) ";
$appNameSlogan="A light weight scripts to conduct secure potential exam";
// no of options
$noptions="4";
// numeric or alphabet
$saveResponseIn="alphabet";
$showResultInstantly=true;
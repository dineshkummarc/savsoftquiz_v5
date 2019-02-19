<?php 
include('config.php');
include('core.php');

if(!isset($_GET['page'])){
	include('login.php');
}else if(!file_exists($_GET['page'].'.php')) {
    include('404.php');
}else{
	include($_GET['page'].'.php');
}

?>
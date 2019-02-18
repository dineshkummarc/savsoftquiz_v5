<?php 
if(validateLogin()){
	redirect('home');
}else{
	
	redirect('login');
}
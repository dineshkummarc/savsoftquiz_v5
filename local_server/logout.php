<?php 
  unset($_SESSION['logged_in_user']);
  unset($_SESSION['logged_in_arr']);
 session_destroy();
	redirect('login');
 
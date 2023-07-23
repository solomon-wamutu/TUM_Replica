<?php
function check_login(){
   if(strlen($_SESSION['student_id']) == 0)  {   
$host = $_SERVER['HTTP_HOST']; 
$uri = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
$extra = "pages_client_index.php";
$_SESSION["student_id"] = "";
header("Location: http://$host$uri/$extra");
   }
}
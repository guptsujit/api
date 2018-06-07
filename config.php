<?php
//header("Access-Control-Allow-Origin: *");
  /****** Database Details *********/
    
    $host      = "localhost"; 
    $user      = "root"; 
    $pass      = ""; 
    $database  = "angular6_db";
    $con       = mysql_connect($host,$user,$pass);

    if (!$con) {
        die('Could not connect: ' . mysql_error());
    }

    //echo 'Connected successfully'; 
    
    mysql_select_db($database,$con);  

    /*******************************/

?>
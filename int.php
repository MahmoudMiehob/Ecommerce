<?php

include 'Admin/connect.php';


 //Routs
 
 $tpl = 'include/template/'   ;  //template directory
 $css = 'layout/css/'         ;  //css directory
 $js  = 'layout/js/'          ;  //js directory


 
 $sessionUser = ' ';

 if(isset($_SESSION['user'])){

     $sessionUser = $_SESSION['user'];

 }
        

 
?>
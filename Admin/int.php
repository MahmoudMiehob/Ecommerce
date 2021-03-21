<?php

include 'connect.php';


 //Routs
 
 $tpl = 'include/template/'   ;  //template directory
 $css = 'layout/css/'         ;  //css directory
 $js  = 'layout/js/'          ;  //js directory



 
 // include the important files 

 if(!isset($noNavbar)){

 include $tpl . 'navbar.php';

 }
 
?>
<?php 
     $do = '';

     if(isset($_GET['do'])){

         $do = $_GET['do'];

     }else{

         $do = 'Manage';

     }
    if($do == 'Manage'){ 

       echo 'welcome you are in manage';
       echo '<a href="page.php?do=Add">Add</a>';

    }elseif($do == 'Add'){

        echo 'you are in Addpage';

    }else{
        echo 'error';
    }

?>
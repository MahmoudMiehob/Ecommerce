<?php



function gitAllForm($filed , $table , $where = null , $and = null, $orderFiled , $ordering = "DESC" ){

    global $con;

    $getAll = $con->prepare("SELECT $filed from $table $where $and ORDER BY $orderFiled $ordering");

    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all ;
}













   function getTitle() {

       global $pageTitle ;

       if(isset($pageTitle)){

           echo $pageTitle ;
        
       }else{
           echo 'Default';
       }
   }








   function redirectHome($theMsg, $url = null , $seconds = 3){

      if ($url === null){

        $url = 'index.php';

      }else{

        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){

            $url = $_SERVER['HTTP_REFERER'];

        }else{
            $url = $url;
        }

      }

       echo "<div class='container'>" ;

       echo $theMsg ;

       echo "<div class='alert alert-info'>You will be direct tp home bage after 3 s</div>" ;

       header("refresh:$seconds;url=$url");

       exit();

       echo "</div>";

      

       exit();
   }









   function checkitem ($select, $from , $value){

       global $con;

       $stmt2 = $con->prepare("SELECT $select from $from WHERE $select = ?");

       $stmt2->execute(array($value));

       $count = $stmt2->rowCount();

       return $count ;

   }







   //count item


   function countItem($item , $tabel){
       global $con ;

       $stmt3 = $con->prepare("SELECT count($item) from $tabel  ");

       $stmt3->execute();

       return $stmt3->fetchColumn();
   }









   //get latest record 

   function getlatest ($select , $table ,$order , $limit = 5){

    global $con ;

    $stmt4 = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");

    $stmt4->execute();

    $row = $stmt4->fetchAll();

    return $row ;

   }
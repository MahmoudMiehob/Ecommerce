<?php



function gitAllForm($filed , $table , $where = null , $and = null, $orderFiled , $ordering = "DESC" ){

    global $con;

    $getAll = $con->prepare("SELECT $filed from $table $where $and  ORDER BY  $orderFiled $ordering");

    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all ;
}







function getAllFrom($tablename, $order , $where = null){

    global $con ;

    $sql = $where == null ?'' :  $where ;

    $getAll = $con->prepare("SELECT * FROM $tablename $sql ORDER BY $order DESC LIMIT 4");

    $getAll->execute();

    $All = $getAll->fetchAll();

    return $All ;

   }







   //get category

   function getItems($where,$value, $approve =Null){

    global $con ;

    if($approve == null){
        $sql = 'And Approve = 1';
    }else{
        $sql = null ;
    }

    $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY item_id DESC");

    $getItems->execute(array($value));

    $items = $getItems->fetchAll();

    return $items ;

   }





   

   //get items 

   function getcat(){

    global $con ;

    $getcat = $con->prepare("SELECT * FROM category ORDER BY id ASC");

    $getcat->execute();

    $cats = $getcat->fetchAll();

    return $cats ;

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







// chick if yser not Activite
// function to check th regstatus the user

function checkuserstatus($user){

        global $con ;  
      
        $stmtx = $con->prepare("SELECT
            Username,Regstatus 
        FROM
            users
        WHERE
            Username = ? 
        And 
        Regstatus = 0");

        $stmtx->execute(array($user));
        $status = $stmtx->rowCount();
        return $status ;
}
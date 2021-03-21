<?php

      ob_start(); // output buffering start

      session_start();
   
      if(isset($_SESSION['Username'])){

        $pageTitle = 'Dashboard';

        include 'include/languages/en.php';
        include 'include/template/header.php';
        include 'int.php';



        $thelatestuser = getlatest("*" , "users" , "UserID" , 6);

        $thelatestitems = getlatest("*" , "items" , "item_id" , 6);

        $nomcomments = 4 ;



       
        // start dashboard page

        ?>

         <div class="container home-stats text-center">
             <h1 class="id">dashboard</h1>
             <div class="row">
                 <div class="col-md-3">
                      <div class="stat st-members">
                      <i class="fa fa-users"></i>
                      <div class="info">
                          Total members
                          <span><a href="members.php"><?php echo countItem('UserID' , 'users') ; ?></a></span>
                          </div>
                      </div>
                 </div>
                 <div class="col-md-3">
                      <div class="stat st-pending">
                        <i class="fa fa-plus"></i>
                        <div class="info">
                            pending members
                          <span><a href="members.php?do=Manage&page=pending">
                          <?php echo checkitem('Regstatus' , 'users' , 0) ; ?></a></span>
                          </div>
                        </div>
                 </div>
                 <div class="col-md-3">
                      <div class="stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Total items
                          <span><a href="items.php"><?php echo countItem('item_id' , 'items') ; ?></a></span>
                          </div>
                        </div>
                 </div>
                 <div class="col-md-3">
                      <div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Totlal comment
                          <span><a href="comment.php"><?php echo countItem('c_id' , 'comments') ; ?></a></span>
                          </div>
                        </div>
                 </div>
             </div>
         </div>

         <div class="container latest">
             <div class="row">
               <div class="col-sm-6">
                 <div class="panel panel-default">
                        <div class="panel-heading">
                        <i class="fa fa-users"> </i> latest 6 Users
                            <span class="toggel-info pull-right">
                              <i class="fa fa-minus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                          <?php   
                                  if(! empty($thelatestuser)){
                                  foreach($thelatestuser as $user){
                                        echo '<li>' ;
                                         echo $user['Username'] ;
                                         echo '<a href="members.php?do=Edit&UserID=' . $user['UserID'] . '">';
                                            echo '<span class="btn btn-success pull-right">' ;
                                            echo '<i class="fa fa-edit"></i> Edit </a>';
                                            
                                            if($user['Regstatus'] == 0){?>
    
                                                <a href='members.php?do=Activate&UserID=<?php echo $user['UserID']; ?>' class='btn btn-info pull-right'><i class='fa fa-check'></i> Activate </a>
    
                                            <?php } ?>
                                         <?php
                                            echo '</span>';
                                            echo '</a>';
                                            echo '</li>' ;
                            }}else{    
                              echo "there\'s no record to show";                        
                            }?>
                        </div>
                 </div>
               </div>
               <div class="col-sm-6">
                 <div class="panel panel-default">
                        <div class="panel-heading">
                        <i class="fa fa-users"> </i> latest 6 items
                            <span class="toggel-info pull-right">
                            <i class="fa fa-minus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                          <?php
                                  if(! empty($thelatestitems)){
                                  foreach($thelatestitems as $item){
                                        echo '<li>' ;
                                         echo $item['Name'] ;
                                         echo '<a href="items.php?do=Edit&itemid=' . $item['item_id'] . '">';
                                            echo '<span class="btn btn-success pull-right">' ;
                                            echo '<i class="fa fa-edit"></i> Edit </a>';
                                            
                                            if($item['Approve'] == 0){?>
    
                                                <a href='items.php?do=Approve&itemid=<?php echo $item['item_id']; ?>' class='btn btn-info pull-right'><i class='fa fa-check'></i> Approve </a>
    
                                            <?php } ?>
                                         <?php
                                            echo '</span>';
                                            echo '</a>';
                                            echo '</li>' ;
                                      }}else{
                                    echo "there\'s no record to show"; } ?>
                        </div>
                    </div>
                 </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                            <i class="fa fa-comments"> </i> latest <?php echo $nomcomments ; ?> comments
                                <span class="toggel-info pull-right">
                                <i class="fa fa-minus fa-lg"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                            <?php 
                            $stmt = $con->prepare("SELECT
                                                        comments.*,users.Username AS username
                                                FROM 
                                                        comments
                                              
                                                INNER JOIN 
                                                         users
                                                ON 
                                                         users.UserID = comments.user_id 
                                                ORDER BY
                                                          c_id DESC
                                                LIMIT $nomcomments ");

                            $stmt->execute();
                            $comments = $stmt->fetchAll();

                            if(! empty($comments)){
                            foreach ($comments as $comment){
                              echo '<div class="comment-box">';?>
                              <span class="mamber-n"> <a href="members.php?do=Edit&UserID=<?php echo $comment["user_id"] ;?>"><?php echo $comment['username']; ?></a></span>
                              <?php echo '<p class="mamber-c">' . $comment['comment'] . '</p>';
                              echo '</div>';
                           } } else{
                            echo "there\'s no record to show";
                          }
                            ?>
                            </div>
                        </div>
                    </div>
                  </div>
               </div>
           </div> 
         </div>

        <?php

        //end dashboard page
        

        include $tpl . 'footer.php' ;

      }else{

          header('Location: index.php');
          
          exit();
      }

      ob_end_flush();
?>
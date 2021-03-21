<?php 
    ob_start();
    session_start();
    $pageTitle="profile" ;

      include 'include/languages/en.php';
      include 'include/template/header.php';
      include 'int.php';

      if(isset($_SESSION['user'])){

        $getUser = $con->prepare('SELECT * FROM users WHERE Username = ?');

        $getUser->execute(array($sessionUser)) ;

        $info = $getUser->fetch();
?>
      <h1 class="text-center"> My profile </h1>
       
      <div class="information block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">My information</div>
                    <div class="panel-body">
                         Name : <?php echo $info['Username'] ; ?><br><hr>
                         Email : <?php echo $info['Email'] ; ?><br><hr>
                         Fullname : <?php echo $info['Fullname'] ; ?><br><hr>
                         Date : <?php echo $info['Date'] ; ?>
                        
                    </div>
                </div>
            </div>
      </div>

      <div id="my-Ads" class="my-ads block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">My Items</div>
                    <div class="panel-body">
                        <?php  
                            $items = getItems('Membor_id',$info['UserID'] , 1) ;
                                if(! empty($items)){
                                    echo '<div class="row">';
                                    foreach($items as $item){
                                        echo '<div class="col-sm-6 col-md-3">';
                                        echo '<div class="thumbnail item-box">';
                                        if($item['Approve'] == 0) {
                                            echo '<span class="approve-status">waiting Approve</span>' ;
                                        }
                                        echo '<span class="price">' . $item['Price'] . '</span>';
                                            echo "<img src='Admin/uploads/items/". $item['image'] . "' alt=''/>";
                                            echo '<div class="caption">';
                                                    echo '<h3><a href="items.php?itemid=' . $item['item_id'] .'">' . $item['Name'] . '</a></h3>';
                                                    echo '<p>' . $item['Description'] . '</p>';
                                                    echo '<div class="date">' . $item['Add_date'] . '</div>';
                                            echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                        
                                    }
                            }else{
                                echo 'sorry there is no Ads to show, creat <a href="newad.php"> new Ads </a>' ;
                            }
                            echo '</div>';
                            ?>              
                    </div>
                </div>
            </div>
      </div>
    
      <div id="my-comment" class="information block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">My comments</div>
                    <div class="panel-body">
                    <?php

                            $stmt = $con->prepare("SELECT comment FROM   comments WHERE user_id = ?");

                            $stmt->execute(array($info['UserID']));

                            $comments = $stmt->fetchAll();

                            if(! empty($comments)){
                                foreach($comments as $comment){
                                    echo '<p>' . $comment['comment'] . '</p>' . '<hr>';
                                }
                            }else{
                                echo " there is no comments to show ";
                            }
                    ?>
                    </div>
                </div>
            </div>
      </div>

<?php

      }else{

       header('Location: login.php');

       exit();

      }
      include $tpl . 'footer.php';
      ob_end_flush();
?>
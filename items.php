<?php 
    ob_start();
    session_start();
    $pageTitle="show items" ;

      include 'include/languages/en.php';
      include 'include/template/header.php';
      include 'int.php';


     //checked if get request userid is numiric $ get the integer value of it
     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

     // selectAll Data Depend on this Id
     $stmt = $con->prepare("SELECT  
                                    items.* ,
                                    category.Name as 'category_Name',
                                    users.Username as 'user_name'
                            FROM 
                                    items 

                            INNER JOIN
                                    category
                            ON 
                                    category.id = items.Cat_id
                            INNER JOIN 
                                    users
                            ON 
                                    users.UserID = items.Membor_id
                            WHERE   
                                    item_id = ?
                            And 
                                    Approve =1");                             
                                         
     //Execute query
     $stmt->execute(array($itemid));

     $count = $stmt->rowCount();

     if($count > 0){

     //fetch all data
     $item = $stmt->fetch();


?>
      <h1 class="text-center"> My <?php echo $item['Name']; ?> </h1>

      <div class="container">
            <div class="row">
                        <div class="col-md-3">
                        <img class="img-responsive img-thumbnail center-block"  src="Admin/uploads/items/<?php echo $item['image']; ?>" alt="" />
                        </div>
                        <div class="col-md-9 item-info">
                        <h2> <?php echo $item['Name']; ?> </h2>
                        <p><?php echo $item['Description']; ?></p>
                        <ul class="list-unstyled">
                                <li><span>Added Date </span>:<?php echo $item['Add_date']; ?></li>
                                <li><span>Price </span>: <?php echo $item['Price']; ?></li>
                                <li><span>Made In  </span>: <?php echo $item['Country_made']; ?></li>
                                <li><span>category</span>: <a href="categories.php?pageid=<?php echo $item['Cat_id']?>"><?php echo $item['category_Name']; ?></a></li>
                                <li><span>Add By  </span>: <a href="#"><?php echo $item['user_name']; ?></a></li>
                        </ul>
                        </div>
            </div>
            <hr class="custom-hr">

            <?php if(isset($_SESSION['user'])){?>

            <!--start Add comment-->
            <div class="row">
                <div class="col-md-offset-3">
                        <div class="add-comment">
                                <h3>Add new comment</h3>
                                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['item_id']?>" method="POST">
                                        <textarea name="comment" class="form-control" required></textarea>
                                        <input class="btn btn-primary" type="submit" value="Add comment">
                                </form>
                                <?php 
                                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                                
                                                $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                                                $itemid = $item['item_id'];
                                                $userid = $_SESSION['uid'];
                                                

                                                if(! empty($comment)){

                                                        $stmt = $con->prepare("INSERT INTO
                                                                                comments(comment, status, comment_date, item_id, user_id)
                                                                                VALUES(:zcomment, 0, NOW(), :zitemid , :zuserid)");

                                                        $stmt->execute(array(
                                                                'zcomment' => $comment ,
                                                                'zitemid'  => $itemid  ,
                                                                'zuserid'  => $userid  
                                                        ));

                                                        if($stmt){

                                                                echo '<div class="alert alert-success">comment Add</div>';
                                                        }
                                                }
                                        }
                                ?>
                        </div>
                </div>
            </div>

            <?php }else{
                    echo '<p class="alert alert-info"><a href="login.php">login or regidster</a>  to Add comment </p>' ;
            } ?>

            <!--end Add comment-->

            <hr class="custom-hr">
            <?php
                        
                        $stmt = $con->prepare("SELECT
                                                    comments.*,users.Username AS username
                                               FROM 
                                                    comments
                                                INNER JOIN 
                                                        users
                                                ON 
                                                        users.UserID = comments.user_id 
                                                where
                                                        item_id = ?
                                                AND 
                                                        status = 1
                                                ORDER BY 
                                                        c_id DESC");

                        $stmt->execute(array($item['item_id']));

                        $comments = $stmt->fetchAll();
                        ?>
                        <?php
                        foreach($comments as $comment){ ?>

                        <div class="comment-box">
                                <div class="row">
                                        <div class="col-sm-2 text-center">
                                                <img class="img-responsive img-thumbnail img-circle center-block"  src="Admin/uploads/avatar/<?php $comment['avatar'] ?>" alt="" />
                                                <?php echo  $comment['username'] ?>
                                        </div>
                                        <div class="col-sm-10"><?php echo '<p class="lead">'.  $comment['comment'] .'</p>' ?></div>
                                </div>
                        </div>   
                        <hr class="custom-hr">  
                <?php } ?>
        </div>
      <?php
     }else{ ?>
     <div class="container">
        <?php
                 $theMsg = '<p class="alert alert-danger">there is no  such ID Or this is waiting Approved</p>';
                 redirectHome($theMsg , 'back');
        ?>
     </div>
    <?php }
      include $tpl . 'footer.php';
      
      ob_end_flush();
?>
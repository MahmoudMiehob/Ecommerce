 <?php
                    ob_start();
                    session_start();
                    $pageTitle = 'comments';
                    
                    
                    if(isset($_SESSION['Username'])){

                    include 'include/languages/en.php';
                    include 'include/template/header.php';

                    
                    
                    
                    $do = '';

                        if(isset($_GET['do'])){

                            $do = $_GET['do'];

                        }else{  
                            $do = 'Manage';
                        }

                    if($do == 'Manage'){
                        

                        
                        $stmt = $con->prepare("SELECT
                                                    comments.*,items.Name AS item_name,users.Username AS username
                                               FROM 
                                                    comments
                                               INNER JOIN 
                                                        items
                                                ON  
                                                        items.item_id = comments.item_id
                                                INNER JOIN 
                                                        users
                                                ON 
                                                        users.UserID = comments.user_id 
                                                ORDER BY 
                                                        c_id DESC");

                        $stmt->execute();

                        $rows = $stmt->fetchAll();

                        if(! empty($rows)){
                        ?>
                    
                        <h1 class="text-center titletop">Manage comments</h1>

                        <div class="container">
                            <div class="table-responsive">
                                <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>Id</td>
                                        <td>comment</td>
                                        <td>Item Name</td>
                                        <td>user name</td>
                                        <td>Add date</td>
                                        <td>control</td>
                                    </tr>
                                    <?php 
                                        foreach($rows as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $row['c_id'] ?></td>
                                        <td><?php echo $row['comment'] ?></td>
                                        <td><?php echo $row['item_name'] ?></td>
                                        <td><?php echo $row['username'] ?></td>
                                        <td><?php echo $row['comment_date'] ?></td>
                                    
                                        <td>
                                            <a href='comment.php?do=Edit&comid=<?php echo $row["c_id"]; ?>' class="btn btn-success"><i class="fa fa-edit"></i>Edit </a>
                                            <a href='comment.php?do=delete&comid=<?php echo $row["c_id"]; ?>' class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete </a>

                                            <?php
                                                if($row['status'] == 0){?>

                                                    <a href='comment.php?do=Approve&comid=<?php echo $row['c_id']; ?>' class='btn btn-info'><i class='fa fa-check'></i> Approve </a>

                                            <?php  }
                                            
                                            ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        
                        <?php }else{
                        echo '<div class="container">';
                        echo '<div class="alert alert-info id">there\'s no items</div>';?>
                        <a href="items.php?do=Add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Items</a>
                        </div>
               <?php   }?>                        

                <?php }
        
                    elseif($do == 'Edit'){
                        
                        //checked if get request userid is numiric $ get the integer value of it

                        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

                        // selectAll Data Depend on this Id

                        $stmt = $con->prepare("SELECT *  FROM    comments    WHERE    c_id = ? ");
                        
                        //Execute query

                        $stmt->execute(array($comid));

                        // Fetch The data

                        $row = $stmt->fetch();

                        //the row count

                        $count = $stmt->rowCount();

                        //if there's fetch id

                        if($stmt->rowCount()>0){?>

                            <h1 class="text-center titletop">Edit comments</h1>

                            <div class="container">
                                
                                <form class="form-horizontal" action="?do=Update" method="POST">
                                    <input type="hidden" name="comid" value="<?php echo $comid ?>">
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">comment</label>
                                        <div class="col-md-6 col-sm-10 ">
                                            <textarea class="form-control" name="comment"><?php echo $row['comment']  ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-lg">
                                        <div class="col-md-offset-2 col-md-6 col-sm-10 ">
                                            <input type="submit" value="save" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                <?php
                    }else{

                            echo "<div class='container'>";

                            $theMsg =  "<div class='alert alert-danger id'>there is no id</div>";

                            redirectHome($theMsg); 
                            

                            echo "</div>";
                    }

                }elseif($do == 'Update'){
                
                    echo ' <h1 class="text-center titletop">Update comment</h1>  ';
                    echo '<div class="container">';
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        

                                $comid     = $_POST['comid']    ;
                                $comment   = $_POST['comment']  ;



                                $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id = ? ");
                                $stmt->execute(array($comment,$comid));

                                $theMsg =  "<div class='alert alert-succses'> " . $stmt->rowCount() . "</div>" ;

                                redirectHome($theMsg , 'back');
                        

                }else{

                    echo "<div class='container'>";

                    $theMsg = "<div class='alert alert-danger'>sorry you cant Browse this page </div> ";

                    redirectHome($theMsg , 'back');

                    echo "</div>";
                }
                echo "</div>";
                }elseif($do == 'delete'){

                    echo ' <h1 class="text-center titletop">delete comments</h1>  ';
                    echo '<div class="container">';

                        //checked if get request comid is numiric $ get the integer value of it

                        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

                        // selectAll Data Depend on this Id

                        $stmt = $con->prepare("SELECT *  FROM    comments    WHERE    c_id = ?  LIMIT 1");
                        
                        
                        //Execute query

                        $stmt->execute(array($comid));


                        //the row count

                        $count = $stmt->rowCount();

                        //if there's fetch id

                        if($stmt->rowCount()>0){

                            $stmt = $con->prepare('DELETE FROM comments WHERE c_id = :zid ');

                            $stmt->bindParam(":zid",$comid);

                            $stmt->execute();

                            $theMsg = '<div class="alert alert-success">you are delete this comment</div>';

                            redirectHome($theMsg , 'back');
                        }else{
                            $theMsg =  '<div class="alert alert-danger">sorry , yos cant delet this comment please try agein</div>';           
                            
                            redirectHome($theMsg , 'back');
                        }
                }elseif($do == 'Approve'){

                    
                    echo ' <h1 class="text-center titletop">Activate comment</h1>  ';
                    echo '<div class="container">';

                        //checked if get request comid is numiric $ get the integer value of it

                        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;

                        // selectAll Data Depend on this Id

                        $stmt = $con->prepare("SELECT c_id  FROM    comments    WHERE    c_id = ? ");
                        
                        
                        //Execute query

                        $stmt->execute(array($comid));


                        //the row count

                        $count = $stmt->rowCount();

                        //if there's fetch id

                        if($stmt->rowCount()>0){

                            $stmt = $con->prepare('UPDATE comments set  status = 1 WHERE c_id = ? ');

                            $stmt->execute(array($comid));

                            $theMsg = '<div class="alert alert-success">you are Upadated this comment</div>';

                            redirectHome($theMsg , 'back');
                        }else{
                            $theMsg =  '<div class="alert alert-danger">sorry , yos cant delet this comment please try agein</div>';           
                            
                            redirectHome($theMsg , 'back');
                        }
                }

                    include $tpl . 'footer.php' ;

                    }else{

                        header('Location: index.php');
                        
                        exit();
                    }

                    ob_end_flush();
?>


<?php

            ob_start();
            session_start();
            $pageTitle = 'members';?>
            
            
        <?php    if(isset($_SESSION['Username'])){

            include 'include/languages/en.php';
            include 'include/template/header.php';
            include 'include/template/navbar.php';
            
            
            
            $do = '';

                if(isset($_GET['do'])){

                    $do = $_GET['do'];

                }else{  
                     $do = 'Manage';
                }

            if($do == 'Manage'){
                
                $query = '';

                if(isset($_GET['page']) && $_GET['page'] == 'pending'){

                    $query = ' AND Regstatus = 0';
                }
                
                $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");

                $stmt->execute();

                $rows = $stmt->fetchAll();

                if(! empty($rows)){
                ?>
               
                <h1 class="text-center titletop">Manage members</h1>

                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>#Id</td>
                                <td>Avatar</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Fullname</td>
                                <td>Regestered</td>
                                <td>control</td>
                            </tr>
                            <?php 
                                  foreach($rows as $row){
                            ?>
                            <tr>
                                <td><?php echo $row['UserID'] ?>  </td>
                                <td><img src="uploads/avatar/<?php echo $row['avatar']; ?>" width="40px" height="35px" alt="no image"> </td>
                                <td><?php echo $row['Username'] ?></td>
                                <td><?php echo $row['Email'] ?>   </td>
                                <td><?php echo $row['Fullname'] ?></td>
                                <td><?php echo $row['Date'] ?>    </td>
                                <td>
                                    <a href='members.php?do=Edit&UserID=<?php echo $row["UserID"]; ?>' class="btn btn-success"><i class="fa fa-edit"></i>Edit </a>
                                    <a href='members.php?do=delete&UserID=<?php echo $row["UserID"]; ?>' class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete </a>

                                    <?php
                                        if($row['Regstatus'] == 0){?>

                                            <a href='members.php?do=Activate&UserID=<?php echo $row['UserID']; ?>' class='btn btn-info'><i class='fa fa-check'></i> Activate </a>

                                      <?php  }
                                    
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
                </div>
                 <?php }else{
                     echo '<div class="container">';
                            echo '<div class="alert alert-info id"> there\'s no record to show </div>';
                     echo '</div>';

                 } ?>

           <?php }elseif($do == 'Add'){ ?>
                //Add members
                    <h1 class="text-center titletop">Add Members</h1>

                    <div class="container">
                        
                        <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Username</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="username"  class="form-control" autocomplete="off" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">password</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="password" name="password" class="password form-control" autocomplate="new-password" required="required" >
                                    <i class="show-pass fa fa-eye fa-2x"></i>
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="email" name="email"  class="form-control" autocomplete="off" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">fullname</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="fullname"  class="form-control" autocomplete="off" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">user image</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="file" name="avatar"  class="form-control" autocomplete="off" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <div class="col-md-offset-2 col-md-6 col-sm-10 ">
                                    <input type="submit" value="Add Member" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
            }elseif($do == 'Insert'){

               if($_SERVER['REQUEST_METHOD'] == 'POST'){

                      echo ' <h1 class="text-center titletop">Insert</h1>  ';
                      echo '<div class="container">';                     
    
                      
                     // $avatar = $_FILES['avatar'];

                      $avatarName = $_FILES['avatar']['name']       ;
                      $avatarSize = $_FILES['avatar']['size']       ;
                      $avatarTemp = $_FILES['avatar']['tmp_name']   ;
                      $avatarType = $_FILES['avatar']['type']       ;

                      $avatarAllowedExtension = array("jpge", "jpg" ,"png" ,"gif");

                      @$avatarExtention = strtolower(end(explode('.', $avatarName)));


                      $user     = $_POST['username']  ;
                      $password = $_POST['password']  ;
                      $email    = $_POST['email']     ;
                      $fullname = $_POST['fullname']  ;
    
                      // password trick
    
    
                      $pass = sha1($_POST['password']) ;
    
                      // validate the user
    
                      $formError = array();
    
    
                      if(strlen($user)<4){
    
                        $formError[] = 'username cant be less than <strong> 4 characters</strong>' ;
    
                      }
    
                      if(strlen($user)> 20){
    
                        $formError[] = 'username cant be more than <strong> 20 characters</strong>' ;
    
                      }
    
    
                      if(empty($user)){
    
                        $formError[] = 'username name cant be <strong>empty</strong>' ;
                          
                      }

                      if(empty($password)){
                          
                        $formError[] = ' password cant be <strong>empty</strong>' ;
                        
                      }  

                      if(empty($fullname)){
                          
                        $formError[] = 'name name cant be <strong>empty</strong>' ;
                        
                      }
                      if(empty($email)){
                          
                        $formError[] = 'email name cant be <strong> empty </strong>' ;
                      }
                      if(! empty($avatarName) &&! in_array($avatarExtention , $avatarAllowedExtension)){

                        $formError[] = 'this Extintion is not Allowed' ;

                      }
                      if(empty($avatarName)){

                        $formError[] = 'image is required' ;

                      }

                      if(($avatarSize) > 4194304){

                        $formError[] = 'image cant br larger than 4MB' ;

                      }
    
                    foreach($formError as $error){
    
                        $theMsg = ' <div class="alert alert-danger"> ' . $error . '</div>' ;
                        redirectHome($theMsg,'back');
    
                    }}else{
                        $theMsg = '<div class="alert alert-danger">sorry you cant Brouse this page</div>';
     
                        redirectHome($theMsg,'back');  
                        
                    }

                    if(empty($formError)){

                        $avatar = rand(0 , 100000000) . '_' . $avatarName;

                        move_uploaded_file($avatarTemp ,"uploads\avatar\\" . $avatar );

                        


                        $check = checkitem ("Username", "users" , $user);

                        if($check == 1){

                            echo "<div class='container'>";

                            $theMsg = "<div class='alert alert-danger'>sorry this user is exist</div>";

                            redirectHome($theMsg,'back');

                            echo "</div>";

                        }else{

                                    $stmt = $con->prepare("INSERT INTO 
                                                                    users(Username,Password,Email,Fullname,Regstatus, Date , avatar)
                                                                    VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar)");
                                    
                                    $stmt->execute(array(
                                        'zuser'  => $user,
                                        'zpass'  => $pass,
                                        'zmail'  => $email,
                                        'zname'  => $fullname,
                                        'zavatar'=> $avatar 
                                       
                                    ));

                                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() .  "</div>";

                                    redirectHome($theMsg,'back');
                    }
                }
               
               echo "</div>";                
            }
            elseif($do == 'Edit'){
                
                //checked if get request userid is numiric $ get the integer value of it

                $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0 ;

                // selectAll Data Depend on this Id

                $stmt = $con->prepare("SELECT *  FROM    users    WHERE    UserID = ?  LIMIT 1");
                
                //Execute query

                $stmt->execute(array($userid));

                // Fetch The data

                $row = $stmt->fetch();

                //the row count

                $count = $stmt->rowCount();

                //if there's fetch id

                if($stmt->rowCount()>0){?>

                    <h1 class="text-center titletop">Edit Members</h1>

                    <div class="container">
                        
                        <form class="form-horizontal" action="?do=Update" method="POST">
                            <input type="hidden" name="userid" value="<?php echo $userid ?>">
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Username</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">password</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
                                    <input type="password" name="newpassword" class="form-control" autocomplate="new-password" placeholder="leave blank if you dont change">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" autocomplete="off" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">fullname</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="fullname" value="<?php echo $row['Fullname'] ?>" class="form-control" autocomplete="off" required="required">
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
          
            echo ' <h1 class="text-center titletop">Update Members</h1>  ';
            echo '<div class="container">';
           if($_SERVER['REQUEST_METHOD'] == 'POST'){
                  

                  $id     = $_POST['userid']    ;
                  $user   = $_POST['username']  ;
                  $email  = $_POST['email']     ;
                  $fullname= $_POST['fullname'] ;

                  // password trick


                  $pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] :sha1($_POST['newpassword']) ;

                  // validate the user

                  $formError = array();
    
    
                  if(strlen($user)<4){

                    $formError[] = 'username cant be less than <strong> 4 characters</strong>' ;

                  }

                  if(strlen($user)> 20){

                    $formError[] = 'username cant be more than <strong> 20 characters</strong>' ;

                  }


                  if(empty($user)){

                    $formError[] = 'username name cant be <strong>empty</strong>' ;
                      
                  }

                  if(empty($fullname)){
                      
                    $formError[] = 'name name cant be <strong>empty</strong>' ;
                    
                  }
                  if(empty($email)){
                      
                    $formError[] = 'email name cant be <strong> empty </strong>' ;
                }

                foreach($formError as $error){

                    echo ' <div class="alert alert-danger"> ' . $error . '</div>' ;

                }

                if(empty($formError)){

                  $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
                  $stmt2->execute(array($user,$id));
                  $count = $stmt2->rowCount();
                  if($count == 1){

                    $theMsg ='<p class="id">sorry this user is exist</p>';
                    redirectHome($theMsg , 'back');
                  }else{


                  $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , Fullname = ?, Password = ? WHERE UserID = ? ");
                  $stmt->execute(array($user, $email, $fullname, $pass, $id));

                  $theMsg =  "<div class='alert alert-succses'> " . $stmt->rowCount() . "</div>" ;

                  redirectHome($theMsg , 'back');
                }}

           }else{

            echo "<div class='container'>";

               $theMsg = "<div class='alert alert-danger'>sorry you cant Browse this page </div> ";

               redirectHome($theMsg , 'back');



            echo "</div>";
           }
           echo "</div>";
        }elseif($do == 'delete'){

            echo ' <h1 class="text-center titletop">delete Members</h1>  ';
            echo '<div class="container">';

                //checked if get request userid is numiric $ get the integer value of it

                $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0 ;

                // selectAll Data Depend on this Id

                $stmt = $con->prepare("SELECT *  FROM    users    WHERE    UserID = ?  LIMIT 1");
                
                
                //Execute query

                $stmt->execute(array($userid));


                //the row count

                $count = $stmt->rowCount();

                //if there's fetch id

                if($stmt->rowCount()>0){

                    $stmt = $con->prepare('DELETE FROM users WHERE UserID = :zuser ');

                    $stmt->bindParam(":zuser",$userid);

                    $stmt->execute();

                    $theMsg = '<div class="alert alert-success">you are delete this members</div>';

                    redirectHome($theMsg , 'back');
                }else{
                    $theMsg =  '<div class="alert alert-danger">sorry , yos cant delet this members please try agein</div>';           
                    
                    redirectHome($theMsg , 'back');
                }
        }elseif($do == 'Activate'){

            
            echo ' <h1 class="text-center titletop">Activate Members</h1>  ';
            echo '<div class="container">';

                //checked if get request userid is numiric $ get the integer value of it

                $userid = isset($_GET['UserID']) && is_numeric($_GET['UserID']) ? intval($_GET['UserID']) : 0 ;

                // selectAll Data Depend on this Id

                $stmt = $con->prepare("SELECT *  FROM    users    WHERE    UserID = ?  LIMIT 1");
                
                
                //Execute query

                $stmt->execute(array($userid));


                //the row count

                $count = $stmt->rowCount();

                //if there's fetch id

                if($stmt->rowCount()>0){

                    $stmt = $con->prepare('UPDATE users set  Regstatus = 1 WHERE UserID = ? ');

                    $stmt->execute(array($userid));

                    $theMsg = '<div class="alert alert-success">you are Upadated this members</div>';

                    redirectHome($theMsg , 'back');
                }else{
                    $theMsg =  '<div class="alert alert-danger">sorry , yos cant delet this members please try agein</div>';           
                    
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


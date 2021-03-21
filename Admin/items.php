<?php

      ob_start();

      session_start();

      $pageTitle = 'Items';

      if(isset($_SESSION['Username'])){


        include 'include/languages/en.php';
        include 'include/template/header.php';
        

          $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

          if($do == 'Manage'){
  
            
            $stmt = $con->prepare("SELECT items.* ,
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
                                          users.UserID = items.Membor_id;
                                    ORDER BY item_id");

            $stmt->execute();

            $items = $stmt->fetchAll();

            if(! empty($items)){
            
            ?>
           
            <h1 class="text-center titletop">Manage Items</h1>

            <div class="container">
                <div class="table-responsive">
                    <table class="main-table text-center table table-bordered">
                        <tr>
                            <td>#Id</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>price</td>
                            <td>Adding date</td>
                            <td>category</td>
                            <td>UserName</td>
                            <td>control</td>
                        </tr>
                        <?php 
                              foreach($items as $item){
                        ?>
                        <tr>
                            <td><?php echo $item['item_id'] ?></td>
                            <td><?php echo $item['Name'] ?></td>
                            <td><?php echo $item['Description'] ?></td>
                            <td><?php echo $item['Price'] ?></td>
                            <td><?php echo $item['Add_date'] ?></td>
                            <td><?php echo $item['category_Name'] ?></td>
                            <td><?php echo $item['user_name'] ?></td>
                            <td>
                                <a href='items.php?do=Edit&itemid=<?php echo $item["item_id"]; ?>' class="btn btn-success"><i class="fa fa-edit"></i>Edit </a>
                                <a href='items.php?do=delete&itemid=<?php echo $item["item_id"]; ?>' class="btn btn-danger confirm"><i class="fa fa-times"></i> Delete </a>

                                <?php
                                        if($item['Approve'] == 0){?>

                                            <a href='items.php?do=Approve&itemid=<?php echo $item['item_id']; ?>' class='btn btn-info'><i class='fa fa-check'></i> Approve </a>

                                <?php  }  ?>                                
                                
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <a href="items.php?do=Add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Items</a>
            </div>
            <?php }else{
                        echo '<div class="container">';
                        echo '<div class="alert alert-info id">there\'s no items</div>';?>
                        <a href="items.php?do=Add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> New Items</a>
                        </div>
               <?php   }?>
           <?php
          }elseif($do == 'Add'){ ?>

            <h1 class="text-center titletop">Add new Items</h1>
            <div class="container">
                
                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-md-6 col-sm-10 ">
                            <input type="text"
                                   name="Name"
                                   class="form-control"
                                   autocomplete="off"
                                  >
                        </div>
                    </div>
                    
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-md-6 col-sm-10 ">
                              <input type="text" 
                                     name="description" 
                                     class="form-control"
                                     autocomplete="off"  >
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-md-6 col-sm-10 ">
                              <input type="text" 
                                     name="price" 
                                     class="form-control"
                                     autocomplete="off"  >
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">country</label>
                        <div class="col-md-6 col-sm-10 ">
                              <input type="text" 
                                     name="country" 
                                     class="form-control"
                                     autocomplete="off"  >
                        </div>
                    </div>
                    
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">item image</label>
                        <div class="col-md-6 col-sm-10 ">
                              <input type="file" 
                                     name="item-image" 
                                     class="form-control"  >
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">ststus</label>
                        <div class="col-md-6 col-sm-10 ">
                              <select class="form-control" name="status">
                                    <option value="0">...</option>
                                    <option value="1">New</option>
                                    <option value="2">like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Old</option>
                              </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-md-6 col-sm-10 ">
                              <select class="form-control" name="member">
                                    <option value="0">...</option>
                                    <?php 
                                       $AllMember = gitAllForm("*" , "users" , "" , "" ,"UserID" );

                                       foreach ($AllMember as $user){
                                           echo "<option value='". $user['UserID'] . "'>" . $user['Username'] . "</option>" ;
                                       }
                                    
                                    ?>
                              </select>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">category</label>
                        <div class="col-md-6 col-sm-10 ">
                              <select class="form-control" name="category">
                                    <option value="0">...</option>
                                    <?php
                                       $Allcat = gitAllForm("*" , "category" , "where parent = 0" , "" ,"id" );

                                       foreach ($Allcat as $cat){
                                           echo "<option value='". $cat['id'] . "'>" . $cat['Name'] . "</option>" ;

                                           $chiledcat = gitAllForm("*" , "category" , "where parent = {$cat['id']}" , "" ,"id" );

                                           foreach($chiledcat as $chiled){

                                            echo "<option value='". $chiled['id'] . "'> ---" . $chiled['Name'] . "</option>" ;

                                           }
                                       }
                                    
                                    ?>
                              </select>
                        </div>
                    </div>


                    <div class="form-group form-group-lg">
                        <div class="col-md-offset-2 col-md-6 col-sm-10 ">
                               <input type="submit"
                                      value="Add Item"
                                      class="btn btn-primary btn-sm">
                        </div>
                    </div>
                </form>
            </div>

          <?php


          }elseif($do == 'Insert'){
              
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        echo ' <h1 class="text-center titletop">Insert Items</h1>  ';
                        echo '<div class="container">';           
                        
                        
                        $itemeImagrName = $_FILES['item-image']['name'];
                        $itemeImagrSize = $_FILES['item-image']['size'];
                        $itemeImagrTmp  = $_FILES['item-image']['tmp_name'];
                        $itemeImagrType = $_FILES['item-image']['type'];


                        $itemAllowedExtension = array("jpge", "jpg" ,"png" ,"gif","jfif");

                        @$itemExtention = strtolower(end(explode('.', $itemeImagrName)));


                        
                        $name     = $_POST['Name']         ;
                        $desc     = $_POST['description']  ;
                        $price    = $_POST['price']        ;
                        $country  = $_POST['country']      ;
                        $status   = $_POST['status']       ;
                        $cat      = $_POST['category']     ;
                        $member   = $_POST['member']       ;

                        // validate the user

                        $formError = array();


                        if(empty($name)){

                        $formError[] = 'name cant be  <strong> empty</strong>' ;

                        }

                        if(empty($price)){

                        $formError[] = 'price cant be  <strong> empty</strong>' ;

                        }


                        if(empty($desc)){

                        $formError[] = 'description cant be  <strong> empty</strong>' ;
                            
                        }

                        if(empty($country)){
                            
                        $formError[] = 'country cant be  <strong> empty</strong>' ;
                        
                        }  

                        if(($status == 0)){
                            
                        $formError[] = 'You must choose the   <strong> status </strong>' ;
                        
                        }

                        if(($member == 0)){
                            
                            $formError[] = 'You must choose the  <strong> member</strong>' ;
                            
                        }

                        if(($cat == 0)){
                            
                        $formError[] = 'You must choose the   <strong> category</strong>' ;
                        
                        }


                        if(! empty($itemeImagrName) &&! in_array($itemExtention, $itemAllowedExtension)){

                            $formError[] = 'this Extintion is not Allowed' ;
    
                          }
                          if(empty($itemeImagrName)){
    
                            $formError[] = 'image is required' ;
    
                          }
    
                          if(($itemeImagrSize) > 4194304){
    
                            $formError[] = 'image cant br larger than 4MB' ;
    
                          }


                    foreach($formError as $error){

                        echo ' <div class="alert alert-danger"> ' . $error . '</div>' ;

                    }}else{
                        $theMsg = '<div class="alert alert-danger">sorry you cant Brouse this page</div>';

                        redirectHome($theMsg , 'back');  
                        
                    }

                    if(empty($formError)){



                                    $itmImg = rand(0 , 100000000) . '_' . $itemeImagrName;

                                    move_uploaded_file($itemeImagrTmp ,"uploads\avatar\\" . $itmImg );
 

                                    $stmt = $con->prepare("INSERT INTO 
                                                                    items(Name,	Description,Price,Country_made, image, Status,Add_date ,Cat_id,Membor_id)
                                                           VALUES  (:zname,:zdesc, :zprice, :zcountry, :zimage , :zstatus, now(),:zcat,:zmember)");
                                    
                                    $stmt->execute(array(
                                        'zname'     => $name,
                                        'zdesc'     => $desc,
                                        'zprice'    => $price,
                                        'zcountry'  => $country,
                                        'zstatus'   => $status ,
                                        'zcat'      => $cat,
                                        'zmember'   => $member ,
                                        'zimage'   => $itmImg 
                                        
                                    ));

                                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() .  "</div>";

                                    redirectHome($theMsg , 'back');
                    }
                

                
                echo "</div>";

          }elseif($do == 'Edit'){

                        //checked if get request userid is numiric $ get the integer value of it

                        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                        // selectAll Data Depend on this Id

                        $stmt = $con->prepare("SELECT   items.* ,
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
                                                        item_id = ?");
                        
                        //Execute query

                        $stmt->execute(array($itemid));

                        // Fetch The data

                        $item = $stmt->fetch();

                        //the row count

                        $count = $stmt->rowCount();

                        //if there's fetch id

                        if($count>0){?>

                        <h1 class="text-center titletop">Edit Items</h1>
                        <div class="container">
                
                        <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="itemid" value="<?php echo $itemid ?>">
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text"
                                        name="Name"
                                        class="form-control"
                                        autocomplete="off"
                                        value="<?php echo $item['Name'] ?>"
                                        >
                                </div>
                            </div>
                            
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" 
                                            name="description" 
                                            class="form-control"
                                            autocomplete="off"
                                            value="<?php echo $item['Description'] ?>"
                                              >
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" 
                                            name="price" 
                                            class="form-control"
                                            autocomplete="off"
                                            value="<?php echo $item['Price'] ?>"
                                              >
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">country</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" 
                                            name="country" 
                                            class="form-control"
                                            autocomplete="off"
                                            value="<?php echo $item['Country_made'] ?>"
                                              >
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">ststus</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <select class="form-control" name="status">
                                            <option value="0"><?php echo $item['Status'] ; ?></option>
                                            <option value="1">New</option>
                                            <option value="2">like New</option>
                                            <option value="3">Used</option>
                                            <option value="4">Old</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Member</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <select class="form-control" name="member">
                                            <option value="0"><?php echo $item['user_name'] ;  ?></option>
                                            <?php 

                                            $stmt = $con->prepare("SELECT * FROM users");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll();

                                            foreach ($users as $user){
                                                echo "<option value='". $user['UserID'] . "'>" . $user['Username'] . "</option>" ;
                                            }
                                            
                                            ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">category</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <select class="form-control" name="category">
                                            <option value="0"><?php echo $item['category_Name'] ;  ?></option>
                                            <?php 

                                            $stmt2 = $con->prepare("SELECT * FROM category");
                                            $stmt2->execute();
                                            $cats = $stmt2->fetchAll();

                                            foreach ($cats as $cat){
                                                echo "<option value='". $cat['id'] . "'>" . $cat['Name'] . "</option>" ;
                                            }
                                            
                                            ?>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group form-group-lg">
                                <div class="col-md-offset-2 col-md-6 col-sm-10 ">
                                    <input type="submit" value="save" class="btn btn-primary">
                                </div>
                            </div>  
                            </form>

                            <?php
                            $stmt = $con->prepare("SELECT
                                                        comments.*,users.Username AS username
                                                FROM 
                                                        comments
                                              
                                                INNER JOIN 
                                                         users
                                                ON 
                                                         users.UserID = comments.user_id 
                                                WHERE item_id = ?");

                            $stmt->execute(array($itemid));

                            $rows = $stmt->fetchAll();

                            if(! empty($rows)){
                            
                            ?>
                        
                            <h1 class="text-center titletop">Manage [<?php echo $item['Name'] ?>] comments</h1>

                           
                                <div class="table-responsive">
                                    <table class="main-table text-center table table-bordered">
                                        <tr>
                                            
                                            <td>comment</td> 
                                            <td>user name</td>
                                            <td>Add date</td>
                                            <td>control</td>
                                        </tr>
                                        <?php 
                                            foreach($rows as $row){
                                        ?>
                                        <tr>
                                            
                                            <td><?php echo $row['comment'] ?></td>
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
                                                    <?php } ?>
                            </div>                     

                        <?php } else{

                            echo "<div class='container'>";

                            $theMsg =  "<div class='alert alert-danger id'>there is no id</div>";

                            redirectHome($theMsg); 


                            echo "</div>";
                         } 

          }elseif($do == 'Update'){


                            echo ' <h1 class="text-center titletop">Update items</h1>  ';
                            echo '<div class="container">';
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                

                                $id        = $_POST['itemid']       ;
                                $Name      = $_POST['Name']         ;
                                $desc      = $_POST['description']  ;
                                $price     = $_POST['price']        ;
                                $contry    = $_POST['country']      ;
                                $status    = $_POST['status']       ;
                                $member    = $_POST['member']       ;
                                $cat       = $_POST['category']     ;


                                // validate the user

                                $formError = array();


                                if(empty($Name)){
        
                                $formError[] = 'name cant be  <strong> empty</strong>' ;
        
                                }
        
                                if(empty($price)){
        
                                $formError[] = 'price cant be  <strong> empty</strong>' ;
        
                                }
        
        
                                if(empty($desc)){
        
                                $formError[] = 'description cant be  <strong> empty</strong>' ;
                                    
                                }
        
                                if(empty($contry)){
                                    
                                $formError[] = 'country cant be  <strong> empty</strong>' ;
                                
                                }  
        
                                if(($status == 0)){
                                    
                                $formError[] = 'You must choose the   <strong> status </strong>' ;
                                
                                }
        
                                if(($member == 0)){
                                    
                                    $formError[] = 'You must choose the  <strong> member</strong>' ;
                                    
                                }
        
                                if(($cat == 0)){
                                    
                                $formError[] = 'You must choose the   <strong> category</strong>' ;
                                
                                }
        
        
                            foreach($formError as $error){
        
                              

                                $theMsg =  "<div class='alert alert-danger'> " . $error  . "</div>" ;

                                redirectHome($theMsg , 'back');
        
                            } 


                            if(empty($formError)){

                                $stmt = $con->prepare("UPDATE
                                                             items
                                                       SET  
                                                             Name = ? ,
                                                             Description = ? ,
                                                             Price = ?,
                                                             Country_made=?,
                                                             Status =? ,
                                                             Cat_id = ? ,
                                                             Membor_id =?
                                                            
                                                      
                                                       WHERE
                                                             item_id = ? ");


                                $stmt->execute(array($Name, $desc, $price, $contry, $status , $cat ,$member ,$id));
              
                                $theMsg =  "<div class='alert alert-succses'> " . $stmt->rowCount() . "</div>" ;
              
                                redirectHome($theMsg , 'back');  }
                            
                            }else{
                                $theMsg = '<div class="alert alert-danger">sorry you cant Brouse this page</div>';
        
                                redirectHome($theMsg , 'back');  
                                
                            }
                        echo "</div>";
                        

          }elseif($do == 'delete'){

                            echo ' <h1 class="text-center titletop">delete items</h1>  ';
                            echo '<div class="container">';

                                //checked if get request userid is numiric $ get the integer value of it

                                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                                // selectAll Data Depend on this Id

                                $stmt = $con->prepare("SELECT *  FROM    items    WHERE    item_id = ?  LIMIT 1");
                                
                                
                                //Execute query

                                $stmt->execute(array($itemid));


                                //the row count

                                $count = $stmt->rowCount();

                                //if there's fetch id

                                if($stmt->rowCount()>0){

                                    $stmt = $con->prepare('DELETE FROM items WHERE item_id = :zid ');

                                    $stmt->bindParam(":zid",$itemid);

                                    $stmt->execute();

                                    $theMsg = '<div class="alert alert-success">you are delete this members</div>';

                                    redirectHome($theMsg , 'back');
                                }else{
                                    $theMsg =  '<div class="alert alert-danger">sorry , yos cant delet this members please try agein</div>';           
                                    
                                    redirectHome($theMsg);
                                }

          }elseif($do == "Approve"){


                                echo ' <h1 class="text-center titletop">Approve items</h1>  ';
                                echo '<div class="container">';

                                    //checked if get request itemid is numiric $ get the integer value of it

                                    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                                    // selectAll Data Depend on this Id

                                    $stmt = $con->prepare("SELECT *  FROM    items    WHERE    item_id = ?  LIMIT 1");
                                    
                                    
                                    //Execute query

                                    $stmt->execute(array($itemid));


                                    //the row count

                                    $count = $stmt->rowCount();

                                    //if there's fetch id

                                    if($stmt->rowCount()>0){

                                        $stmt = $con->prepare('UPDATE items set  Approve = 1 WHERE item_id = ? ');

                                        $stmt->execute(array($itemid));

                                        $theMsg = '<div class="alert alert-success">you are Upadated this items</div>';

                                        redirectHome($theMsg , 'back');
                                    }
          }
          include $tpl . 'footer.php' ;

      }else{
          header ('Location: index.php') ;
      }

      ob_end_flush();

?>
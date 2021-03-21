<?php

      ob_start();

      session_start();

      $pageTitle = '';

      if(isset($_SESSION['Username'])){



        include 'include/languages/en.php';
        include 'include/template/header.php';
        include 'include/template/navbar.php';



          $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

          if($do == 'Manage'){

            $sort = 'ASC';

            $sort_array = array('ASC' , 'DESC');

            if(isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array)){

                $sort = $_GET['sort'];
            }

            $stmt2 = $con->prepare("SELECT * FROM category where parent = 0 ORDER BY Ordering $sort");

            $stmt2->execute();

            $cats = $stmt2->fetchAll(); ?>


            <h1 class="text-center id">Manage categories</h1>

            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-Edit"></i> Manage categories :
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i> Ordering:[
                            <a class="<?php if($sort == 'DESC'){echo 'active' ;} ?>" href="?sort=DESC">DESC</a> |
                            <a class="<?php if($sort == 'ASC'){echo 'active' ;} ?>" href="?sort=ASC"> ASC</a>]
                            <i class="fa fa-eye"></i>View:[ <span class="active" data-view="full">Full</span> |
                                  <span>Classic</span>]
                        </div>
                    </div>
                    <div class="panel-body">
                    <?php
                        foreach($cats as $cat){

                            echo "<div class='cat'>";
                            echo "<div class='hidden-buttons'>";
                                echo "<a href='categories.php?do=Edit&catid=". $cat['id'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                echo "<a href='categories.php?do=delete&catid=" . $cat['id'] ."' class='confirm btn btn-xs btn-danger'><i class='fa fa-times'></i> delete</a>";
                            echo "</div>";

                            echo "<h3>" . $cat['Name'] . "</h3>";
                            echo "<div class='full-view'>";
                                    echo "<p>"; if( $cat['Description'] == ''){echo 'this category has no description' ;}else{echo $cat['Description'] ; }  echo"</p>";
                                    if($cat['Visibality'] == 1){echo "<span class='Visibality'><i class='fa fa-eye'></i> Hidden </span>" ;} 
                                    if($cat['Allow_comment'] == 1){echo "<span class='comment'><i class='fa fa-times'></i> comment disable </span>" ;}
                                    if($cat['Allow_Ads'] == 1){echo "<span class='ads'><i class='fa fa-times'></i> Ads disable </span>" ;}
                            echo "</div>";
                            echo "</div>";

                            //Gey chiled category

                            $chiledcats = gitAllForm('*' , "category" , "where parent = {$cat['id']}" , "", "id" ,"ASC");
                            if(! empty ($chiledcats)){
                                echo '<h4 class="chiled-head">chiled category </h4> ';
                                echo '<ul class="list-unstyled chiled-cat">' ;
                                foreach($chiledcats as $chiledcat){
                                    echo '<li><a href="categories.php?do=Edit&catid='. $chiledcat['id'] .'" >'  . $chiledcat['Name'] . '<a href="categories.php?do=delete&catid='. $chiledcat['id'] .'" class="confirm shoe-delete" > Delete</a>' .'</li>';
                                    echo '';
                                }    
                                echo '</ul>';
                        }
                        echo '<hr class="custom-hr">';
                    }
                    ?>
                    </div>
                </div>
                <a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New category</a>
            </div>

           <?php
          }elseif($do == 'Add'){?>
                    <h1 class="text-center titletop">Add new categories</h1>
                    <div class="container">
                        
                        <form class="form-horizontal" action="?do=Insert" method="POST">
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="Name"  class="form-control" autocomplete="off" required="required">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="description" class="form-control" autocomplate="off"  >
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Ordering</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="Ordering"  class="form-control" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">parent ?</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <select name="parent" class="form-control">
                                         <option value="0">None</option>
                                         <?php
                                            $allCats = gitAllForm("*","category","where parent = 0" , "" , "id" , "ASC");
                                            foreach($allCats as $cate){
                                                echo "<option value='" . $cate['id'] ."'>" . $cate['Name'] ."</option>";
                                            }                                        
                                         ?>
                                    </select>
                                </div>
                            </div>                                                

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Visible</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <div>
                                        <input id="vis-yes" type="radio" name="Visibality" value="0" checked />
                                        <label for="vis-yes" > Yes </label>
                                    </div>
                                    <div>
                                        <input id="vis-no" type="radio" name="Visibality" value="1" />
                                        <label for="vis-no" > No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow commenting</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                        <label for="com-yes" > Yes </label>
                                    </div>
                                    <div>
                                        <input id="com-no" type="radio" name="commenting" value="1" />
                                        <label for="com-no" > No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Ads</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <div>
                                        <input id="Ads-yes" type="radio" name="Ads" value="0" checked />
                                        <label for="Ads-yes" > Yes </label>
                                    </div>
                                    <div>
                                        <input id="Ads-no" type="radio" name="Ads" value="1" />
                                        <label for="Ads-no" > No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <div class="col-md-offset-2 col-md-6 col-sm-10 ">
                                    <input type="submit" value="Add categories" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>

          <?php
          }elseif($do == 'Insert'){
                        if($_SERVER['REQUEST_METHOD'] == 'POST'){

                            echo ' <h1 class="text-center titletop">Insert</h1>  ';
                            echo '<div class="container">';                     

                            
                            $name        = $_POST['Name']         ;
                            $desc        = $_POST['description']  ;
                            $parent      = $_POST['parent'];
                            $order       = $_POST['Ordering']     ;
                            $visible     = $_POST['Visibality']   ;
                            $comment     = $_POST['commenting']   ;
                            $ads         = $_POST['Ads']          ;

                            $check = checkitem ("Name", "category" , $name);

                            if($check == 1){

                                echo "<div class='container'>";

                                $theMsg = "<div class='alert alert-danger'>sorry this categories is exist</div>";

                                redirectHome($theMsg , 'back');

                                echo "</div>";

                            }else{

                                        $stmt = $con->prepare("INSERT INTO 
                                                                        category(Name, Description, parent, Ordering, Visibality, Allow_comment, Allow_Ads)
                                                                      VALUES
                                                                         (:zname, :zdesc, :zparent , :zorder, :zvisible, :zcomment,:zAds)");
                                        
                                        $stmt->execute(array(

                                            'zname'     => $name,
                                            'zdesc'     => $desc,
                                            'zparent'   => $parent,
                                            'zorder'    => $order,
                                            'zvisible'  => $visible,
                                            'zcomment'  => $comment,
                                            'zAds'      => $ads 
                                            
                                        ));

                                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() .  "</div>";

                                        redirectHome($theMsg , 'back');
                        
                    
                    }}else{
                            

                           echo '<div class="container">';

                            $theMsg = '<div class="alert alert-danger id">sorry you cant Brouse this page</div>';

                            redirectHome($theMsg , 'back');  

                            echo '</div>';
                            
                        }
                        

          }elseif($do == 'Edit'){


                        //checked if get request catid is numiric $ get the integer value of it

                        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

                        // selectAll Data Depend on this Id

                        $stmt = $con->prepare("SELECT *  FROM    category    WHERE    id = ?  LIMIT 1");
                        
                        //Execute query

                        $stmt->execute(array($catid));

                        // Fetch The data

                        $cat = $stmt->fetch();

                        //the row count

                        $count = $stmt->rowCount();

                        //if there's fetch id

                        if($count>0){?>


                    <h1 class="text-center titletop">Edit categories</h1>
                    <div class="container">
                        
                        <form class="form-horizontal" action="?do=Update" method="POST">
                            <input type="hidden" name="catid" value="<?php echo $catid ?>" >
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="Name"  class="form-control"  required="required" value="<?php echo $cat["Name"]; ?>">
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="description" class="form-control" value="<?php echo $cat["Description"]; ?>"  >
                                </div>
                            </div>

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Ordering</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <input type="text" name="Ordering"  class="form-control" value="<?php echo $cat["Ordering"]; ?>" >
                                </div>
                            </div>
                            
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">parent ?</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <select name="parent" class="form-control">
                                         <option value="0">None</option>
                                         <?php
                                            $allCats = gitAllForm("*","category","where parent = 0" , "" , "id" , "ASC");
                                            foreach($allCats as $cate){
                                                echo "<option value='" . $cate['id'] ."'";
                                                if($cat['parent'] == $cate['id']){echo 'selected' ;}
                                                echo ">" . $cate['Name'] ."</option>";
                                            }                                        
                                         ?>
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Visible</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <div>
                                        <input id="vis-yes" type="radio" name="Visibality" value="0" <?php if($cat['Visibality'] == 0){echo "checked";} ?> />
                                        <label for="vis-yes" > Yes </label>
                                    </div>
                                    <div>
                                        <input id="vis-no" type="radio" name="Visibality" value="1"  <?php if($cat['Visibality'] == 1){echo "checked";} ?> />
                                        <label for="vis-no" > No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow commenting</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <div>
                                        <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_comment'] == 0){echo "checked";} ?> />
                                        <label for="com-yes" > Yes </label>
                                    </div>
                                    <div>
                                        <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_comment'] == 1){echo "checked";} ?>/>
                                        <label for="com-no" > No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Ads</label>
                                <div class="col-md-6 col-sm-10 ">
                                    <div>
                                        <input id="Ads-yes" type="radio" name="Ads" value="0"  <?php if($cat['Allow_Ads'] == 0){echo "checked";} ?>/>
                                        <label for="Ads-yes" > Yes </label>
                                    </div>
                                    <div>
                                        <input id="Ads-no" type="radio" name="Ads" value="1" <?php if($cat['Allow_Ads'] == 1){echo "checked";} ?> />
                                        <label for="Ads-no" > No </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-lg">
                                <div class="col-md-offset-2 col-md-6 col-sm-10 ">
                                    <input type="submit" value="Save" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>                        

                <?php
                    }else{

                            echo "<div class='container'>";

                            $theMsg =  "<div class='alert alert-danger id'>there is no id</div>";

                            redirectHome($theMsg , 'dashboard.php'); 
                            

                            echo "</div>";
                    }

                

          }elseif($do == 'Update'){

                    echo ' <h1 class="text-center titletop">Update categorys</h1>  ';
                    echo '<div class="container">';
                    
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        

                        $id        = $_POST['catid']       ;
                        $name      = $_POST['Name']        ;
                        $desc      = $_POST['description'] ;
                        $order     = $_POST['Ordering']    ;
                        $parent    = $_POST['parent'];
                        $visible   = $_POST['Visibality']  ;
                        $comments = $_POST['commenting']  ;
                        $adss     = $_POST['Ads']         ;

                    
                        // validate the user

                   

                        $stmt = $con->prepare("UPDATE
                                                     category
                                               SET
                                                     Name = ? ,
                                                      Description = ? ,
                                                      Ordering = ?,
                                                      parent = ? ,
                                                      Visibality = ?,
                                                      Allow_comment =? ,
                                                      Allow_Ads =?
                                               WHERE
                                                     ID = ? ");
                        $stmt->execute(array($name, $desc, $order,$parent, $visible, $comments ,$adss ,$id));

                        $theMsg =  "<div class='alert alert-succses'> " . $stmt->rowCount() . "</div>" ;

                        redirectHome($theMsg , 'back');
                        

                }else{

                    echo "<div class='container'>";

                    $theMsg = "<div class='alert alert-danger'>sorry you cant Browse this page </div> ";

                    redirectHome($theMsg);



                    echo "</div>";
                }
                echo "</div>";
        

          }elseif($do == 'delete'){

                    echo ' <h1 class="text-center titletop">delete category</h1>  ';
                    echo '<div class="container">';

                        //checked if get request userid is numiric $ get the integer value of it

                        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

                        // selectAll Data Depend on this Id

                        $stmt = $con->prepare("SELECT *  FROM    category    WHERE    ID = ?  LIMIT 1");
                        
                        
                        //Execute query

                        $stmt->execute(array($catid));


                        //the row count

                        $count = $stmt->rowCount();

                        //if there's fetch id

                        if($stmt->rowCount()>0){

                            $stmt = $con->prepare('DELETE FROM category WHERE ID = :zuser ');

                            $stmt->bindParam(":zuser",$catid);

                            $stmt->execute();

                            $theMsg = '<div class="alert alert-success">you are delete this members</div>';

                            redirectHome($theMsg , 'back');
                        }else{
                            $theMsg =  '<div class="alert alert-danger">sorry , you cant delete this category please try agein</div>';           
                            
                            redirectHome($theMsg , 'back');
                        }

          }
          include $tpl . 'footer.php' ;

      }else{
          header ('Location: index.php') ;
      }

      ob_end_flush();

?>
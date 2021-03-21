<?php 
ob_start();
      session_start();
      $pageTitle="Creat New Item" ;

      include 'include/languages/en.php';
      include 'include/template/header.php';
      include 'int.php';

      if(isset($_SESSION['user'])){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $formerror = array();


            $itemeImagrName = $_FILES['item-image']['name'];
            $itemeImagrSize = $_FILES['item-image']['size'];
            $itemeImagrTmp  = $_FILES['item-image']['tmp_name'];
            $itemeImagrType = $_FILES['item-image']['type'];


            $itemAllowedExtension = array("jpge", "jpg" ,"png" ,"gif");

            @$itemExtention = strtolower(end(explode('.', $itemeImagrName)));            
            

            $name     = filter_var($_POST['Name'],FILTER_SANITIZE_STRING);
            $desc     = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $price    = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country  = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $status   = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
            $cat      = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);


            if(strlen($name) < 4){

                $formerror[] = ' Item title must be more 4 char' ;

            }

            if(strlen($desc) < 10 ){

                $formerror[] = ' Item description must be more 10 char' ;
                
            }

            if(strlen($desc) > 30 ){

                $formerror[] = ' Item description must be less 30 char' ;
                
            }

            if(strlen($country) < 2){

                $formerror[] = ' Item country must be more 2 char' ;
                
            }
            if(empty($price)){

                $formerror[] = ' Item price must be not empty' ;
                
            }

            if(empty($status)){

                $formerror[] = ' Item price must be not empty' ;
                
            }
            if(empty($cat)){

                $formerror[] = ' Item price must be not empty' ;
                
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



            if(empty($formError)){

                $itmImg = rand(0 , 100000000) . '_' . $itemeImagrName;

                move_uploaded_file($itemeImagrTmp ,"Admin\uploads\items\\" . $itmImg );

                $stmt = $con->prepare("INSERT INTO 
                                                items(Name,	Description,Price,Country_made,image,	Status,Add_date ,Cat_id,Membor_id)
                                       VALUES  (:zname,:zdesc, :zprice, :zcountry,:zimage, :zstatus, now(),:zcat,:zmember)");
                
                $stmt->execute(array(
                    'zname'     => $name,
                    'zdesc'     => $desc,
                    'zprice'    => $price,
                    'zcountry'  => $country,
                    ':zimage'   => $itmImg,
                    'zstatus'   => $status ,
                    'zcat'      => $cat,
                    'zmember'   => $_SESSION['uid'] 
                    
                ));

                if($stmt){

                $successMsg =  "<div class='alert alert-success'>" . "Item Add" .  "</div>";

                }
            }
        }
?>
      <h1 class="text-center"><?php echo $pageTitle ?></h1>
       <div class="create-ad block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading"><?php echo $pageTitle ; ?></div>
                         <div class="panel-body">
                              <div class="row">
                                    <div class="col-md-8">
                                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Name</label>
                                            <div class="col-md-9 col-sm-10 ">
                                                <input type="text"
                                                        name="Name"
                                                        class="form-control live-name"
                                                        autocomplete="off"
                                                        required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Description</label>
                                            <div class="col-md-9 col-sm-10 ">
                                                <input type="text" 
                                                        name="description" 
                                                        class="form-control live-desc"
                                                        autocomplete="off" 
                                                        required >
                                            </div>
                                        </div>

                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Price</label>
                                            <div class="col-md-9 col-sm-10 ">
                                                <input type="text" 
                                                        name="price" 
                                                        class="form-control live-price"
                                                        autocomplete="off" 
                                                        required >
                                            </div>
                                        </div>

                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">country</label>
                                            <div class="col-md-9 col-sm-10 ">
                                                <input type="text" 
                                                        name="country" 
                                                        class="form-control"
                                                        autocomplete="off" 
                                                        required >
                                            </div>
                                        </div>

                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">image</label>
                                            <div class="col-md-9 col-sm-10 ">
                                                <input type="file" 
                                                        name="item-image" 
                                                        class="form-control"  >
                                            </div>
                                        </div>                                       

                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">ststus</label>
                                            <div class="col-md-9 col-sm-10 ">
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
                                            <label class="col-sm-3 control-label">category</label>
                                            <div class="col-md-9 col-sm-10 ">
                                                <select class="form-control" name="category">
                                                        <option value="0">...</option>
                                                        <?php 
                                                        $cats =getAllFrom('category','ID');
                                                        foreach ($cats as $cat){
                                                            echo "<option value='". $cat['id'] . "'>" . $cat['Name'] . "</option>" ;
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
                                        <!--start looping through error-->
                                        <?php
                                                if(! empty($formerror)){
                                                    foreach($formerror as $error){
                                                        echo '<div class="alert alert-danger"> '. $error  . '</div>';
                                                    }
                                                }
                                                if(isset($successMsg)){
                                                    echo $successMsg ;
                                                }
                                        ?>
                                        <!--end looping through error-->
                                    </form>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="thumbnail item-box live-preview">
                                            <span class="price">$0</span>
                                            <img src="IMG_20200314_011336_034.jpg" alt="" />
                                            <div class="caption">
                                                <h3>Title</h3>
                                                <p>Description</p>
                                            </div>
                                        </div>
                                   </div>
                               </div>
                           </div>
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
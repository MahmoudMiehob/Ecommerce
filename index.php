<?php 
    ob_start();
    session_start();
    $pageTitle="Homepage" ;

      include 'include/languages/en.php';
      include 'include/template/header.php';
      include 'int.php';?>

<!--start header-->

     <div id="myCarousel" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>
          <!-- Wrapper for slides -->
          <div class="carousel-inner carousel-edit">
              <div class="item active">
                  <img src="image/ecommerce4.jpg" width="100%" height="400px" alt="Los Angeles">
              </div>
              <div class="item">
                  <img src="image/ecommerce2.jpg" width="100%" height="400px" alt="Chicago">
              </div>
              <div class="item">
                  <img src="image/ecommerce.jpg" width="100%" height="400px" alt="New York">
              </div>
          </div>

          <!-- Left and right controls -->
          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
          </a>
     </div>

<!--end header-->

<!--start plog-->
     <div class="font-Ausom">
      <div class="container text-center">
        <div class="row">

          <div class="col-md-3 main-icon-edit one">
            <div class="icon-edit"><i class="fa fa-phone-square fa-5x" aria-hidden="true"></i></i></div>
            <p class="lead"><a href="#contact-as">contact as</a></p>
          </div>
          
          <div class="col-md-3 main-icon-edit">
            <div class="icon-edit"><i class="fa fa-th fa-5x" aria-hidden="true"></i></div>
            <p class="lead"><a href="#item">items</a></p>
          </div>

          <div class="col-md-3 main-icon-edit one">
            <div class="icon-edit"><i class="fa fa-list-alt fa-5x" aria-hidden="true"></i></div>
            <p class="lead"><a href="categories.php">category</a></p>
          </div>

          <div class="col-md-3 main-icon-edit">
            <div class="icon-edit"><i class="fa fa-cog fa-5x" aria-hidden="true"></i></div>
            <p class="lead"><a href="Admin/index.php">Accessories</a></p>
          </div>

        </div>
      </div>
    </div>

<!--end blog-->

<!--start clients-->
          <div class="header-Adress">
             <h2 class="text-center caty-show">last clients</h2>
          </div>
          <div class="container">
              <div class="row">
              <?php $ourclients = getAllFrom('users','UserID');
                      foreach($ourclients as $client){
              ?>
                <div class="col-sm-6 col-md-3">
                  <div class="thumbnail text-center">
                    <div class="caption">
                      <img class="img-circle" src="Admin/uploads/avatar/<?php echo $client['avatar']; ?>" alt="avatar" width="140px" height="140px"/>
                      <h2><?php echo $client['Username']; ?></h2> 
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
           </div>


<!--end clients-->
<!--start category-->
          <div class="header-Adress">
              <h2 class="text-center caty-show">our category</h2>
          </div>
          <div class="container">
              <div class="row">
              <?php $ourcategory = getAllFrom('category','id');
                      foreach($ourcategory as $category){
              ?>
                <div class="col-sm-6 col-md-4">
                  <div class="thumbnail text-center cat-info">
                    <div class="caption">
                      <?php                    
                      echo
                       '<h2>
                            <a href="categories.php?pageid=' . $category['id'] .'">
                            ' . $category['Name'] . '
                            </a>
                        </h2>';?>
                    
                    
                      <p class="text-left lead"><?php echo $category['Description']; ?></p>  
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
           </div>

<!--end category-->
<!--start items-->

          <div id="item" class="header-Adress">
              <h2 class="text-center caty-show">our items</h2>
          </div>
          <div class="row">
            <?php  
                $allAds = getAllFrom('items','item_id', 'where Approve = 1');
                foreach($allAds as $item){
                    echo '<div class="col-sm-6 col-md-3">';
                       echo '<div class="thumbnail item-box">';
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
                ?>
            </div>
            <div class="row show">
              <div class="btn form-control show-All"><a href="All_items.php">Show All items</a></div>
            </div>
<!--ent items-->
<!--start contact-->
              <div class="container">
                  <div class="row">
                          <div class="card">
                              <div class="card-title">
                                  <div id="item" class="header-Adress">
                                  <h2 class="text-center shows py-2"> contact as </h2>
                                  <hr>
                                  </div>
                              </div>
                              <div class="card-body">
                                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">   
                                      <input type="text" name="Uname" placeholder="full name" class="form-control mb-2">
                                      <input type="email" name="email" placeholder="Email" class="form-control mb-2">
                                      <input type="text" name="subject" placeholder="Subject" class="form-control mb-2">
                                      <textarea name="msg" placeholder="the message" class="form-control"></textarea>
                                      <button class="btn btn-success form-control" name="btn-send">send</button>
                                
                                      <?php

                                      if(isset($_POST['btn-send'])){

                                        $username = filter_var($_POST['Uname'],FILTER_SANITIZE_STRING);
                                        $mail = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
                                        $subjects = filter_var($_POST['subject'],FILTER_SANITIZE_STRING);
                                        $msg = filter_var($_POST['msg'],FILTER_SANITIZE_STRING);

                                        if(empty($username) || empty($mail) || empty($subjects) || empty($msg)){
                                          echo '<p class="lead alert alert-danger form-control text-center error-email">sorry , you must be complete All input</p>';
                                        }
                                        else{
                                          $to = "mahmoudmiehob@gmail.com";
                                          $header = "From: ".$mail;
                                          $subject = "Contact From" . $subjects ;
                                          $txt = "You have received an e-mail from ".$username.".\n\n".$msg;

                                          mail($to, $subject, $txt, $header);
                                          header('Location: index.php?mailsend');
                                         
                                        }
                                      }

                                      ?>
                                    </form>
                            </div>
                       </div>
                  </div>
              </div>
<!--end contact as-->
<!--start footer-->

            <div class="footer-index text-center">
                  <div class="col-md-4">
                     <h2 id="contact-as" class="footer-h">contact Me</h2>
                     <div class="back-footer">
                        <p class="lead">got Qustion ? call as</p>
                        <span class="footer-num">+963993856679</span>
                        <p class="lead">social media</p>
                        <a href="https://www.facebook.com/profile.php?id=100010194910703" target="blank"><i class='fab fa-facebook' style='font-size:36px'></i></a>
                        <a href="https://github.com/MahmoudMiehob" target="blank"><i class='fab fa-github' style='font-size:36px'></i></a>
                        <a href="https://www.instagram.com/mahmoudmiyhob/" target="blank"><i class='fab fa-instagram' style='font-size:36px'></i></a>
                        <a href="https://www.linkedin.com/in/mahmoud-miehob-937064187" target="blank"><i class='fab fa-linkedin' style='font-size:36px'></i></a>
                     </div>
                     </div>
                  
                  <div class="col-md-4">
                    <h2 class="footer-h">our category</h2>
                      <div class="back-footer">
                          <?php
                            $ourcategory = getAllFrom('category','id');
                            echo '<ul>';
                            foreach($ourcategory as $caty){
                                echo '<li><p class="lead text-left">' . $caty['Name'] . '</p></li>';
                            }
                            echo '</ul>';         
                          ?> 
                    </div>
                  </div>
                  <div class="col-md-4">
                     <h2 class="footer-h">last update</h2>
                     <div class="back-footer">
                        <p class="lead last-update"><?php echo '18/3/2021'; ?></p>
                     </div> 
                  </div>

            </div>
              </div>
<!--end footer-->
<?php
      include $tpl . 'footer.php';
      ob_end_flush();
?>
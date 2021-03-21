<?php 
    ob_start();
    session_start();
    $pageTitle="Homepage" ;

      include 'include/languages/en.php';
      include 'include/template/header.php';
      include 'int.php';?>

<!--start items-->
        <div class="container">
          <div class="row">
            <?php  
                $allAds = gitAllForm('*','items','where Approve = 1','','item_id');
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
          </div>

<!--ent items-->
<?php
      include $tpl . 'footer.php';
      ob_end_flush();
?>
<?php 
      ob_start();
      session_start();
      include 'include/languages/en.php';
      include 'include/template/header.php';
      include 'int.php';
      
?>

        <div class="container">
            <h1 class="text-center">Category</h1>
            <div class="row">
            <?php  
                if(isset($_GET['pageid'])){
                $items = getItems('Cat_id',$_GET['pageid']) ;
                
                foreach($items as $item){
                    echo '<div class="col-sm-6 col-md-3">';
                       echo '<div class="thumbnail item-box">';
                       echo '<span class="price">' . $item['Price'] . '</span>';
                           echo '<img src="IMG_20200314_011336_034.jpg" alt="" />';
                           echo '<div class="caption">';
                                echo '<h3><a href="items.php?itemid=' . $item['item_id'] .'">' . $item['Name'] . '</a></h3>';
                                echo '<p>' . $item['Description'] . '</p>';
                                echo '<div class="date">' . $item['Add_date'] . '</div>';
                           echo '</div>';
                       echo '</div>';
                    echo '</div>';
                }
            }else{
                
                $allcat = gitAllForm('*' , "category" , "where parent = 0" , "", "id" ,"ASC");
                 foreach($allcat as $cates){
                    echo '<div class="col-sm-6 col-md-3">';
                    echo '<div class="thumbnail category-box">';
                        echo '<div class="caption">';
                             echo '<h3><a href="categories.php?pageid=' . $cates['id'] .'">' . $cates['Name'] . '</a></h3>';
                             echo '<p>' . $cates['Description'] . '</p>';
                        echo '</div>';
                    echo '</div>';
                 echo '</div>';
                 }
            
            }
                ?>
            </div>
        </div>

<?php
      include $tpl . 'footer.php';

      ob_end_flush();

?>
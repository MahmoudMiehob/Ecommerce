<?php 
      ob_start();
      session_start();
      $noNavbar = '';
      $pageTitle="login" ;

     
      if(isset($_SESSION['Username'])){
            header('Location: dashboard.php');
      }    
            
      include 'int.php';
      include 'include/languages/en.php';
      include $tpl . 'header.php';  
?>

      <?php
       if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $hashedPass = sha1($password);

            $stmt = $con->prepare("SELECT
                                          UserID,Username,Password 
                                    FROM
                                           users
                                    WHERE
                                           Username = ? 
                                    And 
                                           Password = ?
                                    And 
                                           GroupID = 1
                                    LIMIT 1");

            $stmt->execute(array($username, $hashedPass));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if($count>0){
              $_SESSION['Username']=$username;
              $_SESSION['ID']      =$row['UserID'];
              header('Location: dashboard.php');
              exit();
            }

       }
      ?>
      
      <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <h4 class="text-center title-login">Admin login</h4>
            <input class="form-control" type="text" name="user" placeholder="username"  autocomplete="off" />
            <input class="form-control" type="password" name="pass" placeholder="password" autocomplate="new-password" />
            <input class="btn btn-primary btn-block" type="submit" value="login" />
      </form>


<?php
      include $tpl . 'footer.php';
      ob_end_flush();
?>
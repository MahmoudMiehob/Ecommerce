<?php
    ob_start();
    session_start();
    $pageTitle="login" ;

    if(isset($_SESSION['user'])){
        header('Location: login.php');
   }  

      include 'include/languages/en.php';
      include 'include/template/header.php';
      include 'int.php';

      if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['login'])){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $hashedPass = sha1($pass);


        $stmt = $con->prepare("SELECT
                                     UserID, Username,Password 
                                FROM
                                       users
                                WHERE
                                       Username = ? 
                                And 
                                       Password = ?
                                ");

        $stmt->execute(array($user, $hashedPass));

        $get = $stmt->fetch();

        $count = $stmt->rowCount();

        if($count>0){
          $_SESSION['user']=$user;

          $_SESSION['uid'] = $get['UserID'];

          print_r($_SESSION);

          header('Location: index.php');

          exit();
        }
     }else{
         $formerror = array();


         $avatarName = $_FILES['avatar']['name']       ;
         $avatarSize = $_FILES['avatar']['size']       ;
         $avatarTemp = $_FILES['avatar']['tmp_name']   ;
         $avatarType = $_FILES['avatar']['type']       ;

         $avatarAllowedExtension = array("jpge", "jpg" ,"png" ,"gif");

         @$avatarExtention = strtolower(end(explode('.', $avatarName)));




         $username = $_POST['username'];
         $fullname = $_POST['fullname'];
         $password = $_POST['password'];
         $password2 = $_POST['password-again'];
         $email =$_POST['email'];


         if(isset($username)){
             $filteruser = filter_var($username, FILTER_SANITIZE_STRING) ;

             if(strlen($filteruser) < 4){
                 $formerror[] = 'username can\'t be  less 4 characters';
             }
         }


         if(isset($fullname)){
            $filteruser = filter_var($fullname, FILTER_SANITIZE_STRING) ;

            if(strlen($filteruser) < 4){
                $formerror[] = 'fullname can\'t be  less 4 characters';
            }
        }

         if(isset($password) && isset($password2)){
            
            if(empty($password)){
                $formerror[] = 'sorry password can\'t be empty ' ;
            }

            $pass1 = sha1($password) ;
            $pass2 = sha1($password2) ;

            if(sha1($password) !== sha1($password2)){

                $formerror[] = 'sorry password is not match' ;
                
            }
        } 

        if(isset($email)){
            $filteremail = filter_var($email, FILTER_SANITIZE_EMAIL) ;

            if(filter_var($filteremail , FILTER_VALIDATE_EMAIL) != true){
                $formerror[] = 'this email is not valid' ; 
            }
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

        // check if user exist in database

        if(empty($formError)){

            $avatar = rand(0 , 100000000) . '_' . $avatarName;

            move_uploaded_file($avatarTemp ,"Admin/uploads/avatar/" . $avatar );



            $check = checkitem ("Username", "users" , $username);

            if($check == 1){

                echo "<div class='container'>";

                $formerror[] = 'sorry this user is exist' ;

                echo "</div>";

            }else{

                        $stmt = $con->prepare("INSERT INTO 
                                                        users(Username,Fullname,Password,Email,Regstatus, Date , avatar)
                                                        VALUES(:zuser,:zfullname, :zpass, :zmail, 0, now() , :zavatar)");
                        
                        $stmt->execute(array(
                            'zuser'       => $username,
                            'zfullname'  => $fullname,
                            'zpass'       => sha1($password),
                            'zmail'       => $email,
                            'zavatar'     => $avatar
                           
                        ));

                        $succesMsg = "<div class='alert alert-success'>" . "success login" .  "</div>";

        }
    }

     }
   }
?>

    <div class="container login-page">
        <h1 class="text-center"><span class="selected" data-class="login">Login</span> |
         <span data-class="signup">Signup</span></h1>
         <!--start login -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <input
             class="form-control"
              type="text" name="username"
               autocomplete="off"
               required
                placeholder="Type your username" />

            <input
             class="form-control"
              type="password"
               name="password"
                autocomplete="new-password"
                 placeholder="Type Your password" />

            <input
             class="btn btn-primary btn-block"
              type="submit"
               value="login"
                name="login"
                 placeholder="username" />
        </form>

        <!--end login -->
        <!--start siginup -->
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <input
             class="form-control"
              type="text" name="username"
               autocomplete="off"
                placeholder="Type your name" />

            <input
             class="form-control"
              type="text" name="fullname"
               autocomplete="off"
                placeholder="Type your fullname" />

            <input
             class="form-control"
              type="password"
               name="password"
                autocomplete="new-password"
                 placeholder="Type a complex password" />

            <input
             class="form-control"
              type="password"
               name="password-again"
                autocomplete="new-password"
                 placeholder="Type a password again" />

            <input
             class="form-control"
              type="Email"
               name="email"
                 placeholder="Type a valid Email" />

            <input
             class="form-control"
              type="file"
               name="avatar"
                placeholder="Choose your photo"
                 value="Choose your photo">

            <input
             class="btn btn-success btn-block"
              type="submit"
               value="Signup"
                name="signup"
                 placeholder="username" />
        </form>
        <!--end siginup -->
        <div class="the-error text-center">
                <?php 
                        if(! empty($formerror)){
                            foreach ($formerror as $error){
                               echo '<p class="alert alert-danger ">' . $error . '<hr>' ;
                            }
                        }
                        if(isset($succesMsg)){

                            echo $succesMsg ;  
                      }
                ?>
        </div>
    </div>

<?php
      include $tpl . 'footer.php';
      ob_end_flush();
?>
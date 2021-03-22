<?php include 'int.php';
      include 'include/function/function.php';
       ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <link rel="stylesheet" href= "<?php echo $css ; ?>frrrr.css" >
    </head>
    <body>
    <div class="upper-bar">
        <div class="container">
        <?php
           if(isset($_SESSION['user'])){ ?>

           
           <div class="btn-group my-info text-right">
                    <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <?php echo $sessionUser ?>
                        <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">my profile</a></li>
                        <li><a href="newad.php">new Item</a></li>
                        <li><a href="profile.php#my-Ads">My Item</a></li>
                        <li><a href="profile.php#my-comment">My Comments</a></li>
                        <li><a href="logout.php">logout</a></li>
                    </ul>
           </div>

              <?php
               
           }else{
        ?>
            <a href="login.php">
                <span class="pull-right">Login/Singup</span>
            </a>
           <?php } ?>
        </div>
    </div>
    <nav class="navbar navbar-inverse nav-edit">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <div class="collapse navbar-collapse " id="app-nav">
            <ul  class="nav navbar-nav navbar-right">
            <?php
               $allcat = gitAllForm('*' , "category" , "where parent = 0" , "", "id" ,"ASC");
                foreach($allcat as $cat){
                    echo
                       '<li>
                            <a href="categories.php?pageid=' . $cat['id'] .'">
                            ' . $cat['Name'] . '
                            </a>
                        </li>';
                }
            ?>
            </ul>

            </div>
    </nav>    

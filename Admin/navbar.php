
<nav class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#app-nav">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('home-Admin') ?></a>
    </div>
    <div class="collapse navbar-collapse " id="app-nav">
      <ul  class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('GAEGORIES')  ?></a></li>
        <li><a href="items.php"><?php echo lang('ITEMS')  ?></a></li>
        <li><a href="members.php?do=Manage&UserID=<?php echo $_SESSION['ID'] ?>"><?php echo lang('MEMBERS')  ?></a></li>
        <li><a href="comment.php"><?php echo lang('COMMENTS')  ?></a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right"> 
        <li class="dropdown">
          <a href="#" class="dropdown-toggle users" data-toggle="dropdown">mahmoud <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="../index.php">Visit shop</a></li>
            <li><a href="members.php?do=Edit&UserID=<?php echo $_SESSION['ID'] ?>">Edit profile</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>


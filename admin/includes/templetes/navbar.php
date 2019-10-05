<div id="container">


  <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
     <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
     
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link" href="dashboard.php"><?php echo lang('HOME_Admin') ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><?php echo lang('categories'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="item.php"><?php echo lang('Items'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php"><?php echo lang('Members'); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comment.php"><?php echo lang('Comments'); ?></a>
        </li>
       


      </ul>

       <ul class="nav navbar-nav navbar-right ">
       <li class="nav-item dropdown ">
         <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      mahmoud
    </button>
          <div class="dropdown-menu lin " aria-labelledby="navbarDropdown">
            <a class="dropdown-item text-white " href="../index.php" target="_blank"> Visit Shop</a>
            <a class="dropdown-item text-white " href="members.php?do=edit&userid=<?php echo $_SESSION['ID']; //to edit member belong to his id will go to page ?>">Edit Profile</a>
            <a class="dropdown-item text-white " href="#">Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-white " href="logout.php">logout</a>
          </div>
        </li>
      </ul>
    


     </div>

    </div>
  </div>

  </nav>






























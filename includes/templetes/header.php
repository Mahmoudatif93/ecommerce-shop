
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?PHP echo getTitle() ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
	     <!-- fontawesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900,900i" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo $css;?>jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $css;?>jquery.selectBoxIt.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $css;?>front.css">
</head>
<body>

  <!--/////////////////////navbar page for front END////////////////////// -->
    
     <div class="upper-bar navbar-light" style="background-color:#021b27;">
        <div class="container ">
          <?php 
     
             if(isset($_SESSION['user'])){?>
             <div class="btn-group my-info">
              <img class=" img-thumbnail img-circle " src="images.jpg" alt="" />&nbsp;
                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                  <?php echo $_SESSION['user'] ; ?>
                   </button>
                  <ul class="dropdown-menu lin">
                    <li><a href="profile.php"class="dropdown-item text-white profile-menue" >my profile</a></li>
                    <li><a href="newad.php" class="dropdown-item text-white">New Item</a></li>
                     <li><a href="profile.php#my-ads" class="dropdown-item text-white">My Items</a></li>
                    <li><a href="logout.php" class="dropdown-item text-white">Logout</a></li>

                  </ul>
                
               
              </div>
            
  


          <?php
             

            }else{
              ?>

          
          <a href="login.php" target='_blank'>
            <span class="pull-right">Login/Signup</span>
          </a>
        <?php }?>
        </div>  
      </div>
   <!-- //////////////main menue////// -->
   <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
       <div class="container col-lg-6">
           <div class="navbar-header">
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
               
            </div>
            <div class=" nav collapse navbar-collapse" id="app-nav">
               <ul class="navbar-nav mr-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="index.php"><?php echo lang('HOME_Admin') ?></a>
                 </li>
               </ul>
           </div>

           <div class=" nav collapse navbar-collapse" id="app-nav">
               <ul class="nav navbar-nav navbar-right ">
                 <?php 
                 $getall=getAllItems("*","categories","where parent=0","","ID","ASC");
                   foreach ($getall as $cat) {
                     echo '<li class="nav-item"> <a class="nav-link" href="categories.php?pageid='.$cat['ID'].'"> ' . $cat['Name'] . '</a></li>' ;}
                   ?>
                 </ul>
            </div>
         </div>
  </nav>

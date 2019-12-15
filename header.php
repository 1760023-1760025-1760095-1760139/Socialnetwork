<?php 
  require_once 'init.php';
  require_once 'functions.php';
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link REL="SHORTCUT ICON" HREF="./image/logo.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css"/>
    <link rel="stylesheet" href="css/header.css"/>
    <!-- <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css"/> -->
   
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $currentUser ? getPageTitle($page, $user['id']) : getPageTitle($page, -1); ?></title>

</head>
<body>
<div style="margin-bottom: 70px;">
  <nav class="navbar navbar-expand-md navbar-white fixed-top bg-white">
      <div class="page-logo">
        <a class="navbar-brand" id="logo-branch" href="index.php">
          <i class="fa fa-instagram" id="logo-icon" aria-hidden="true"></i>
          <span id="branch-name">PEACE<span>
        </a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="header-middle">
        <form class="form-inline" method="POST">
          <div class="search-box">
            <input class="form-control mr-sm-2" type="search"name="search-friend-box" placeholder="Tìm kiếm" aria-label="Search" Required>
            <button class="btn btn-outline-success my-2 my-sm-0" name="search-btn" hidden  type="submit">Tìm kiếm</button>
          </div>
        </form>
      </div>
      
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto" id="menu-nav">
          <?php if(!$currentUser): ?>
          <li class="nav-item <?php echo $page == 'index' ? 'active' : '' ?>">
            <a class="nav-link <?php echo $page == 'index' ? 'active' : '' ?>" style="color:black ;font-weight:bold" href="index.php">Trang chủ<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item <?php echo $page == 'login' ? 'active' : '' ?>">
            <a class="nav-link" style="color:black ;font-weight:bold" href="login.php">Đăng nhập</a>
          </li>
          <li  class="nav-item <?php echo $page == 'register' ? 'active' : '' ?>">
            <a class="nav-link" style="color:black ;font-weight:bold" href="register.php">Đăng ký</a>
          </li>
          <li class="nav-item <?php echo $page == 'forgot-password' ? 'active' : '' ?>">
            <a class="nav-link" style="color:black ;font-weight:bold" href="forgot-password.php">Quên mật khẩu</a>
          </li>
          <?php else: ?>
          <li class="nav-item active">
            <!-- <a class="nav-link" href="personal.php"><img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $currentID;?>.jpg">  <?php echo $currentUser['username'] ?><span class="sr-only">(current)</span></a> -->
            <a class="nav-link" title="Trang cá nhân" href="personal.php"><i class="fa fa-user-o" aria-hidden="true"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" title="Tin nhắn" style="color:black ;font-weight:bold" href="messenger.php"><i class="fa fa-commenting-o" aria-hidden="true"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" title="Đăng xuất" style="color:black ;font-weight:bold" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
          </li>
          <?php endif;?> 
        </ul>
        
      </div>
    </nav>

    <?php
      if(isset($_POST['search-btn']))
      {
         header('Location: result-search.php?name='.$_POST['search-friend-box']);
         exit();
      }
    ?>
</div>
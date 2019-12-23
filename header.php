<?php 
  require_once 'init.php';
  require_once 'functions.php';
  if ($page === 'index')
  {
    $title = 'Trang chủ';
  }
  else if ($page === 'login')
  {
    $title = 'Đăng nhập';
  }
  else if ($page === 'register')
  {
    $title = 'Đăng ký';
  }
  else if ($page === 'personal')
  {
    $title = 'Trang cá nhân';
  }
  else if ($page === 'profile' || $page ==='listfriend')
  {
    $usernameProfile = findUserById($user['id']);
    $title = $usernameProfile['username'];
  }
  else if ($page === 'forgot-password')
  {
    $title = 'Quên mật khẩu';
  }
  else if ($page === 'reset-password')
  {
    $title = 'Đổi mật khẩu';
  }
  else if ($page === 'search-friend')
  {
    $title='Tìm kiếm';
  }
  else if($page ==='verify-email')
  {
    $title ='Xác thực tài khoản';
  }
  else if ($page='result')
  {
    $title= 'Kết quả tìm kiếm';
  }
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>

</head>
<body>
<div style="margin-bottom: 70px;">
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="index.php">NINETEEN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            
            <?php if(!$currentUser): ?>
            <li class="nav-item <?php echo $page == 'index' ? 'active' : '' ?>">
              <a class="nav-link <?php echo $page == 'index' ? 'active' : '' ?>" href="index.php">Trang chủ<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php echo $page == 'login' ? 'active' : '' ?>">
              <a class="nav-link" href="login.php">Đăng nhập</a>
            </li>
            <li class="nav-item <?php echo $page == 'register' ? 'active' : '' ?>">
              <a class="nav-link" href="register.php">Đăng ký</a>
            </li>
            <li class="nav-item <?php echo $page == 'forgot-password' ? 'active' : '' ?>">
              <a class="nav-link" href="forgot-password.php">Quên mật khẩu</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
            <li class="nav-item active">
              <a class="nav-link" href="personal.php"><img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $currentID;?>.jpg">  <?php echo $currentUser['username'] ?><span class="sr-only">(current)</span></a>
            </li>
              <a class="nav-link" href="logout.php">Đăng xuất</a>
            </li>
            <?php endif;?> 
          </ul>
          <form class="form-inline" method="POST">
            <input class="form-control mr-sm-2" type="search" name="search-friend-box" placeholder="Tìm kiếm bạn bè..." aria-label="Search" Required>
            <button class="btn btn-outline-success my-2 my-sm-0" name="search-btn"  type="submit">Tìm kiếm</button>
          </form>
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
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css"/>
    <link rel="stylesheet" href="css/header.css"/>
    <link rel="stylesheet" href="css/post.css"/>
    <?php if(!$currentUser): ?>
        <link rel="stylesheet" href="css/index.css"/>
        <?php if($page == 'login'): ?>
            <link rel="stylesheet" href="css/login-page.css"/>
        <?php elseif($page == 'register'): ?>
            <link rel="stylesheet" href="css/register-page.css"/>
        <?php elseif($page == 'forgot-password'): ?>
            <link rel="stylesheet" href="css/forgot-password.css"/>
        <?php endif; ?>
    <?php else:?>
        <?php if($page == 'personal'): ?>
          <link rel="stylesheet" href="css/personal-page.css"/>
        <?php elseif($page == 'index'): ?>
          <link rel="stylesheet" href="css/index.css"/>
          <link rel="stylesheet" href="css/modal-upload-image.css"/>
        <?php elseif($page == 'messenger'): ?>
        <script async='async' src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-4529508631166774",
                enable_page_level_ads: true
            });
        </script>
        <title>Messenger</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
    <link rel="stylesheet" href="css/message.css"/>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
        <?php endif; ?>
    <?php endif; ?>

    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $currentUser ? getPageTitle($page, $user['id']) : getPageTitle($page, -1); ?></title>

</head>
<body>
<div class="nav-header">
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
          <?php else: ?>
          <?php
                $newMessage = fetch_user_notification($currentUser['id'], 1);
                $countNewMessage = count($newMessage);
                $notifications = fetch_user_notification($currentUser['id'], 2);
                $countNotification = count($notifications);
              ?>
          <li class="nav-item active">
            
            <a class="nav-link" title="Trang cá nhân" href="personal.php"><i class="fa fa-user-o" aria-hidden="true"></i></a>
          </li>
          <li class="nav-item" style="position: relative">
            <a class="nav-link" title="Tin nhắn" style="color:black ;font-weight:bold" href="messenger.php">
                <i class="fa fa-commenting-o" aria-hidden="true"></i>
                <?php if($countNewMessage != 0): ?>
                    <span class="badge"><?php echo $countNewMessage?></span>
                <?php endif; ?>
            </a>
          </li>
          <li class="nav-item" style="position: relative">
              <div class="dropdown">
                  <div class="nav-link" title="Thông báo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black ;font-weight:bold;" href="#">
                      <i class="fa fa-bell-o" aria-hidden="true"></i>
                      <?php if($countNotification != 0): ?>
                          <span class="badge"><?php echo $countNotification?></span>
                      <?php endif; ?>
                  </div>
                  <?php if($countNotification != 0): ?>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <?php foreach ($notifications as $noti ) : ?>
                            <div class="dropdown-menu-items" onclick="location.href='<?php echo $noti['collection_link'];?>';">
                                <div class="dropdown-menu-items-left">
                                    <img style="width: 40px;height: 40px; border-radius: 50%;" src="uploads/<?php echo $noti['creator'];?>.jpg">
                                </div>
                                <div class="dropdown-menu-items-right">
                                    <p class="noti-content"><?= $noti['content']?></p>
                                </div>

                            </div>
                          <?php endforeach; ?>
                      </div>
                  <?php endif; ?>
              </div>
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
          $keyword = strip_tags($_POST['search-friend-box']);
          header('Location: result-search.php?name='.$keyword);
          exit();
      }
    ?>
</div>
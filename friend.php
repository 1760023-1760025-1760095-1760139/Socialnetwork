<?php 
  require_once 'init.php';
  require_once 'functions.php';
  $page = 'friend';  
  $user = findUserById($_POST['id']);
  if(!$currentUser )
  {
    header('Location: index.php');
    exit();
  }
  if($currentUser['id']==$user['id'] ) 
  {
    header('Location: personal.php');
    exit();
  }
  $relationship = findRelationship($currentUser['id'], $user['id']);
  $isFriend = count($relationship) === 2;
  $isStranger = count($relationship) === 0;
  if(count($relationship) == 1)
  {
      $isRequesting = $relationship[0]['user1Id'] === $currentUser['id'];
  }

  if($_POST['action'] === 'Kết bạn' || $_POST['action'] === 'Đồng ý yêu cầu kết bạn')
  {
      addRelationship($currentUser['id'],$user['id']);
  }
  if($_POST['action'] === 'Hủy yêu cầu kết bạn' || $_POST['action'] === 'Xóa bạn bè')
  {
      removeRelationship($currentUser['id'],$user['id']);
  }
   header('Location: profile.php?id='.$user['id']);
    exit();
?>
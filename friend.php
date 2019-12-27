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
  if($currentUser['id'] == $user['id'] )
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
      $baseURL = explode("friend.php",getBaseUrl())[0];
      if(count($relationship) === 0)
      {
          addNotification(
              $user['id'],
              2,
              'addfriend',
              $currentUser['id'],
              $currentUser['username']. ' đã gửi cho bạn một lời mời kết bạn',
              $baseURL.'profile.php?id='.$currentUser['id']
              );
          sentEmail(
              $user['email'],
              $user['username'],
              'Loi moi ket ban moi',
              'Ban co loi moi ket ban tu <a href="'.$baseURL.'profile.php?id='.$currentUser['id'].'">'. $currentUser['username'].'</a>'
          );
      }
      else if (count($relationship) === 1)
      {
          addNotification(
              $user['id'],
              2,
              'addfriend',
              $currentUser['id'],
              $currentUser['username']. ' đã chập nhận lời mời kết bạn',
              $baseURL.'profile.php?id='.$currentUser['id']
          );
          removeNotification($currentUser['id'],2,'addfriend', $user['id']);

          sentEmail(
              $user['email'],
              $user['username'],
              $currentUser['username'].' da chap nhan loi moi ket ban',
              '<a href="'.$baseURL.'profile.php?id='.$currentUser['id'].'">'. $currentUser['username'].'</a> da chap nhan loi moi ket ban'
          );
      }

  }
  if($_POST['action'] === 'Hủy yêu cầu kết bạn' || $_POST['action'] === 'Xóa bạn bè')
  {
      removeRelationship($currentUser['id'],$user['id']);
      removeNotification($currentUser['id'],2,'addfriend', $user['id']);
      removeNotification($user['id'],2,'addfriend', $currentUser['id']);
  }

  header('Location: profile.php?id=' . $user['id']);
  exit();
?>
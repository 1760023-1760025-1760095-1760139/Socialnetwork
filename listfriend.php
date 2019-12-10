<?php 
  require_once 'init.php';
  require_once 'functions.php';
  $page = 'listfriend'; 
  $user = findUserById($_GET['id']);
  $mutualFriends = countMutualFriend($currentUser['id'],$user['id']);
  $friends = findAllFriend($user['id']);
  if(!$currentUser )
  {
    header('Location: index.php');
    exit();
  }
  if($currentUser['id']==$user['id']) 
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

?>
<!-- Body -->
<?php include 'header.php'; ?>
<!-- If user isn't found or $_GET['id'] is null, show page not found-->
<?php if(empty($user)):?>
 <div style="margin-top: 10%;">
      <div class="row">
          <div class="card" style="width: 80%; margin: 0 auto; text-align:center;">
               <div class="card-body">
               <h3>Lỗi</h3>
               <p>Trang mà bạn yêu cầu không tìm thấy!</p>
               </div>
          </div>
      </div>
  </div>  
<!-- Else show all user's friend -->  
<?php else:?>
    <div style="margin-top: 10%;">  
      <div class="card" style="width: 80%; margin: 0 auto; text-align:center;">
        <div class="card-body">
              <img style="width: 150px;height: 150px; border-radius: 50%;border: #003366 solid 5px;" src="uploads/<?php echo $user['id'] ;?>.jpg">
            <p><h4><?php echo $user['username']; ?></h4></p>
            <?php if($mutualFriends != 0): ?> 
            <p><?php echo $mutualFriends; ?> bạn chung</p>
            <?php endif;?>
            <form action = "friend.php" method ="POST">
            <input type="hidden" name="id" value= "<?php echo $user['id']; ?>"/>
            
            <?php if($isFriend): ?>
            <input type="submit" name="action" class="btn btn-danger" value= "Xóa bạn bè">
            <?php elseif($isStranger): ?>
                    <input type="submit" name="action" class="btn btn-primary" value= "Kết bạn">
            <?php else: ?>
                <?php if(!$isRequesting): ?>
                  <input type="submit" name="action" class="btn btn-success" value= "Đồng ý yêu cầu kết bạn">
                <?php endif; ?>  
                  <input type="submit" name="action" class="btn btn-warning" value= "Hủy yêu cầu kết bạn">
          
            <?php endif; ?>
            <a class="btn btn-primary" href="listfriend.php?id=<?php echo $user['id']; ?>" role="button">Danh sách bạn bè</a>
            </form>
        </div>
      </div>
    <!-- Show all user's friend -->
      <?php foreach ($friends as $friend ) : ?>
      <?php $friendInfo = findUserById($friend);?>
         <?php if($friendInfo['id'] != $currentUser['id']) :?>      
      <div class="card" style="width: 80%; margin: 0 auto; ">
        <div class="card-body">     
            <div class="row">
              <div class="col-1">
                <a href ="profile.php?id=<?php echo $friendInfo['id'];?>" >
                  <img style="width: 80px;height: 80px; border-radius: 50%;" src="uploads/<?php echo $friendInfo['id'];?>.jpg"> 
                </a>
              </div>
              <div class="col-11">
                <h5 class="text-left">
                  <a href ="profile.php?id=<?php echo $friendInfo['id'];?>" >
                  <?php echo $friendInfo['username']; ?>     
                  </a>
                  <?php if($friendInfo['id'] != $currentUser['id']) :?>  
                    <?php $mutualFriends = countMutualFriend($currentUser['id'],$friendInfo['id']); ?>
                    <?php if($mutualFriends !=0) :?>
                      <p class="text-secondary"><?php echo $mutualFriends;?> bạn chung</p>
                    <?php endif; ?>
                  <?php endif; ?>  
                </h5>
              </div>
            </div>
        </div>
      </div>  
<?php endif; ?>  
    <?php endforeach; ?>
    </div>      
<?php endif;?>
<?php include 'footer.php'; ?>
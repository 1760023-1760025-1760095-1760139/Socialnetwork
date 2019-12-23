<?php 
  require_once 'init.php';
  require_once 'functions.php';
  $page = 'profile'; 
  $user = findUserById($_GET['id']);
  $mutualFriends = countMutualFriend($currentUser['id'],$user['id']);
  
  if(!$currentUser )
  {
    header('Location: index.php');
    exit();
  }
  if($currentUser['id']==$user['id']||$_GET['id']=="") 
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
  
  $posts = findAllPostOfUserVisiting($user['id'],$isFriend);
?>



<?php include 'header.php'; ?>
<!-- If user isn't found, show page not found-->
<?php if(empty($user)):?>
 <div class="container" style="margin-top: 10%;">
      <div class="row">
          <div class="card" style="width: 80%; margin: 0 auto; text-align:center;">
               <div class="card-body">
               <h3>Lỗi</h3>
               <p>Trang mà bạn yêu cầu không tìm thấy!</p>
               </div>
          </div>
      </div>
  </div>  
<!-- Else show information and all posts with privacy are public and friend if they are friends of each other -->  
<?php else:?>
    <div class="container" style="margin-top: 10%;">  
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


      <!-- Hiển thị các post của user đang xem-->
      <?php foreach ($posts as $post ) : ?>
      <div class="card" style="width: 80%; margin: 0 auto; ">
        <div class="card-body">
          <h5>
          <a href ="profile.php?id=<?php echo $post['userId'];?>" >
          <img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $user['id'];?>.jpg">
          <?php echo $user['username']; ?>     
          </a>
         </h5>
          <h6 class="card-subtitle mb-2 text-muted" ><?php echo $post['createdAt']; ?></h6>
          <p class="card-text"><?php echo $post['content']; ?></p>
          <a href="#" class="card-link">Thích</a>
          <a href="#" class="card-link">Bình luận</a>
        </div>
      </div>    
    <?php endforeach; ?>
    </div>      
<?php endif;?>
<?php include 'footer.php'; ?>
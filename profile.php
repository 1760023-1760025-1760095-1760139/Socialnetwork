<?php 
  require_once 'init.php';
  require_once 'functions.php';
  
  require_once 'like_dislike.php';
  require_once 'comment.php';
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

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="script.js"></script>

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
          
          
           <div class ="post">
                  <div class="post-info">
                  <i <?php if (userLiked($post['id'])): ?>
                              class="fa fa-thumbs-up like-btn"
                            <?php else: ?>
                              class="fa fa-thumbs-o-up like-btn" 
                            <?php endif ?>
                            
                            data-id="<?php echo $post['id'] ?>"></i>
                          
                            <span class="likes"><?php   echo getLikes($post['id']); ?></span>
                          
                          &nbsp;&nbsp;&nbsp;&nbsp;

                        <!-- if user dislikes post, style button differently -->
                          <i 
                            <?php if (userDisliked($post['id'])): ?>
                              class="fa fa-thumbs-down dislike-btn"
                            <?php else: ?>
                              class="fa fa-thumbs-o-down dislike-btn"
                            <?php endif ?>
                            data-id="<?php echo $post['id'] ?>"></i>
                          <span class="dislikes"><?php echo getDislikes($post['id']); ?></span>
                  </div>
              </div>

                
                <form class="clearfix" action="index.php" method="post" 
                  id="comment_form_<?php echo $post['id'] ?>" data-id="<?php echo $post['id']; ?>"> 
                  <textarea name="comment_text" id="comment_text_<?php echo $post['id'] ?>" class="form-control" cols="30" rows="1"></textarea>
                  <button name="submit" class="btn btn-primary btn-sm pull-right" id="submit_comment"data-id="<?php echo $post['id']; ?>style:background:white">Bình luận</button>
                </form>
                <?php $comments=getAllCommentOfPost($post['id']);?>

                  <a><span id="comments_count_<?php echo $post['id'] ?>"><?php echo count($comments) ?></span> bình luận</a>
                  <hr>
                  
                  <div id="comments_wrapper_<?php echo $post['id']; ?>">
                    <?php if (isset($comments)): ?>
                    <!-- Display comments -->
                      <?php foreach ($comments as $comment): ?>
                      <!-- comment -->
                      <div class="comment clearfix">
                        <div class="comment-details">
                        <img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $comment['user_id'];?>.jpg">
                          <b><span class="comment-name"><?php echo findUserById($comment['user_id'])['username'] ?></span></b>
                          <span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
                          <p><?php echo $comment['body']; ?></p>
                          <a class="reply-btn"  href="#" data-id="<?php echo $comment['id']; ?>">reply</a>

                          </div>

                        <!-- reply form -->
                        <form style="display: none;" action="index.php" class="reply_form clearfix" id="comment_reply_form_<?php echo $comment['id'] ?>" data-id="<?php echo $comment['id']; ?>">
                          <textarea class="form-control" name="reply_text" id="reply_text" cols="30" rows="1"></textarea>
                          <button class="btn btn-primary btn-xs pull-right submit-reply">Viết phản hồi</button>

                        </form>

                        <!-- GET ALL REPLIES -->
                        <?php $replies = getAllRepliesOfComment($comment['id']) ?>
                        <div class="replies_wrapper_<?php echo $comment['id']; ?>">
                          <?php if (isset($replies)): ?>
                            <?php foreach ($replies as $reply): ?>
                              <!-- reply -->
                              <div class="comment reply clearfix">

                                <!-- <img src="profile.png" alt="" class="profile_pic"> -->
                                <div class="comment-details">

                                  <span class="comment-name"><b><?php echo findUserById($reply['user_id'])['username'] ?></b></span>
                                  <span class="comment-date"><?php echo date("F j, Y ", strtotime($reply["created_at"])); ?></span>
                                  <p style="margin-left: 40px;"><?php echo $reply['body']; ?></p>
                                </div>
                              </div>
                            <?php endforeach ?>
                          <?php endif ?>
                        </div>
                      </div>
                        <!-- // comment -->
                      <?php endforeach ?>
                    <?php else: ?>
                      <a>Hãy trở thành người đầu tiên bình luận về bài viết này</a>
                    <?php endif ?>
                  </div><!-- comments wrapper -->
                  </div><!-- // all comments -->
                        <!-- end comment3 -->
        </div>
      </div>    
    <?php endforeach; ?>
    </div>      
<?php endif;?>
<?php include 'footer.php'; ?>
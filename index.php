<?php
  require_once 'init.php';
  require_once 'functions.php';
  require_once 'like_dislike.php';
  require_once 'comment.php';

  $posts = findAllPostOfFriends($currentUser['id']);    
  $page = 'index';
  $privacy="1";

  if(isset($_POST['post']) )
  {
    if(empty($_POST['status'])==false )
    {
      $privacy = $_POST['Privacy-value'];
      switch($privacy)
      {
        case 'Mọi người': $privacyNum = 1;break; 
        case 'Bạn bè': $privacyNum = 2;break; 
        case 'Chỉ mình tôi': $privacyNum = 3;break; 
      }
      $content = $_POST['status'];
      $userId = $currentUser['id'];
      addPost($userId,$content,$privacyNum);
      header('Location: index.php');
      exit();
    }
  }

?>
<!-- add Jquery -->
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="script.js"></script>

<!-- styling -->


<?php include 'header.php';?>
<?php if(!$currentUser):?>
<div class="card" style="width: 80% ; margin: 0 auto;">
  <div class="card-body">
             <p style="font-weight:bold; font-size:20px; text-align:center; font-family:sans-serif; color:black;">Chào mừng đến với website. Vui lòng đăng nhập để tiếp tục</p>
             <div style="text-align: center;">
                <a class="btn btn-dark" href="login.php" role="button">Đăng nhập</a>
                <a class="btn btn-dark" href="register.php" role="button">Đăng ký</a>

            </div>
  </div>
</div>
<?php else:?>
    <div class="container" style="margin-top: 10%;">
      <div class="row">
        <div class="col-sm-2" style="text-align: center;">
          <img style="width: 100px;height: 100px; border-radius: 50%;border: #003366 solid 5px;" src="uploads/<?php echo $currentUser['id'] ;?>.jpg"><p style="font-weight:bold; font-size:20px; font-family:sans-serif;  color:black;"><?php echo $currentUser['username'];?></p>
        </div>
        <div class="col-sm-10">
            <form method="POST" style="margin-bottom: 20px;">
                <div class="form-group" >
                  <label for="status">Tạo bài viết</label>
                  <textarea class="form-control" rows="5" id="status" name ="status" placeholder="Bạn đang nghĩ gì?" Required></textarea>
                  <textarea style="display:none;" class="getDropdownValue" rows="1" name ="Privacy-value">Mọi người</textarea>
                </div>
                <div style="text-align: right;">
                  <div class="dropdown">
                   <form method="POST">
                    <button type="button" class="btn btn-info" name="post-image" id="post-image">Đăng ảnh</button>
                    <input type="file"  name="upload_image" id="upload_image" multiple style="display: none;">  
                      
                    <button class="btn btn-secondary dropdown-toggle" style="min-width: 150px;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    ><span class="privacy-value">Mọi người</span></button>
                    <button type="submit" class="btn btn-primary" name="post">Đăng</button>
                    <div class="dropdown-menu" id="dropdown-menu-index" type="submit"  aria-labelledby="dropdownMenuButton">
                      <li><a style="cursor: default;" class="dropdown-item">Mọi người</a></li>
                      <li><a style="cursor: default;" class="dropdown-item">Bạn bè</a></li>
                      <li><a style="cursor: default;" class="dropdown-item">Chỉ mình tôi</a></li>
                    </div>
                  </div>
                </div>
            </form>
        </div>
      </div>
    </div>    
</div>
    <?php foreach ($posts as $post ) : ?>
      <div class="card" style="width: 60%; margin: 0 auto; ">
        <div class="card-body">
          <?php $userPost = findUserById($post['userId']);?>
          <h5>
          <a href ="profile.php?id=<?php echo $post['userId'];?>" >
          <img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $userPost['id'];?>.jpg">
          <?php echo $userPost['username']; ?>
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
                  <button name="submit" class="btn btn-primary btn-sm pull-right" id="submit_comment"data-id="<?php echo $post['id']; ?>">Bình luận</button>
                </form>
                <?php $comments=getAllCommentOfPost($post['id']);?>

                  <a><span id="comments_count_<?php echo $post['id'] ?>"><?php echo count($comments) ?></span> bình luận</a>
                  <hr>
                  <!-- comments wrapper -->
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
                          <a class="reply-btn"  href="#" data-id="<?php echo $comment['id']; ?>">Viết phản hồi</a>

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
                      <a>Hãy trở thành người đầu tiên bình luận cho bài viết này</a>
                    <?php endif ?>
                  </div><!-- comments wrapper -->
                  </div><!-- // all comments -->
                        <!-- end comment3 -->
                

          
        </div>
      </div>
      <?php endforeach; ?>
<?php endif;?>

<?php include 'footer.php'; ?>
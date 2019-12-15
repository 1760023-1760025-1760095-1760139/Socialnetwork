<?php 
  require_once 'init.php';
  require_once 'functions.php';
  
  require_once 'like_dislike.php';
  require_once 'comment.php';
  $page = 'result';  
  $name = $_GET['name'];
  $peoples = searchFriendByName($name,$currentUser['id']);
  $posts = searchPostByString($name);
  if(!$currentUser)
  {
    header('Location: index.php');
    exit();
  } 
?>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="script.js"></script>

<?php include 'header.php'; ?>
<br><br><br><br>
<?php if(empty($peoples) && empty($posts)):?>
<div style="text-align: center;">
     <h4>Không có kết quả tìm kiếm cho '<?php echo $name;?>'</h4>
</div>
<?php else: ?>
<div style="text-align: center;">
     <h4>Kết quả tìm kiếm cho '<?php echo $name;?>'</h4>
</div>
  <?php if(empty($peoples)==false):?>
  <div class="card" style="width: 80%; margin: 0 auto; border: none;"><h4>Mọi người</h4></div>
  <?php endif;?>
  <?php foreach ($peoples as $people ) : ?>
      <div class="card" style="width: 80%; margin: 0 auto; ">
        <div class="card-body">     
            <div class="row">
              <div class="col-1">
                <a href ="profile.php?id=<?php echo $people['id'];?>" >
                  <img style="width: 80px;height: 80px; border-radius: 50%;" src="uploads/<?php echo $people['id'];?>.jpg"> 
                </a>
              </div>
              <div class="col-11 ">
                <h5 class="text-left">
                  <a href ="profile.php?id=<?php echo $people['id'];?>" >
                  <?php echo $people['username']; ?>     
                  </a>
                  <?php if($people['id'] != $currentUser['id']) :?>  
                    <?php $mutualFriends = countMutualFriend($currentUser['id'],$people['id']); ?>
                    <?php if($mutualFriends !=0) :?>
                      <p class="text-secondary"><?php echo $mutualFriends;?> bạn chung</p>
                    <?php endif; ?>
                  <?php endif; ?>  
                </h5>
              </div>
            </div>
           
        </div>
      </div>  
    
  <?php endforeach; ?>
  <?php if(empty($posts)==false):?>
  <div class="card" style="width: 80%; margin: 0 auto; border: none;"><h4>Bài viết</h4></div>
  <?php endif; ?>
  <?php foreach ($posts as $post ) : ?>
    <?php if($post['privacy'] == 1 || $post['privacy']==2 && isFriend($currentUser['id'],$post['userId']) || $currentUser['id']==$post['userId']):?>  
      <div class="card" style="width: 80%; margin: 0 auto; ">
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
         
           <!--like by phuong -->
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

                <!-- comment by phuong-->
                <form class="clearfix" action="index.php" method="post" 
                  id="comment_form_<?php echo $post['id'] ?>" data-id="<?php echo $post['id']; ?>"> 
                  <textarea name="comment_text" id="comment_text_<?php echo $post['id'] ?>" class="form-control" cols="30" rows="1"></textarea>
                  <button name="submit" class="btn btn-primary btn-sm pull-right" id="submit_comment"data-id="<?php echo $post['id']; ?>">Submit comment</button>
                </form>
                <?php $comments=getAllCommentOfPost($post['id']);?>

                  <a><span id="comments_count_<?php echo $post['id'] ?>"><?php echo count($comments) ?></span> Comment(s)</a>
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
                          <a class="reply-btn"  href="#" data-id="<?php echo $comment['id']; ?>">reply</a>

                          </div>

                        <!-- reply form -->
                        <form style="display: none;" action="index.php" class="reply_form clearfix" id="comment_reply_form_<?php echo $comment['id'] ?>" data-id="<?php echo $comment['id']; ?>">
                          <textarea class="form-control" name="reply_text" id="reply_text" cols="30" rows="1"></textarea>
                          <button class="btn btn-primary btn-xs pull-right submit-reply">Submit reply</button>

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
                      <a>Be the first to comment on this post</a>
                    <?php endif ?>
                  </div><!-- comments wrapper -->
                  </div><!-- // all comments -->
                        <!-- end comment3 -->
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif;?>
<?php include 'footer.php'; ?>
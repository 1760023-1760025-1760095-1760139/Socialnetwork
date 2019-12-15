<?php 
  require_once 'init.php';
  require_once 'functions.php';
  require_once 'like_dislike.php';
  require_once 'comment.php';

  $page = 'personal';  
  $posts = findAllPostOfUser($currentUser['id']);
  $friends = findAllFriend($currentUser['id']);
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
    <div class="container" style="margin-top: 10%;">
        <div style="text-align: center;">
         <div class="card" style="width: 80%; margin: 0 auto; ">
          <div class="card-body">
            <img style="width: 200px;height: 200px; border-radius: 50%;border: #003366 solid 5px;" src="uploads/<?php echo $currentUser['id'] ;?>.jpg">
             <p><h4><?php echo $currentUser['username']; ?></h4></p>
         
           
            <div>
              <form method="POST">
                <!-- <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#popup">Cập nhật ảnh đại diện</button>               -->
                <button type="submit" class="btn btn-white" data-toggle="modal" name="update-avatar" id="update-avatar">Cập nhật ảnh đại diện</button>
                <input type="file"  name="upload_avatar" id="upload_avatar" multiple style="display: none;">
              </form>
            </div>
          </div>
          <div class="card" >
            <form method="POST">
            
            <div class="row">
              <div class="col-sm">
                <button type="button" class="btn btn-link"name="timeline-btn" id="timeline-btn" style=" text-decoration: none">Dòng thời gian</button>
              </div>
              <div class="col-sm">
                <button type="button" class="btn btn-link" name="about-btn" id="about-btn" style=" text-decoration: none;">Thông tin cá nhân</button>
              </div>
              <div class="col-sm">
                <button type="button" class="btn btn-link" name="friendlist-btn" id="friendlist-btn" style=" text-decoration: none;">Bạn bè</button>
              </div>
            
            </form>
          </div>
         </div>
        </div>     
      </div>
  </div>
<!-- modal-dialog show when click Update avatar button -->
    <div id="uploadimageModal" class="modal" role="dialog" >
	<div class="modal-dialog">
		<div class="modal-content">
      		<div class="modal-header" >
        	<h4 class="modal-title" style="margin: 0 auto;">Upload & Crop Image</h4>
          </div>
          <!-- body-->
      		<div class="modal-body" style="margin: 0 auto;">
            <div id="crop-area">
              <div class="text-center"> 
                <div id="image_demo" style="width:350px; margin-top:30px"></div>
              </div>
              <div style="text-align: center;">
                <button class="btn btn-success crop_image">Crop & Upload</button>            
              </div>
            </div>
            <div id="image-viewer"></div>
          <!-- body-->
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
    	</div>
    </div>
</div>


<div class="container" id="personal-main">
  <div id="about-user"></div>
  <div id="friends-of-user"></div>
  <div id="all-post">
    <?php foreach ($posts as $post ) : ?>
          <div class="card" style="width: 80%; margin: 0 auto;">
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
                   
                      <?php foreach ($comments as $comment): ?>
                     
                      <div class="comment clearfix">
                        <div class="comment-details">
                        <img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $comment['user_id'];?>.jpg">
                          <b><span class="comment-name"><?php echo findUserById($comment['user_id'])['username'] ?></span></b>
                          <span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
                          <p><?php echo $comment['body']; ?></p>
                          <a class="reply-btn"  href="#" data-id="<?php echo $comment['id']; ?>">Viết phản hồi</a>

                          </div>

                        <!-- trả lời bình luận -->
                        <form style="display: none;" action="index.php" class="reply_form clearfix" id="comment_reply_form_<?php echo $comment['id'] ?>" data-id="<?php echo $comment['id']; ?>">
                          <textarea class="form-control" name="reply_text" id="reply_text" cols="30" rows="1"></textarea>
                          <button class="btn btn-primary btn-xs pull-right submit-reply">Bình luận</button>

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
  
</div>
<?php include 'footer.php'; ?>
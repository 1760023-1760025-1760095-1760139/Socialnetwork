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

<?php include 'header.php'; ?>
    <div class="container" style="margin-top: 10%;">
        <div style="text-align: center;">
         <div class="card" style="width: 80%; margin: 0 auto; ">
          <div class="card-body">
            <img style="width: 200px;height: 200px; border-radius: 50%;" src="uploads/<?php echo $currentUser['id'] ;?>.jpg">
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
        <?php $comments=getAllCommentOfPost($post['id']);?>

        <div class="card post" style="width: 80%;">
            <div class="card-body">
              <?php $userPost = findUserById($post['userId']);?>
                <div class="user-post-info">
                  <img style="width: 40px;height: 40px; border-radius: 50%;" src="uploads/<?php echo $userPost['id'];?>.jpg">
                  <div class="user-post-date">
                    <a class="user-post-name" href="profile.php?id=<?php echo $post['userId'];?>">
                      <?php echo $userPost['username']; ?>
                    </a>
                    <p class="post-date" ><?php echo $post['createdAt']; ?></p>
                  </div>
                </div>
                <div class="post-body">
                    <p class="card-text"><?php echo $post['content']; ?></p>
                    <?php if ($post['image']):?>
                        <div class="post-image-container">
                            <img src="<?php echo $post['image']; ?>" class="post-image-img" alt="">
                        </div>
                    <?php endif; ?>
                </div>
                <div class ="post">
                      <div class="post-like-comment">
                          <div class="post-like">
                              <i <?php if (userLiked($post['id'])): ?>
                                  class="fa fa-thumbs-up like-btn"
                              <?php else: ?>
                                  class="fa fa-thumbs-o-up like-btn"
                              <?php endif ?>
                                      data-id="<?php echo $post['id'] ?>">
                              </i>
                              <span class="likes"><?php echo getLikes($post['id']); ?></span><span> lượt thích</span>
                          </div>
                          <div class="post-comment">
                              <i class="fa fa-commenting-o" aria-hidden="true"></i>
                              <span id="comments_count_<?php echo $post['id'] ?>"><?php echo count($comments) ?></span><span> bình luận</span>
                          </div>
                      </div>
                </div>
                <form class="clearfix" action="personal.php" method="post"
                  id="comment_form_<?php echo $post['id'] ?>" data-id="<?php echo $post['id']; ?>">
                  <div class="comment-area">
                  <input name="post_id" value="<?php echo $post['id']; ?>" hidden>
                    <input name="comment_text" id="comment_text_<?php echo $post['id'] ?>" class="form-control" ></input>
                    <button name="submit" class="btn btn-primary btn-sm pull-right submit_comment" data-id="<?php echo $post['id']; ?>">Bình luận</button>
                  </div>
                </form>
                  <hr>
                 
                  <div id="comments_wrapper_<?php echo $post['id']; ?>">
                    <?php if (isset($comments)): ?>
                   
                      <?php foreach ($comments as $comment): ?>
                     
                      <div class="comment clearfix">
                        <div class="comment-details">
                        <img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $comment['user_id'];?>.jpg">
                        <div class="comment-body">
                          <a class="user-comment-name" href="profile.php/?id=<?=$comment['user_id']?>"><span class="comment-name"><?php echo findUserById($comment['user_id'])['username'] ?></span></a>
                          <p><?php echo $comment['body']; ?></p>
                        </div>
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
        <?php endforeach; ?>
  </div>

</div>
  
</div>
<?php include 'footer.php'; ?>
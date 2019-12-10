<?php 
  require_once 'init.php';
  require_once 'functions.php';
  require_once 'like_dislike.php';

  $page = 'personal';  
  $posts = findAllPostOfUser($currentUser['id']);
  $friends = findAllFriend($currentUser['id']);
  if(!$currentUser)
  {
    header('Location: index.php');
    exit();
  } 
?>

<!-- add Jquery -->
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="script_like.js"></script>

<!-- styling -->

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
                <button type="submit" class="btn btn-dark" data-toggle="modal" name="update-avatar" id="update-avatar">Cập nhật ảnh đại diện</button>
                <input type="file"  name="upload_avatar" id="upload_avatar" multiple style="display: none;">
              </form>
            </div>
          </div>
          <div class="card" >
            <form method="POST">
            <div class="row">
              <div class="col-sm">
                <button type="button" class="btn btn-link" name="timeline-btn" id="timeline-btn" style=" text-decoration: none;">Dòng thời gian</button>
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
<!--End of modal-dialog-->

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
              <!-- <a href="#" class="card-link">Thích</a> -->
               <!-- phuong_like -->
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
          <!-- phuong_endlike -->
              <!-- <a href="#" class="card-link">Bình luận</a> -->
              <div class="form-inline">
                <div>
                  <input type="text" class="form-control" style=" border: 1px solid #ccd0d5; border-radius: 16px;" placeholder="Viết bình luận...">
                </div>
                  <button type="submit"class="btn btn-primary" style=" border: 1px solid #ccd0d5; border-radius: 30px;" name="postComment">Bình luận</button> 
              </div>
            </div>
          </div>    
        <?php endforeach; ?>
  </div>
  
</div>
<?php include 'footer.php'; ?>
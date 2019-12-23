</body>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>




<script>
$(".dropdown-menu li a").click(function () {
    var selText = $(this).text();
    $(".privacy-value").html(selText);
    $(".getDropdownValue").html(selText);
    console.log(selText);
    
});
</script>

<script>  
$(document).ready(function(){

	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' 
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_avatar').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"upload-avatar.php",
        type: "POST",
        data:{"image": response},
        success:function(data)
        {
        //   $('.modal-title').html('Ảnh đại diện đã được cập nhật');
        //   $('#crop-area').html('');
        //   $('#image-viewer').html(data);
            $('#uploadimageModal').modal('hide');
            location.reload();
        }
      });
    })
  });

});  

</script>
<!-- update-avatar-btn -->
<script>
$('#update-avatar').on('click', function() { $('#upload_avatar').click();return false;});
</script>
<!-- upload-image-index-post -->
 <script>
  $('#post-image').on('click', function() { 
    $('#upload_image').click();
    return false;
    });
</script>   

<script>
$(document).ready(function(){
$('#about-btn').on('click', function() {
    console.log('click');
     $('#all-post').hide();
     $('#friends-of-user').hide();
    $('#about-user').html('<div class="card" style="width: 80%; margin: 0 auto; "><div class="card-body"><p>Tên người dùng: <h4><?php echo $currentUser['username']; ?></h4></p><p>Email: <h4><?php echo $currentUser['email']; ?></h4></p></div></div>');
    return false;
});

$('#timeline-btn').on('click', function() {
    console.log('click');
    $('#about-user').hide();
    $('#friends-of-user').hide();
    $('#all-post').show();
    return false;
});

$('#friendlist-btn').on('click', function() {
    console.log('click');
    $('#all-post').hide();
    $('#about-user').hide();
    $('#friends-of-user').html('<?php foreach ($friends as $friend ) : ?><?php $friendInfo = findUserById($friend);?><?php if($friendInfo['id'] != $currentUser['id']) :?><div class="card" style="width: 80%; margin: 0 auto; "><div class="card-body"><h5><a href ="profile.php?id=<?php echo $friendInfo['id'];?>" ><img style="width: 50px;height: 50px; border-radius: 50%;" src="uploads/<?php echo $friendInfo['id'];?>.jpg"><?php echo $friendInfo['username']; ?></a></h5><?php $mutualFriends = countMutualFriend($currentUser['id'],$friendInfo['id']); ?><?php if($mutualFriends !=0) :?><p><?php echo $mutualFriends;?> bạn chung</p><?php endif; ?></div></div><?php endif; ?><?php endforeach; ?>');
    return false;
});
});
</script>

</html>
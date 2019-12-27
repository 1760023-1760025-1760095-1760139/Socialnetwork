<div class="modal fade" id="modal-upload-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="upload-image-status.php" id="form-post-image" method="post" enctype="multipart/form-data">
    <div class="modal-dialog" id="modal-image-dialog" role="document">
        <div class="modal-content" id="modal-upload-image-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đăng ảnh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-upload-image-body">
                <div id="before-upload">
                    <button type="button" class="btn btn-light" name="post-image" id="choose-image">
                        <i class="fa fa-camera" id="camera-icon" aria-hidden="true"></i>
                    </button>
                </div>
                <div id="after-upload" style="display: none;">
                    <div class="form-group" id="post-area">
                        <div id="avatar-modal-container">
                            <div id="user-avatar">
                                <img style="width: 100px;height: 100px; border-radius: 50%;border: #333 solid 2px;" src="uploads/<?php echo $currentUser['id'] ;?>.jpg">
                            </div>
                        </div>
                        <div id="input-container">
                            <textarea class="form-control" id="status-image" name="status-image" placeholder="Nói gì đó về ảnh này..."></textarea>
                        </div>
                    </div>
                    <img id="preview" style="width: 100%; height: auto; margin: 0 auto;" alt="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button class="btn btn-secondary dropdown-toggle" style="min-width: 150px;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                ><span class="privacy-value">Mọi người</span></button>
                <div class="dropdown-menu" id="dropdown-menu-index" type="submit"  aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item">Mọi người</a></li>
                    <li><a class="dropdown-item">Bạn bè</a></li>
                    <li><a class="dropdown-item">Chỉ mình tôi</a></li>
                </div>
                <textarea style="display:none;" class="getDropdownValue" rows="1" name="Privacy-value">Mọi người</textarea>
                <input type="submit" class="btn btn-primary" value="Đăng" id="post-this-image" name="submit" disabled>
                <input type="file"  name="upload_image" id="upload_image" onchange="showImage(this);" multiple style="display: none;">
            </div>

        </div>
    </div>
    </form>
</div>

<script type="text/javascript">
    function showImage(input) {
        var extAccept = ['image/jpeg','image/png'];
        //TODO: check type file input.files[0].type: "image/[jpeg/png/gif]"
        if (input.files && input.files[0]) {
            if(extAccept.includes(input.files[0].type))
            {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                }
                $('#before-upload').hide();
                $('#after-upload').show();

                reader.readAsDataURL(input.files[0]);
                $('#post-this-image').attr("disabled", false);

            }
            else
            {
                alert('File không được hỗ trợ!\nVui lòng chọn một hình ảnh.');
                input.files = null;
                $('#post-this-image').attr("disabled", true);
            }
        }
    }
</script>
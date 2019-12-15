<?php 
  require_once 'init.php';
  require_once 'functions.php';
  $page = 'verify-email';
if($currentUser)
{
	header('Location: index.php');
    exit();
}
$userId = $_GET['id'];
$emailVerify = findEmailById($userId);
$secret = $_GET['secret'];
$success = false;
$secret = $_GET['secret'];
$verify = findVerifyBySecret($secret);
if(isset($_POST['submit']))
{
  $code = $_POST['verify-code'];
//   Kiểm tra điều kiện code
  if($code && $code=$verify['code'] && $verify['used']==0)
  {
    deleteVerify($secret);
    updateVerifyState($userId);
    $success = true;
    $_SESSION['userId'] = $userId;
    header('Location: index.php');
    exit();
  }
}
?>


<?php include 'header.php'; ?>
  <?php if(!$verify):?>
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
  <?php else: ?>
    <?php if(!$success): ?>
    <h1 style="text-align: center;">XÁC THỰC EMAIL</h1>
    <div class="card" style="width: 80%	; margin: 0 auto;">
      <div class="card-body">
      <form method="POST" >
        <div class="form-group">
            <p>Vui lòng nhập mã xác thực đã gửi tới <strong><?php echo $emailVerify['email']?></strong> để xác thực email</p>
          <label  style="font-weight: bold; font-size: 20px;" for="code">Mã xác thực</label>
          <input type="text" class="form-control" id="verify-code" name ="verify-code" minlength="6" required placeholder="Nhập mã xác thực" autocomplete="off" Required>
        </div>
        <div style="text-align: center;">
          <button type="submit" name="submit" class="btn btn-primary">Xác thực</button>
        </div>				
      </form>
    </div>
    </div>
  
    <?php endif;?>
  <?php endif;?>
<?php include 'footer.php'; ?>
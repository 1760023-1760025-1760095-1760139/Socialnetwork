<?php 
  require_once 'init.php';
  require_once 'functions.php';
  $page = 'reset-password';
if($currentUser)
{
	header('Location: index.php');
    exit();
}
$success = false;
if(isset($_POST['submit']))
{
  $secret = $_GET['secret'];
  $reset = findResetPassword($secret);
  if($reset && $reset['used']==0)
  {
    $passwordHash = password_hash($_POST['password'],PASSWORD_BCRYPT);
    markSecretUsed($secret);
    updatePassword($reset['userId'],$passwordHash);
    $success = true;
    $_SESSION['userId'] = $reset['userId'];
    header('Location: index.php');
    exit();
  }
}

?>
<?php if(!$success): ?>
<?php include 'header.php'; ?>
 <h1 style="text-align: center;">MẬT KHẨU MỚI</h1>
<div class="card" style="width: 70%	; margin: 0 auto;">
  <div class="card-body">
	<form method="POST" >
	  <div class="form-group">
	    <label  style="font-weight: bold; font-size: 20px;" for="password">Mật khẩu</label>
	    <input type="password" class="form-control" id="password" name ="password" minlength="8" required placeholder="Nhập mật khẩu" autocomplete="off" >
	  </div>
	  <div style="text-align: center;">
	    <button type="submit" name="submit" class="btn btn-primary">Đổi mật khẩu</button>
	  </div>				
	</form>
 </div>
</div>
<?php include 'footer.php'; ?>
<?php endif;?>
<?php 
ob_start();
  require_once 'init.php';
	require_once 'functions.php';
	$page = 'register';
  if(empty($currentUser)==false)
  {
	header('Location: index.php');
    exit();
  }
  ob_flush();
?>

<?php include 'header.php'; ?>

<h1 style="text-align: center;">ĐĂNG KÝ</h1>
<div class="card" style="width: 70%	; margin: 0 auto;">
  <div class="card-body">
	<form method="POST">
	<div class="form-group">
		<label style="font-weight: bold; font-size: 20px;" for="user">Tên người dùng</label>
	    <input type="user" class="form-control" id="user" name="user"  placeholder="Nhập tên người dùng" autocomplete="off" minlength="4" Required >
	</div>
  	<div class="form-group"> 
	    <label style="font-weight: bold; font-size: 20px;" for="email">Email</label>
	    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" autocomplete="off" Required>
	 </div>
  <div class="form-group">
    <label style="font-weight: bold; font-size: 20px;" for="password">Mật khẩu</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" autocomplete="off" minlength="8" Required>
  </div>
  <div class="form-group">
    <label style="font-weight: bold; font-size: 20px;" for="password">Nhập lại mật khẩu</label>
    <input type="password" class="form-control" id="password" name="conf-password" placeholder="Nhập lại mật khẩu" minlength="8" autocomplete="off" Required>
  </div>
  
		<?php
			if(isset($_POST['submit']))
			{
				$username = $_POST['user'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$conf_password =$_POST['conf-password'];
				if($password!=$conf_password)
				{
					echo '<div style="text-align: center;"><p style="color:#f25119;">Mật khẩu xác nhận không đúng!</p></div>';
				}
				else
				{
					$check =0;
					$hashPassword = password_hash($password, PASSWORD_DEFAULT);

					if(KiemTraTonTaiEmail($email)==true)
					{
						echo '<div style="text-align: center;"><p style="color:#f25119;">Email này đã có tài khoản!<a href="forgotpassword.php"> Quên mật khẩu<a></p></div>';
					}
					else if (KiemTraTonTaiUser($username)==true)
					{
						echo '<div style="text-align: center;"><p style="color:#f25119;">Tên người dùng này đã được sử dụng! Vui lòng chọn tên khác</p></div>';
					}
					else
					{
						CreateUserNoVerify($username,$email,$hashPassword);
						$createId = findUserByEmail($email);
						resizeImage('image/avatar-navbar.jpg', 512, 512, $crop=FALSE,'uploads/'.$createId['id'].'.jpg') ;
						$code = randomNumber(6);
						$secret= createVerifyEmail($createId['id'],$code);
						sentEmail($email,$username,'Xác thực địa chỉ mail','<p style="font-size: 15px;">Xin chào <strong>'.$username.'</strong>! Bạn đã đăng kí tài khoản MXH bằng email này.<br> Vui lòng click <a href="http://localhost:8080/peace/verify-email.php?secret=' . $secret . '&id='.$createId['id'].'">vào đây</a> và nhập mã xác thực để xác thực email này!<p><br><h3>Mã xác thực: </h3><h2>'.$code.'</h2>');
						header('Location: verify-email.php?secret='.$secret.'&id='.$createId['id'].'');
					}
					
				}
				
				
			}
		?>
		<div style="text-align: center;">
		<button type="submit" class="btn btn-dark" name="submit">Đăng ký</button>
	</div>
	</form>
	</div>
</div>
<?php include 'footer.php'; ?>
<?php 
require_once 'init.php';
require_once 'functions.php';
$page = 'forgot-password';
if($currentUser)
{
	header('Location: index.php');
	exit();
}

?>
<?php include 'header.php'; ?>
	<h1 style="text-align: center;">KHÔI PHỤC MẬT KHẨU</h1>
	<div class="card" style="width: 70%	; margin: 0 auto;">
		<div class="card-body">
			<?php if(isset($_POST['submit'])): ?>
				
				
				<?php $email = $_POST['email']; ?>
				<div style="text-align: center;"><img src="./image/successful.png" style="width: 60px; height: 60px;"></div><br>
				<div class="alert alert-success" role="alert">
					Đã gửi xác nhận khôi phục mật khẩu đến email của bạn!
				</div>
				<?php 
				if(kiemTraTonTaiEmail($email))
				{
					$user = findUserByEmail($email);
					$secret = createResetPassword($user['id']);
					$baseUrl = explode("forgot-password.php",getBaseUrl())[0];
					echo $baseUrl;
					sentEmail($user['email'],$user['username'],'Xac nhan doi mat khau','Xin chào <strong>'.$user['username'].'</strong>! Bạn đã yêu cầu khôi phục mật khẩu.<br> Vui lòng click <a href="' . $baseUrl . 'reset-password.php?secret=' . $secret . '">vào đây</a> để đổi mật khẩu!');
				}

				 ?>
				<?php else: ?>				
					<form method="POST">
						<div class="form-group">
							<label style="font-weight: bold; font-size: 20px;" for="email">Email khôi phục</label>
							<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" Required autocomplete="off">
						</div>
						<div style="text-align: center;">
							<button type="submit" class="btn btn-dark" name="submit">Khôi phục</button>
						</div>

					<?php endif ?>

				</form>	
			</div>
		</div>	
	<?php include 'footer.php'; ?>
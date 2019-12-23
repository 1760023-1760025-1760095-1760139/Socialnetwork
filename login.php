<?php 
  require_once 'init.php';
	require_once 'functions.php';
	$page = 'login';
if($currentUser)
{
	header('Location: index.php');
    exit();
}

?>

<?php include 'header.php'; ?>

 <h1 style="text-align: center;">Đăng nhập</h1>
<div class="card" style="width: 70%	; margin: 0 auto;">
  <div class="card-body">
	<form method="POST" >
	  	<div class="form-group"> 
	    <label style="font-weight: bold; font-size: 20px;" for="email">Email</label>
	    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" autocomplete="off" Required>
	 </div>
	  <div class="form-group">
	    <label  style="font-weight: bold; font-size: 20px;" for="password">Mật khẩu</label>
	    <input type="password" class="form-control" id="password" name ="password" placeholder="Nhập mật khẩu" autocomplete="off" >
	  </div>
	  <div style="text-align: center;">
	  <button type="submit" name="log-submit" class="btn btn-dark">Đăng nhập</button>
	  </div>
	  </div>
	  <?php 

				if(isset($_POST['email'])&& isset($_POST['password']))
				{
					
					$password = $_POST['password'];
					$email = $_POST['email'];
					$user = findUserByEmail($email);
					if($user)
					{
						if($user['verified']==1)
						{
								$checkpass = password_verify($password,$user['password']);
								if($checkpass)
								{
									$_SESSION['userId'] = $user['id'];
									header('Location: index.php');
									exit();
								}
								else
								{
									echo '<div style="text-align: center;"><p style="color:#ba2e35; ">Sai email hoặc mật khẩu</p></div>';
									
								}
						}
						else
						{
								$verify =  findVerifyByUserId($user['id']);
								header('Location: verify-email.php?secret='.$verify['secret'].'&id='.$verify['userId'].'');
						}
					}
					else
					{
						echo '<div style="text-align: center;"><p style="color:#ba2e35; ">Sai email hoặc mật khẩu</p></div>';
						
					}	
				}

		?>
				<br>
				<div style="text-align: center;color:black">
				<a href="register.php">Đăng ký!</a><br>	
				<a href="forgot-password.php" >Quên mật khẩu?</a>
				</div>
	</form>
 </div>
</div>
</div>
	
<?php include 'footer.php'; ?>
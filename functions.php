<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function findUserById($id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM users WHERE id=? LIMIT 1');
	$stmt->execute(array($id));
	$user =  $stmt->fetch(PDO::FETCH_ASSOC);
	return $user;
}

function findEmailById($id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT email FROM users WHERE id= ? LIMIT 1');
	$stmt->execute(array($id));
	$user =  $stmt->fetch(PDO::FETCH_ASSOC);
	return $user;
}


function findUserByEmail($email)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM users WHERE email=? LIMIT 1');
	$stmt->execute(array($email));
	$user =  $stmt->fetch(PDO::FETCH_ASSOC);
	return $user;
}

function kiemTraTonTaiEmail($email)
{
	GLOBAL $db;
	$stmt = $db->query('SELECT * FROM users');
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{ 
		if($row['email']==$email)
		{
			return true;
		}
	}
	return false;
 
}
function kiemTraTonTaiUser($user)
{
	GLOBAL $db;
	$stmt = $db->query('SELECT * FROM users');
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
	{ 
		if($row['username']==$user)
		{
			return true;
		}
	}
	return false;
 
}

 function CreateUserNoVerify($user,$email,$password)
 {
 	GLOBAL $db;
	$stmt = $db->prepare("INSERT INTO users(username,email,password,verified) VALUES(?,?,?,0)");
	$stmt->execute(array($user,$email,$password));
	
	// $stmt = $db->prepare('SELECT * FROM users WHERE email= ? LIMIT 1');
	// $stmt->execute(array($email));
	// $userId =  $stmt->fetch(PDO::FETCH_ASSOC);
	// $file = $_FILES['image/avatar-navbar.jpg']
	// move_uploaded_file($file, 'uploads/' .$userId['id'] .'.jpg');
 }


function addPost($userId,$content,$privacyNum)
{
	GLOBAL $db;
	$stmt = $db->prepare("INSERT INTO post(userId,content,privacy) VALUES(?,?,?)");
	$stmt->execute(array($userId,$content,$privacyNum));	
}

function addPicture($userId,$content,$pictureId)
{
	GLOBAL $db;
	$stmt = $db->prepare("INSERT INTO post(userId,content,pictureId) VALUES(?,?,?)");
	$stmt->execute(array($userId,$content,$pictureId));
}

function findAllPost()
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM post ORDER BY createdAt DESC' );
	$stmt->execute();
	$posts = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $posts;
	
}


function randomString($length)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function randomNumber($length)
{
	$characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



function createResetPassword($userId)
{
	GLOBAL $db;
	$secret = randomString(10);
	$stmt = $db->prepare("INSERT INTO resetpassword(userId,secret, used) VALUES(?,?,0)");
	$stmt->execute(array($userId,$secret));
	return $secret;
}

function createVerifyEmail($userId,$code)
{
	GLOBAL $db;
	$secret = randomString(10);
	$stmt = $db->prepare("INSERT INTO verifyemail(userId,secret,code,used) VALUES(?,?,?,0)");
	$stmt->execute(array($userId,$secret,$code));
	return $secret;
}



 
function sentEmail($email,$receiver,$subject,$content)
{
	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	// try {
		//Server settings
		// $mail->SMTPDebug = 2;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'verify.email.1660407@gmail.com';                 // SMTP username
		$mail->Password = 'Khanhnhat@123';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		//
		//Recipients
		$mail->setFrom('verify.email.1660407@gmail.com', '1660407 Social Network');
		$mail->addAddress($email,$receiver);     // Add a recipient
	
	
		//Content
		$mail->isHTML(true);// Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $content;
		$mail->send();
		// return true;
	// } 
	// catch (Exception $e) {
	// 	return false;
	// }
}

//Reset Password
function findResetPassword($secret)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM resetpassword WHERE secret =? LIMIT 1');
	$stmt->execute(array($secret));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}
function updatePassword($userId, $password)
{
	GLOBAL $db;
	$stmt = $db->prepare("UPDATE users SET password=? WHERE id= ?");
	$stmt->execute(array($password,$userId));
}

function markSecretUsed($secret)
{
	GLOBAL $db;
	$stmt = $db->prepare("UPDATE resetpassword SET used = 1 WHERE secret = ? ");
	$stmt->execute(array($secret));
}

//Confirm Email Register
// Tìm secret khi login mà tài khoản chưa xác thực
function findVerifyByUserId($userId)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM verifyemail WHERE userId =? LIMIT 1');
	$stmt->execute(array($userId));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findVerifyBySecret($secret)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM verifyemail WHERE secret =? LIMIT 1');
	$stmt->execute(array($secret));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function deleteVerify($secret)
{
	GLOBAL $db;
	$stmt = $db->prepare("DELETE FROM verifyemail WHERE secret = ?");
	$stmt->execute(array($secret));
}

function updateVerifyState($userId)
{
	GLOBAL $db;
	$stmt = $db->prepare("UPDATE users SET verified= 1 WHERE id= ?");
	$stmt->execute(array($userId));
}

function resizeImage($file, $w, $h, $crop=FALSE,$out) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	imagejpeg($dst, $out);
}


function findRelationship($user1Id, $user2Id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM relationship WHERE user1Id = ? AND user2Id = ? OR  user1Id = ? AND user2Id=?');
	$stmt->execute(array($user1Id, $user2Id, $user2Id, $user1Id));
	$relationship = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $relationship;
}

function addRelationship($user1Id, $user2Id)
{
	
	GLOBAL $db;
	$stmt = $db->prepare('INSERT INTO relationship (user1Id,user2Id) VALUES (?,?) ');
	$stmt->execute(array($user1Id, $user2Id));
}

function removeRelationship($user1Id, $user2Id)
{
	GLOBAL $db;
	$stmt = $db->prepare('DELETE FROM relationship WHERE user1Id = ? AND user2Id = ? OR  user1Id = ? AND user2Id=?');
	$stmt->execute(array($user1Id, $user2Id, $user2Id, $user1Id));
}

function findAllFriend($userId)
{
	GLOBAL $db;
	$stmt = $db->prepare("SELECT DISTINCT f1.user2Id FROM relationship AS f1 JOIN relationship AS f2  ON  f1.user2Id = f2.user1Id WHERE f1.user1Id = ?");
	$stmt->execute(array($userId));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$friends = array();
	foreach($rows AS $row)
	{
		$friends[] = $row['user2Id'];
	}
	return $friends;
}


function findAllPostOfFriends($userId)
{
	GLOBAL $db;
	$friendIds = findAllFriend($userId);
	//$friendIds[] =$userId;
	// $stmt = $db->prepare('SELECT * FROM post  WHERE userId IN ('.str_pad('',count($friendIds)*2-1,'?,').') AND privacy = 1 OR privacy = 2  ORDER BY createdAt DESC');
	$stmt = $db->prepare('SELECT * FROM post WHERE userId IN (SELECT DISTINCT f1.user2Id FROM relationship AS f1 JOIN relationship AS f2 ON f1.user2Id = f2.user1Id WHERE f1.user1Id = ?) AND (privacy = 1 OR privacy = 2) UNION ALL SELECT * FROM post p2 WHERE p2.userId= ? ORDER BY createdAt DESC
');
	$stmt->execute(array($userId,$userId));
	$posts = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $posts;
	 
}



function findAllPostOfUser($userId)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM post  WHERE userId = ? ORDER BY createdAt DESC');
	$stmt->execute(array($userId));
	$posts = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $posts;
	 
}

function findAllPostOfUserVisiting($userId,$isFriend)
{
	// Xét điều kiện lọc bài viết
	if($isFriend == true)
	{
		$condition = '(privacy = 1 OR privacy = 2)';
	}
	else
	{
		$condition = 'privacy = 1';
	}
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM post  WHERE userId = ? AND '.$condition.' ORDER BY createdAt DESC');
	$stmt->execute(array($userId));
	$posts = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $posts;
	 
}

function findUsernameById($userId)
{
	GLOBAL $db;
	$stmt = $db->prepare("SELECT username from users where userId = ?");
	$stmt->execute(array($userId));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//Đếm bạn chung
function countMutualFriend($userId1,$userId2)
{
	$index = 0;
	$friends1 = findAllFriend($userId1);
	$friends2 = findAllFriend($userId2);	
	foreach($friends1 AS $friend1)
	{
		foreach($friends2 AS $friend2)
		{
			if($friend2 == $friend1)
			{
				$index++;
			}
		}
	}
	return $index;
}

function searchFriendByName($name,$currentUser)
{
	GLOBAL $db;
	//$query = 'SELECT us.id,us.username FROM users as us where us.username like :keyword ORDER BY (SELECT COUNT(*) From (SELECT DISTINCT f1.user2Id as id1 FROM relationship AS f1 JOIN relationship AS f2  ON  f1.user2Id = f2.user1Id WHERE f1.user1Id = 29) as T1 JOIN (SELECT DISTINCT f3.user2Id as id2 FROM relationship AS f3 JOIN relationship AS f4  ON  f3.user2Id = f4.user1Id WHERE f3.user1Id = us.id) as t2 WHERE t1.id1 = t2.id2) DESC';
	$query = 'SELECT us.id,us.username FROM users as us where us.username like :keyword ORDER BY us.username DESC';
	$stmt = $db->prepare($query);
	$stmt->bindValue(':keyword', '%' . $name . '%', PDO::PARAM_STR);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

function searchPostByString($string)
{
	GLOBAL $db;
	$query = 'SELECT * FROM post where content like :keyword  ORDER BY privacy';
	$stmt = $db->prepare($query);
	$stmt->bindValue(':keyword', '%' . $string . '%', PDO::PARAM_STR);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}
//phuong
function getAllCommentOfPost($post_id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM comments WHERE post_id= ? ORDER BY created_at DESC');
	$stmt->execute(array($post_id));
	$comments = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $comments;
}

function isFriend($user1Id, $user2Id)
{
    $relationship = findRelationship($user1Id, $user2Id);
    $isFriend = count($relationship) === 2;
    return $isFriend;
}
<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

ob_start();
require 'config.php';
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

function KiemTraTonTaiEmail($email)
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
function KiemTraTonTaiUser($user)
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
	
 }


function addPost($userId,$content,$privacyNum,$image)
{
	GLOBAL $db;
	$stmt = $db->prepare("INSERT INTO post(userId,content,privacy,image) VALUES(?,?,?,?)");
	$stmt->execute(array($userId,$content,$privacyNum,$image));
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

function findUserByPostId($postId)
{
    GLOBAL $db;
    $stmt = $db->prepare('SELECT userId FROM post WHERE id = '.$postId );
    $stmt->execute();
    $userID = $stmt->fetchALL(PDO::FETCH_ASSOC);
    return $userID;
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
	$mail = new PHPMailer(true);                              

		$mail->isSMTP();                                      
		$mail->Host = 'smtp.gmail.com';  
		$mail->SMTPAuth = true;                               
		$mail->Username = 'khanhnhatclone@gmail.com';
		$mail->Password = 'chauvankhanhnhat1997';
		$mail->SMTPSecure = 'tls';                            
		$mail->Port = 587;                                    
		

		//Recipients
		$mail->setFrom('khanhnhatclone@gmail.com', 'PEACE');
		$mail->addAddress($email,$receiver);     
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $content;
		$mail->send();

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

// login tai khoan chua xac thuc
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

//Bạn chung
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


function isFriend($user1Id, $user2Id)
{
    $relationship = findRelationship($user1Id, $user2Id);
    $isFriend = count($relationship) === 2;
    return $isFriend;
}


//Comment

function getAllCommentOfPost($post_id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM comments WHERE post_id= ? ORDER BY created_at DESC');
	$stmt->execute(array($post_id));
	$comments = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $comments;
}
function InsetComment($post_id,$user_id,$comment_text)
{
	GLOBAL $db;
	$stmt = $db->prepare("INSERT INTO comments (post_id, user_id, body, created_at, updated_at) 
	VALUES (?,?,?, now(), null)");
	$stmt->execute(array($post_id,$user_id,$comment_text));
}
function getCommentsCountByPostId($post_id)
{
	global $db;
	$stmt = $db->prepare("SELECT COUNT(*) FROM comments WHERE post_id=?");
	$stmt->execute(array($post_id));
	$data = $stmt->fetchColumn(0);
	return $data;
}
function getCommentByID($id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM comments WHERE id=? LIMIT 1');
	$stmt->execute(array($id));
	$comment =  $stmt->fetch(PDO::FETCH_ASSOC);
	return $comment;
}

//Reply comment
function getAllRepliesOfComment($comment_id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM replies WHERE comment_id= ?');
	$stmt->execute(array($comment_id));
	$replies = $stmt->fetchALL(PDO::FETCH_ASSOC);
	return $replies;
}
function insertReplyInComment($user_id , $comment_id, $reply_text)
{
	GLOBAL $db;
	$stmt = $db->prepare("INSERT INTO replies (user_id, comment_id, body, created_at, updated_at)
	VALUES (?,?,?, now(), null)");
	$stmt->execute(array($user_id , $comment_id, $reply_text));
}
function getRepLyByID($id)
{
	GLOBAL $db;
	$stmt = $db->prepare('SELECT * FROM replies WHERE id=?');
	$stmt->execute(array($id));
	$reply =  $stmt->fetch(PDO::FETCH_ASSOC);
	return $reply;
}


date_default_timezone_set('Asia/Kolkata');

function fetch_user_last_activity($user_id, $db)
{
	$query = "
	SELECT * FROM login_details 
	WHERE user_id = '$user_id' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['last_activity'];
	}
}

function fetch_user_chat_history($from_user_id, $to_user_id, $db)
{
	$query = "
	SELECT * FROM chat_message 
	WHERE (from_user_id = '".$from_user_id."' 
	AND to_user_id = '".$to_user_id."') 
	OR (from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."') 
	ORDER BY timestamp ASC
	";
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<ul class="list-unstyled">';
	foreach($result as $row)
	{
		$user_name = '';
		if($row["from_user_id"] == $from_user_id)
		{
            $output .= '<li class="message-list-li">
                            <span class="message-list message-from-me">
                                <p class="message-list-content">'.$row["chat_message"].'</p>
                            </span>
                        </li>
                        ';
		}
		else
		{
            $output .= '<li class="message-list-li">
                            <span class="message-list message-from-friend">
                                <p class="message-list-content">'.$row["chat_message"].'</p>
                            </span>
                        </li>
                        ';
		}

	}
	$output .= '</ul>';
	$query = "
	UPDATE chat_message 
	SET status = '0' 
	WHERE from_user_id = '".$to_user_id."' 
	AND to_user_id = '".$from_user_id."' 
	AND status = '1'
	";
	$statement = $db->prepare($query);
	$statement->execute();
	return $output;
}

function fetch_user_notification($userID, $type)
{
    GLOBAL $db;
    $query = "
	SELECT * FROM notification WHERE userId = ".$userID." and `type`= ".$type."
	ORDER  BY createAt DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function get_user_name($user_id, $db)
{
	$query = "SELECT username FROM users WHERE id = ". $user_id;
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['username'];
	}
}

function count_unseen_message($from_user_id, $to_user_id, $db)
{
	$query = "
	SELECT * FROM chat_message 
	WHERE from_user_id = '$from_user_id' 
	AND to_user_id = '$to_user_id' 
	AND status = '1'
	";
	$statement = $db->prepare($query);
	$statement->execute();
	$count = $statement->rowCount();
	$output = '';
	if($count > 0)
	{
		$output = '<span class="label label-success">'.$count.'</span>';
	}
	return $output;
}

function fetch_is_type_status($user_id, $db)
{
	$query = "
	SELECT is_type FROM login_details 
	WHERE user_id = '".$user_id."' 
	ORDER BY last_activity DESC 
	LIMIT 1
	";	
	$statement = $db->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		if($row["is_type"] == 'yes')
		{
			$output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
		}
	}
	return $output;
}

function fetch_group_chat_history($db)
{
	$query = "
	SELECT * FROM chat_message 
	WHERE to_user_id = '0'  
	ORDER BY timestamp DESC
	";

	$statement = $db->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	$output = '<ul class="list-unstyled">';
	foreach($result as $row)
	{
		$user_name = '';
		if($row["from_user_id"] == $_SESSION["user_id"])
		{
			$user_name = '<b class="text-success">You</b>';
		}
		else
		{
			$user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $db).'</b>';
		}

		$output .= '

		<li style="border-bottom:1px dotted #ccc">
			<p>'.$user_name.' - '.$row['chat_message'].' 
				<div align="right">
					- <small><em>'.$row['timestamp'].'</em></small>
				</div>
			</p>
		</li>
		';
	}
	$output .= '</ul>';
	return $output;
}



function getBaseUrl(){
	if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function getPageTitle($page,$userId){
	$title = 'PEACE';
	if ($page === 'index')
  {
    $title = 'Trang chủ';
  }
  else if ($page === 'login')
  {
    $title = 'Đăng nhập';
  }
  else if ($page === 'register')
  {
    $title = 'Đăng ký';
  }
  else if ($page === 'personal')
  {
    $title = 'Trang cá nhân';
  }
  else if ($page === 'profile' || $page ==='listfriend')
  {
    $usernameProfile = findUserById($userId);
    $title = $usernameProfile['username'];
  }
  else if ($page === 'forgot-password')
  {
    $title = 'Quên mật khẩu';
  }
  else if ($page === 'reset-password')
  {
    $title = 'Đổi mật khẩu';
  }
  else if ($page === 'search-friend')
  {
    $title='Tìm kiếm';
  }
  else if($page ==='verify-email')
  {
    $title ='Xác thực tài khoản';
  }
  else if ($page='result')
  {
    $title= 'Kết quả tìm kiếm';
  }
  else if ($page === 'messenger')
  {
    $title = 'Messenger';
  }
  return $title;
}

function addNotification($receiver, $type, $code, $creator, $content, $collect_link)
{

    GLOBAL $db;
    $stmt = $db->prepare('INSERT INTO notification (userId,type,code,creator,content,collection_link) VALUES(?,?,?,?,?,?)');
    $stmt->execute(array($receiver, $type, $code, $creator, $content, $collect_link));
}


function removeNotification($receiver, $type, $code, $creator)
{

    GLOBAL $db;
    $stmt = $db->prepare('DELETE FROM notification WHERE userId = ? and type = ? and code = ? and creator = ?');
    $stmt->execute(array($receiver, $type, $code, $creator));
}



ob_flush();
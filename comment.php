<?php 
  require_once 'init.php';
  require_once 'functions.php';
	
	$user_id = $currentUser['id'];
    if (isset($_POST['comment_text'])) {
        global $db;
        //$post_id = 2;
        
        $post_id = $_POST['post_id'];
        $comment_text = $_POST['comment_text'];
         //echo("<script>console.log('PHP: ".$post_id."');</script>");;
        $result=InsetComment($post_id,$user_id,$comment_text);
        $inserted_id = $db->lastInsertId();
        // echo("<script>console.log('PHP: ".$inserted_id."');</script>");
        $inserted_comment =getCommentByID($inserted_id);
        $count_comment=getCommentsCountByPostId($post_id);
        // InsetComment($inserted_comment['post_id'],$inserted_comment['user_id'],$inserted_comment['body']); test getcomment
        if (true) {
            $comment = "<div class='comment clearfix'>
                            <div class='comment-details'> 
                                <span class='comment-name'>" . findUserById($inserted_comment['user_id'])['username'] . "</span>
                                <span class='comment-date'>" . date('F j, Y ', strtotime($inserted_comment['created_at'])) . "</span>
                                <p>" . $inserted_comment['body'] . "</p>
                                <a class='reply-btn' href='#' data-id='" . $inserted_comment['id'] . "'>reply</a>
                            </div>
                            <!-- reply form -->
                            <form action='index.php' class='reply_form clearfix' id='comment_reply_form_" . $inserted_comment['id'] . "' data-id='" . $inserted_comment['id'] . "'>
                                <textarea class='form-control' name='reply_text' id='reply_text' cols='30' rows='2'></textarea>
                                <button class='btn btn-primary btn-xs pull-right submit-reply'>Submit reply</button>
                            </form>
                        </div>";
            $comment_info = array(
                'comment' => $comment,
                'comments_count' =>$count_comment // test demo with n=2;
            );
        
            echo json_encode($comment_info);
            exit();
        } else {
            echo "error";
            exit();
        }
    }
    // If the user clicked submit on reply form...
    if (isset($_POST['reply_posted'])) {
        global $db;
        // grab the reply that was submitted through Ajax call
        $reply_text = $_POST['reply_text']; 
        $comment_id = $_POST['comment_id']; 
        // insert reply into database
        $result = insertReplyInComment($user_id , $comment_id, $reply_text);
        $inserted_id = $db->lastInsertId();
        $inserted_reply = getRepLyByID($inserted_id);
        // if insert was successful, get that same reply from the database and return it
        if ($inserted_id) {
            $reply = "<div class='comment reply clearfix'>
                        <div class='comment-details'>
                            <b><span class='comment-name'>" . findUserById($inserted_reply['user_id'])['username'] . "</span></b>
                            <span class='comment-date'>" . date('F j, Y ', strtotime($inserted_reply['created_at'])) . "</span>
                            <p>" . $inserted_reply['body'] . "</p>
                        </div>
                    </div>";
            echo $reply;
            exit();
        } else {
            echo "error";
            exit();
        }
    }
<?php

//fetch_user_chat_history.php

include('init.php');

// session_start();

echo fetch_user_chat_history($_SESSION['userId'], $_POST['to_user_id'], $db);

?>
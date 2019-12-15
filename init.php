<?php 
require_once 'functions.php';
session_start();
//$db = new PDO('mysql:host=sql213.byethost.com;dbname=b17_22717149_users;charset=utf8', 'b17_22717149', 'nguyenthimy');
// $db = new PDO('mysql:host=localhost;dbname=users;charset=utf8', 'root', '');
$db = new PDO('mysql:host=localhost;dbname=peace;charset=utf8', 'root', '');

 $currentUser = null;
 $currentID = null;
 if(isset($_SESSION['userId']))
 {
 $user = findUserByID($_SESSION['userId']);
 if($user)
 {
    $currentUser = $user;
    $currentID = $_SESSION['userId'];
 }
 }

<?php

// import config.php, where we are keeping our functions
require "config.php";

// connect to server and select database
session_start();

$name = $_SESSION['username'];
if(!$name)
{
    header("location: nope.php");
}

$db = dbConnect();

$article = $db->real_escape_string($_POST['articleId']);
$me = $db->real_escape_string($_POST['me']);


$stmt = "DELETE FROM rec WHERE articleId='". $article."' AND toId='". $me."'";

$db->query($stmt);

header("location: rec.php");



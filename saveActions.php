<?php

// import config.php, where we are keeping our functions
require "config.php";

// connect to server and select database
session_start();

$post = strip_tags($_POST['post']);
$name = $_SESSION['username'];
$save = $_POST['save'];

$db = dbConnect();

$stmt = "SELECT * FROM articles WHERE articleId='".$post."'";

$result = $db->query($stmt);

$row = $result->fetch_assoc();

$title = $row['title'];
$link = $row['link'];

$result->free();

if($save)
{

    $name = $db->real_escape_string(strip_tags($name));
    $link =  $db->real_escape_string(strip_tags($link));
    $title =  $db->real_escape_string(strip_tags($title));
    $id = $db->real_escape_string(strip_tags($post));
    $stmt = "INSERT INTO saved (saveId, userName, link, title, saveDate, articleId) VALUES (NULL, '".$name."', '".$link."', '".$title."', NOW(), '". $id."');";
    $db->query($stmt);
    $db->close();
    header("location: post.php?post=". $post);

}

$article = $_POST['articleId'];
$delete = $_POST['delete'];

if($delete)
{
    $db = dbConnect();
    $stmt = "DELETE FROM saved WHERE articleId='" . $article . "' AND userName='" . $name . "'";
    $db->query($stmt);
    $db->close();
    header("location: saved.php");
}


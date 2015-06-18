<?php

// import config.php, where we are keeping our functions
require "config.php";

session_start();

$post = $_POST['post'];
$name = $_SESSION['username'];
$comment = $_POST['comment'];
$buttonPress = $_POST['submit'];

if(!$name)
{
    header("location: nope.php");
}

$db = dbConnect();

if($buttonPress)
{
    if($comment)
    {
        $post = $db->real_escape_string(strip_tags($post));
        $name =  $db->real_escape_string(strip_tags($name));
        $comment =  $db->$comment;
        $stmt = "INSERT INTO COMMENTS (comId, articleId, userName, com, comDate) VALUES (NULL, '".$post."', '".$name."', '".$comment."', NOW())";
        $db->query($stmt);
        //it worked, back to the post
        header("location: post.php?post=". $post);
        $db->close();

    }
    else
    {
        header("location: post.php?post=". $post);
        $db->close();
    }
}

$comment = $_POST['comId'];
$delete = $_POST['delete'];


if($delete)
{
    $db = dbConnect();
    $stmt = "DELETE FROM comments WHERE comId=". $comment ;
    $db->query($stmt);
    $db->close();
    header("location: post.php?post=". $post);
}





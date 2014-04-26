<?php
require "config.php";

// make database object
$db = dbConnect();

//buttons
$send = $_POST['send'];
$cancel = $_POST['cancel'];
$accept = $_POST['accept'];
$ignore = $_POST['ignore'];
$unfriend = $_POST['unfriend'];


$member = $db->real_escape_string($_POST['member']);
$me = $db->real_escape_string($_POST['userId']);

if($send)
{
    $stmt = "INSERT INTO friendReq VALUES ('','".$me."', '".$member."')";
    $db->query($stmt);
}

if($cancel)
{
    $stmt = "DELETE FROM friendReq WHERE (fromId='".$me."' AND toId='".$member."')";
    $db->query($stmt);
}

if($accept)
{
    $stmt = "DELETE FROM friendReq WHERE (fromId='".$member."' AND toId='".$me."')";
    $db->query($stmt);

    $stmt = "INSERT INTO friends VALUES ('', '".$member."', '".$me."')";
    $db->query($stmt);
}

if($ignore)
{
    $stmt = "DELETE FROM friendReq WHERE (fromId='".$member."' AND toId='".$me."')";
    $db->query($stmt);
}

if($unfriend)
{
    $stmt = "DELETE FROM friends WHERE (user1='".$member."' AND user2='".$me."') OR (user1='".$me."' AND user2='".$member."')";
    $db->query($stmt);
}

$userName = getName($member);
header("location: profile.php?username=". $userName);
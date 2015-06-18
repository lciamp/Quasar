<?php

session_start();
require "config.php";

$db = dbConnect();

$userName = $_SESSION['username']; //username

$stmt = "SELECT userId from MEMBERS WHERE userName='".$userName."'";

$result = $db->query($stmt);
$row = $result->fetch_assoc();
$me = $row['userId'];
$result->free();
$db->close();
$me = (int)$me;
//echo $me;

$db = dbConnect();
$stmt = "SELECT count(*) as num FROM friendReq WHERE toId=".$me;
$result = $db->query($stmt);
$row = $result->fetch_assoc();
	
$num = $row['num'];
$result->free();


$num = (string)$num;

echo $num;

 
$db->close();
?>
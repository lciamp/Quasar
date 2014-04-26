<?php
// import config.php, where we are keeping our functions
require "config.php";

// TO BE USED LATER ONCE THE DATABASE IS SET UP
//
// connect to server and select database
session_start();
#converts the date/time from the sql database
function convert($date)
{
    $converteddate = date("F j, Y", strtotime($date." + 1day"));
    return $converteddate;
}

$userName = $_SESSION['username'];
$edit = $_POST['edit'];

if($edit)
{
    header("location: editProfile.php");
}


$db = dbConnect();
$result = $db->query("SELECT * FROM members WHERE userName='$userName' ");
$row = $result->fetch_assoc();
$result->close();
$db->close();

?>
<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
    <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5; inital-scale=0.98; user-scalable=no; width=1024'>
</head>

<body>
<div class="site">

    <div class="spacer" style="height: 20px;">
        <a href="index.php" ><img src="img/menu.png" class="logo" /> </a>
    </div>


    <?php
    buildMenu();
    ?>

    <div class="spacer" style="height: 20px"></div>

    <div class="body">

        <div class="profile" style="padding-left: 200px;">
            <div class="profPic">
        <?php
        //header("Content-type:" . $row['profPic']);

        //echo '<img class="profile" src="data:image/jpeg;base64,' . base64_encode($row['profPic']) . '" width="280" height="280">';
		if($row['profPic'])
		{
			echo formatImage($row['profPic'], "profile picture");
       	}
		else
		{
			?>
            <img class="profile" src="./img/question.jpg"/></br>     
			<?php
		}
		?>
            </div>
            <div class="profBody">
        <?php

        echo "<h2 class='profile'> User Name: </h2><h2 class='profileInfo'>" . $row['userName'] . "</h2></br></br>";
        echo "<h2 class='profile'>Name: </h2><h2 class='profileInfo'>" . $row['fName'] . " ". $row['lName'] . "</h2></br></br>";
        echo "<h2 class='profile'>Email: </h2><h2 class='profileInfo'>" . $row['email'] . "</h2></br></br>";
        echo "<h2 class='profile'>Location: </h2><h2 class='profileInfo'>" . $row['location'] . "</h2></br></br>";
        echo "<h2 class='profile'>Member Since: </h2><h2 class='profileInfo'>" . convert($row['uDate']) . "</h2></br></br>";

        ?>
                <form action="profile.php" method="POST">
                <input type="submit" name="edit" class="button" value="Edit Profile" >
                </form>
            </div>
        </div>

        </div>
    </div>

</div>


</body>
</html>

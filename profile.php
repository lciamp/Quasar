<?php
// import config.php, where we are keeping our functions
require "config.php";

// TO BE USED LATER ONCE THE DATABASE IS SET UP
//
// connect to server and select database
session_start();
#converts the date/time from the sql database

$sessionName = $_SESSION['username'];

$getName = $_GET['username'];


if(!$sessionName)
{
    header("location: nope.php");
}

if($getName != $sessionName)
{
    $name = $getName;
}
if($getName == $sessionName)
{
    $name = $sessionName;
}
if(!$getName && $sessionName)
{
    $name = $sessionName;
}





$edit = $_POST['edit'];

if($edit)
{
    header("location: editProfile.php");
}


$db = dbConnect();


$result = $db->query("SELECT userId FROM MEMBERS WHERE userName='".$name."'");
$num = $result->num_rows;
$result->free();

$result = $db->query("SELECT * FROM members WHERE userName='".$name."' ");
$row = $result->fetch_assoc();
$result->free();


?>
<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
    <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5; inital-scale=0.98; user-scalable=no; width=1024'>
    <script type='text/javascript' src='js/jquery.js'></script>

    <script type='text/javascript'>
        $(document).ready(function(){
            $("img.a").hover(
                function() {
                    $(this).stop().animate({"opacity": "0"}, "slow");
                },
                function() {
                    $(this).stop().animate({"opacity": "1"}, "slow");
                });
        });
    </script>
    <link rel="shortcut icon" href="img/favicon.ico" >
</head>

<body>
<div class="site">

    <div class="spacer" style="height: 20px;">
        <?
        logo();
        ?>
        <div class="ajax">
            <form  action="index.php" method="POST" enctype="multipart/form-data">
                <table border="0" style="color: #ffffff; margin-left:0px;">
                    <tr>
                        <!-- <td>
                            <input type="hidden" name="searched" value="searched" />
                        </td> -->
                        <td>
                            <input type="text" autocomplete="off" name="searchBar" value="Search" maxlength="100" onclick="value=''" class="searchBar" />
                        </td>
                        <td align="right" colspan="2" class="login">

                            <input type="submit" name="search" class="search" value=""/>
                        </td>

                    </tr>
                </table>
            </form>
        </div>
    </div>


    <?php
    buildMenu();
    ?>

    <div class="spacer" style="height: 20px"></div>

    <div class="body">

        <?
        if($num < 1)
        {
            echo "<h1 class='page'>User Does Not Exist</h1>\n";
        }
        else{




            echo "<div class='profile' style='padding-left: 200px;'>\n";
            echo "    <div class='profPic'>\n";

            if($row['profPic'])
            {
                echo formatImage($row['profPic'], "profile picture");
            }
            else
            {
                echo formatImage("./img/question.jpg", "default profile picture");
            }
            echo "    </div>\n";

            echo "    <div class='profBody'>\n";

            echo "<h2 class='profile'> User Name: </h2><h2 class='profileInfo'>" . $row['userName'] . "</h2></br></br>\n";
            echo "<h2 class='profile'>Name: </h2><h2 class='profileInfo'>" . $row['fName'] . " ". $row['lName'] . "</h2></br></br>\n";
            echo "<h2 class='profile'>Email: </h2><h2 class='profileInfo'>" . $row['email'] . "</h2></br></br>\n";
            echo "<h2 class='profile'>Location: </h2><h2 class='profileInfo'>" . $row['location'] . "</h2></br></br>\n";
            echo "<h2 class='profile'>Member Since: </h2><h2 class='profileInfo'>" . convert($row['uDate']) . "</h2></br></br>\n";

            if($name == $_SESSION['username'])
            {
                echo "<form action='profile.php' method='POST'>\n";
                echo "<input type='submit' name='edit' class='button' value='Edit'>\n";
                echo "</form>\n";
            }




        $stmt = "SELECT userId from MEMBERS WHERE userName='".$sessionName."'";
        $result = $db->query($stmt);
        $row = $result->fetch_assoc();
        $myId = $row['userId'];
        $result->free();

        if(isset($_GET['username']) && !empty($_GET['username']))
        {
            $user = $_GET['username'];
            $stmt = "SELECT userId from MEMBERS WHERE userName='".$user."'";
            $result = $db->query($stmt);
            $row = $result->fetch_assoc();
            $nameId = $row['userId'];
            $result->free();
        }


        $stmt = "SELECT id FROM friends WHERE (user1='".$myId."' AND user2='".$nameId."') OR (user1='".$nameId."' AND user2='".$myId."')";

        $friendCheck = $db->query($stmt);

        if($_SESSION)
        {
            if($friendCheck->num_rows == 1)
            {
                echo "<h2 class='profileInfo'>You Are Friends with ". $user . "</h2>";
                echo "<form action='friendsActions.php' method='POST'>";
                echo "<input type='hidden' name='member' value=". $nameId . ">";
                echo "<input type='hidden' name='userId' value=". $myId . ">";
                echo "</br><input type='submit' name='unfriend' class='unfriendButton' value='Unfriend'><br/>";
                echo "</form>\n";

            }
            elseif($name == $_SESSION['username'])
            {
                //TODO get all friends requests that have been sent to you
            }
            else
            {
                //echo $friendCheck->num_rows;
                echo "<h2 class='profileInfo'>You Are Not Friends with " . $user . "</h2></br>";

                $stmt = "SELECT id FROM friendReq WHERE fromId='".$nameId."' AND toId='".$myId."'";
                $from = $db->query($stmt);
                $stmt = "SELECT id FROM friendReq WHERE fromId='".$myId."' AND toId='".$nameId."'";
                $to = $db->query($stmt);


                if($from->num_rows == 1)
                {
                    echo "</br><h2 class='profileInfo'>But " . $user ." sent you a friend request</h2>";
                    echo "<form action='friendsActions.php' method='POST'>";
                    echo "<input type='hidden' name='member' value=". $nameId . ">";
                    echo "<input type='hidden' name='userId' value=". $myId . ">";
                    echo "</br><input type='submit' name='accept' class='friendButton' value='Accept' style='float: left;'>";
                    echo "<input type='submit' name='ignore' class='unfriendButton' value='Ignore' style='float: left; margin-left: 5px'></br>";

                    echo "</form>\n";

                }
                elseif($to->num_rows == 1)
                {
                    echo "</br><h2 class='profileInfo'>But You Have Sent a Request</h2></br>";
                    echo "<form action='friendsActions.php' method='POST'>";
                    echo "<input type='hidden' name='member' value=". $nameId . ">";
                    echo "<input type='hidden' name='userId' value=". $myId . ">";
                    echo "</br><input type='submit' name='cancel' class='unfriendButton' value='Cancel Request'></br>";
                    echo "</form>\n";
                }
                else
                {
                    echo "<form action='friendsActions.php' method='POST'>";
                    echo "<input type='hidden' name='member' value=". $nameId . ">";
                    echo "<input type='hidden' name='userId' value=". $myId . ">";
                    echo "</br><input type='submit' name='send' class='friendButton' value='Request'><br/>";
                    echo "</form>\n";
                }
                $from->free();
                $to->free();
                $db->close();

            }
        }
        }

        ?>

    </div>
</div>

</div>
</div>


</body>
</html>

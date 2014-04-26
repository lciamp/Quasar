<?php
// import config.php, where we are keeping our functions
require "config.php";

session_start();



$name = $_SESSION['username'];
$admin = $_SESSION['admin'];


$db = dbConnect();

$delete = $_POST['delete'];
$user = $db->real_escape_string($_POST['username']);

$create = $_POST['create'];
$newUser = $db->real_escape_string($_POST['newUser']);
$password = $db->real_escape_string($_POST['password']);

$db->close();

if($create)
{
    $db =dbConnect();
    $stmt = "SELECT userName FROM members WHERE userName='".$newUser."'";
    $namecheck = $db->query($stmt);

    $count = $namecheck->num_rows;

    $namecheck->close();

    if($count > 0)
    {
        //let the user know that the name is taken
        $error =  "Username Taken";
    }
    else
    {
        if(!$newUser and !$password)
        {
            $error = "Fields are Blank";
        }
        elseif(!$newUser)
        {
            $error = "User is Blank";
        }
        elseif(!$password)
        {
            $error = "Password is Blank";
        }

        if($newUser and $password)
        {


            $password = md5($password);
            $stmt = "INSERT INTO MEMBERS (userId, userName, userPass, uDate, isAdmin) VALUES ('', '".$newUser ."', '".$password ."', NOW(), '0') ";

            $db->query($stmt);

            $db->close();
            $error = $newUser . " Created";
        }
    }


}




if($delete)
{
    $db = dbConnect();

    $stmt =  "SELECT userId FROM MEMBERS WHERE userName='".$user ."'";

    $result = $db->query($stmt);

    $id = $result->fetch_assoc();

    $id = $id['userId'];

    //delete form friends
    $stmt = "DELETE FROM friends WHERE user1='".$id."' OR user2='".$id."'";
    $db->query($stmt);

    //delete from friend requests
    $stmt = "DELETE FROM friendRew WHERE fromId='".$id."' OR toId='".$id."'";
    $db->query($stmt);

    //delete from members
    $stmt = "DELETE FROM MEMBERS WHERE userName='". $user . "'";
    $db->query($stmt);

    //delete all comments
    $stmt = "DELETE FROM comments WHERE userName='". $user ."'";
    $db->query($stmt);

    //delete all saved
    $stmt = "DELETE FROM saved WHERE userName='". $user ."'";
    $db->query($stmt);

    $db->close();
    $error2 = $user . " Deleted";
}


if($name != "admin" or !$admin)
{
    header("location: nope.php");
}



$db = dbConnect();
if(isset($_GET['category']))
{
    $cat = $_GET['category'];
    $stmt = "SELECT * FROM articles WHERE cat='".$cat."' ORDER BY pubDate DESC";
    //echo $cat . " worked";
}
elseif(isset($_GET['view']))
{
    $view = $_GET['view'];
    if($view == "top20")
    {
        $stmt = "SELECT * FROM articles ";
        //echo "top 20";
    }
    elseif($view == "members")
    {
        header("location: members.php");
    }
    elseif($view == "mostrecent")
    {
        $stmt = "SELECT * FROM articles ORDER BY pubDate DESC LIMIT 20";
        //echo "most recent";
    }
    $i = 1;

}
elseif(isset($_GET['tag']))
{
    $tag = $_GET['tag'];
    if($tag == "programming")
        $tag = "prog";
    $stmt = "SELECT * FROM articles WHERE tag='".$tag."' ORDER BY pubDate DESC";
    //echo $tag . " worked";
}
else
{
    $stmt = "SELECT * FROM ARTICLES ORDER BY pubDate DESC LIMIT 20";
    $i = 1;
}
if(isset($_POST['search']))
{
    $showResSearch = $_POST['search'];
    $searchtxt = $_POST['searchBar'];
    $searchtxt = mysql_real_escape_string(strip_tags($searchtxt));
    $searchtxt1 = "% ".$searchtxt." %";
    $searchtxt2 = $searchtxt." %";
    $stmt = "SELECT * FROM ARTICLES WHERE title like '".$searchtxt1."' or description like '".$searchtxt1."' or title like '".$searchtxt2."' or description like '".$searchtxt2."' ORDER BY pubDate DESC";
    $i =1;
}


?>
<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
    <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5; inital-scale=0.98; user-scalable=no; width=1024'>
    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='JavaScript/functions.js'></script>

    <script type='text/javascript'>
        $(document).ready(function()
        {
            $("img.a").hover(
                function()
                {
                    $(this).stop().animate({"opacity": "0"}, "slow");
                },
                function()
                {
                    $(this).stop().animate({"opacity": "1"}, "slow");
                });
        });
    </script>

    <link rel="shortcut icon" href="img/favicon.ico" >
</head>

<body>
<div class="site">


    <div class="spacer" style="height: 20px;">
        <?php
        logo();
        ?>
        <div class="ajax">
            <form  action="index.php" method="POST" enctype="multipart/form-data">
                <table border="0" style="color: #ffffff; margin-left:0px;">
                    <tr>
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

        <div class="innerbody" style="padding-top: 10px;">
            <form action="admin.php" method="POST">
                <table border="0" width="64%" style="color: black">
                    <tr>
                        <div class="spacer" style="height:10px; width: 80px;"></div>
                        <td class="login"><h1 class="login">Create User:</h1></td>
                        <td><br/>
                            <?php
                            echo "<h4 class='admin'>" . $error . "</h4>\n";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="login">
                            User name:
                        </td>
                        <td align="right" width="25" style="color:black" class="login">
                            <input autocomplete="off" type="text" name="newUser" maxlength="25" value=""/>
                        </td>
                    </tr>
                    <!-- table row for password -->
                    <tr>
                        <td class="login">
                            Password:
                        </td>
                        <td class="login">
                            <input autocomplete="off" type="password" name="password" maxlength="25"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="2" class="login">
                            <input type="submit" name="create" class="button" value="Create" onclick="confirm('Are You Sure?')">
                        </td>
                    </tr>
                </table>
            </form>
            <form action="admin.php" method="POST">
                <table border="0" width="64%" style="color: black">
                    <tr>
                        <div class="spacer" style="height:10px; width: 80px;"></div>
                        <td class="login"><h1 class="del">Delete User:</h1></td>
                        <td><br/>
                            <?php
                            echo "<h4 class='admin'>" . $error2 . "</h4>\n";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="login">
                            User name:
                        </td>
                        <td align="right" width="25" style="color:black" class="login">

                            <select name="username" style="width: 154px;">
                                <?php

                                $db = dbConnect();

                                $stmt = "SELECT userName FROM MEMBERS ORDER BY userName ";

                                $result = $db->query($stmt);

                                while($rows = $result->fetch_assoc())
                                {
                                    if($rows['userName'] == "admin");
                                    else
                                    {
                                        echo "<option value='".$rows['userName']."'>".$rows['userName'] ."</option>";
                                    }
                                }


                                ?>



                            </select>
                        </td>
                    </tr>

                        <td align="right" colspan="2" class="login">
                            <input type="submit" name="delete" class="unfriendButton" value="Delete" onclick="confirmSubmit()">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div>

</body>
</html>

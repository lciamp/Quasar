<?php
// import config.php, where we are keeping our functions
require "config.php";


// TO BE USED LATER ONCE THE DATABASE IS SET UP
//
// connect to server and select database
session_start();

$sessionName = $_SESSION['username'];
if(!$sessionName)
{
    header("location: nope.php");
}


$db = dbConnect();


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

    <div class="spacer" >
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

    <?
    buildMenu();
    ?>

    <div class="spacer" style="height: 20px"></div>

    <div class="body">
        <div class="innerbody">
            <div class="article" style="border-bottom: 0;">
            <?
            $userName = $_SESSION['username'];

            $stmt = "SELECT userId from MEMBERS WHERE userName='".$userName."'";
            $result = $db->query($stmt);
            $row = $result->fetch_assoc();
            $me = $row['userId'];
            $result->free();


            $stmt = "SELECT * FROM friendReq WHERE toId='".$me."'";
            $result = $db->query($stmt);
            $req = $result->num_rows;



            if($req < 1 )
            {
                echo "<h1 class='page'>No Friend Requests Right Now</h1>\n";
            }
            else
            {
                echo "    <h2 class='title' style='margin-top: 10px;'>Requests:</h2>\n";
                while($row = $result->fetch_assoc())
                {

                    //echo "<div class='articleSaved' style='margin: 5px;'>";
                    $name = getName($row['fromId']);

                    echo "<table>\n";
                    echo "    <tr>\n";
                    echo "        <td style='vertical-align: top;'>\n";

                    $stmt = "SELECT profThumb FROM MEMBERS WHERE userName='".$name."'";
                    $pics = $db->query($stmt);
                    $pic = $pics->fetch_assoc();
                    echo "<a href='profile.php?username=" . $name . "'>";
                    echo formatImage($pic['profThumb'], "profile picture");
                    echo "</a>";

                    echo "        </td>\n";
                    echo "        <td style='vertical-align: middle;'>\n";

                    echo  "<a class='friend' href='profile.php?username=" . $name . "'><h2 class='friend' style='margin-bottom: 0; padding-top: 2px;'>" . $name . "</h2></a></br>";
                    echo "        </td>\n";
                    echo "    </tr>\n";
                    echo "</table>\n";

                }
            }
            $result->free();
            $db->close();
            ?>
                </div>
        </div>
    </div>

</div>

</body>
</html>

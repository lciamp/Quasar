<?php
// import config.php, where we are keeping our functions
require "config.php";

// TO BE USED LATER ONCE THE DATABASE IS SET UP
//
// connect to server and select database
session_start();

$name = $_SESSION['username'];
$me = $_SESSION['me'];

if(!$name)
{
    header("location: nope.php");
}

?>
<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
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
    <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5; inital-scale=0.98; user-scalable=no; width=1024'>
    <link rel="shortcut icon" href="img/favicon.ico" >
</head>

<body>
<div class="site">

    <div class="spacer">
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

    <div class="body" style="padding-left: 10px; padding-right: 10px;">
        <p style="text-align: center; margin-top:0;">
            <?php
            $db = dbConnect();
            $stmt = "SELECT * FROM rec WHERE toId='". $me."'";
            $result = $db->query($stmt);
            $num = $result->num_rows;
            $result->free();

            if($num > 0)
            {
                echo "<h1 class='page' style='margin-bottom: 10px; margin-top: 10px;'>Recommended:</h1>\n";
                echo "</p>\n";



                $stmt = "SELECT * FROM rec WHERE toId='". $me."'";

                $result = $db->query($stmt);

                while($rows = $result->fetch_assoc())
                {
                    $name = getName($rows['fromId']);
                    echo "<div class='articleSaved'>\n";
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
                    echo "        <td style='vertical-align: middle; width: 800px;'>\n";

                    echo  "<a class='friend' href='profile.php?username=" . $name . "'><h2 class='friend' style='margin-bottom: 0; padding-top: 2px;  display: inline; padding-right: 4px;'>" . $name . "</h2></a><h2 class='friend' style='font-size:18px; display: inline; padding-left:0;'>recommended:</h2></br>";
                    echo "        </td>\n";
                    echo "    </tr>\n";
                    echo "</table>\n";

                    echo "<table width=100%>\n";
                    echo "<tr>\n";
                    echo "<td width='840px;'>\n";
                    echo "<h2 class='titleSaved' style='display: inline'>\n";
                    echo "<a class='rec' href=post.php?post=". $rows['articleId'].">". substr($rows['title'],0, 70) ."</a></h2>\n";
                    echo "</td>\n";

                    echo "<td>\n";
                    echo "<form style='display: inline;' action='deleteRec.php' method='POST'>\n";
                    echo "<input type='hidden' name='articleId' value='". $rows['articleId'] . "'>\n";
                    echo "<input type='hidden' name='me' value='". $rows['toId'] . "'>\n";

                    echo "<input type='submit' name='delete' class='delete' value='Delete'>\n";
                    echo "</form>\n";
                    echo "</td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "</div>";
                    //echo getName($rows['fromId']) . "</br>";
                    //echo $rows['title'] . "</br>";
                    //echo $rows['recDate'] . "</br>";
                    //echo $rows['articleId'] . "</br>";
                }
            }
            else
            {
                echo "<h1 class='page'>Nothing Recommended</h1>\n";
            }

            ?>


    </div>
</div>

</body>
</html>

<?php
require "config.php";

$name = $_SESSION['username'];

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
        <?php
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
        <div class="innerbody" style="margin-left: 15px; width: 97%;">

            <?
            $db = dbConnect();

            $stmt = "SELECT profThumb, userName FROM MEMBERS ORDER BY userName";
            $result = $db->query($stmt);
            echo "    <h2 class='title' style='margin-top: 10px;'>Members:</h2>\n";
            while($rows = $result->fetch_assoc())
            {
                if($rows['userName'] == $name);
                if($rows['userName'] == "admin");
                else
                {
                    echo "<table style='margin-top: 20px;'>\n";
                    echo "    <tr>\n";
                    echo "        <td style='vertical-align: top;'>\n";
                    echo "<a href='profile.php?username=" . $rows['userName'] . "'>";
                    echo formatImage($rows['profThumb'], "profile picture");
                    echo "</a>\n";
                    echo "        </td>\n";
                    echo "        <td style='vertical-align: middle; padding-bottom: 8px;'>\n";
                    echo  "<a class='friend' href='profile.php?username=" . $rows['userName'] . "'><h2 class='friend' style='margin-bottom: 0; padding-top: 2px; display: inline;'>" . $rows['userName'] . "</h2></a>";
                    echo "        </td>\n";
                    echo "    </tr>\n";
                    echo "</table>\n";
                }
            }
            ?>
        </div>
    </div>

</div>

</body>
</html>


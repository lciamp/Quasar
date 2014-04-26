<?php
// import config.php, where we are keeping our functions
require "config.php";

// TO BE USED LATER ONCE THE DATABASE IS SET UP
//
// connect to server and select database
session_start();

$name = $_SESSION['username'];

if(!$name)
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

    <div class="body" style="padding-left: 10px; padding-right: 10px;">
        <p style="text-align: center; margin-top:0;">
            <?php

                $db = dbConnect();

                $stmt = "SELECT * FROM saved WHERE userName='".$name. "'";
                $result = $db->query($stmt);
                $num = $result->num_rows;
                $result->free();

                if($num > 0)
                {
                    echo "<h1 class='page' style='margin-bottom: 10px; margin-top: 10px;'>Saved</h1>\n";
                    echo "</p>\n";

                    $stmt = "SELECT * FROM saved WHERE userName='".$name. "' ORDER BY saveDate DESC";
                    $result = $db->query($stmt);

                    while($rows = $result->fetch_assoc())
                    {
                        echo "<div class='articleSaved'>\n";
                        echo "<table width=100%>\n";
                        echo "<tr>\n";
                        echo "<td width='550px;'>\n";
                        echo "<h2 class='titleSaved' style='display: inline'>\n";
                        echo "<a target='_blank' class='friend' href='". $rows['link']."'>". substr($rows['title'],0, 50) ."</a></h2>\n";
                        echo "</td>\n";
                        echo "<td width='300px;'>\n";
                        echo "<h3 class='saved' style='display: inline'>Saved on: " . date("n/j/Y", strtotime($rows['saveDate'])) . " at " . date("g:i a",strtotime($rows['saveDate'])) . "</h3>\n";
                        echo "</td>\n";
                        echo "<td>\n";
                        echo "<form style='display: inline;' action='saveActions.php' method='POST'>\n";
                        echo "<input type='hidden' name='articleId' value='". $rows['articleId'] . "'>\n";
                        echo "<input type='submit' name='delete' class='delete' value='Delete'>\n";
                        echo "</form>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                        echo "</table>\n";
                        echo "</div>\n";
                    }
                    $result->free();
                    $db->close();
                }
                else
                {
                    echo "<h1 class='page'>You Have Nothing Saved</h1>\n";
                }
            ?>


    </div>
</div>



</body>
</html>

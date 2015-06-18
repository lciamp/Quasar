<?php
error_reporting(E_ALL ^ E_NOTICE);

require "config.php";

session_start();

$post = strip_tags($_GET['post']);
$name = $_SESSION['username'];
$me = $_SESSION['me'];

$admin = $_SESSION['admin'];


$db = dbConnect();
$send = $_POST['send'];

if($send)
{
    $to = $db->real_escape_string($_POST['to']);
    $from = $db->real_escape_string($_POST['from']);
    $articleId = $db->real_escape_string($_POST['articleId']);
    $title = $db->real_escape_string($_POST['title']);

    $stmt = "SELECT * FROM rec WHERE toId='" . $to . "' AND fromId='" . $from . "' AND title='" . $title . "'";
    $result = $db->query($stmt);
    $rec = $result->num_rows;
    $result->free();

    if($rec > 0)
    {
        $error = "You already recommended this article to " . getName($to);
    }
    else
    {
        $stmt = "INSERT INTO rec (id, toId, fromId, title, recDate, articleId) VALUES ('', '" . $to . "','" . $from . "', '" . $title . "', SYSDATE(), '" . $post . "')";

        $db->query($stmt);
    }
}

$db->close();

?>
<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <?php
    if(!$_SESSION['admin'])
    {
        echo "<link rel='stylesheet' href='css/style.css' type='text/css'>";
    }
    else
    {
        echo "<link rel='stylesheet' href='css/admin.css' type='text/css'>";
    }
    ?>
    <meta charset="UTF-8">
	<?php
	if(isset($_SESSION['username']))
		echo "<script type='text/javascript' src='JavaScript/updateFriendRequest.js'></script>";
	?>
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
        <div class="innerbody">


    <?php
        $db = dbConnect();
        $stmt = "SELECT * FROM articles WHERE articleId='".$post."'";
        $result = $db->query($stmt);

        $row = $result->fetch_assoc();

        echo "<div class='article'> <h2 class='titlePost'>\n";
        $link = $row['link'];
        $title = $row['title'];

        echo "<a target='_blank' class='rss' href='". $row['link'] ."'>\n";
        echo "" . $row['title'] . "</a></h2>\n";
        echo "<p class='descriptionPost'>" . $row['description'] . "</p>\n";
        echo "<table border='0px' style='background-color:#ffffff' width='100%' cellpadding='0' cellspacing='3'>";
        echo "<tr style='font-family: verdana, monospace; padding-top: 0; padding-bottom: 0px;'>";
        echo "<td  style='font-family: verdana, monospace; width: 300px; border:0;'>";
        echo "&nbsp&nbsp&nbspPosted by: <strong><a target='_blank' class='comments' href='http://www.". $row['site'] . "'>" . $row['site'] . "</a>\n";
        echo "</strong> on " . date("n/j/Y",strtotime($row['pubDate'])) . " at " . date("g:i a",strtotime($row['pubDate'])). "</tb>";

        echo "<td  style='font-family:verdana, monospace; width: 100px; border: 0;'></td>";
        echo "<td  style='font-family: verdana, monospace; width: 100px; height: 30px; border: 0;'>";
        $result->free();

    //make sure the article isn't already saved by the user and the user is logged in
        $title = $row['title'];
        $stmt = "SELECT title FROM saved WHERE (title='".$title."' AND userName='".$name."' )";
        $result = $db->query($stmt);
        $num = $result->num_rows;
        $result->free();

        if($num < 1 and $name and !$admin)
        {
            echo "<form action='saveActions.php' method='POST'>\n";
            echo "<input type='hidden' name='post' value=". $post . ">\n";
            echo "<input type='submit' name='save' class='save' value='Save'></tb>";
            echo "</form>";
        }

        echo "</tr>";
        echo "</table>";
        echo "</p>\n";


        // recommend recommend recommend recommend recommend recommend recommend
        if($_SESSION['username'] == "admin");
        elseif($_SESSION['username'])
        {
            echo "    <p>";
            echo "<div class='rec'>";
            echo "    <h2 class='rec'>Recommend:</h2>";
            echo "   <table style='background-color: #ffffff; width: 400px; height: 20px; border-radius: 0;'>";
            echo "       <tr>";
            echo "           <td style='height: 20px; width: 160px;'>";

            echo "<form action='' method='POST'>";
            echo "<select class='demo' name='to' style='width: 154px;'>";

            $stmt = "SELECT * FROM friends WHERE user1='". $me."' OR user2='". $me."'";

            $result = $db->query($stmt);

            while($rows = $result->fetch_assoc())
            {
                    if($rows['user1'] == $me)
                    {
                    	$f = $rows['user2'];
                    }
                    else
                    {
                   		$f = $rows['user1'];
                    }
                echo "<option value='".$f."'>" . getName($f). "</option>";
            }

            echo "                    </select>";
            echo "                </td>";
            echo "                <td style='height: 20px; padding: 0;'>";

            //TODO hidden stuff
            echo "<input type='hidden' name='from' value='".$me."'/>";
            echo "<input type='hidden' name='articleId' value='".$post."'/>";
            echo "<input type='hidden' name='title' value='".$title."'/>";
            echo "<input type='hidden' name='link' value='".$link."'/>";
            echo "                    <input type='submit' name='send' class='save'  value='Send'>";
            echo "<td>";
            echo "<h4>" . $error . "</h4>\n";
            echo "</td>";
            echo "                </td>";
            echo "            </tr>";
            echo "        </table>";
            echo "</form>";
            echo "</div>";
            echo "    </p>";
        }

        echo "</div>\n";
        echo "<div class='comment_title'>";
        echo    "<p class='comments'>";
        echo "        <h2 class='title'>";
        echo "        Comments:";
        echo "        </h2>";
        echo "    </p>";
        echo "</div>";


        $stmt = "SELECT * FROM comments WHERE articleId = '".$post."'";
        $result = $db->query($stmt);

        $num = $result->num_rows;
        $result->free();

        // no comments
        if($num < 1)
        {
            echo "<div class='comment'>\n";
            echo "    <p class='comment'>\n";
            echo "    <h2 class='comment'>No Comments</h2>\n";
            echo "</p>\n";
            echo "</div>";
        }
        // get comments
        else
        {
            $stmt2 = "SELECT * FROM comments WHERE articleId='".$post."'";
            $results = $db->query($stmt2);

            //comments
            while($row = $results->fetch_assoc())
            {
                echo "<div class='comment'>\n";
                $stmt = "SELECT profThumb FROM MEMBERS WHERE userName='". $row['userName'] . "'";
                $pics = $db->query($stmt);
                $pic = $pics->fetch_assoc();

                echo "<table>\n";
                echo "    <tr>\n";
                echo "        <td style='vertical-align: top;'>\n";
                echo "<a href='profile.php?username=" . $row['userName'] . "'>";
                echo formatImage($pic['profThumb'], "profile picture");
                echo "</a>\n";
                echo "        </td>\n";
                echo "        <td style='vertical-align: middle; padding-top: 0; padding-bottom: 6px;'>\n";
                echo "<a class='friend' href='profile.php?username=" . $row['userName'] . "'>";
                echo "    &nbsp<h2 class='comment'>". $row['userName'] . "</h2>\n";
                echo "</a>\n";
                echo "    <h3 class='date'> on " . date("n/j/Y",strtotime($row['comDate'])) . " at " . date("g:i a",strtotime($row['comDate'])) . "</h3>\n";
                echo "        </td>\n";
                echo "<td>";
                //TODO delete button
                if($_SESSION['admin'])
                {
                    echo "<form style='display: inline;' action='commentActions.php' method='POST'>\n";
                    echo "<input type='hidden' name='comId' value='". $row['comId'] . "'>\n";
                    echo "<input type='hidden' name='post' value='". $post . "'>\n";
                    echo "<input type='submit' name='delete' class='delete' value='Delete'>";
                    echo "</form>";
                }
                echo "</td>";
                echo "    </tr>\n";
                echo "</table>\n";
                echo "    <p class='comment' style='padding-top: 0;'>" . $row['com'] . "</p>\n";

                echo "    </p>\n";
                echo "<a href='#' class='rss' style='font-family: verdana, monospace;'>Reply</a>";
                echo "</div>\n";
            }
            $results->free();
        }

        $db->close();



        echo "<div class='comment_container'>\n";
        echo "    <div>\n";

        echo "        <div style='width: 100%; margin: 0 auto;'>\n";

        //comment post form
        if($name)
        {
            echo "<form action='commentActions.php' method='POST'>\n";
            echo "  <table class='comment'>\n";
            echo "    <tr>\n";
            echo "        <td style='text-align: left; padding-top: 10px;'>\n";
            echo "            <h2 class='as'></h2><h2 class='user'><a class='user' href='profile.php?username=" . $name . "'>".$name .":</h2>\n";
            echo "</td>\n";
            echo "</tr>\n";
            echo "<tr>";
            echo "    <td><textarea class='comment' rows='5' cols='80' style='font-family: verdana, monospace' name='comment'></textarea>";
            echo "<input type='hidden' name='post' value=". $post . "> </td>\n</tr>\n";
            echo "<tr>\n";
            echo "    <td class='article' style='float: right;'><input type='submit' name='submit' class='button' value='Comment'></td>\n";
            echo "</tr>\n";
            echo "</table>\n";
            echo "</form>\n";
        }
        else
        {
            echo "<div style='width: 100%; margin: 0 auto; align-content: center; text-align: center;'>\n";
            echo "<h2 class='as'>You Must Be Logged In to Comment</h2>\n";
            echo "</div>\n";
        }
    ?>

    </div>
</div>
</div>



</body>
</html>

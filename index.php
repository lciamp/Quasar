<?php
// import config.php, where we are keeping our functions
require "config.php";

session_start();

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

            <div class="innerbody">
            <?php

                $results = $db->query($stmt);

                if($results->num_rows == 0)
                {
                    echo "<h1 class='page'>No Results Found</h1>\n";
                }
                else{
                    while($rows = $results->fetch_assoc())
                    {
                        echo "<div class='article'> ";
                        echo "<h2 class='title'><a class='rss' href='post.php?post=" . $rows['articleId'] ."'></br>";


                        echo $rows['title'] . "</a></h2>";

                        echo "<table border='0px' style='background-color:#ffffff' width='100%' cellpadding='0' cellspacing='3'>";
                        echo "<tr style='font-family: verdana, monospace; padding-top: 0px; padding-bottom: 0px;'>";
                        echo "<td  style='font-family: verdana, monospace; width: 300px; border:0;'>Posted by: <strong><a target='_blank' class='comments' href='http://www." . $rows['site'] . "'>" . $rows['site'] . "</a></strong>\n";
                        echo " on " . date("n/j/Y",strtotime($rows['pubDate'])) . " at " . date("g:i a",strtotime($rows['pubDate'])) . "</tb>\n";

                        $db = dbConnect();

                        $stmt = "SELECT * FROM COMMENTS WHERE articleId=" . $rows['articleId'];
                        $result = $db->query($stmt);
                        $num = $result->num_rows;
                        $result->free();
                        $db->close();

                        echo "<td class='comment' style='width: 100px; border: 0;'><a href='post.php?post=". $rows['articleId'] ."' class='comments'><strong>Comments: ".$num."</strong></a></tb>\n";
                        echo "<td  class='tag' style=' width: 100px; border: 0;'>";
                        if($_GET['category'] or $i == 1)
                        {
                            echo "<a class='tag' href='index.php?tag=". $rows['tag'] ."'><strong>tag: " . $rows['tag'] . "</strong></a>\n";
                        }
                        echo "</h3></td>\n";

                        echo "</tr>\n";
                        echo "</table>\n";
                        echo "<p class='descriptionIndex' style='font-family: verdana, monospace;' >\n";
                        if(strip_tags($rows['description']) == "Comments")
                            echo "";
                        else
                            echo strip_tags($rows['description']) . "\n";
                        echo "</div>\n";
                    }
                }
        //getRSS();
        //getPics();
        ?>
            </div>
        </div>

    </div>

</body>
</html>

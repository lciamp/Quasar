<?php
// import config.php, where we are keeping our functions
require "config.php";


?>
<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css"><!-- <a href="/Users/Costas/Downloads/quasar/config.php" id="" title="config">config</a> -->
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
        <div class="about">
            <h3 class="about">Quasar is a RSS Feed reader.</br></br>It picks up new posts from a variety of websites.</br></br> By browsing through the categories, you can select which one interests you.
            </br></br>By becoming a member you are able to save links to the articles that you would like to read at a later date.</br></br>
            By becoming a member you are also able to comment on the articles you have read and give your feed back to other users.
            </h3>
            <h3 class="us">Quasar was developed by Louis Ciampanelli, Costas Vhramis, and Michael Brown @ Iona College in 2014</h3>

        </div>
    </div>
</div>


</body>
</html>

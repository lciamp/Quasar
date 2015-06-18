<?php
error_reporting(E_ALL ^ E_NOTICE);

require "config.php";

session_start();
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

        <?php
        echo "<h1 class='page'>You Need To Be Logged In For This</h1>\n";
        ?>

    </div>

</div>

</body>
</html>

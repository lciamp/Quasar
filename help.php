<?php
error_reporting(E_ALL ^ E_NOTICE);

require_once "config.php";
 
// TO BE USED LATER ONCE THE DATABASE IS SET UP
//
// connect to server and select database
session_start();
 
$error = $_GET['error'];

?>
<!DOCTYPE html>
 
<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
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
	<?php
	if(isset($_SESSION['username']))
		echo "<script type='text/javascript' src='JavaScript/updateFriendRequest.js'></script>";
	?>

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

        <div style = "font-family: verdana, monospace; margin: 0;">
            <center>
                <h5><?php echo $error ?></h5>
                <?php
                if (!isset($_POST["submit"]))
                {
                ?>
                <p style = "padding-left: 135px; padding-right: 135px;"><h3 class="about" style="margin: 0;">Please email us with any questions or problems!</h3></p>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                From: <input class="login" type="text" name="from" placeholder = " Your Email Address"><br><br>
                Subject: <input class="login" type="text" name="subject" placeholder = " Subject"><br><br>
                Message: <textarea class="comment" rows="9" cols="40" name="message" placeholder = " We welcome your feedback!"></textarea><br>
                <input type="submit" name="submit" value="Submit" class="button"> <br> <br>
                </form>
                <?php 
                    }
                    else
                    {
                        if (isset($_POST["from"]))
                        {
                            $from = $_POST["from"]; // sender
                            $subject = $_POST["subject"];
                            $message = $_POST["message"];
                            $message = wordwrap($message, 70);
                            if ($from && $subject && $message) {
                                 if (mail("mbrown5k@gmail.com",$subject." :QUASAR_USER",$message,$from))
                                 {
                                      mail("cvrahimis.11@gmail.com",$subject." :QUASAR_USER",$message,$from);
                                      echo "Thanks for the feedback!";
                                 }
                                 else
                                 {
                                      echo "Sorry an error has occurred...";
                                 }
                            }
                        else
                        {
                             header("location: help.php?error='please fill in all fields'");
                        }

                        }
                    }
                ?>
                </form>
            </center>
    </div>
 
</div>

 
</body>
</html>
 
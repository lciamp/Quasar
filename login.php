<?php
//Sign In Page
error_reporting(E_ALL ^ E_NOTICE);


//get the config file
require_once "config.php";

//session start
session_start();

// make database object
$db = dbConnect();

//buttons
$signin = $_POST['signin'];

//form data, strip tags of any html
$signinName = trim(strtolower(strip_tags($_POST['signinname'])));
$signinPassword = trim(strip_tags($_POST['signinpassword']));

//PRESSING THE SIGN IN BUTTON
if($signin)
{

    //check to see if both user name and password are enter ed
    if( $signinName && $signinPassword )
    {
        //select everything from the database where the user_name and the signinName entered match up
        $result = $db->query("SELECT * FROM members WHERE userName='". $signinName ."' ");

        //if there is 0, the name doesnt exisit
        if($result->num_rows !=0)
        {
            // gets associated row
            $row = $result->fetch_assoc();

                // name and password from database and id
            $dbUserName = $row['userName'];
            $dbPassword = $row['userPass'];
            $me = $row['userId'];


        // free results

        $result->free();

            // it worked
            if($signinName == $dbUserName && md5($signinPassword) == $dbPassword)
            {
                // set user name
                $_SESSION['username'] = $dbUserName;
                $_SESSION['me'] =  $me;
                if($row['isAdmin'] == 1)
                {
                    $_SESSION['admin'] = true;
                    header("location: admin.php");
                }
                else
                    header("location: index.php");
            }
            else // password error
                $error = "Incorrect Password";
        }
        else // user id error
            $error = "User doesn't exist";
    }
    else // something is missing
        $error = "Please enter a username and password";
}
//END OF PRESSING THE SIGN IN BUTTON

$db->close()
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
    <link rel="shortcut icon" href="img/favicon.ico" >
</head>

    <body>


    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{your-app-id}',
                status     : true,
                xfbml      : true
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>


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


        <div class="spacer" style="height: 20px;"></div>

        <div class="body">
                <form action="login.php" method="POST">
                    <table border="0" width="64%" style="color: black">
                        <tr>
                            <div class="spacer" style="height:10px; width: 80px;"></div>
                            <td class="login"><h1 class="login">Log In:</h1></td>
                            <td><br/>
                                <?php
                                echo "<h4>" . $error . "</h4>\n";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="login">
                                User name:
                            </td>
                            <td align="right" width="25" style="color:black" class="login">
                                <input autocomplete="off" type="text" name="signinname" maxlength="25" value="<?php echo $username ?>"/>
                            </td>
                        </tr>
                        <!-- table row for password -->
                        <tr>
                            <td class="login">
                                Password:
                            </td>
                            <td class="login">
                                <input autocomplete="off" type="password" name="signinpassword" maxlength="25"/>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="2" class="login">
                                <input type="submit" name="signin" class="button" value="Log In">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>

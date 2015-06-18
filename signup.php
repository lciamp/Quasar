<?php
error_reporting(E_ALL ^ E_NOTICE);

//get the config file
require "config.php";
//session start
session_start();

// make database object
$db = dbConnect();

//buttons
$signup = $_POST['signup'];

//form data, strip tags of any html
$fName =  trim(strip_tags($_POST['fName']));    //first name
$lName =  trim(strip_tags($_POST['lName']));    //last name
$location =  trim(strip_tags($_POST['location']));    //location
$email = trim(strip_tags($_POST['email']));   //eamil
$userName = trim(strtolower(strip_tags($_POST['userName']))); //usrname
$password = trim(strip_tags($_POST['password'])); //password
$repassword = trim(strip_tags($_POST['repassword'])); //re-enter password


//PRESSING THE SIGN UP BUTTON
if($signup)
{
	$username = $db->real_escape_string($userName);
    //check for user name
    $namecheck = $db->query("SELECT userName FROM members WHERE userName='".$userName."'");

    $count = $namecheck->num_rows;

    $namecheck->close();

    $error = "Everything is Required";

    //if the username is already used
    if($count > 0)
    {
        //let the user know that the name is taken
        $error =  "Username taken";
    }
    else
    {
        //check to make sure everything is filled out
        if($userName && $password && $repassword && $email && $fName && $lName && $location)
        {
            //check to see if the passwords match
            if($password == $repassword && strlen($password) < 25)
            {
                //check char length of user name and full name
                if(strlen($username)>25 || strlen($fName)>25 || strlen($lName)> 25)
                {
                    $error = "Max length for Username and Full Name is 25 characters.";
                }
                else
                {
                    //check password
                    if(strlen($password) > 25 || strlen($password) < 6)
                    {   //let user the password is to big or small
                        $error = "Password must be between 6 and 25 characters.";
                    }
                    else
                    {
						if(isValidEmail($email))
						{
                        	//encrypt the password
                        	//clear repassword
                        	$password = md5($password);
                        	$repassword = "";

                        	//real escape string protects from sql injection
                        	//strip tags strips any html the user might enter
                        	$fName = mysql_real_escape_string(strip_tags($fName));
                        	$lName = mysql_real_escape_string(strip_tags($lName));
                        	$location = mysql_real_escape_string(strip_tags($location));
                        	$email = mysql_real_escape_string(strip_tags($email));
                        	$username = mysql_real_escape_string(strip_tags($userName));
                        	$password = mysql_real_escape_string(strip_tags($password));


                        	//send the info to the database
                        	$db->query("INSERT INTO members (userId, fName, lName, email, userName, userPass, uDate, location) VALUES('', '".$fName."','". $lName."', '".$email."','".$username."','".$password."', NOW(),'". $location."')");
                        	//it worked
                        	//put username in session and go to index.php
                        	$_SESSION['username'] = $userName;

                            $stmt = "SELECT userId FROM MEMBERS WHERE userName='". $userName ."'";
                            $me = $db->query($stmt);
                            $me = $me->fetch_assoc();
                            $me = $me['userId'];
                            $_SESSION['me'] = $me;


                            $db->close();

                            header("location: index.php");
						}
						else
						{
							$error = "Please enter a valid email";
						}
					}
                }
            }
            else    //if the passwords don't match
                $error = "Passwords do not match.";
        }
        else    //if everything isn't filled in
            $error = "Please fill in ALL fields.";
    }
}
//END OF PRESSING THE SIGNUP BUTTON

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

    <div class="spacer"  style="height: 20px;"></div>

    <div class="body">

        <!-- REGISTER FORM BEGINNING -->
        <form  action="signup.php" method="POST">
            <table border="0" width="64%" style="color: #ffffff;">
                <tr>
                    <div class="spacer" style="height: 10px; width:80px;"></div>
                    <td class="login"><h1 class="login">Sign Up:</h1></td>
                    <td>
                        <?php
                        echo "<h4>" . $error . "</h4>\n";
                        ?>
                    </td></tr>
                <!-- table row for name -->
                <tr>
                    <td class="login">
                         First Name:
                    </td>
                    <td align="right" width="25" class="login">
                        <input autocomplete="off" type="text" name="fName" value="<?php echo "$fName" ?> " maxlength="25"/>
                    </td>
                </tr>
                <tr>
                    <td class="login">
                        Last Name:
                    </td>
                    <td align="left" width="25" class="login">
                        <input autocomplete="off" type="text" name="lName" value="<?php echo "$lName" ?> " maxlength="25"/>
                    </td>
                </tr>

                <tr>
                    <td class="login">
                        Location:
                    </td>
                    <td align="right" width="25" class="login">
                        <input autocomplete="off" type="text" name="location" value="<?php echo "$location" ?> " maxlength="25"/>
                    </td>
                </tr>
                <!-- table row for email -->
                <tr>
                    <td class="login">
                        Email:
                    </td>
                    <td align="left" width="25" class="login">
                        <input type="text" name="email" value="<?php echo "$email" ?>" maxlength="25"/>
                    </td>
                </tr>
                <!-- table row for username -->
                <tr>
                    <td class="login">
                        User Name:
                    </td>
                    <td align="right" width="25" class="login">
                        <input autocomplete="off" type="text" name="userName" value="<?php echo "$userName" ?>" maxlength="25"/>
                    </td>
                </tr>
                <!-- table row for password -->
                <tr>
                    <td class="login">
                        Password:
                    </td>
                    <td align="right" width="25" class="login">
                        <input autocomplete="off" type="password" name="password" maxlength="25"/>
                    </td>
                </tr>
                <!-- table row to re-eneter password -->
                <tr>
                    <td class="login">
                        Re-Enter Password:
                    </td>
                    <td align="right" width="25" class="login">
                        <input autocomplete="off" type="password" name="repassword" maxlength="25"/>
                    </td>
                </tr>
                <!-- submit button -->
                <tr>

                    <td align="right" colspan="2" class="login">
                        <input type="submit" name="signup" class="button" value="Sign Up"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>

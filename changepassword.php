<?php

require_once "config.php";

session_start();

$db = dbConnect();
$userName = $_SESSION['username'];

if(!$userName)
{
    header("location: nope.php");
}


$changedPassword = $_POST['change'];

$password = strip_tags($_POST['password']); //password
$repassword = strip_tags($_POST['repassword']); //re-enter password
$oldpassword = strip_tags($_POST['oldpassword']);



//PRESSING THE CHANGE BUTTON
if($changedPassword)
{
	$oldpassword = mysql_real_escape_string($oldpassword);
	$sql = "SELECT userPass FROM members WHERE userName='".$userName."' LIMIT 1";
	
	$oldPassCheck = $db->query($sql);
	$row = $oldPassCheck->fetch_assoc();
	$oldPassCheck->free();
	
	if($row['userPass'] == md5($oldpassword))
	{
    	//$message = "Everything Required";
	
        //check to make sure everything is filled out  /*&& $password && $repassword*/
        if($password && $repassword && $oldpassword)
        {
			
			//$result = $db->query("SELECT * FROM members WHERE userName='$signinName' ");
            //check to see if the passwords match
            if($password == $repassword && strlen($password) < 25)
            {
                //check char length of user name and full name
                if(strlen($username)>25 || strlen($fName)>25 || strlen($lName)> 25)
                {
                    $_SESSION['message'] = "Max length for Username and Full Name is 25 characters.";
					header("location: changepassword.php");
                }
                else
                {
                    //check password
                    if(strlen($password) > 25 || strlen($password) < 6)
                    {   //let user the password is to big or small
                        $_SESSION['message'] = "Password must be between 6 and 25 characters.";
						header("location: changepassword.php");
       				}
					else
					{
						$password = md5($password);
                        $repassword = "";
						//echo "here";
                        if($db->query("UPDATE members SET userPass='".$password."' WHERE userName='".$userName."'"))
                        {//it worked
							$_SESSION['message'] = "Password Changed";
                        	header("location: changepassword.php");
						}
						else
						{
	                        $_SESSION['message'] = "Could not change password";
							header("location: changepassword.php");
						}
					}
					
                }
			}
           	else    //if the passwords don't match
            {    
				$_SESSION['message'] = "Passwords do not match.";
				header("location: changepassword.php");
			}
		}
        else    //if everything isn't filled in
        {
			$_SESSION['message'] = "Please fill in ALL fields.";
			header("location: changepassword.php");
		}
	}
	else
	{
		$_SESSION['message'] = "Incorrect Old Password";
		header("location: changepassword.php");
	}
}
$db->close();
?>
    

		<!DOCTYPE html>

		<html>
		<head>
		    <title>Quasar</title>
		    <link rel="stylesheet" href="css/style.css" type="text/css">
			<script language=Javascript type="text/javascript" src="Javascript/MenuMethods.js"></script>

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
	
			<div class="spacer" style="width:80px;"></div>
			<div class="body">
        

            <!-- REGISTER FORM BEGINNING -->
            <form  action="changepassword.php" method="POST" enctype="multipart/form-data">
                <table border="0" width="64%" style="color: #ffffff;">
                    <tr>
                        <div class="spacer" style="height: 10px; width: 80px;"></div>
                        <td class="login"><h1 class="login">Password:</h1></td>
                        <td>
                            <?php
                            echo "<h4>" . $_SESSION['message'] . "</h4>\n";
                            ?>
                        </td></tr>
						<!-- old password -->
                    <tr>
                        <td class="login">
                            Old Password:
                        </td>
                        <td align="right" width="25" class="login">
                            <input type="password" name="oldpassword" maxlength="25"/>
                        </td>
					</tr>	
					<!-- password -->
                    <tr>
                        <td class="login">
                            New Password:
                        </td>
                        <td align="right" width="25" class="login">
                            <input type="password" name="password" maxlength="25"/>
                        </td>
                    </tr>
                    <!-- table row to re-eneter password -->
                    <tr>
                        <td class="login">
                            Re-Enter New Password:
                        </td>
                        <td align="right" width="25" class="login">
                            <input type="password" name="repassword" maxlength="25"/>
                        </td>
                    </tr>
                    <!-- submit button -->
                    <tr>

                        <td align="right" colspan="2" class="login">
                            <input type="submit" name="change" class="button" value="Change"/>
                        </td>
						
						<!-- cancel -->
                    </tr>
                </table>
            </form>
        </div>
    </div>

</body>
</html>


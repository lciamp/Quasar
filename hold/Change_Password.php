<?php
session_start();

$db = dbConnect();
?>

<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
</head>

<body>

	<div class="site">

    	<div class="spacer" style="height: 20px;">
        	<a href="index.php" ><img src="img/menu.png" class="logo" /> </a>
    	</div>

    <?php
    buildMenu();
    ?>
	
	<div class="spacer" style="width:80px;"></div>
	
<?php

$changedPassword = $_POST['changedPassword'];

//PRESSING THE EDIT BUTTON
if($changedPassword)
{
    $error = "Everything Required";

        //check to make sure everything is filled out  /*&& $password && $repassword*/
        if($password && $repassword)
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
						$password = md5($password);
                        $repassword = "";
                        $db->query("UPDATE members SET fName='$fName', lName='$lName', profPic='$img_path', email='$email', userPass='$password', location='$location' WHERE userName='$userName'");
                        //it worked
						$_SERVER['passwordChanged'] = 1;
                        header("location: Change_Password.php");
					}
					
                }
			}
           	else    //if the passwords don't match
            {   
				$_SERVER['passwordChanged'] = 0;
				header("location: Change_Password.php"); 
				$error = "Passwords do not match.";
        	}
		}
        else    //if everything isn't filled in
        {
			$error = "Please fill in ALL fields.";
			$_SERVER['passwordChanged'] = 0;
			header("location: Change_Password.php");
		}
}
elseif($_SERVER['passwordChanged'] == 1)
{
	
}
else	
{	
?>
    

        <div class="body">

            <!-- REGISTER FORM BEGINNING -->
            <form  action="editProfile.php" method="POST" enctype="multipart/form-data">
                <table border="0" width="64%" style="color: #ffffff;">
                    <tr>
                        <div class="spacer" style="height: 10px; width: 80px;"></div>
                        <td class="login"><h1 class="login">Edit:</h1></td>
                        <td>
                            <?
                            echo "<h4>" . $error . "</h4>\n";
                            ?>
                        </td></tr>
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
                            <input type="submit" name="changePassword" class="button" value="Change Password"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}
?>	

</body>
</html>


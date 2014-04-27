<?php
//edit profile page

//get the config file
require_once "images.php";
require_once "config.php";
require_once "thumbnailer.php";
//session start
session_start();
$userName = $_SESSION['username']; //username
if(!$userName)
{
    header("location: nope.php");
}


// make database object
$db = dbConnect();

//buttons
$edit = $_POST['edit'];

//this is to pre-populate the form with original profile data
$stmt = "SELECT fName, lName, email, location FROM members WHERE userName='".$userName."'";
$result = $db->query($stmt);
$row = $result->fetch_assoc();

$formFname = $row['fName'];
$formLname = $row['lName'];
$formEmail = $row['email'];
$formLocation = $row['location'];
$result->free();

//from form data, strip tags of any html
$fName =  strip_tags($_POST['fName']);    //first name
$lName =  strip_tags($_POST['lName']);    //last name
$location =  strip_tags($_POST['location']);    //location
$email = strip_tags($_POST['email']);   //eamil
$date = date("Y-m-d");  //date
$fileInfo = $_FILES['photo'];

if(isset($_SESSION['username']))
{
    $name = $_SESSION['username'];
}

//$password = strip_tags($_POST['password']); //password
//$repassword = strip_tags($_POST['repassword']); //re-enter password


//$name = $_SESSION['username'];


//PRESSING THE EDIT BUTTON
if($edit)
{

    //check to make sure everything is filled out  /*&& $password && $repassword*/
    if($userName
        && $email
        && $fName
        && $lName
        && $location)
    {
        //check to see if the passwords match
//            if($password == $repassword && strlen($password) < 25)
//            {
        //check char length of user name and full name
        if(strlen($username)>25
            || strlen($fName)>25
            || strlen($lName)> 25)
        {
            $error = "Max length for Username and Full Name is 25 characters.";
        }
        else
        {

            $image = new ImageHandler("/quasar/profilePics/");

            $imgPath = $image->processUploadedImage($fileInfo);
            //echo $imgPath;

            $Thumb = new ThumbNailer("/quasar/thumbNails/");
            //print_r($Thumb);

            $thumbPath = $Thumb->makeThumb($imgPath);
            /*if($thumbPath)
                echo $thumbPath;
            else
                echo "didnt fucking work";
            */




            //real escape string protects from sql injection
            //strip tags strips any html the user might enter
            $fName = mysql_real_escape_string(strip_tags($fName));
            $lName = mysql_real_escape_string(strip_tags($lName));
            $location = mysql_real_escape_string(strip_tags($location));
            $email = mysql_real_escape_string(strip_tags($email));


            $sql = "UPDATE members SET fName='".$fName."', lName='".$lName."', profPic='".$imgPath."', profThumb='".$thumbPath."', email='".$email."', location='".$location."' WHERE userName='".$userName."'";
            //send the info to the database
            $db->query($sql);
            //echo "here";
            //it worked
            header("location: profile.php");

        }
    }
    else    //if everything isn't filled in
        $error = "Please fill in ALL fields.";

}
$db->close()
?>

<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="img/favicon.ico" >
</head>

<body>
<div class="site">

    <div class="spacer" >
        <?
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

    <div class="spacer" style="width:80px;"></div>

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
                        User Name:
                    </td>
                    <td align="left" style="text-align: left;" width="25" class="login">
                        <?
                        echo $name;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="login">
                        First Name:
                    </td>
                    <td align="right" width="25" class="login">
                        <input type="text" name="fName" maxlength="25" value=<? echo htmlentities($formFname) ?>>
                    </td>
                </tr>
                <tr>
                    <td class="login">
                        Last Name:
                    </td>
                    <td align="left" width="25" class="login">
                        <input type="text" name="lName" maxlength="25" value=<? echo htmlentities($formLname) ?>>
                    </td>
                </tr>
                <tr>
                    <td class="login">
                        Location:
                    </td>
                    <td align="right" width="25" class="login">
                        <input type="text" name="location" maxlength="25" value=<? echo htmlentities($formLocation) ?>>
                    </td>
                </tr>
                <!-- table row for email -->
                <tr>
                    <td class="login">
                        Email:
                    </td>
                    <td align="left" width="25" class="login">
                        <input type="text" name="email" maxlength="25" value=<? echo htmlentities($formEmail) ?>>
                    </td>
                </tr>
                <!-- Table row to enter the picture -->
                <tr>
                    <td class="login">
                        Profile Picture:
                    </td>
                    <td>
                        <input type="file" name="photo" />  <!-- I took out this for debug value="<?php// echo "$photo" ?>" -->
                    </td>
                </tr>
                <!-- submit button -->
                <tr>

                    <td align="right" colspan="2" class="login">
                        <input type="submit" name="edit" class="button" value="Done"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>

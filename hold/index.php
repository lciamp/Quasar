<?php
// import config.php, where we are keeping our functions
require "config.php";


// TO BE USED LATER ONCE THE DATABASE IS SET UP
//
// connect to server and select database
session_start();

/*Debug*/ $signedIn = array('Subscriptions', 'Saved', 'Help', 'Logout', 'Change Password');
?>
<!DOCTYPE html>

<html>
<head>
    <title>Quasar</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="UTF-8">
    <meta name='viewport' content='minimum-scale=0.98; maximum-scale=5; inital-scale=0.98; user-scalable=no; width=1024'>
</head>

<body>
	<?php
	/*Debug*/ 	//$ref = str_replace("_"," ",$signedIn[4]);
	
				$ref = strip($signedIn[4]);
				echo $ref;
				$ref = strip($signedIn[3]);
				echo $ref;
	?>
<div class="site">

    <div class="spacer" style="height: 20px;">
        <a href="index.php" ><img src="img/menu.png" class="logo" /> </a>
        <div class="ajax"><h3 class="ajax">Most Recent</h3> </div>
    </div>
	
	
    <?
    buildMenu();
    ?>

    <div class="spacer" style="height: 20px"></div>

    <div class="body">
        <?
		echo "here";
        getRSS();
		echo "over here";
        //getPics();
        ?>
    </div>

</div>

</body>
</html>
$signedIn = array('Subscriptions', 'Saved', 'Help', 'Logout', 'Changed Password');
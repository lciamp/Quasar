<?php
session_start();

// function that removes white space and forward slashes, then makes every letter lowercase. Used for the menu links
function strip($word)
{
    // remove white space
    $word = str_replace(" ", "", $word);
    // remove forward slashes
    $word = str_replace("/", "", $word);
    // make all char lowercase
    $word = strtolower($word);

    return $word;
}

function convert($date)
{
    $converteddate = date("F j, Y", strtotime($date." + 1day"));
    return $converteddate;
}

// function that connects to the server and selects a database
function dbConnect()
{
    // variables for connecting to server and selecting database
    $dbHost = "localhost";
    $dbUsername = "root";
    $dbPassword = "root";
    $dbName = "quasar";

    // connect to mysql
    $connection = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName)
                  or
                  die ("Connect error: (" . $connection->connect_errno . ") " . $connection->connect_error);

    //return database connection as an object
    return $connection;
}


function getRSS()
{


    $stack = array();
    $source = array();

    if($_GET['tag']== "movies")
    {
        $url = "http://www.fandango.com/rss/fandangomovieblog.rss";
        $rss = simplexml_load_file($url);
        $source1 = "fandango.com";
        array_push($source, $source1);
        array_push($stack, $rss);
    }


    $url2 = "http://www.huffingtonpost.com/feeds/verticals/entertainment/index.xml";
    $rss = simplexml_load_file($url2);
    $source2 = "huffingtonpost.com";
    array_push($source, $source2);
    array_push($stack, $rss);



    for($i = 0; $i < count($stack); $i++)
    {
        $item = $stack[$i]->channel->item;

        for($j = 0; $j < 5; $j++)
        {
            echo "<div class='article'> ";
            echo "<h2 class='title'><a target='_blank' class='rss' href='" . $item[$j]->link ."'></br>";
            echo $item[$j]->title . "</a></h2>";
            echo "<table border='0px' style='background-color:#ffffff' width='100%' cellpadding='0' cellspacing='3'>";
            echo "<tr style='font-family: verdana, monospace; padding-top: 0px; padding-bottom: 0px;'>";
            echo "<td  style='font-family: verdana, monospace; width: 300px; border:0;'>Posted by: <strong><a target='_blank' class='comments' href='http://www." . $source[$i] . "'>" . $source[$i] . "</a></strong> on " . date("n/j/Y",strtotime($item[$j]->pubDate)) . " at " . date("g:i a",strtotime($item[$j]->pubDate)) . "</tb>";

            echo "<td  style='font-family:verdana, monospace; width: 100px; border: 0;'></tb>";
            echo "<td  style='font-family: verdana, monospace; width: 100px; border: 0;'></tb>";
            echo "</tr>";
            echo "</table>";
            echo "<p class='descriptionIndex' style='font-family: verdana, monospace;' >" . substr(strip_tags($item[$j]->description),0,150) . "...";
            echo "</div>";
        }
    }
}

// get rss function
/*function getRSS()
{


    $stack = array();
    $source = array();

    if($_GET['tag']== "movies")
    {
        $url = "http://www.fandango.com/rss/fandangomovieblog.rss";
        $rss = simplexml_load_file($url);
        $source1 = "fandango.com";
        array_push($source, $source1);
        array_push($stack, $rss);
    }


    $url2 = "http://www.huffingtonpost.com/feeds/verticals/entertainment/index.xml";
    $rss = simplexml_load_file($url2);
    $source2 = "huffingtonpost.com";
    array_push($source, $source2);
    array_push($stack, $rss);



    for($i = 0; $i < count($stack); $i++)
    {
        $item = $stack[$i]->channel->item;

        for($j = 0; $j < 5; $j++)
        {
            echo "<div class='article'> ";
            echo "<h2 class='title'><a target='_blank' class='rss' href='" . $item[$j]->link ."'></br>";
            echo $item[$j]->title . "</a></h2>";
            echo "<table border='0px' style='background-color:#ffffff' width='100%' cellpadding='0' cellspacing='3'>";
            echo "<tr style='font-family: verdana, monospace; padding-top: 0px; padding-bottom: 0px;'>";
            echo "<td  style='font-family: verdana, monospace; width: 300px; border:0;'>Posted by: <strong><a target='_blank' class='comments' href='http://www." . $source[$i] . "'>" . $source[$i] . "</a></strong> on " . date("n/j/Y",strtotime($item[$j]->pubDate)) . " at " . date("g:i a",strtotime($item[$j]->pubDate)) . "</tb>";

            echo "<td  style='font-family:verdana, monospace; width: 100px; border: 0;'></tb>";
            echo "<td  style='font-family: verdana, monospace; width: 100px; border: 0;'></tb>";
            echo "</tr>";
            echo "</table>";
            echo "<p class='descriptionIndex' style='font-family: verdana, monospace;' >" . substr(strip_tags($item[$j]->description),0,150) . "...";
            echo "</div>";
        }
    }
}*/
/*
function getPics()
    {
    $xml = simplexml_load_file('http://feeds.gawker.com/gawker/full');

    $descriptions = $xml->xpath('//item/description');
    foreach ( $descriptions as $description_node )
    {
        // The description may not be valid XML, so use a more forgiving HTML parser mode
        $description_dom = new DOMDocument();
        $description_dom->loadHTML((string)$description_node);

        // Switch back to SimpleXML for readability
        $description_sxml = simplexml_import_dom($description_dom);

        // Find all images, and extract their 'src' param
        $imgs = $description_sxml->xpath('//img');
        foreach($imgs as $image)
        {
            echo "<img style='border-radius: 20px' src='" . (string)$image['src'] . "' alt='some_text'>\n";
        }
    }
}
*/


function buildMenu()
{

    if(isset($_SESSION['username']))
    {
        $view = array('Most Recent', 'Members');
    }
    else
    {
        $view = array('Most Recent');
    }

    $sports = array('F1', 'NHL', 'NFL', 'MLB', 'NBA');
    $news = array('American', 'World', 'Politics');
    $tech = array('Programming', 'Android', 'iOS');
    $entertainment = array('General', 'Movies', 'TV', 'Video Games');
    $finance = array('NYSE', 'Nasdaq');



    $signedIn = array('Friends', 'Requests', 'Recommended', 'Saved', 'Change Password', 'Help', 'Logout');
    $notSignedIn = array('Log In', 'Sign Up');



    echo "<div class='menu'>\n";
    echo "<nav>\n";
    echo "    <ul>\n";
    echo "        <li><a href='about.php'><strong>About</strong></a></li>\n";
    echo "        <li><a href='#'><strong>View</strong></a>\n";
    echo "            <ul>\n";
        for ($i = 0; $i < count($view); $i++)
        {
            echo "                <li><a href='index.php?view=" . strip($view[$i]) . "'>" . $view[$i] . "</a></li>\n";
        }
    echo "            </ul>\n";
    echo "        </li>\n";


    echo "        <li><a href='#'><strong>Categories</strong></a>\n";
    echo "            <ul>\n";

    echo "                <li><a href='index.php?category=sports'>Sports</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($sports); $i++)
            echo "                    <li><a href='index.php?tag=". strip($sports[$i]) . "'>" . $sports[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";

    echo "            <li><a href='index.php?category=news'>News</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($news); $i++)
            echo "                    <li><a href='index.php?tag=" . strip($news[$i]) . "'>". $news[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";

    echo "            <li><a href='index.php?category=tech'>Tech</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($tech); $i++)
            echo "                    <li><a href='index.php?tag=" . strip($tech[$i]) . "'>". $tech[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";

    echo "            <li><a href='index.php?category=entertainment'>Entertainment</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($entertainment); $i++)
            echo "                    <li><a href='index.php?tag=" . strip($entertainment[$i]) . "'>". $entertainment[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";

    echo "            <li><a href='index.php?category=finance'>Finance</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($finance); $i++)
            echo "                    <li><a href='index.php?tag=" . strip($finance[$i]) . "'>". $finance[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";
    echo "         </ul>\n";
    echo "        </li>\n";
        if (isset($_SESSION['username']))
        {
            $name = $_SESSION['username'];
            if ($name == "admin")
            {
                echo "            <li><a href='admin.php'><strong>" . $name ."</strong></a>\n";
            }
            else
                echo "            <li><a href='profile.php'><strong>" . $name ."</strong></a>\n";
            echo "                <ul>\n";
            for($i = 0; $i < count($signedIn); $i++)
            {
                if($signedIn[$i] == "Requests")
                {
                    $db = dbConnect();
                    $userName = $_SESSION['username'];
                    $stmt = "SELECT userId from MEMBERS WHERE userName='".$userName."'";
                    $result = $db->query($stmt);
                    $row = $result->fetch_assoc();
                    $me = $row['userId'];
                    $result->free();

                    $stmt = "SELECT * FROM friendReq WHERE toId='".$me."'";
                    $result = $db->query($stmt);
                    $req = $result->num_rows;

                    if($req == 1 )
                    {
                        $a = $req . " Request";
                        echo "                    <li><a href='". strip($signedIn[$i]) .".php'>". $a ."</a></li>\n";
                    }
                    elseif($req > 1)
                    {
                        $a = $req . " Requests";
                        echo "                    <li><a href='". strip($signedIn[$i]) .".php'>". $a ."</a></li>\n";
                    }
                    $db->close();

                }
                elseif($signedIn[$i] == "Friends")
                {
                    $db = dbConnect();
                    $userName = $_SESSION['username'];
                    $stmt = "SELECT userId from MEMBERS WHERE userName='".$userName."'";
                    $result = $db->query($stmt);
                    $row = $result->fetch_assoc();
                    $me = $row['userId'];
                    $result->free();

                    $stmt = "SELECT * FROM friends WHERE user1='".$me."' OR user2='".$me."'";
                    $result = $db->query($stmt);
                    $req = $result->num_rows;

                    if($req == 1 )
                    {
                        $a = "1 Friend";
                        echo "                    <li><a href='". strip($signedIn[$i]) .".php'>". $a ."</a></li>\n";

                    }
                    elseif($req >= 1)
                    {
                        $a = $req . " Friends";
                        echo "                    <li><a href='". strip($signedIn[$i]) .".php'>". $a ."</a></li>\n";
                    }
                    $db->close();
                }
                elseif($signedIn[$i] == "Saved")
                {
                    $db = dbConnect();
                    $userName = $_SESSION['username'];

                    $stmt = "SELECT * FROM saved WHERE userName='".$userName."'";
                    $result = $db->query($stmt);
                    $req = $result->num_rows;

                    if($req == 0 )
                    {

                    }
                    elseif($req >= 1)
                    {
                        $a = $req . " Saved";
                        echo "                    <li><a href='". strip($signedIn[$i]) .".php'>". $a ."</a></li>\n";
                    }
                    $db->close();
                }
                elseif($signedIn[$i] == "Recommended")
                {
                    $db = dbConnect();
                    $userName = $_SESSION['username'];
                    $me = $_SESSION['me'];
                    $stmt = "SELECT * FROM rec WHERE toId='".$me."'";
                    $result = $db->query($stmt);
                    $req = $result->num_rows;

                    if($req == 0 )
                    {

                    }
                    elseif($req >= 1)
                    {
                        $a = $req . " Recommended";
                        echo "                    <li><a href='rec.php'>". $a ."</a></li>\n";
                    }
                    $db->close();
                }
                else
                {
                    echo "                    <li><a href='". strip($signedIn[$i]) .".php'>". $signedIn[$i] ."</a></li>\n";
                }


        }
            echo "                </ul>\n";
            echo "            </li>";
        }
        else
        {
            echo "<li><a href='#'><strong>Member</strong></a>\n";
            echo "            <ul>\n";
            for($i = 0; $i < count($notSignedIn); $i++)
                echo "                    <li><a href='". strip($notSignedIn[$i]) .".php'>". $notSignedIn[$i] ."</a></li>\n";
            echo "            </ul>\n";
            echo "        </li>\n";
        }
    echo "        </ul>\n";
    echo "    </nav>\n";
    echo "</div>";
}

function formatImage($img=NULL, $alt=NULL)
{
	if((!isset($img)) || ($img == ''))
	{
		return null;
	}
	else
	{
		return '<img class="profile" src="'.$img.'" alt="'.$alt.'" />';
	}
	
}

function isValidEmail($email)
{
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	
	if (preg_match($regex, $email)) return true;
	else  return false;
}

function nope()
{
    header("location: nope.php");
}

function logo()
{
    echo "<div class='fadehover'>\n";
    echo "        <a href='index.php' ><img src='img/Qlight.jpeg'  class='a' /><img src='img/Qdark.jpeg'  class='b' /></a>\n";
    echo "    </div>\n";
}

function getName($id)
{
    $db = dbConnect();
    $stmt = "SELECT userName FROM MEMBERS WHERE userId='".$id."'";
    $result = $db->query($stmt);
    $name = $result->fetch_assoc();
    $name = $name['userName'];
    $result->free();
    $db->close();

    return $name;
}



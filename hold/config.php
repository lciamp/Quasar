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

// get rss function
function getRSS()
{


    $stack = array();
    $source = array();

    /*
    $url = "http://www.skysports.com/rss/0,20514,12433,00.xml";
    $rss = simplexml_load_file($url);
    $source1 = "skysports.com";
    array_push($source, $source1);
    array_push($stack, $rss);
    */


    $url2 = "http://www.formula1.com/rss/news/headlines.rss";
    $rss = simplexml_load_file($url2);
    $source2 = "formula1.com";
    array_push($source, $source2);
    array_push($stack, $rss);

    $url3 = "http://racer.com/index.php/f1/51?format=feed&type=rss";
    $rss = simplexml_load_file($url3);
    $source3 = "racer.com";
    array_push($source, $source3);
    array_push($stack, $rss);


    $url4 = "http://www.autosport.com/rss/f1news.xml";
    $rss = simplexml_load_file($url4);
    $source4 = "autosport.com";
    array_push($source, $source4);
    array_push($stack, $rss);

    $url5 = "http://rss.feedsportal.com/c/350/f/537798/index.rss?";
    $rss = simplexml_load_file($url5);
    $source5 = "crash.net";
    array_push($source, $source5);
    array_push($stack, $rss);


    for($i = 0; $i < count($stack); $i++)
    {
        $item = $stack[$i]->channel->item;

        for($j = 0; $j < 1; $j++)
        {
            echo "<div class='article'> ";
            echo "<h2 class='title'><a class='rss' href='" . $item[$j]->link ."'></br>";

            // This is for a picture: ALL RSS FEEDS DO NOT HAVE PICTURES
            if((string)$item[$j]->enclosure['url'][0])
                echo "<img style='border-radius: 10px' src='" . (string)$item[$j]->enclosure['url'][0] . "'>&nbsp&nbsp";

            echo $item[$j]->title . "</a></h2>";

            echo "<table border='0px' style='background-color:#ffffff' width='100%' cellpadding='3' cellspacing='3'>";
            echo "<tr style='font-family: verdana, monospace; padding-top: 5px;'>";
            echo "<td  style='font-family: verdana, monospace; width: 300px; border:0;'>Posted by: <strong><a target='_blank' class='comments' href='http://www." . $source[$i] . "'>" . $source[$i] . "</a></strong> on " . date("m-j-Y G:i",strtotime($item[$j]->pubDate)) . "</tb>";

            if ($_SESSION['username'])
            {
                echo "<td  style='font-family:verdana, monospace; width: 100px; border: 0;'><a href='post.php' class='comments'><strong>Comments: 0</strong></a></tb>";
                echo "<td  style='font-family: verdana, monospace; width: 100px; border: 0;'><input type='submit' name='save' class='save' value='Save'></tb>";
            }
            else
            {
                echo "<td  style='font-family:verdana, monospace; width: 100px; border: 0;'><a href='post.php' class='comments'>Comments: 0</a></tb>";
                echo "<td  style='font-family: verdana, monospace; width: 100px; border: 0;'></tb>";
            }
            echo "</tr>";
            echo "</table>";
            echo "<p class='description'>" . strip_tags($item[$j]->description) . "";
            echo "</div>";
        }
    }
}

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



function buildMenu()
{
    $view = array('Top 20', 'Most Recent');
    $sports = array('F1', 'Football', 'Baseball');
    $news = array('American', 'World', 'Politics');
    $tech = array('General', 'Programming', 'Android', 'iOS');
    $entertainment = array('Movies', 'TV', 'Video Games');
    $finance = array('NYSE', 'Nasdaq');
    $signedIn = array('Subscriptions', 'Saved', 'Help', 'Logout', 'Change Password');
    $notSignedIn = array('Log In', 'Sign Up');
	
	
	
	/*$ref = str_replace(" ","_",strip($signedIn[$sLength - 1]));
	echo $ref;*/

    $menu = array
	(
        $view,
        $sports,
        $news,
        $tech,
        $entertainment,
        $finance,
        $signedIn,
        $notSignedIn,
    );



    echo "<div class='menu'>\n";
    echo "<nav>\n";
    echo "    <ul>\n";
    echo "        <li><a href='about.php'>About</a></li>\n";
    echo "        <li><a href='#'>View</a>\n";
    echo "            <ul>\n";
        for ($i = 0; $i < count($view); $i++)
            echo "                <li><a href='" . strip($view[$i]) . ".php'>" . $view[$i] . "</a></li>\n";
    echo "            </ul>\n";
    echo "        </li>\n";


    echo "        <li><a href='#'>Categories</a>\n";
    echo "            <ul>\n";

    echo "                <li><a href='#'>Sports</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($sports); $i++)
            echo "                    <li><a href='". strip($sports[$i]) .".php'>". $sports[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";

    echo "            <li><a href='#'>News</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($news); $i++)
            echo "                    <li><a href='". strip($news[$i]) .".php'>". $news[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";

    echo "            <li><a href='#'>Tech</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($tech); $i++)
            echo "                    <li><a href='". strip($tech[$i]) .".php'>". $tech[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";

    echo "            <li><a href='#'>Entertainment</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($entertainment); $i++)
            echo "                    <li><a href='". strip($entertainment[$i]) .".php'>". $entertainment[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";include '../quasar/config.php';
    

    echo "            <li><a href='#'>Finance</a>\n";
    echo "                <ul>\n";
        for($i = 0; $i < count($finance); $i++)
            echo "                    <li><a href='". strip($finance[$i]) .".php'>". $finance[$i] ."</a></li>\n";
    echo "                </ul>\n";
    echo "            </li>\n";
    echo "         </ul>\n";
    echo "        </li>\n";
        if ($_SESSION['username'])
        {
			//$sLenght = count($signedIn) - 1;
			//$ref = str_replace(" ","_",$signedIn[4]);
			//$ref = "/". $ref ."/";
			//echo $ref;
            $name = $_SESSION['username'];
            echo "            <li><a href='profile.php'>" . $name ."</a>\n";
            echo "                <ul>\n";
            for($i = 0; $i < count($signedIn); $i++)
                echo "                    <li><a href='". strip($signedIn[$i]) .".php'>". $signedIn[$i] ."</a></li>\n";
            echo "                </ul>\n";
            echo "            </li>";
        }
        else
        {
            echo "<li><a href='#'>Member</a>\n";
            echo "            <ul>\n";
            for($i = 0; $i < count($notSignedIn); $i++)
                echo "               <li><a href='". strip($notSignedIn[$i]) .".php'>". $notSignedIn[$i] ."</a></li>\n";
            echo "            </ul>\n";
            echo "        </li>\n";
        }
}

function formatImage($img=NULL, $alt=NULL)
{
	if((!isset($img)) || ($img == ''))
	{
		return null;
	}
	else
	{
		return '<img src="'.$img.'" alt="'.$alt.'" />';
	}
}

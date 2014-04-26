<?php
require "config.php";

//while(1)
//{
$db = dbConnect();


    //F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1 F1
    $stack = array();
    $source = array();


    $url2 = "http://www.formula1.com/rss/news/headlines.rss";
    $rss = simplexml_load_file($url2);
    $source2 = "formula1.com";
    array_push($source, $source2);
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

        for($j = 0; $j <= 10; $j++)
        {
            $link = $item[$j]->link;
            $title = $item[$j]->title;
            $site = $source[$i];
            $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
            $description = substr(strip_tags($item[$j]->description),0,250);
            $tag = "f1";
            $category = "sports";

            if($link && $title && $site && $date && $description)
            {
                $stmt = "SELECT title FROM articles where title='$title'";
                $itemExists = $db->query($stmt);
                if($itemExists->num_rows < 1)
                {
                    $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                    $db->query($stmt);
                    echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
                }
                else
                {
                    echo "not inserting<br/>";
                }

            }
        }
    }

    //NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL NFL
    $stack = array();
    $source = array();


    $url2 = "http://rss.cnn.com/rss/si_nfl.rss";
    $rss = simplexml_load_file($url2);
    $source2 = "si.com";
    array_push($source, $source2);
    array_push($stack, $rss);

    $url4 = "http://sports.yahoo.com/nfl/rss.xml";
    $rss = simplexml_load_file($url4);
    $source4 = "yahoo.com";
    array_push($source, $source4);
    array_push($stack, $rss);

    $url4 = "http://sports.espn.go.com/espn/rss/nfl/news";
    $rss = simplexml_load_file($url4);
    $source4 = "espn.com";
    array_push($source, $source4);
    array_push($stack, $rss);

    for($i = 0; $i < count($stack); $i++)
    {
        $item = $stack[$i]->channel->item;

        for($j = 0; $j <= 10; $j++)
        {
            $link = $item[$j]->link;
            $title = $item[$j]->title;
            $site = $source[$i];
            $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
            $description = substr(strip_tags($item[$j]->description),0,250);
            $tag = "nfl";
            $category = "sports";

            if($link && $title && $site && $date && $description)
            {
                $stmt = "SELECT title FROM articles where title='$title'";
                $itemExists = $db->query($stmt);
                if($itemExists->num_rows < 1)
                {
                    $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                    $db->query($stmt);
                    echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
                }
                else
                {
                    echo "not inserting<br/>";
                }

            }
        }
    }


    //NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL NHL
$stack = array();
$source = array();


$url2 = "http://www.nhl.com/rss/news.xml";
$rss = simplexml_load_file($url2);
$source2 = "nhl.com";
array_push($source, $source2);
array_push($stack, $rss);

$url4 = "http://rss.cnn.com/rss/si_hockey.rss";
$rss = simplexml_load_file($url4);
$source4 = "si.com";
array_push($source, $source4);
array_push($stack, $rss);

$url4 = "http://sports.yahoo.com/nhl/rss.xml";
$rss = simplexml_load_file($url4);
$source4 = "yahoo.com";
array_push($source, $source4);
array_push($stack, $rss);

for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "nhl";
        $category = "sports";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA AMERICA
$stack = array();
$source = array();


$url2 = "http://www.cbsnews.com/latest/rss/us";
$rss = simplexml_load_file($url2);
$source2 = "cbsnews.com";
array_push($source, $source2);
array_push($stack, $rss);

$url4 = "http://rss.cnn.com/rss/cnn_us.rss";
$rss = simplexml_load_file($url4);
$source4 = "cnn.com";
array_push($source, $source4);
array_push($stack, $rss);

$url4 = "http://feeds.foxnews.com/foxnews/latest";
$rss = simplexml_load_file($url4);
$source4 = "foxnews.com";
array_push($source, $source4);
array_push($stack, $rss);

for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "american";
        $category = "news";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD WORLD
$stack = array();
$source = array();


$url2 = "http://www.cbsnews.com/latest/rss/world";
$rss = simplexml_load_file($url2);
$source2 = "cbsnews.com";
array_push($source, $source2);
array_push($stack, $rss);

$url3 = "http://feeds.bbci.co.uk/news/rss.xml";
$rss = simplexml_load_file($url3);
$source3 = "bbc.com";
array_push($source, $source3);
array_push($stack, $rss);

$url4 = "http://rss.cnn.com/rss/cnn_world.rss";
$rss = simplexml_load_file($url4);
$source4 = "cnn.com";
array_push($source, $source4);
array_push($stack, $rss);

$url5 = "http://feeds.foxnews.com/foxnews/world";
$rss = simplexml_load_file($url5);
$source5 = "foxnews.com";
array_push($source, $source5);
array_push($stack, $rss);

for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "world";
        $category = "news";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS POLITICS
$stack = array();
$source = array();


$url2 = "http://rss.cnn.com/rss/cnn_allpolitics.rss";
$rss = simplexml_load_file($url2);
$source2 = "cnn.com";
array_push($source, $source2);
array_push($stack, $rss);

$url3 = "/http://www.cbsnews.com/latest/rss/politics";
$rss = simplexml_load_file($url3);
$source3 = "cbsnews.com";
array_push($source, $source3);
array_push($stack, $rss);

$url4 = "http://feeds.foxnews.com/foxnews/politics";
$rss = simplexml_load_file($url4);
$source4 = "foxnews.com";
array_push($source, $source4);
array_push($stack, $rss);

$url5 = "http://feeds.abcnews.com/abcnews/politicsheadlines";
$rss = simplexml_load_file($url5);
$source5 = "abcnews.com";
array_push($source, $source5);
array_push($stack, $rss);

for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "politics";
        $category = "news";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH TECH
$stack = array();
$source = array();


$url2 = "https://news.ycombinator.com/rss";
$rss = simplexml_load_file($url2);
$source2 = "news.ycombinator.com";
array_push($source, $source2);
array_push($stack, $rss);



for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "prog";
        $category = "tech";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID ANDROID
$stack = array();
$source = array();


$url2 = "http://feeds2.feedburner.com/androidcentral";
$rss = simplexml_load_file($url2);
$source2 = "androidcentral.com";
array_push($source, $source2);
array_push($stack, $rss);


for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "android";
        $category = "tech";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}


http://www.huffingtonpost.com/feeds/verticals/entertainment/index.xml
//ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT ENT
$stack = array();
$source = array();


$url2 = "http://www.huffingtonpost.com/feeds/verticals/entertainment/index.xml";
$rss = simplexml_load_file($url2);
$source2 = "huffingtonpost.com";
array_push($source, $source2);
array_push($stack, $rss);


$url3 = "http://feeds.gawker.com/gawker/full";
$rss = simplexml_load_file($url3);
$source3 = "gawker.com";
array_push($source, $source3);
array_push($stack, $rss);

$url4 = "http://www.tmz.com/rss.xml";
$rss = simplexml_load_file($url4);
$source4 = "tmz.com";
array_push($source, $source4);
array_push($stack, $rss);

for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "general";
        $category = "entertainment";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES MOVIES
$stack = array();
$source = array();


$url2 = "http://www.fandango.com/rss/fandangomovieblog.rss";
$rss = simplexml_load_file($url2);
$source2 = "fandango.com";
array_push($source, $source2);
array_push($stack, $rss);

$url3= "http://i.rottentomatoes.com/syndication/rss/in_theaters.xml";
$rss = simplexml_load_file($url3);
$source3 = "rottentomatoes.com";
array_push($source, $source3);
array_push($stack, $rss);


for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "movies";
        $category = "entertainment";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV TV
$stack = array();
$source = array();


$url2 = "http://rss.tvguide.com/breakingnews";
$rss = simplexml_load_file($url2);
$source2 = "tvguide.com";
array_push($source, $source2);
array_push($stack, $rss);


for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $checkTitle = md5($item[$j]->title);
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "tv";
        $category = "entertainment";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}


//VIDEO GAMES VIDEO GAMES VIDEO GAMES VIDEO GAMES VIDEO GAMES VIDEO GAMES VIDEO GAMES VIDEO GAMES VIDEO GAMES VIDEO GAMES
$stack = array();
$source = array();


$url2 = "http://feeds.gawker.com/kotaku/full";
$rss = simplexml_load_file($url2);
$source2 = "kotaku.com";
array_push($source, $source2);
array_push($stack, $rss);

$url3 = "http://www.gamespot.com/feeds/reviews/";
$rss = simplexml_load_file($url3);
$source3 = "gamespot.com";
array_push($source, $source3);
array_push($stack, $rss);

$url4 = "http://www.gamespot.com/feeds/news/";
$rss = simplexml_load_file($url4);
$source4 = "gamespot.com";
array_push($source, $source4);
array_push($stack, $rss);

for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $checkTitle = md5($item[$j]->title);
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "videogames";
        $category = "entertainment";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

//FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE FINANCE

$stack = array();
$source = array();


$url2 = "http://articlefeeds.nasdaq.com/nasdaq/categories?category=Business";
$rss = simplexml_load_file($url2);
$source2 = "nasdaq.com";
array_push($source, $source2);
array_push($stack, $rss);

$url3 = "http://articlefeeds.nasdaq.com/nasdaq/categories?category=Economy";
$rss = simplexml_load_file($url3);
$source3 = "nasdaq.com";
array_push($source, $source3);
array_push($stack, $rss);


for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $checkTitle = md5($item[$j]->title);
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "nasdaq";
        $category = "finance";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}

$stack = array();
$source = array();


$url2 = "http://markets.nyx.com//content/msa_traderupdates/all/all/rss.xml";
$rss = simplexml_load_file($url2);
$source2 = "nyse.com";
array_push($source, $source2);
array_push($stack, $rss);

$url4 = "http://feeds2.feedburner.com/NysecomFinancialNewsReleases";
$rss = simplexml_load_file($url4);
$source4 = "nyse.com";
array_push($source, $source4);
array_push($stack, $rss);


for($i = 0; $i < count($stack); $i++)
{
    $item = $stack[$i]->channel->item;

    for($j = 0; $j <= 10; $j++)
    {
        $link = $item[$j]->link;
        $title = $item[$j]->title;
        $checkTitle = md5($item[$j]->title);
        $site = $source[$i];
        $date = date("Y-m-j G:i:s",strtotime($item[$j]->pubDate));
        $description = substr(strip_tags($item[$j]->description),0,250);
        $tag = "nyse";
        $category = "finance";

        if($link && $title && $site && $date && $description)
        {
            $stmt = "SELECT title FROM articles where title='$title'";
            $itemExists = $db->query($stmt);
            if($itemExists->num_rows < 1)
            {
                $stmt = "INSERT INTO articles (articleId, link, cat, title, site, pubDate, description, tag) VALUES (NULL, '$link', '$category', '$title', '$site', '$date', '$description', '$tag')";

                $db->query($stmt);
                echo "inserting&nbsp" . $j . "&nbspfrom:&nbsp". $site . " - ". $tag ."</br>";
            }
            else
            {
                echo "not inserting<br/>";
            }

        }
    }
}
//$db->close();
//sleep(3600);
//}
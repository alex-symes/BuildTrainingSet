<?php
//This script takes in the information posted from training.php and adds it the bottom of a csv file.

//File with list of rated tweets
$ratedTweets = 'ratedTweets.csv';


$ID=$_POST["ID"];
$text=$_POST["text"];
$rating=$_POST["rating"];


if(!empty($rating)){


$cvsData = $ID . "," . chr(34) . $text . chr(34)  . "," . $rating;

$fp = fopen($ratedTweets,"a"); // $fp is now the file pointer to file $filename

    if($fp)
    {
        fwrite($fp,$cvsData . "\n"); // Write information to the file
        fclose($fp); // Close the file
    } 
    echo "Data Submitted succesfully";
} else {
	echo "fail";
}




?>

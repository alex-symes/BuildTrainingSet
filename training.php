
<?
//Load in set of tweets with ID
//CSV should be set up --> Twitter ID, Twitter UN, Tweet Text, Tweet URL

$TodaysTweets = 'TodaysTweets.csv';
$TodaysTweetsArray = array();

$fp = fopen($TodaysTweets, 'rb');
while(!feof($fp)) {
    $TodaysTweetsArray[] = fgetcsv($fp);
}
fclose($fp);

//Choose a random tweet
$randTweetKey = array_rand($TodaysTweetsArray);

$tweetID = $TodaysTweetsArray[$randTweetKey][0];
$tweetText = $TodaysTweetsArray[$randTweetKey][2];


?>



<!DOCTYPE>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Build A traning set</title>


<style>
.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>

<style>

  #tweet {
   // width: 400px !important;
  }

blockquote.twitter-tweet {
  display: inline-block;
  padding: 16px;
  margin: 10px 0;
  max-width: 468px;
  border: #ddd 1px solid;
  border-top-color: #eee;
  border-bottom-color: #bbb;
  border-radius: 5px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.15);
  font: bold 14px/18px Helvetica, Arial, sans-serif;
  color: #555;
}

blockquote.twitter-tweet p {
  font: normal 18px/24px Georgia, "Times New Roman", Palatino, serif;
  margin: 0 5px 10px 0;
  color: #555;
}

blockquote.twitter-tweet a[href^="https://twitter.com"] {
  font-weight: normal;
  color: #666;
  font-size: 12px;

  #tweet iframe {
    border: none !important;
    box-shadow: none !important;
  }



</style>

<script sync src="https://platform.twitter.com/widgets.js"></script>

<script>

  window.onload = (function(){

    var tweet = document.getElementById("tweet");
    var id = tweet.getAttribute("tweetID");

    twttr.widgets.createTweet(
      id, tweet, 
      {
        conversation : 'none',    // or all
        cards        : 'hidden',  // or visible 
        linkColor    : '#7fa2db', // default is blue
        theme        : 'light'    // or dark
      })
    .then (function (el) {
      el.contentDocument.querySelector(".footer").style.display = "none";
    });

  });

</script>
//AJAX code submits form to input.php, then reloads with another tweet.

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
      $("#submit").click(function() {
          $("p").slideToggle();
          var id = $("#ID").val();
          var text = $("#text").val();
          var rating = $("input[type=radio]:checked").val();
          var data = $("#user").val();
		    localStorage["myData"] = data;

          //alert(id + ", " + text + ", " + rating);
          if (id == '' || text == '' || rating == '' || oRating == '') {
              alert("Insertion Failed Some Fields are Blank....!!");
          } else {
              // Returns successful data submission message when the entered information is stored in database.
              $.post("insert.php", {
                  ID: id,
                  text: text,
                  rating: rating
              }, function(data) {
                 //document.write("<br>  what did I do? " + data);
                //alert("Worked");
                  $('#insertForm')[0].reset(); // To reset form fields
                  document.location.reload(true);
				 //var myLoadedData = localStorage["myData"];
	
              });
          }
      });
  });


</script>
  </head>
<body>


<?

//Display Tweet
echo '<div id="tweet" tweetID="' . $tweetID . '"></div>';

//Text to explain what you are doing to user.
echo "<h2>Help us build a training set.</h2>";
if (strlen($tweetRating) > 3) {
	echo '<div id="tweetRating"><p>Our machine learning views this tweet as: ' . $tweetRating . '</p></div>';
} else {
	echo '<div><p>Our machine learning refused to rate this tweet</p></div>';
}
 
 
//Following form allows users to choose if tweet is positive, neutral or negative. 
?>

<h2>What do you think?</h2>
<form id="insertForm" name="insertForm" >
      <input type="radio" name="rating" id="positive" value="positive">Positive
      <input type="radio" name="rating" id="neutral" value="neutral">Neutral
      <input type="radio" name="rating" id="negative" value="negative">Negative
      <!--<input type="text" name="user" id="user"> enter user name. -->
      <input type="hidden" name="ID" id="ID" value="<?php echo $tweetID ?> " />
      <input type="hidden" name="text" id="text" value="<?php echo $tweetText ?>" />
      <input type="button" id="submit" value="Submit"> </input>
</form>


</body>
</html>

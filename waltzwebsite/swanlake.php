<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
</head>
<body>

<?php
    $db_conn = mysql_connect('waltznetworkscom.ipagemysql.com', 'architbaweja', 'lpw92513'); 
    if (!$db_conn) { 
        die('Could not connect: ' . mysql_error()); 
    } 
    mysql_select_db("swanlake");
          
    // TODO: Basic entry validation (not null etc).
    // TODO: Find best answer
    $result = mysql_query("SELECT * FROM stanford_fair", $db_conn);
    $total_answers = mysql_num_rows($result);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $best_answer = "Test Best Answer";
        // TODO: Save answer; check for errors.
?>
<h2>Thanks for your submission!</h2>
The current best answer is (total: <?=$total_answers?>)<?=$best_answer?>

<?php
        mysql_close($db_conn);
    } else { // Tis a GET
?>
        Total Answers: <?=$total_answers?>
<form action="/swanlake.php" method="POST">
<label for="name">Name:</label>
<input type="text" name="name">
</form>

<?php
      }
?>

</body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59554915-1', 'auto');
  ga('send', 'pageview');

</script>
</html>

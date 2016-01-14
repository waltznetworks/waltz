<?php
        $TOP_N_ANSWERS = 3;
        $TABLE_NAME = "stanford_fair";

	function score($answer) {
		$sequence = array_map('intval', explode(',', $answer));
		$length = count($sequence);

		$used = array_pad(array(), 201, false);

		for ($i = 0; $i < $length; $i++) {
			$val = $sequence[$i];

			if ($val < 1) return 0;
			if ($val > 200) return 0;
			if ($used[$val]) return 0;

			$used[$val] = true;
		}

		for ($i = 0; $i < $length - 1; $i++) {
			$x = $sequence[$i];
			$y = $sequence[$i + 1];

			if ($x % $y == 0) continue;
			if ($y % $x == 0) continue;

			return 0;
		}

		return $length;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<title>Waltz Networks- Routing the Future</title>
<!--[if lt IE 9]>
  <script src="./assets/javascripts/html5.js"></script>
<![endif]-->

<!-- typekit -->
<script src="//use.typekit.net/zbs6lmw.js"></script>
<script>try{Typekit.load();}catch(e){}</script>
<!-- end typekit -->

<link rel="stylesheet" href="/static/assets/stylesheets/unsemantic-grid-base.css" />
<link rel="stylesheet" href="/static/assets/stylesheets/normalize.css" />
<link rel="stylesheet" href="/static/assets/stylesheets/main.css" />

<noscript>
  <link rel="stylesheet" href="static/assets/stylesheets/unsemantic-grid-mobile.css" />
    <link rel="stylesheet" href="static/assets/stylesheets/unsemantic-tablet-mobile.css" />

</noscript>
<script>
  var ADAPT_CONFIG = {
    path: 'static/assets/stylesheets/',
    dynamic: true,
    range: [
      '0 to 767px = unsemantic-grid-mobile.css',
      '767 to 1100px = unsemantic-grid-tablet.css',
      '1100px = unsemantic-grid-desktop.css'
    ]
  };
</script>
<script src="static/assets/javascripts/adapt.min.js"></script>
</head>
<body>
  <div class="grid-container">
    <div id="nav" class="grid-90 prefix-5">

      <img alt="Waltz Networks" id="logo" width="170px" src="static/img/logo.png"/>

      <ul>
        <li><a href="/#work">What We Do</a></li>
        <li><a href="/#team">Our Team</a></li>
        <li class="last"><a href="/#contact">Contact</a></li>
      </ul>
    </div>
  </div>

<?php
    $db_conn = mysql_connect('waltznetworkscom.ipagemysql.com', 'architbaweja', 'lpw92513'); 
    if (!$db_conn) { 
        die('Could not connect: ' . mysql_error()); 
    }
    mysql_select_db("swanlake");

    // TODO: Basic entry validation (not null etc).
    // TODO: Find best answer
    $result = mysql_query("SELECT * FROM $TABLE_NAME", $db_conn);
    $total_answers = mysql_num_rows($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Avoid SQL-injection attacks by using mysql_real_escape_string
        $name = mysql_real_escape_string($_POST["name"]);
        $email = mysql_real_escape_string($_POST["email"]);
        $github = mysql_real_escape_string($_POST["github"]);
        $answer = mysql_real_escape_string($_POST["answer"]);
        $score = score($_POST["answer"]);
        $codesample = mysql_real_escape_string($_POST["codesample"]);

        if ($_FILES["resume"]["size"] > 0) {
            $resume_name = mysql_real_escape_string($_FILES["resume"]["name"]);
            $resume_size = mysql_real_escape_string($_FILES["resume"]["size"]);
            $resume_mime = mysql_real_escape_string($_FILES["resume"]["type"]);
        }

        $insert_sql = "INSERT INTO $TABLE_NAME (name, email, github, answer, codesample, resume_name, resume_size, resume_mime, score) VALUES ('$name', '$email', '$github', '$answer', '$codesample', '$resume_name', '$resume_size', '$resume_mime', $score)";

        if (!mysql_query($insert_sql)) {
            die('Error saving entry: ' . mysql_error());
        } else {
            $tmp_file = $_FILES["resume"]["tmp_name"];
            $resume_save_name = "/home/users/web/b1523/ipg.waltznetworkscom/resumes/" . mysql_insert_id() . "-" . $resume_name;
            move_uploaded_file($tmp_file, $resume_save_name);
        }
?>

  <div>
    <div class="grid-container">
      <div class="grid-50 prefix-25">
        <h3>Thanks for your submission!</h3>
      </div>
    </div>
  </div>

<?php
        mysql_close($db_conn);
    } else { // Tis a GET
      $result = mysql_query("SELECT score FROM $TABLE_NAME ORDER BY score DESC LIMIT $TOP_N_ANSWERS");
      $best_answers = array();
      while ($row = mysql_fetch_array($result)) {
          $best_answers[] = $row["score"];
      }
?>

  <div>
    <div class="grid-container">
      <div class="grid-50 prefix-25">
        <h4>Congratulations! Just one more puzzle...</h4>
         <div>
           A "happy" sequence of integers is one in which, in every pair of adjacent elements, one is a divisor of the other. Drawing from the numbers 1, 2, ..., 200 without repetition, create the longest happy sequence you can.
        </div>
        <div style="margin-top: 10px;">
          We will be giving Visa Gift Cards for $250, $150 and $100 for the three longest chains! Please submit your answers by next Friday, January 22, to be considered.
        </div>
        <div style="margin-top: 10px;">
          Current top answers are: <?php echo implode(",", $best_answers); ?>
        </div>
        <h4 style="margin-bottom: 10px;">Your Answer?</h4>
        <form method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <label for="name">Name:</label>
            <input type="text" name="name">
          </div>
          <div class="form-row">
            <label for="email">Email:</label>
            <input type="text" name="email">
          </div>
          <div class="form-row">
            <label for="github">Github:</label>
            <input type="text" name="github">
          </div>
          <div class="form-row">
            <label for="answer">Answer:</label>
            <input type="text" name="answer">
          </div>
          <div class="form-row">
            <label for="codesample">Code:</label>
            <textarea name="codesample"></textarea>
          </div>
          <div class="form-row" style="margin-top: 9px;">
            <label for="resume">Resume:</label>
            <input type="file" name="resume">
          </div>
          <div class="form-row" style="margin-top: 10px;margin-bottom: 20px;">
            <input type="submit" value="Send &raquo;" />
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="clear"></div>

<?php
      }
?>
  <div id="bottomnav">
    <div class="grid-container">
      <div class="grid-40 prefix-30">
        Copyright &copy; 2015 Waltz Networks, Inc. | All rights reserved<br/>
        5 Thomas Mellon Circle, Suite 270, San Francisco, CA 94134
      </div>
    </div>
  </div>

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

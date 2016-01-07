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
    $result = mysql_query("SELECT * FROM stanford_fair", $db_conn);
    $total_answers = mysql_num_rows($result);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $best_answer = "Test Best Answer";
        // TODO: Save answer; check for errors.
?>
  <div id="contact">
    <div class="grid-container">
      <div class="grid-50 prefix-25">
        <h3>Thanks for your submission!</h3>
        The current best answer is (total: <?=$total_answers?>)<br><?=$best_answer?>
      </div>
    </div>
  </div>
<?php
        mysql_close($db_conn);
    } else { // Tis a GET
?>
  <div id="contact">
    <div class="grid-container">
      <div class="grid-50 prefix-25">

        <h3>Your Answer?</h3>
        <p>Total Answers: <?=$total_answers?></p>
        <form action="/swanlake.php" method="POST">
          <div class="Form-row">
            <label for="name">Name:</label>
            <input type="text" name="name">
          </div>
          <div class="form-row">
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

<?php
/*
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

session_start();
require_once dirname(__FILE__) . "/config.php";

// No user logged in
if (empty($_SESSION['user']['address']) || empty($_SESSION['user']['info']))
{
	header ('location:' . SERVER_URL);
	exit;
}

$address = $_SESSION['user']['address'];
$user_info = $_SESSION['user']['info'];
$nickname = $user_info['fio'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">

    <title>Digi-ID demo site</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/chat.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<?php if (DIGIID_GOOGLE_ANALYTICS_TAG != '') : ?><!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= DIGIID_GOOGLE_ANALYTICS_TAG ?>"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date()); gtag('config', '<?= DIGIID_GOOGLE_ANALYTICS_TAG ?>');</script><?php endif ?>
  </head>

  <body onload="setInterval('chat.update()', 1000)">

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
<!--            <div class="inner">
              <h3 class="masthead-brand">Cover</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="#">Home</a></li>
                </ul>
              </nav>
            </div>-->
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Hello, <?= $user_info['fio']; ?>!</h1>

            <p class="lead">Your address:<br />
            <small><?= $address ?></small></p>

		<div id="page-wrap">
		    <p><small><strong>Hint:</strong> Hit enter to send to chat</small></p>
		    <p id="name-area"></p>
		    <div id="chat-wrap"><div id="chat-area"></div></div>
		    <form id="send-message-area">
		        <p>Your message:<br />
		        <textarea id="sendie" maxlength = '100' rows = '1'></textarea></p>
		    </form>
		</div>


            <p class="lead" style="margin-top: 40px">
              <a href="logout.php" class="btn btn-lg btn-default">Logout</a>
              <a href="forget.php" class="btn btn-lg">Forget me</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Telegram support: <a href="https://t.me/DigiByteDevelopers">DigiByte Developers</a></p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script type="text/javascript" src="chat.js"></script>
<script type="text/javascript">

  var name = <?php echo json_encode($nickname); ?>;
  var address = <?php echo json_encode($address); ?>;
  // strip tags
  name = name.replace(/(<([^>]+)>)/ig,"");

  // display name on page

  // kick off chat
  var chat =  new Chat();

  $(function() {

     chat.getState();

     // watch textarea for key presses
     $("#sendie").keydown(function(event) {

         var key = event.which;

         //all keys including return.
         if (key >= 33) {
             var maxLength = $(this).attr("maxlength");
             var length = this.value.length;
             // don't allow new content if length is maxed out
             if (length >= maxLength) {
                 event.preventDefault();
             }
         }
	});
     // watch textarea for release of key press
     $('#sendie').keyup(function(e) {
        if (e.keyCode == 13) {
              var text = $(this).val();
              var maxLength = $(this).attr("maxlength");
              var length = text.length;
              // send
              if (length <= maxLength + 1) {
                chat.send(text, name, address);
                $(this).val("");
              } else {
                $(this).val(text.substring(0, maxLength));
              }
        }
     });
  });
</script>


  </body>
</html>

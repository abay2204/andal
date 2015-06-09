<?php
/**if(session_status() == PHP_SESSION_NONE){
    session_start();
 	if(isset($_GET['tryagain'])){
 		unset($_SESSION['nama']);
  		header('location:login.php');
 	}
}
if(!isset($_SESSION['nama'])){
	header('location:login.php');
}
if($_SESSION['lat']!=null and $_SESSION['lat']!=null){
session_write_close();**/
require ('sistem/konfigs.php');
require ('sistem/function.php');
require ('theme/header.php');
require ('theme/left-nav.php');
$page = "main";
	if(isset($_GET['hal'])) {
		$page = $_GET['hal'];
	}

	if(!file_exists("konten/{$page}.php")) {
		$page = "not-found";
		navbar("404");
	}
	
	//include contents
		require "konten/{$page}.php";
	require ('theme/right-nav.php');
	require ('theme/js.php');
/**}
else{
	require('theme/js.php');
	echo "<title>Please Enable Your Geolocation</title>
	<script src=\"assets/vendor/jquery-validation/jquery.validate.js\"></script>
	<script src=\"assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js\"></script>
	<script src=\"assets/vendor/pnotify/pnotify.custom.js\"></script>
	<script src=\"assets/javascripts/forms/examples.wizard.js\"></script>
	<link rel=\"stylesheet\" href=\"assets/vendor/bootstrap/css/bootstrap.css\" /><link rel=\"stylesheet\" href=\"assets/stylesheets/theme.css\" /><link rel=\"stylesheet\" href=\"assets/stylesheets/skins/default.css\" />
	<div class=\"jumbotron\">
	<div class=\"col-lg-1\"></div>
	<div class=\"col-lg-10\">
	<section class=\"panel form-wizard\" id=\"w1\">
	<header class=\"panel-heading\">
	<div class=\"panel-actions\">
	<a href=\"#\" class=\"fa fa-caret-down\"></a>
	<a href=\"#\" class=\"fa fa-times\"></a>
	</div>
	<h2 class=\"panel-title\">Whats wrong?</h2>
	</header>
	<div class=\"panel-body panel-body-nopadding\">
	<div class=\"wizard-tabs\">
	<ul class=\"wizard-steps\">
	<li class=\"active\"><a href=\"#w1-account\" data-toggle=\"tab\" class=\"text-center\">
	<span class=\"badge hidden-xs\">1</span>Enable geolocation</a></li>
	<li><a href=\"#w1-profile\" data-toggle=\"tab\" class=\"text-center\">
	<span class=\"badge hidden-xs\">2</span>Check your connection</a></li>
	<li><a href=\"#w1-confirm\" data-toggle=\"tab\" class=\"text-center\">
	<span class=\"badge hidden-xs\">3</span>Browser not support</a></li>
	</ul></div><form class=\"form-horizontal\" novalidate=\"novalidate\">
	<div class=\"tab-content\"><div id=\"w1-account\" class=\"tab-pane active\">
	<div class=\"row\"><div class=\"col-md-12\">How to enable geolocation:<br/>
		<div class=\"tabs tabs-primary\">
	<ul class='nav nav-tabs nav-justified'>
  <li class='active'><a href='#mozilla' data-toggle='tab'>Mozilla</a></li>
  <li><a href='#chrome' data-toggle='tab'>Chrome</a></li>
  <li><a href='#mobile' data-toggle='tab'>Mobile</a></li>
</ul>
<div class='tab-content'>
        <div class='tab-pane active' id='mozilla'>
          Open Firefox and navigate to jkt.nusa.net.id/crm. From the Tools menu at the top of your Firefox window (if it's not visible, press F11), select Page Info. Select the Permissions tab. Change the setting for Share Location.<br/>
      <img src=\"https://waziggle.com/Images/firefoxShareLoc.jpg\">
      Then refresh the screen by pressing the F5 button and you should see a box appear asking for you permission to give your location. Select <strong>Share Location</strong> or choose from the dropdown list. Here's more information on geolocation from Mozilla Firefox.<br/>
      <img src=\"https://waziggle.com/Images/firefoxShareLoc2.jpg\">
        </div>
        <div class='tab-pane' id='chrome'>
              Click the Chrome menu icon on the Chrome Toolbar. Select Settings. Click Show Advanced Settings (at the bottom of screen). In the \"Privacy\" section click Content Settings. In the dialog that appears, scroll down to the \"Location\" section. Select your default permission for future location. Click Manage exceptions to remove previously-granted permissions or denials for specific sites. <br/>
      <img src=\"https://waziggle.com/Images/chromeSettings.jpg\">
      Open Chrome and goto jkt.nusa.net.id/crm and you should see a box appear asking for your permission to give your location. Select Allow or choose from the dropdown list. Here's more information from Google Chrome. <br/>
      <img src=\"https://waziggle.com/Images/ChromePermissionBar.jpg\">
        </div>
        <div class='tab-pane' id='mobile'>
          Still using the sample code above we can see on iOS (in both Safari and Chrome) that we are presented with a straight \"Ok\" or \"Don't Allow\" which is a permanent setting for the current site.
      Geolocation permission dialog in Safari on iOS:<br/><br/>
      <img src=\"https://fearmediocrity.co.uk/img/posts/geolocation-mobile-mobile-safari-096eb967.png\"><br/>
      Chrome on Android performs in a similar fashion to the desktop version, with a banner style notification for \"Allow\" or \"Deny\"<br/><br/>
      <img src=\"https://fearmediocrity.co.uk/img/posts/geolocation-mobile-mobile-chrome-dd9539f7.png\"><br/>
      Geolocation permission dialog in Chrome on Android
        </div>
</div>
</div>
<a class=\"btn btn-primary\" href=\"?tryagain\">Ok, i got it. Let me try to login again</a>
	</div></div></div>
	<div id=\"w1-profile\" class=\"tab-pane\">Make sure you have stable connection or you can try to access google.com. If yu can't access google.com it means you have trouble with your connection. Please contact your provider and <a href=\"?tryagain\">try again later</a>.</div>
	<div id=\"w1-confirm\" class=\"tab-pane\">Throw up your phone and try again someday. </form></div></section>
	</div></div>";}
**/
?>
 <script type="text/javascript">
$(document).ready(function() {
   getLocation();
            });
 function showLocation(position) {
  var latitude = position.coords.latitude;
  latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  document.getElementById("lokasi").innerHTML = "<input name=lat value="+ latitude +" type=hidden><input name=lng value="+ longitude +" type=hidden>";
  var i, 
    elements = document.getElementsByClassName('lokasi');
for ( i = 0; i < elements.length; i += 1) {
  elements[i].innerHTML = "<input name=lat value="+ latitude +" type=hidden><input name=lng value="+ longitude +" type=hidden>";
}
}

function errorHandler(err) {
  if(err.code == 1) {
    alert("Error: You must allow geolocation or you cannot login this website");
  }else if( err.code == 2) {
    alert("Error: Position is unavailable!");
  }
}


function getLocation(){

   if(navigator.geolocation){
      // timeout at 60000 milliseconds (60 seconds)
      var options = {timeout:60000};
      navigator.geolocation.getCurrentPosition(showLocation, 
                                               errorHandler,
                                               options);
   }else{      alert("Sorry, browser does not support geolocation!");
   }
}
$('#datetimepicker3').datetimepicker({
	yearOffset:222,
	lang:'ch',
	timepicker:false,
	format:'d/m/Y',
	formatDate:'Y/m/d',
	minDate:'-1970/01/02', // yesterday is minimum date
	maxDate:'+1970/01/02' // and tommorow is maximum date calendar
});
</script>